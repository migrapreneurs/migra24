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


// HOME DATA
    $json_url = 'https://raw.githubusercontent.com/migrapreneurs/migra24/main/_data/migra-home.json';

    // Fetch the JSON data
    $json_data = file_get_contents($json_url);

    // Decode the JSON data into an associative array
    $jsonData = json_decode($json_data, true);

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
          <section id="Why" class="row mar-t-120 col-xs-12">
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

          <!-- FAQ -->
          <section id="FAQ">

            <div class="faq-container col-md-8 col-md-offset-2">
              <h2 class="h1 mar-b-60">Frequently Asked Questions</h2>
              <?php
              foreach ($jsonData['sections']['faq'] as $faqItem) {
                if (!empty($faqItem['question']) && !empty($faqItem['answer'])) { ?>
              <div class="faq-item">
                <input type="checkbox" class="faq-toggle" id="faq1">
                <label for="faq1" class="faq-question">Question 1</label>
                <div class="faq-answer">
                  Answer 1 goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </div>
              </div>
            <?php }} ?>

            </div>
          </section>

        </main>





    </body>
  </html>

  <?php
  error_reporting(E_ALL);
ini_set('display_errors', 1);
 ?>
