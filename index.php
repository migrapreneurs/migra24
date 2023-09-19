<?php include('init.php'); ?>


<?php
// URL of the JSON data
$json_url = 'https://raw.githubusercontent.com/migrapreneurs/migra24/main/_data/meta.json';

// Fetch the JSON data
$json_data = file_get_contents($json_url);

// Decode the JSON data into an associative array
$metadata = json_decode($json_data, true);

// Function to generate meta tags
function generateMetaTags($metaArray) {
    $metaTags = '';

    foreach ($metaArray as $meta) {
        $tag = '<meta ';

        foreach ($meta as $key => $value) {
            $tag .= $key . '="' . htmlspecialchars($value) . '" ';
        }

        $tag .= "/>\n";
        $metaTags .= $tag;
    }

    return $metaTags;
}

// Generate the HTML meta tags
$htmlMetaTags = generateMetaTags($metadata['metadata'][0]['meta']);


$json_url = 'https://raw.githubusercontent.com/migrapreneurs/migra24/main/_data/migra-home.json';

// Fetch the JSON data
$json_data = @file_get_contents($json_url);

if ($json_data === false) {
    // Handle error, e.g., echo an error message
    echo "Error fetching JSON data.";
} else {
    // Decode the JSON data into an associative array
    $jsonData = json_decode($json_data, true);

    if ($jsonData === null) {
        // Handle JSON decoding error, e.g., echo a decoding error message
        echo "Error decoding JSON data.";
    }
}

//var_dump($jsonData);

?>

<!doctype html>
  <html lang="<?= $LANG; ?>">
    <head>
      <meta charset="<?= $CHARSET; ?>">

      <base href="<?= $BASE; ?>">


      <?php echo $htmlMetaTags; ?>


      <link rel="icon" type="image/x-icon" href="favicon.ico">
      <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

      <link rel=“canonical“ href=“https://migrafair.org“ />



      <title>Migra 24 – February 7th + 8th 2024, Berlin</title>

      <!-- cross browser support -->

      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <link rel="stylesheet" href="_assets/_css/full.css.php">


    </head>
    <body>

      <script>
              // Function to update the countdown
              function updateCountdown() {
                  // Set the deadline date
                  const deadline = new Date("2024-02-07T00:00:00").getTime();

                  // Update the countdown every 1 second
                  const timer = setInterval(function () {
                      const now = new Date().getTime();
                      const timeRemaining = deadline - now;

                      if (timeRemaining <= 0) {
                          clearInterval(timer); // Stop the timer when the deadline is reached
                      } else {
                          const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                          const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                          const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));

                          document.getElementById("countdown").innerHTML = `<b>${days}</b> days <b>${hours}</b> hours <b>${minutes}</b> minutes`;
                      }

                      // Show the countdown div when the script is fired
                      document.getElementById("countdown").style.display = "inline-block";

                      // Remove the countdown div when timeRemaining <= 0
                      if (timeRemaining <= 0) {
                          document.getElementById("countdown").style.display = "none";
                      }
                  }, 1000);
              }

              // Run the updateCountdown function after the DOM is loaded
              document.addEventListener("DOMContentLoaded", function () {
                document.getElementById("countdown").style.display = "none";
                  updateCountdown();
              });
          </script>


        <?php include('_assets/_script/header.php'); ?>


        <!-- HERO STAGE -->
        <div class="hero row middle-xs">
          <div class="col-lg-8 col-lg-offset-1 col-xs-11 col-xs-offset-1 hero-text">
            <h1 class="h1XL"><?php echo $jsonData['sections']['header']['title']; ?></h1>
            <p class="S"><?php echo $jsonData['sections']['header']['subtitle']; ?></p>
            <div class="col-xs-12 mar-t-80 hero-cta-container">
              <a class="btn large bg-turquoise text-black S" href="#Tickets">Buy Tickets</a>
              <div class="bg-yellow text-black S bold" id="countdown"></div>
            </div>

          </div>
        </div>


        <main>
          <!-- WHY ATTEND -->
          <section id="Why" class="row col-xs-12">
            <h2 class="h1"><?php echo $jsonData['sections']['why']['title']; ?></h2>
            <p class="L col-lg-8"><?php echo $jsonData['sections']['why']['subtitle']; ?></p>
            <ul class="highlight-box col-xs-12 mar-t-60">
              <?php
              foreach ($jsonData['sections']['why']['benefits'] as $benefit) {
                echo '<li>' . $benefit['text'] . '</li>';
              }
              ?>
            </ul>
          </section>



          <!-- SPEAKERS -->
          <section id="Speakers">
            <h2 class="h1">Our Speakers</h2>
            <div class="mar-t-60 card-list-container">
              <div class="card-list">
                <?php
            foreach ($jsonData['sections']['speakers'] as $speaker) {
                if (!empty($speaker['fullname']) && !empty($speaker['jobtitle']) && !empty($speaker['url'])) { ?>
                <div class="card">
                  <img src="https://res.cloudinary.com/migrapreneur/image/upload/dpr_2.0,e_sharpen:139,q_auto:best/v1695030494/migra24/speakers/<?= $speaker['url']; ?>" alt="<?= $speaker['fullname']; ?>">
                  <div class="card-text">
                    <h3 class="L"><?= $speaker['fullname']; ?></h3>
                    <p><?= $speaker['jobtitle']; ?></p>
                  </div>
                </div>
              <?php }} ?>
              </div>
            </div>
          </section>



          <!-- PARTNERS -->
          <section id="Partners">
            <h2 class="h1">Our Key Partners</h2>
            <ul class="partner-list mar-t-60">
              <?php
              for ($i = 1; $i <= 9; $i++) {
                echo '<li class="partner-item"><img src="_assets/_images/_partners/partner_' . $i . '.png" alt="Partner ' . $i . '"></li>';
              }
              ?>
            </ul>
            </div>
          </section>



          <!-- TICKETS -->
          <?php
          // Fetch and decode the JSON data
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

          ?>

          <section id="Tickets">
            <h2 class="h1"><?= $json_data['tickets']['general']['title'];?></h2>
            <div class="mar-t-60 ticket-container">
              <?php foreach ($tickets as $ticket) {
                $fullColorClass = $ticket['text_color'];
                $colorName = substr($fullColorClass, strlen("text-"));
                ?>
                <div class="ticket rounded-box <?= $ticket['background_color']; ?> <?= $ticket['text_color']; ?>">
                  <div class="ticket-title">
                    <h3><?= $ticket['title']; ?></h3>
                  </div>
                  <div class="price-tag mar-b-20">
                    <span class="price"><?= $ticket['price']; ?>€</span>
                    <span class="line <?= $colorName; ?>"></span>
                    <span class="denominator">ticket*</span>
                  </div>
                  <ul class="circle <?= $colorName; ?> mar-b-20">
                    <?php foreach ($ticket['content'] as $bullet) { ?>
                      <li><?= $bullet; ?></li>
                    <?php } ?>
                  </ul>
                  <p class="XXS">* limited capacity, registration required.</p>
                  <div class="col-xs-12 mar-t-80">
                    <a class="btn standard bg-black text-white XS mar-t-20" href="<?= $ticket['checkout_url']; ?>">Buy <?= $ticket['title']; ?></a>
                  </div>
                </div>
              <?php } ?>
            </div>
          </section>





          <!-- FAQ -->
          <section id="FAQ">

            <div class="faq-container col-md-8 col-md-offset-2">
              <h2 class="h1 mar-b-60">Frequently Asked Questions</h2>
              <?php

              foreach ($jsonData['sections']['faq'] as $faqItem) {
                //if (!empty($faqItem['question']) && !empty($faqItem['answer'])) {

                  $count = $count+1;
                  $faqNum = "faq".$count;

                  ?>
              <div class="faq-item">
                <input type="checkbox" class="faq-toggle" id="<?= $faqNum; ?>">
                <label for="<?= $faqNum; ?>" class="faq-question"><?= $faqItem['question']; ?></label>
                <div class="faq-answer">
                  <?= $faqItem['answer']; ?>
                </div>
              </div>
            <?php


              }

             ?>

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
