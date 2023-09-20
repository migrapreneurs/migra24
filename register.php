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

      <meta name="viewport" content="width=device-width, initial-scale=1" />

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

          <section id="Inputs">
            <div class="col-xs-8">
              <h2 class="mar-b-60">Thank you! You just got access to Migra24, Feb 8 2024, Berlin.</h2>
              <p class="M">In order to get fully registered for the event, we need you to enter some essential personal details to ensure your seamless experience at Migra24, the migrant-first gathering in Berlin.</p>
            </div>

            <form action="finalize" method="POST">
            <div class="input-container mar-t-120 col-xs-12">
              <div class="input-wrapper">
                <label for="firstName">First name</label>
                <input type="text" id="firstName" name="firstName" disabled value="<?= $firstName; ?>">
              </div>

              <div class="input-wrapper">
                <label for="lastName">Second name</label>
                <input type="text" id="lastName" name="lastName" disabled value="<?= $lastName; ?>">
              </div>

              <div class="input-wrapper">
                <label for="eMail">Email address</label>
                <input type="email" id="eMail" name="eMail" disabled value="<?= $customerEmail; ?>">
              </div>

              <div class="input-wrapper">
                <label for="orderedPass">Ordered Pass</label>
                <input type="text" id="orderedPass" name="orderedPass" disabled value="<?= $ticketTitle; ?>">
              </div>

              <?php
              $allowedPassIDs = ['1', '3', '4', '5', '6', '7'];
              if (in_array($passID, $allowedPassIDs)) {
              ?>
              <div class="input-wrapper">
                  <label for="companyName">Company Name</label>
                  <input type="text" id="companyName" name="companyName" value="">
              </div>
              <?php } ?>

              <div class="select-container">
                <label for="reasonWhy">What are you looking for? <span class="text-red"> *</span></label>
                <select class="select-input" id="reasonWhy" name="reasonWhy" required>
                  <option disabled selected value></option>
                  <option value="exploreCommunityInsights">Explore Community Insights</option>
                  <option value="engageInPoliticalDiscussions">Engage in Political Discussions</option>
                  <option value="redfineEntrepreneurship">Redefine Entrepreneurship</option>
                  <option value="networkWithFounders">Network with Founders</option>
                  <option value="meetInvestors">Meet Investors</option>
                  <option value="exploreJobOpportunities">Explore Job Opportunities</option>
                  <option value="connectWithCompanies">Connect with Companies</option>
                  <option value="attendEmpoweringWorkshops">Attend Empowering Workshops</option>
                </select>
              </div>

            </div>

            <div class="input-container mar-t-60 col-xs-12">

              <div class="select-container">
                <label for="countryofOrigin">Country of Origin <span class="text-red"> *</span></label>
                <select class="select-input" id="countryofOrigin" name="countryofOrigin" required>
                  <option disabled selected value></option>
                  <option value="Afghanistan">Afghanistan</option>
                  <option value="Åland Islands">Åland Islands</option>
                  <option value="Albania">Albania</option>
                  <option value="Algeria">Algeria</option>
                  <option value="American Samoa">American Samoa</option>
                  <option value="Andorra">Andorra</option>
                  <option value="Angola">Angola</option>
                  <option value="Anguilla">Anguilla</option>
                  <option value="Antarctica">Antarctica</option>
                  <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                  <option value="Argentina">Argentina</option>
                  <option value="Armenia">Armenia</option>
                  <option value="Aruba">Aruba</option>
                  <option value="Australia">Australia</option>
                  <option value="Austria">Austria</option>
                  <option value="Azerbaijan">Azerbaijan</option>
                  <option value="Bahamas">Bahamas</option>
                  <option value="Bahrain">Bahrain</option>
                  <option value="Bangladesh">Bangladesh</option>
                  <option value="Barbados">Barbados</option>
                  <option value="Belarus">Belarus</option>
                  <option value="Belgium">Belgium</option>
                  <option value="Belize">Belize</option>
                  <option value="Benin">Benin</option>
                  <option value="Bermuda">Bermuda</option>
                  <option value="Bhutan">Bhutan</option>
                  <option value="Bolivia">Bolivia</option>
                  <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                  <option value="Botswana">Botswana</option>
                  <option value="Bouvet Island">Bouvet Island</option>
                  <option value="Brazil">Brazil</option>
                  <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                  <option value="Brunei Darussalam">Brunei Darussalam</option>
                  <option value="Bulgaria">Bulgaria</option>
                  <option value="Burkina Faso">Burkina Faso</option>
                  <option value="Burundi">Burundi</option>
                  <option value="Cambodia">Cambodia</option>
                  <option value="Cameroon">Cameroon</option>
                  <option value="Canada">Canada</option>
                  <option value="Cape Verde">Cape Verde</option>
                  <option value="Cayman Islands">Cayman Islands</option>
                  <option value="Central African Republic">Central African Republic</option>
                  <option value="Chad">Chad</option>
                  <option value="Chile">Chile</option>
                  <option value="China">China</option>
                  <option value="Christmas Island">Christmas Island</option>
                  <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                  <option value="Colombia">Colombia</option>
                  <option value="Comoros">Comoros</option>
                  <option value="Congo">Congo</option>
                  <option value="Congo, The Democratic Republic of the">Congo, The Democratic Republic of the</option>
                  <option value="Cook Islands">Cook Islands</option>
                  <option value="Costa Rica">Costa Rica</option>
                  <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                  <option value="Croatia">Croatia</option>
                  <option value="Cuba">Cuba</option>
                  <option value="Cyprus">Cyprus</option>
                  <option value="Czech Republic">Czech Republic</option>
                  <option value="Denmark">Denmark</option>
                  <option value="Djibouti">Djibouti</option>
                  <option value="Dominica">Dominica</option>
                  <option value="Dominican Republic">Dominican Republic</option>
                  <option value="Ecuador">Ecuador</option>
                  <option value="Egypt">Egypt</option>
                  <option value="El Salvador">El Salvador</option>
                  <option value="Equatorial Guinea">Equatorial Guinea</option>
                  <option value="Eritrea">Eritrea</option>
                  <option value="Estonia">Estonia</option>
                  <option value="Ethiopia">Ethiopia</option>
                  <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                  <option value="Faroe Islands">Faroe Islands</option>
                  <option value="Fiji">Fiji</option>
                  <option value="Finland">Finland</option>
                  <option value="France">France</option>
                  <option value="French Guiana">French Guiana</option>
                  <option value="French Polynesia">French Polynesia</option>
                  <option value="French Southern Territories">French Southern Territories</option>
                  <option value="Gabon">Gabon</option>
                  <option value="Gambia">Gambia</option>
                  <option value="Georgia">Georgia</option>
                  <option value="Germany">Germany</option>
                  <option value="Ghana">Ghana</option>
                  <option value="Gibraltar">Gibraltar</option>
                  <option value="Greece">Greece</option>
                  <option value="Greenland">Greenland</option>
                  <option value="Grenada">Grenada</option>
                  <option value="Guadeloupe">Guadeloupe</option>
                  <option value="Guam">Guam</option>
                  <option value="Guatemala">Guatemala</option>
                  <option value="Guernsey">Guernsey</option>
                  <option value="Guinea">Guinea</option>
                  <option value="Guinea-Bissau">Guinea-Bissau</option>
                  <option value="Guyana">Guyana</option>
                  <option value="Haiti">Haiti</option>
                  <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                  <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                  <option value="Honduras">Honduras</option>
                  <option value="Hong Kong">Hong Kong</option>
                  <option value="Hungary">Hungary</option>
                  <option value="Iceland">Iceland</option>
                  <option value="India">India</option>
                  <option value="Indonesia">Indonesia</option>
                  <option value="Iran, Islamic Republic Of">Iran, Islamic Republic Of</option>
                  <option value="Iraq">Iraq</option>
                  <option value="Ireland">Ireland</option>
                  <option value="Isle of Man">Isle of Man</option>
                  <option value="Israel">Israel</option>
                  <option value="Italy">Italy</option>
                  <option value="Jamaica">Jamaica</option>
                  <option value="Japan">Japan</option>
                  <option value="Jersey">Jersey</option>
                  <option value="Jordan">Jordan</option>
                  <option value="Kazakhstan">Kazakhstan</option>
                  <option value="Kenya">Kenya</option>
                  <option value="Kiribati">Kiribati</option>
                  <option value="Kosovo, Republic of">Kosovo, Republic of</option>
                  <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                  <option value="Korea, Republic of">Korea, Republic of</option>
                  <option value="Kuwait">Kuwait</option>
                  <option value="Kyrgyzstan">Kyrgyzstan</option>
                  <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                  <option value="Latvia">Latvia</option>
                  <option value="Lebanon">Lebanon</option>
                  <option value="Lesotho">Lesotho</option>
                  <option value="Liberia">Liberia</option>
                  <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                  <option value="Liechtenstein">Liechtenstein</option>
                  <option value="Lithuania">Lithuania</option>
                  <option value="Luxembourg">Luxembourg</option>
                  <option value="Macao">Macao</option>
                  <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                  <option value="Madagascar">Madagascar</option>
                  <option value="Malawi">Malawi</option>
                  <option value="Malaysia">Malaysia</option>
                  <option value="Maldives">Maldives</option>
                  <option value="Mali">Mali</option>
                  <option value="Malta">Malta</option>
                  <option value="Marshall Islands">Marshall Islands</option>
                  <option value="Martinique">Martinique</option>
                  <option value="Mauritania">Mauritania</option>
                  <option value="Mauritius">Mauritius</option>
                  <option value="Mayotte">Mayotte</option>
                  <option value="Mexico">Mexico</option>
                  <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                  <option value="Moldova, Republic of">Moldova, Republic of</option>
                  <option value="Monaco">Monaco</option>
                  <option value="Mongolia">Mongolia</option>
                  <option value="Montserrat">Montserrat</option>
                  <option value="Morocco">Morocco</option>
                  <option value="Mozambique">Mozambique</option>
                  <option value="Myanmar">Myanmar</option>
                  <option value="Namibia">Namibia</option>
                  <option value="Nauru">Nauru</option>
                  <option value="Nepal">Nepal</option>
                  <option value="Netherlands">Netherlands</option>
                  <option value="Netherlands Antilles">Netherlands Antilles</option>
                  <option value="New Caledonia">New Caledonia</option>
                  <option value="New Zealand">New Zealand</option>
                  <option value="Nicaragua">Nicaragua</option>
                  <option value="Niger">Niger</option>
                  <option value="Nigeria">Nigeria</option>
                  <option value="Niue">Niue</option>
                  <option value="Norfolk Island">Norfolk Island</option>
                  <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                  <option value="Norway">Norway</option>
                  <option value="Oman">Oman</option>
                  <option value="Pakistan">Pakistan</option>
                  <option value="Palau">Palau</option>
                  <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                  <option value="Panama">Panama</option>
                  <option value="Papua New Guinea">Papua New Guinea</option>
                  <option value="Paraguay">Paraguay</option>
                  <option value="Peru">Peru</option>
                  <option value="Philippines">Philippines</option>
                  <option value="Pitcairn">Pitcairn</option>
                  <option value="Poland">Poland</option>
                  <option value="Portugal">Portugal</option>
                  <option value="Puerto Rico">Puerto Rico</option>
                  <option value="Qatar">Qatar</option>
                  <option value="Reunion">Reunion</option>
                  <option value="Romania">Romania</option>
                  <option value="Russian Federation">Russian Federation</option>
                  <option value="Rwanda">Rwanda</option>
                  <option value="Saint Helena">Saint Helena</option>
                  <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                  <option value="Saint Lucia">Saint Lucia</option>
                  <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                  <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                  <option value="Samoa">Samoa</option>
                  <option value="San Marino">San Marino</option>
                  <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                  <option value="Saudi Arabia">Saudi Arabia</option>
                  <option value="Senegal">Senegal</option>
                  <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                  <option value="Seychelles">Seychelles</option>
                  <option value="Sierra Leone">Sierra Leone</option>
                  <option value="Singapore">Singapore</option>
                  <option value="Slovakia">Slovakia</option>
                  <option value="Slovenia">Slovenia</option>
                  <option value="Solomon Islands">Solomon Islands</option>
                  <option value="Somalia">Somalia</option>
                  <option value="South Africa">South Africa</option>
                  <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                  <option value="Spain">Spain</option>
                  <option value="Sri Lanka">Sri Lanka</option>
                  <option value="Sudan">Sudan</option>
                  <option value="Surilabel">Surilabel</option>
                  <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                  <option value="Swaziland">Swaziland</option>
                  <option value="Sweden">Sweden</option>
                  <option value="Switzerland">Switzerland</option>
                  <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                  <option value="Taiwan">Taiwan</option>
                  <option value="Tajikistan">Tajikistan</option>
                  <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                  <option value="Thailand">Thailand</option>
                  <option value="Timor-Leste">Timor-Leste</option>
                  <option value="Togo">Togo</option>
                  <option value="Tokelau">Tokelau</option>
                  <option value="Tonga">Tonga</option>
                  <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                  <option value="Tunisia">Tunisia</option>
                  <option value="Turkey">Turkey</option>
                  <option value="Turkmenistan">Turkmenistan</option>
                  <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                  <option value="Tuvalu">Tuvalu</option>
                  <option value="Uganda">Uganda</option>
                  <option value="Ukraine">Ukraine</option>
                  <option value="United Arab Emirates">United Arab Emirates</option>
                  <option value="United Kingdom">United Kingdom</option>
                  <option value="United States">United States</option>
                  <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                  <option value="Uruguay">Uruguay</option>
                  <option value="Uzbekistan">Uzbekistan</option>
                  <option value="Vanuatu">Vanuatu</option>
                  <option value="Venezuela">Venezuela</option>
                  <option value="Vietnam">Vietnam</option>
                  <option value="Virgin Islands, British">Virgin Islands, British</option>
                  <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                  <option value="Wallis and Futuna">Wallis and Futuna</option>
                  <option value="Western Sahara">Western Sahara</option>
                  <option value="Yemen">Yemen</option>
                  <option value="Zambia">Zambia</option>
                  <option value="Zimbabwe">Zimbabwe</option>
                </select>
              </div>

              <div class="input-wrapper">
                <label for="City">In which city do you currently live?</label>
                <input type="text" id="City" name="City" value="">
              </div>

              <div class="select-container">
                <label for="industry">Which industry do you operate in? <span class="text-red"> *</span></label>
                <select class="select-input" id="industry" name="industry" required>
                  <option disabled selected value></option>
                  <option value="analytics">Analytics</option>
                  <option value="biotech">Biotech</option>
                  <option value="cleantech">Cleantech</option>
                  <option value="climate">Climate</option>
                  <option value="clothingFashion">Clothing &amp; Fashion</option>
                  <option value="comms">Communications</option>
                  <option value="consumerElectronics">Consumer Electronics</option>
                  <option value="crypto">Cryptocurrencies</option>
                  <option value="cyber">Cyber Security</option>
                  <option value="onlineMarkets">E-commerce</option>
                  <option value="edu">Education</option>
                  <option value="energy">Energy</option>
                  <option value="enterpriseSoftware">Enterprise Software</option>
                  <option value="eventTech">Event Tech</option>
                  <option value="fintech">Fintech &amp; Insurance Tech</option>
                  <option value="food">Food &amp; Nutrition</option>
                  <option value="gaming">Gaming</option>
                  <option value="health">Health &amp; Wellbeing</option>
                  <option value="home">Home &amp; Living</option>
                  <option value="recruitment">Jobs &amp; Recruitment</option>
                  <option value="legal">Legal Tech</option>
                  <option value="manufacturingMaterials">Manufacturing &amp; Materials</option>
                  <option value="marketingAds">Marketing &amp; AdTech</option>
                  <option value="media">Media</option>
                  <option value="medtechPharma">Medtech &amp; Pharma</option>
                  <option value="mobility">Mobility</option>
                  <option value="MusicEntertainment">Music, Arts &amp; Entertainment</option>
                  <option value="propConstruction">Property &amp; Construction Tech</option>
                  <option value="robo">Robotics</option>
                  <option value="realestate">Real Estate</option>
                  <option value="regtech">Regtech &amp; Compliance</option>
                  <option value="socialImpact">Social Impact</option>
                  <option value="someMessaging">Social Media &amp; Messaging</option>
                  <option value="space">Spacetech</option>
                  <option value="sports">Sports</option>
                  <option value="logistics">Transportation &amp; Logistics</option>
                  <option value="travel">Travel &amp; Leisure</option>
                  <option value="wearables">Wearables</option>
                  <option value="somethingElse">Something Else</option>

                </select>
              </div>



              <div class="select-container">
                <label for="currentJob">What is your current occupation? <span class="text-red"> *</span></label>
                <select class="select-input" id="currentJob" name="currentJob" required>
                  <option disabled selected value></option>
                  <option value="academic">Academic Researcher</option>
                  <option value="artist-creative">Artist &amp; Creative Professional</option>
                  <option value="business-development">Business Development Professional</option>
                  <option value="ceo">CEO</option>
                  <option value="comms-media-pr">Communication or PR Professional</option>
                  <option value="community-hub-manager">Community &amp; Hub Manager</option>
                  <option value="content-creator">Content Creator</option>
                  <option value="customer-user-professional">Customer or User Professional</option>
                  <option value="data-analyst">Data or Analytics Professional</option>
                  <option value="developer">Developer</option>
                  <option value="designer">Designer</option>
                  <option value="event-organizer">Event Organizer</option>
                  <option value="finance">Finance Professional</option>
                  <option value="freelancer">Freelancer</option>
                  <option value="founder">Founder</option>
                  <option value="hr-director">People, Culture or DEI Professional</option>
                  <option value="investor">Investor</option>
                  <option value="it-professional">IT Professional</option>
                  <option value="journalist">Journalist</option>
                  <option value="legal">Legal Professional</option>
                  <option value="marketing-branding">Marketing or Branding Professional</option>
                  <option value="non-c-exec">Non C-level executive</option>
                  <option value="other-c-exec">Other C-level executive</option>
                  <option value="operations">Operations</option>
                  <option value="other">Other</option>
                  <option value="product management">Product Management</option>
                  <option value="sales">Sales Professional</option>
                  <option value="student">Student</option>


                </select>
              </div>

              <div class="input-wrapper">
                <input type="hidden" name="orderID" value="<?= $orderID; ?>">
                <input type="hidden" name="firstName" value="<?= $firstName; ?>">
                <input type="hidden" name="lastName" value="<?= $lastName; ?>">
                <input type="hidden" name="eMail" value="<?= $customerEmail; ?>">
                <input type="hidden" name="orderedPass" value="<?= $ticketTitle; ?>">
              </div>


            </div>
            <!-- Submit Button -->
            <div class="mar-t-60 col-xs-12">
              <input class="btn large bg-yellow text-black" type="submit" value="Submit and Download your Ticket">
            </div>
          </form>

          </section>


        </main>

        <?php //include('_assets/_script/footer.php'); ?>





    </body>
  </html>

  <?php
  error_reporting(E_ALL);
ini_set('display_errors', 1);
 ?>
