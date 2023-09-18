<?php include('init.php'); ?>

<!doctype html>
  <html lang="<?= $LANG; ?>">
    <head>

      <base href="<?= $BASE; ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name=robots content="noindex,nofollow">
      <link rel="stylesheet" href="_assets/_css/full.css.php">


    </head>
    <body>



      <header>
        <div class="logo"><img src="_assets/_images/migra-logo.svg" alt="Migra24 Logo" /></div>
        <nav>
          <ul>
            <li><a class="btn standard bg-red text-white" href="#">Become an exhibitor</a></li>
            <li><a href="#">Why attend</a></li>
            <li><a href="#">Speakers</a></li>
            <li><a href="#">Partners</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a class="btn standard bg-turquoise text-black" href="#">Buy Tickets</a></li>
          </ul>
        </nav>
        <div class="icon-container">
          <img src="_assets/_images/hamburger.svg" class="hamburger-icon" />
          <img src="_assets/_images/close.svg" class="close-icon hidden" /> <!-- Initially hidden -->
        </div>
        <div class="mobile-menu">
          <ul>
            <li><a href="#">Why attend</a></li>
            <li><a href="#">Speakers</a></li>
            <li><a href="#">Partners</a></li>
            <li><a href="#">FAQ</a></li>
            <div class="col-xs-12 mar-t-120">
              <li><a class="btn large bg-turquoise text-black S" href="#">Buy Tickets</a></li>
              <li><a class="btn large bg-red text-white S" href="#">Become an exhibitor</a></li>
            </div>
          </ul>
        </div>
      </header>
      <script src="_assets/_script/mobile-menu.js"></script>
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

          <div class="hero row middle-xs">
            <div class="col-lg-8 col-lg-offset-1 col-xs-11 col-xs-offset-1 hero-text">
              <h1 class="h1XL">The only migrant-focused talent gathering in Berlin.</h1>
              <p class="S">Migrapreneur is a non-profit and the world’s largest gathering of VC – delivering actionable company-building advice and bringing together the who’s who in startups.</p>
              <div class="col-xs-12 mar-t-80 hero-cta-container">
                <a class="btn large bg-turquoise text-black S" href="#">Buy Tickets</a>
                <div class="bg-yellow text-black S bold" id="countdown"></div>
              </div>

            </div>
          </div>

        <main>
          <section class="row mar-t-60 col-xs-12">
            <div class="col-xs-12">

              <div id="Typography" class="col-xs-12">
                  <h6 class="mar-b-60">Typography</h6>
                  <h1 class="h1XL">HeadlineXL</h1>
                  <h1>Headline H1</h1>
                  <h2>Headline H2</h2>
                  <h3>Headline H3</h3>
                  <h4>Headline H4</h4>
                  <h5>Headline H5</h5>
                  <h6>Headline H6</h6>
                  <p class="L">Increase your open rates and get more responses – powered by a well-tuned AI.</p>
                  <p class="M">Increase your open rates and get more responses – powered by a well-tuned AI.</p>
                  <p class="S">Increase your open rates and get more responses – powered by a well-tuned AI.</p>
                  <p class="XS">Increase your open rates and get more responses – powered by a well-tuned AI.</p>
              </div>
              <div id="Buttons" class="mar-t-80">
                  <h6 class="mar-b-60">Buttons</h6>
                  <button class="btn large text-white bg-red">Button Large</button>
                  <button class="btn standard text-black bg-turquoise">Button Standard</button>
              </div>

              <div id="StandardLists" class="mar-t-80">
                  <h6 class="mar-b-60">Standard Lists</h6>
                  <ul class="standard">
                    <li>Great opportunity to <b>connect with more</b> than 1000+ attendees.</li>
                    <li>Connect and stay in touch with other companies and platforms in other fields such as the medical and health field, media, education institutions and more...</li>
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                  </ul>
                  <ul class="circle white">
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                    <li>Connect and stay in touch with other companies and platforms in other fields such as the medical and health field, media, education institutions and more...</li>
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                  </ul>

                  <ul class="circle black">
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                    <li>Connect and stay in touch with other companies and platforms in other fields such as the medical and health field, media, education institutions and more...</li>
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                    <li>Great opportunity to connect with more than 1000+ attendees.</li>
                  </ul>
              </div>
              <div id="RoundedBoxes" class="mar-t-80">
                  <h6 class="mar-b-60">Rounded Boxes</h6>
                  <div class="rounded-box bg-yellow text-black">
                    <h3>Headline</h3>
                    <p class="S">Connect and stay in touch with other companies and platforms in other fields such as the medical and health field, media, education institutions and more...</p>
              </div>
              <div id="Inputs" class="mar-t-80">
                <h6 class="mar-b-60">Inputs</h6>
                <div class="input-container">
                  <div class="input-wrapper">
                    <label for="input1">Label 1</label>
                    <input type="text" id="input1" name="input1">
                  </div>

                  <div class="input-wrapper">
                    <label for="input2">Label 2</label>
                    <input type="text" id="input2" name="input2">
                  </div>

                  <div class="input-wrapper">
                    <label for="input2">Label 2</label>
                    <input type="text" id="input2" name="input2">
                  </div>

                  <div class="input-wrapper">
                    <label for="input2">Label 2</label>
                    <input type="text" id="input2" name="input2">
                  </div>

                  <div class="input-wrapper">
                    <label for="input2">Label 2</label>
                    <input type="text" id="input2" name="input2">
                  </div>

                  <div class="select-container">
                    <label for="input2">Label 2</label>
                    <select class="select-input">
                      <option></option>
                      <option value="option1">Option 1</option>
                      <option value="option2">Option 2</option>
                      <option value="option3">Option 3</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>



                </div>

              </div>
              <div id="Accordions" class="mar-t-80">
                <h6 class="mar-b-60">Accordions</h6>
                <div class="faq-container">
                  <div class="faq-item">
                    <input type="checkbox" class="faq-toggle" id="faq1">
                    <label for="faq1" class="faq-question">Question 1</label>
                    <div class="faq-answer">
                      Answer 1 goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </div>
                  </div>
                  <div class="faq-item">
                    <input type="checkbox" class="faq-toggle" id="faq2">
                    <label for="faq2" class="faq-question">Question 2</label>
                    <div class="faq-answer">
                      Answer 2 goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </div>
                  </div>
                  <div class="faq-item">
                    <input type="checkbox" class="faq-toggle" id="faq3">
                    <label for="faq3" class="faq-question">Question 3</label>
                    <div class="faq-answer">
                      Answer 3 goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </div>
                  </div>
                </div>

              </div>
              <div id="Carousel" class="mar-t-80">
                <h6 class="mar-b-60">Draggable Image Gallery</h6>
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
              </div>
              <div id="Cards" class="mar-t-80">
                <h6 class="mar-b-60">Draggable Card List</h6>
                <div class="card-list-container">
                  <div class="card-list">
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="_assets/_images/_speakers/speaker_1.jpg" alt="Ana Alvarez">
                      <div class="card-text">
                        <h3 class="L">Ana Alvarez</h3>
                        <p>CEO and Co-Founder of Migrapreneur</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div id="Cards" class="mar-t-80">
                <h6 class="mar-b-60">Standard Table</h6>
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


              </div>


            </div>
          </section>

        </main>





    </body>
  </html>
