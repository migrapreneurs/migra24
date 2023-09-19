<?php


// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../cache/error_log.log'); // Replace with your desired log file path

// https://github.com/sleiman/airtable-php
// INIT AT API


try {
  require 'at_init.php';

  // UserData
  $rawData = file_get_contents("php://input");
  if ($rawData === null || $rawData === "") {
      $rawData = '{"First Name":"Mohammed","1st Preferred language":"Arabic","2nd Preferred language":"English","Persona":"Entrepreneur","Country of Destination":"Germany","Relocated":1,"Progress":"Settled","Activity":"Founding","RecordID":"rec1yQK40zyqPyEmU","Nationality":"Egypt"}';
  }
  $dataArray = json_decode($rawData, true);
  $userData = (object) $dataArray;


  // Define the cache directory
  $ATCache = '../cache/';

  // Function for caching data
  function fetchDataFromAirtable($airtable, $table, $ATCache)
  {
    $cacheExpiration = 86400;
    $cacheFilePath = $ATCache . $table . '.json';

    if (file_exists($cacheFilePath)) {
      $cachedData = json_decode(file_get_contents($cacheFilePath));

      // Check if cached data has expired
      if (time() - filemtime($cacheFilePath) >= $cacheExpiration) {
        // Check if new data is available in Airtable
        $latestCreatedTime = getLatestCreatedTimeFromAirtable($airtable, $table);
        if (strtotime($latestCreatedTime) > filemtime($cacheFilePath)) {
          $data = $airtable->getContent($table)->getResponse()['records'];
          file_put_contents($cacheFilePath, json_encode($data));
        } else {
          $data = $cachedData;
        }
      } else {
        $data = $cachedData;
      }
    } else {
      $data = $airtable->getContent($table)->getResponse()['records'];
      file_put_contents($cacheFilePath, json_encode($data));
    }

    return $data;
  }

  // Function to get the "Created Time" of the latest item in Airtable
  function getLatestCreatedTimeFromAirtable($airtable, $table) {
    $data = $airtable->getContent($table, ['sort' => [['field' => 'Created Time', 'direction' => 'desc']], 'maxRecords' => 1])
    ->getResponse()['records'];

    if (!empty($data)) {
      return $data[0]->fields->{'Created Time'};
    }

    return null;
  }




  // MATCHMAKING INIT

  // INIT VARS
  $serviceTypeKey = 'Service Type';

  // INITIALIZE Data
  $SPR_Data = fetchDataFromAirtable($airtable, 'Service Providers', $ATCache);
  $EXP_Data = fetchDataFromAirtable($airtable, 'Experts', $ATCache);
  $BNK_Data = fetchDataFromAirtable($airtable, 'Banking', $ATCache);


  // Function to unset unnecessary parameters
  function unsetUnnecessaryParams($item) {
    unset(
      $item->fields->{'Intents'},
      $item->fields->{'CalendlyMeetingID'},
      $item->fields->{'Persona relevance'},
      $item->fields->{'relocated'},
      $item->fields->{'Created By'},
      $item->{'createdTime'},
      $item->fields->{'RecordID'},
      $item->fields->{'Email Address'}
    );
  }

  // Common function to extract relevant fields
  function extractFields($item) {
    $fields = $item->fields;
    return [
      'preferredLanguages' => $fields->{'Preferred Languages'} ?? [],
      'personaRelevance' => $fields->{'Persona relevance'} ?? [],
      'relocated' => $fields->{'relocated'} ?? [],
      'notAllowedNationalities' => $fields->{'Not allowed (Nationality)'} ?? []
    ];
  }

  // Function to filter data
  function filterData($data, $userData, $filterCallback) {
    return array_filter($data, function ($item) use ($userData, $filterCallback) {
      //unsetUnnecessaryParams($item);
      return $filterCallback($item, $userData);
    });
  }

  // Function to check if preferred languages match
  function preferredLanguagesMatch($item, $userData) {
    $fields = extractFields($item);
    return in_array($userData->{'1st Preferred language'}, $fields['preferredLanguages'])
    || in_array($userData->{'2nd Preferred language'}, $fields['preferredLanguages']);
  }

  // Function to check if persona relevance matches
  function personaRelevanceMatches($item, $userData) {
    $fields = extractFields($item);
    $userPersona = $userData->Persona;
    return !isset($userPersona) || in_array($userPersona, $fields['personaRelevance']);
  }

  // Function to check if expert is relocated
  function isExpertRelocated($item) {
    $fields = extractFields($item);
    return !empty($fields['relocated'][0]);
  }

  // Function to filter experts, services, and banks
  $filterExperts = function ($item, $userData) {
    return preferredLanguagesMatch($item, $userData)
    && personaRelevanceMatches($item, $userData)
    && isExpertRelocated($item);
  };

  $filterServices = function ($item, $userData) {
    $fields = extractFields($item);
    return in_array($userData->Persona, $fields['personaRelevance'])
    && in_array($userData->Relocated, $fields['relocated']);
  };

  $filterBanks = function ($item, $userData) {
    $fields = extractFields($item);
    return !in_array($userData->{'Nationality'}, $fields['notAllowedNationalities']);
  };

  // Filtering logic for experts, services, and banks
  $filteredExperts = filterData($EXP_Data, $userData, $filterExperts);
  $filteredServices = filterData($SPR_Data, $userData, $filterServices);
  $filteredBanks = filterData($BNK_Data, $userData, $filterBanks);

  // Apply unsetUnnecessaryParams to each item in the filtered arrays
  array_walk($filteredExperts, 'unsetUnnecessaryParams');
  array_walk($filteredServices, 'unsetUnnecessaryParams');
  array_walk($filteredBanks, 'unsetUnnecessaryParams');

  // Transform the arrays to remove the "fields" wrapper
    $transformedExperts = array_map(function ($item) {
        return (array) $item->fields;
    }, $filteredExperts);
    $transformedServices = array_map(function ($item) {
        return (array) $item->fields;
    }, $filteredServices);
    $transformedBanks = array_map(function ($item) {
        return (array) $item->fields;
    }, $filteredBanks);

    // Merge the arrays
    $MGData = [
        'id' => 'MIGMATCH', // Add an identifier property
        'serviceproviders' => array_values($transformedServices),
        'experts' => array_values($transformedExperts),
        'banks' => array_values($transformedBanks)
    ];

  // Encode $MGData object as JSON
  header('Content-Type: application/json');
  echo json_encode($MGData, JSON_PRETTY_PRINT);

} catch (Exception $e) {
  // Log the error
  error_log('Error: ' . $e->getMessage());

  // Send a user-friendly error response
  header('Content-Type: application/json');
  echo json_encode(['error' => 'An error occurred. Please try again later.']);
}

?>
