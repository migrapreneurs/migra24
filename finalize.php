<?php


try {

      // INIT AIRTABLE
      session_start(); // Start the session
      require __DIR__.'/_src/at_init.php';

      //CREATE TICKET ID
      function generatePassID($length = 12) {
          $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $passID = '';

          $characterCount = strlen($characters);
          for ($i = 0; $i < $length; $i++) {
              if ($i > 0 && $i % 4 === 0) {
                  $passID .= '-';
              }
              $passID .= $characters[rand(0, $characterCount - 1)];
          }

          return $passID;
      }

      $RanPassID = generatePassID();



      //POST VARIABLES
      $firstName = $_POST['firstName'];
      $lastName = $_POST['lastName'];
      $eMail = $_POST['eMail'];
      $orderedPass = $_POST['orderedPass'];
      $countryofOrigin = $_POST['countryofOrigin'];
      $industry = $_POST['industry'];
      $reasonWhy = $_POST['reasonWhy'];
      $currentJob = $_POST['currentJob'];
      $passID = $RanPassID;
      $orderID = $_POST['orderID'];
      $City = $_POST['City'];
      $CompanyName = $_POST['companyName'];


      //CREATE NEW CUSTOMER

      $AirtableData = array(
        'E-Mail'                    =>  $eMail,
        'First Name'                =>  $firstName,
        'Last Name'                 =>  $lastName,
        'Pass Type'                 =>  $orderedPass,
        'Country of Origin'         =>  $countryofOrigin,
        'City'                      =>  $City,
        'Company Name'               =>  $CompanyName,
        'Industry'                  =>  $industry,
        'Reason for Visit'          =>  $reasonWhy,
        'Current Occupation'        =>  $currentJob,
        'Unique Ticket ID'          =>  $passID,
        'Stripe Payment ID'         =>  $orderID,
      );

      // Save to Airtable
      $AirtableCustomer = $airtable->saveContent( "Migra24 – Visitors", $AirtableData );








      // ADD CUSTOMER TO MAILERLITE
      //$mailerLiteApiKey = getenv('MIG_ML_SK');
      //$groupId = '112280603'; //2024 Migrapreneur Fair Customers
      //$mailerliteClient = new \MailerLiteApi\MailerLite($mailerLiteApiKey);

      //$groupsApi = $mailerliteClient->groups();
      //$groups = $groupsApi->get(); // returns array of groups


      //$subscriber = [
        //'email' => $eMail,
        //'name' => $firstName,
        //'fields' => [
        //  'last_name' => $lastName,
        //  'city' => $City,
        //  'reasonwhy' => $reasonWhy,
        //  'currentjob' => $currentJob,
        //  'passtype' => $orderedPass,
        //  'ticket' => $passID,
        //  'company' =>  $CompanyName,
        //  'nationality' =>  $countryofOrigin,
        //]
      //];

      //$response = $groupsApi->addSubscriber($groupId, $subscriber); // Change GROUP_ID with ID of group you want to add subscriber to


      //OUTPUT RESULTS

      // Redirect to Ticket page
      $ticketId = $passID; // Replace with the appropriate ticket ID
      header("Location: ticket?id=$ticketId");
      exit; // Make sure to exit to prevent further script execution


    } catch (Exception $e) {
        // Handle exceptions here, e.g., log them or show an error message
        echo "An error occurred: " . $e->getMessage();
    }


?>
