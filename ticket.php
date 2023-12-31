<?php

// INIT AIRTABLE
session_start(); // Start the session
require __DIR__.'/_src/at_init.php';

$desiredRecord = null;
$ticketID_Temp = $_GET['id'];




// GET EVENT CREDENTIALS
$json_url = 'https://raw.githubusercontent.com/migrapreneurs/migra24/main/_data/migra-home.json';

// Fetch the JSON data
$event_data = @file_get_contents($json_url);

if ($event_data === false) {
    // Handle error, e.g., echo an error message
    echo "Error fetching JSON data.";
} else {
    // Decode the JSON data into an associative array
    $eventData = json_decode($event_data, true);

    if ($eventData === null) {
        // Handle JSON decoding error, e.g., echo a decoding error message
        echo "Error decoding JSON data.";
    }
}

$eventLocation = $eventData['sections']['header']['eventdata']['location'];
$eventDate = $eventData['sections']['header']['eventdata']['date'];



do {
    $request = $airtable->getContent( 'Migra24 – Visitors' );
    $response = $request->getResponse();

    $records = $response[ 'records' ];

    foreach ($records as $record) {
        // Check if the 'Unique Ticket ID' field matches the desired value
        if ($record->fields->{'Unique Ticket ID'} == $ticketID_Temp) {
            $desiredRecord = $record;
            break 2; // Break both the inner and outer loops
        }
    }
} while ($request = $response->next());

if ($desiredRecord !== null) {

  // Found the desired record
  $fields = $desiredRecord->fields;
  $email = $fields->{'E-Mail'};
  $firstName = $fields->{'First Name'};
  $lastName = $fields->{'Last Name'};
  $passType = $fields->{'Pass Type'};
  $ticketID = $fields->{'Unique Ticket ID'};
  $fullName = $firstName." ".$lastName;
  $orderID = $fields->{'Stripe Payment ID'};
  $companyName = $fields->{'Company Name'};


  // Create a DateTime object from the provided date string
  $dateTime = new DateTime($desiredRecord->createdTime);

  // Format the date as "F, jS Y, h:i A" (e.g., "September, 20th 2023, 05:59 AM")
  $formattedDate = $dateTime->format("F, jS Y, h:i A");


} else {
    // Record not found
    echo "Record not found with the specified 'Unique Ticket ID'.";
}




?>

<!doctype html>
  <html lang="<?= $LANG; ?>">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Ticket – Migra24 – <?= $ticketID; ?> – <?= $fullName; ?></title>

      <link rel="stylesheet" href="_assets/_css/ticket.css">
      <link rel="stylesheet" href="_assets/_css/flexboxgrid.min.css">



    </head>
    <body>

        <div id="Print">
          <button id="printButton" class="XS bold">Print Your Ticket</button>
          <script>
          // Get a reference to the "Print" button
          const printButton = document.getElementById('printButton');

          // Add a click event listener to the button
          printButton.addEventListener('click', () => {
            // Call the browser's print function
            window.print();
          });
        </script>

        </div>

        <main>
          <section id="Ticket" class="row col-xs-12">
            <div class="logo-container col-xs-12 mar-b-20">
              <img src="_assets/_images/migra-logo-black-ticket.svg" height="30px" width="auto" />
            </div>
            <h2 class="h1 col-xs-12"><?= $passType; ?></h2>
            <p class="M bold col-xs-12 mar-b-60"><?= $fullName;
            if (isset($companyName)){ ?>
            &rarr; <?= $companyName;

          } ?></p>
            <p class="L bold ticketID">
              Ticket ID: <?= $ticketID; ?>
            </p>

            <div id="EventData" class="col-xs-12 XS mar-t-40">
              <p><b>Event Location</b> <br />
              <?= $eventLocation; ?></p>
              <p class="mar-t-20"><b>Event Date</b><br />
              <?= $eventDate; ?></p>
            </div>

            <div id="Order Information" class="col-xs-12 mar-t-60 XXS">
              <p> <b>Order Information</b></p>
              <p> Order ID: <?= $orderID; ?> | Ordered by <?= $fullName; ?> on <?= $formattedDate; ?></p>
            </div>
            </div>
          </section>



        </main>






    </body>
  </html>
