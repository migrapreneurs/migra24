<?php


  include('init.php');
  session_start(); // Start the session
  require __DIR__.'/_src/at_init.php';


  $STRIPE_SK = getenv('STRIPE_SECRET_KEY');
  $sessionID = $_GET['session_id'];

  $stripe = new \Stripe\StripeClient($STRIPE_SK);
  $StripeData = $stripe->checkout->sessions->retrieve($sessionID);


  $customerEmail = $StripeData['customer_details']['email'];
  $customerName = $StripeData['customer_details']['name'];
  $orderID =  $StripeData['payment_intent'];
  $passID = $_GET['pass-id'];
  if (!empty($StripeData)){
  $status = $StripeData['status'];
} else {
  $status = $_GET['status'];
}



  //name

  $nameParts = explode(' ', $customerName);

  // Extract the first and last names
  $firstName = $nameParts[0];
  $lastName = end($nameParts);


  // Get Pass Name and ID
  $tickets_json_url = 'https://raw.githubusercontent.com/migrapreneurs/migra24/main/_data/tickets.json';
  $ticket_data = @file_get_contents($tickets_json_url);

  if ($ticket_data === false) {
    echo "Error fetching JSON data.";
    exit;
  }

  $json_data = json_decode($ticket_data, true);

  if ($json_data === null || !isset($json_data['tickets'])) {
    echo "Error decoding JSON data or missing 'tickets' key.";
    exit;
  }

  $tickets = $json_data['tickets'];

  function getTicketByPassId($passId, $tickets) {
    foreach ($tickets as $ticket) {
        if ($ticket['pass-id'] == $passId) {
            return $ticket;
        }
    }
    return null; // Return null if ticket with specified pass-id is not found
}


$foundTicket = getTicketByPassId($passID, $json_data['tickets']);

if ($foundTicket !== null) {
    // Ticket found, you can access its properties
    $ticketTitle = $foundTicket['title'];
    $earlyPrice = $foundTicket['early-price'];
    $standardPrice = $foundTicket['standard-price'];

} else {
    echo "Ticket not found.";
}

// RANDOM PASS ID
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

// Example usage:
$RanPassID = generatePassID();







?>

<!doctype html>
  <html lang="<?= $LANG; ?>">
    <head>
      <meta charset="<?= $CHARSET; ?>">

      <base href="<?= $BASE; ?>">



      <title>Migra 24 – Register for Migra24</title>

      <!-- cross browser support -->

      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <link rel="stylesheet" href="_assets/_css/full.css.php">


    </head>
    <body>

        <!--?php include('_assets/_script/header_simple.php'); ?-->


        <main>
          <section id="Inputs" class="mar-t-80">
            <div class="col-xs-8">
              <h2 class="mar-b-60">Thank you! You just got access to Migra24, Feb 8 2024, Berlin.</h2>
              <p class="M">In order to get fully registered for the event, we need you to enter some essential personal details to ensure your seamless experience at Migra24, the migrant-first gathering in Berlin.</p>
            </div>
            <div class="input-container mar-t-120 col-xs-12">
              <div class="input-wrapper">
                <label for="input1">First name</label>
                <input type="text" id="input1" name="input1" disabled value="<?= $firstName; ?>">
              </div>

              <div class="input-wrapper">
                <label for="input2">Second name</label>
                <input type="text" id="input2" name="input2" disabled value="<?= $lastName; ?>">
              </div>

              <div class="input-wrapper">
                <label for="input3">Email address</label>
                <input type="email" id="input3" name="input3" disabled value="<?= $customerEmail; ?>">
              </div>

              <div class="input-wrapper">
                <label for="input4">Ordered Pass</label>
                <input type="text" id="input4" name="input4" disabled value="<?= $ticketTitle; ?>">
              </div>
            </div>

            <div class="input-container mar-t-60 col-xs-12">

              <div class="select-container">
                <label for="input2">Country of Origin</label>
                <select class="select-input">
                  <option></option>
                  <option value="option1">Option 1</option>
                  <option value="option2">Option 2</option>
                  <option value="option3">Option 3</option>

                </select>
              </div>

              <div class="select-container">
                <label for="input2">Which City do you currently live in?</label>
                <select class="select-input">
                  <option></option>
                  <option value="option1">Option 1</option>
                  <option value="option2">Option 2</option>
                  <option value="option3">Option 3</option>

                </select>
              </div>



              <input type="hidden" name="passID" value="<?= $RanPassID; ?>">
              <input type="hidden" name="orderID" value="<?= $orderID; ?>">

            </div>

          </section>


        </main>

        <?php include('_assets/_script/footer.php'); ?>





    </body>
  </html>

  <?php
  error_reporting(E_ALL);
ini_set('display_errors', 1);
 ?>
