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


$json_url = 'https://raw.githubusercontent.com/migrapreneurs/migra24/main/_data/migra-exhibitor.json';

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

var_dump($jsonData['sections']['faq']);

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




        <?php include('_assets/_script/header.php'); ?>


        <!-- HERO STAGE -->
        <div class="hero-secondary row middle-xs bg-lille">
          <div class="col-md-6 col-xs-12 text first-md first-md">
            <h1><?= $jsonData['sections']['header']['title']; ?></h1>
            <p class="S"><?= $jsonData['sections']['header']['subtitle']; ?></p>
          </div>
          <div class="col-md-6 col-xs-12 first-xs">
            <picture class="col-xs-12">
              <!-- Define your <source> elements for various screen widths here -->
              <source media="(min-width: 2000px)" srcset="https://placehold.co/2400x1800/FF3300/FFFFFF" type="image/webp">
              <source media="(min-width: 1025px)" srcset="https://placehold.co/1200x900/FF3300/FFFFFF" type="image/webp">
              <source media="(min-width: 767px)" srcset="https://placehold.co/800x400/FF3300/FFFFFF" type="image/webp">
              <source media="(min-width: 300px)" srcset="https://placehold.co/400x200/FF3300/FFFFFF" type="image/webp">
              <img src="https://placehold.co/400x400/FF3300/FFFFFF" alt="Image 1" width="1460" height="800">
            </picture>
          </div>
        </div>


        <main>
          <!-- WHY ATTEND -->
          <section id="Why" class="row col-xs-12 top-xs">
            <h2 class="h1 mar-b-60"><?= $jsonData['sections']['why']['title']; ?></h2>
            <div class="col-md-6">
              <ul class="standard col-xs-12 mar-b-60">
              <?php
              foreach ($jsonData['sections']['why']['benefits'] as $benefit) {
                echo '<li>' . $benefit['text'] . '</li>';
              }
              ?>
              </ul>
            </div>
            <div class="col-md-5 col-md-offset-1 rounded-box bg-yellow text-black top-xs">
              <h3>Book your seats now before your competitor does, as there are limited stands available!</h3>
              <ul class="circle black mar-b-20">
                <li>The quicker you are at booking your place, the better location you get of your choice. The availability of rostrums, assignment of communication/presentation apertures and workspaces of the events are limited.</li>
                <li>This is a chance not to be missed, if you’re not there your competitors will be!</li>
              </ul>
              <a class="btn standard bg-black text-white S mar-t-20" href="#">Book a call</a>
            </div>

          </section>

          <section id="Carousel">
            <h2 class="h1 mar-b-60">The Venue</h2>
            <script src="_assets/_script/gallery.js"></script>
            <div class="gallery-container">
              <div class="gallery">
                <div class="gallery-slide">
                  <picture>
                    <!-- Define your <source> elements for various screen widths here -->
                    <source media="(min-width: 2000px)" srcset="https://placehold.co/2400x1200/FF3300/FFFFFF" type="image/webp">
                    <source media="(min-width: 1025px)" srcset="https://placehold.co/1200x600/FF3300/FFFFFF" type="image/webp">
                    <source media="(min-width: 767px)" srcset="https://placehold.co/800x500/FF3300/FFFFFF" type="image/webp">
                    <source media="(min-width: 300px)" srcset="https://placehold.co/400x500/FF3300/FFFFFF" type="image/webp">
                    <img src="https://placehold.co/400x300/FF3300/FFFFFF" alt="Image 1" width="1460" height="800">
                  </picture>
                </div>
                <div class="gallery-slide">
                  <picture>
                    <!-- Define your <source> elements for various screen widths here -->
                    <source media="(min-width: 2000px)" srcset="https://placehold.co/2400x1200/FFFFFF/FF3300" type="image/webp">
                    <source media="(min-width: 1025px)" srcset="https://placehold.co/1200x600/FFFFFF/FF3300" type="image/webp">
                    <source media="(min-width: 767px)" srcset="https://placehold.co/800x500/FFFFFF/FF3300" type="image/webp">
                    <source media="(min-width: 300px)" srcset="https://placehold.co/400x500/FFFFFF/FF3300" type="image/webp">
                    <img src="https://placehold.co/400x300/FFFFFF/FF3300" alt="Image 1" width="1460" height="800">
                  </picture>
                </div>
                <!-- Add more .gallery-slide divs for additional images -->
              </div>
              <div class="gallery-bullets"></div>
            </div>
            <div class="col-xs-12 mar-t-60">
              <address class="col-xs-6 mar-b-20">
                <p class="bold M"><?= $jsonData['sections']['venue'][0]['name']; ?></p>
                <p class="S">
                  <?= $jsonData['sections']['venue'][0]['address']; ?><br />
                  <?= $jsonData['sections']['venue'][0]['zipcode']; ?>, <?= $jsonData['sections']['venue'][0]['city']; ?>
                </p>
              </address>
              <a href="<?= $jsonData['sections']['venue'][0]['mapslink']; ?>" class="btn standard bg-turquoise text-black" target="_blank">View on Google Maps</a>
            </div>
          </section>





          <!-- BOOTH PLANS -->
          <section id="Booth Plans" class="mar-t-80">
            <div class="row col-xs-12 mar-b-60">
              <div class="col-md-5 col-md-offset-1">
                <h2 class="h1">Booth Plans</h2>
                  <p class="M">Let’s discuss your needs and requirements and let us make this happen together.</p>
              </div>
              <div class="col-md-5 col-md-offset-1">
                <a class="btn large bg-yellow text-black" href="">Book a call</a>
              </div>

            </div>
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th class="bold first-column">Booth Type</th>
                    <th>Description</th>
                    <th>Unit Size</th>
                    <th class="right">Unit Price</th>
                    <th class="right">Total Price</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="bold first-column">Type A</td>
                    <td>Data 1</td>
                    <td>Data 2</td>
                    <td class="right">Data 3</td>
                    <td class="M right">€2,500.00</td>
                  </tr>
                  <tr>
                    <td class="bold first-column">Type B</td>
                    <td>Data 1</td>
                    <td>Data 2</td>
                    <td class="right">Data 3</td>
                    <td class="M right">€7,500.00</td>
                  </tr>
                  <!-- Add more rows as needed -->
                </tbody>
              </table>
            </div>


          </section>



          <!-- FAQ -->
          <section id="FAQ">

            <div class="faq-container col-md-8 col-md-offset-2">
              <h2 class="h1 mar-b-60">Frequently Asked Questions</h2>
              <?php

              foreach ($jsonData['sections']['faq'] as $faqItem) {

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
            <?php } ?>

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
