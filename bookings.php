
<?php

require_once 'connect.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"] ?? '';
    $lastname = $_POST["lastname"] ?? '';
    $email = $_POST["email"] ?? '';
    $contact = $_POST["contact"] ?? '';
    $anyother = $_POST["anyother"] ?? null;

    $region = $_POST["selected_region"] ?? '';
    $destination = $_POST["selected_destination"] ?? '';

    $selected_price = $_POST["selected_price"] ?? null;
    $selected_currency = $_POST["selected_currency"] ?? null;

    $payment_method = $_POST["payment_method"] ?? '';

    $card_number = $_POST["card_number"] ?? null;
    $paypal_email = $_POST["paypal_email"] ?? null;

    $cash_amount_paid = $_POST["cash_amount_paid"] ?? null;

    $sql = "INSERT INTO bookings (firstname, lastname, email, contact, anyother, region, destination, selected_price, selected_currency, payment_method, card_number, paypal_email, cash_amount_paid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssdssssd",
            $firstname,
            $lastname,
            $email,
            $contact,
            $anyother,
            $region,
            $destination,
            $selected_price,
            $selected_currency,
            $payment_method,
            $card_number,
            $paypal_email,
            $cash_amount_paid
        );

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Booking successfully submitted!";
        } else {
            error_log("Database Execute Error (Bookings): " . mysqli_stmt_error($stmt));
            $error_message = "Error saving your booking. Please try again. Details: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        error_log("Database Prepare Error (Bookings): " . mysqli_error($con));
        $error_message = "Error preparing booking statement. Please try again. Details: " . mysqli_error($con);
    }
}

if (isset($con) && $con) {
    mysqli_close($con);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings-Wildpath Expeditions</title>
    <link rel="stylesheet" href="bookings.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group select,
         .form-group input[type="number"]
         {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .read-only-field {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }
        .booking-summary {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .booking-summary p {
            margin-bottom: 8px;
        }

        form div.name {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
         form div.name > div.first {
             flex: 1;
         }
        form input.place,
        form select.Destination-place,
        form input.places {
             width: 100%;
             padding: 10px;
             margin-bottom: 15px;
             border: 1px solid #ccc;
             border-radius: 5px;
             box-sizing: border-box;
        }
        form button#submit {
             width: auto;
             padding: 10px 20px;
             background-color: #f4bc07;
             color: white;
             border: none;
             border-radius: 5px;
             cursor: pointer;
             font-size: 1em;
        }

        .payment-details-container {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .payment-details-container .form-group {
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
<div class="navigation-bar">
        <div id="head">
            <img id="icon" src="icon.jpeg" alt="Company Icon">
        </div>
        <div class="introduction">
            <div>
                <p class="Company-name">WILDPATH EXPEDITIONS</p>
            </div>
            <div id="services">
                <a href="home.html" class="service">HOME</a>
                <a href="activities.html" class="service">SERVICES</a>
                <a href="destinations.html" class="service">DESTINATIONS</a>
                <a href="contacts.php" class="service">CONTACT US</a>  <a href="bookings.php" class="service">BOOKINGS</a>  </div>
        </div>
    </div>
    <div class="container">
        <video autoplay muted loop>
                  <source src="images/bookings-video.mp4" type="video/mp4">
              </video>
        <div class="text">
            <p style="margin-bottom: 0; color: rgb(244, 188, 7);">Wildpath Expeditions</p>
            <p style="margin: 40px; text-align: center;">Bookings</p>
        </div>
    </div>
    <div>
        <p class="preamble2">
            Book with us today so that we can make your tour in the Pearl of Africa super fantastic one
        </p>
    </div>

    <?php
    if ($success_message) {
        echo '<p style="color: green; text-align: center;">' . htmlspecialchars($success_message) . '</p>';
    }
    if ($error_message) {
        echo '<p style="color: red; text-align: center;">' . htmlspecialchars($error_message) . '</p>';
    }
    ?>

    <form action="bookings.php" method="post" id="mainBookingForm"> <div class="name">
            <div class="first">
                <input class="place" type="text" placeholder="First Name" name="firstname" id="firstname" required>
            </div>
            <div class="first">
                <input class="place" type="text" placeholder="Last Name" name="lastname" id="lastname" required>
            </div>
        </div>
        <div class="name">
            <div class="first">
                <input class="place" type="text" placeholder="Email" name="email" id="email" required>
            </div>
            <div class="first">
                <input class="place" type="Tel" placeholder="Contact" name="contact" id="contact" required>
            </div>
        </div>

        <div class="form-group">
            <label for="region">Region:</label>
            <select id="region" required>
                <option value="">Select Region</option>
                <option value="Eastern Region">Eastern Region</option>
                <option value="Western Region">Western Region</option>
                <option value="Central Region">Central Region</option>
                <option value="Northern Region">Northern Region</option>
            </select>
        </div>

        <div class="form-group">
             <label for="destination">Destination:</label>
             <select class="Destination-place" id="destination" required>
                <option value="">Select Destination</option>
                <option value="Sipi Falls">Sipi Falls</option>
                <option value="The New Jinja Road Bridge">The New Jinja Road Bridge</option>
                <option value="Mountain Elgon slopes">Mountain Elgon slopes</option>
                <option value="Camps Along the slopes">Camps Along the slopes</option>
                <option value="Road Rotation">Road Rotation</option>
                <option value="Ragged Terran Rwenzori">Ragged Terran Rwenzori</option>
                <option value="Snow Capped Scenaries">Snow Capped Scenaries</option>
                <option value="River Mpologoma">River Mpologoma</option>
                <option value="Lake Victoria">Lake Victoria</sipi>
                <option value="Buganda Palace">Buganda Palace</option>
                <option value="Uganda Wildlife Center">Uganda Wildlife Center</option>
                <option value="Uganda Museum">Uganda Museum</option>
                <option value="Game Parks">Game Parks</option>
                <option value="Vegetation">Vegetation</option>
                <option value="Bird Sanctuaries">Bird Sanctuaries</option>
                <option value="Karuma Falls">Karuma Falls</option>
             </select>
        </div>

         <div class="form-group">
             <label for="booking_currency">Select Currency:</label>
             <select id="booking_currency" required>
                 <option value="UGX">UGX</option>
                 <option value="USD">USD</option>
                 <option value="EUR">EUR</option>
             </select>
         </div>


        <div class="booking-summary">
            <p>Selected Destination: <span id="selected-destination-display">Not Selected</span></p>
            <p>Selected Region: <span id="selected-region-display">Not Selected</span></p>
            <p>Estimated Price: <span id="selected-price-display"></span> <span id="selected-currency-display"></span></p>
             <input type="hidden" name="selected_destination" id="hidden-destination">
             <input type="hidden" name="selected_region" id="hidden-region">
             <input type="hidden" name="selected_price" id="hidden-price">
             <input type="hidden" name="selected_currency" id="hidden-currency">
        </div>

        <div class="payment-details-container max-w-md mx-auto bg-white p-8 rounded-xl shadow-md">
            <h3 class="text-lg font-bold mb-4">Payment Information</h3>
            <div class="form-group">
                <label for="payment_method" class="ph">Payment Method:</label>
                <select id="payment_method" name="payment_method" class="ph" required>
                    <option value="">Select Method</option>
                    <option value="creditcard">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="cash">Cash</option>
                </select>
                <div id="payment-method-error" class="ph text-red-500 text-sm mt-1" style="display: none;"></div>
            </div>

            <div id="creditCardDetails" style="display: none;">
                <div class="form-group">
                    <label for="card_number" class="ph">Card Number:</label>
                    <input type="text" id="card_number" name="card_number" class="ph" placeholder="Enter card number">
                    <div id="card-number-error" class="ph text-red-500 text-sm mt-1" style="display: none;"></div>
                </div>
            </div>

            <div id="paypalDetails" style="display: none;">
                <div class="form-group">
                    <label for="paypal_email" class="ph">PayPal Email:</label>
                    <input type="email" id="paypal_email" name="paypal_email" class="ph" placeholder="Enter PayPal email">
                    <div id="paypal-email-error" class="ph text-red-500 text-sm mt-1" style="display: none;"></div>
                </div>
            </div>

            <div id="cashDetails" style="display: none;">
                <div class="form-group">
                    <label for="cash_amount">Cash Amount:</label>
                    <input type="number" id="cash_amount" name="cash_amount_paid" class="ph" placeholder="Amount to pay">
                    <div id="cash-amount-error" class="ph text-red-500 text-sm mt-1" style="display: none;"></div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <input class="places" type="text" placeholder="Any other Content" name="anyother" id="anyother"><br><br>
        <div class="name">
            <div class="first"> <button id="submit" type="Submit">Submit Booking</button></div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const getQueryParams = () => {
                const params = {};
                const queryString = window.location.search.substring(1);
                const regex = /([^&=]+)=([^&]*)/g;
                let m;
                while (m = regex.exec(queryString)) {
                    params[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                }
                return params;
            };

            const destinationData = {
                "Sipi Falls": { region: "Eastern Region", prices: {"UGX": 100000, "USD": 30, "EUR": 25} },
                "The New Jinja Road Bridge": { region: "Eastern Region", prices: {"UGX": 50000, "USD": 15, "EUR": 12} },
                "Mountain Elgon slopes": { region: "Eastern Region", prices: {"UGX": 150000, "USD": 45, "EUR": 40} },
                "Camps Along the slopes": { region: "Eastern Region", prices: {"UGX": 200000, "USD": 60, "EUR": 55} },
                "Road Rotation": { region: "Western Region", prices: {"UGX": 80000, "USD": 25, "EUR": 20} },
                "Ragged Terran Rwenzori": { region: "Western Region", prices: {"UGX": 250000, "USD": 75, "EUR": 70} },
                "Snow Capped Scenaries": { region: "Western Region", prices: {"UGX": 300000, "USD": 90, "EUR": 85} },
                "River Mpologoma": { region: "Western Region", prices: {"UGX": 70000, "USD": 20, "EUR": 18} },
                "Lake Victoria": { region: "Central Region", prices: {"UGX": 60000, "USD": 18, "EUR": 15} },
                "Buganda Palace": { region: "Central Region", prices: {"UGX": 40000, "USD": 12, "EUR": 10} },
                "Uganda Wildlife Center": { region: "Central Region", prices: {"UGX": 120000, "USD": 35, "EUR": 30} },
                "Uganda Museum": { region: "Central Region", prices: {"UGX": 30000, "USD": 10, "EUR": 8} },
                "Game Parks": { region: "Northern Region", prices: {"UGX": 200000, "USD": 60, "EUR": 55} },
                "Vegetation": { region: "Northern Region", prices: {"UGX": 50000, "USD": 15, "EUR": 12} },
                "Bird Sanctuaries": { region: "Northern Region", prices: {"UGX": 100000, "USD": 30, "EUR": 25} },
                "Karuma Falls": { region: "Northern Region", prices: {"UGX": 90000, "USD": 28, "EUR": 23} }
            };

            const params = getQueryParams();
            const urlDestination = params.destination || '';
            const urlRegion = params.region || '';
            const urlPrice = params.price || '';
            const urlCurrency = params.currency || '';

            const mainBookingForm = document.getElementById('mainBookingForm');
            const destinationSelect = document.getElementById('destination');
            const regionSelect = document.getElementById('region');
            const bookingCurrencySelect = document.getElementById('booking_currency');
            const paymentMethodSelect = document.getElementById('payment_method');
            const cashAmountInput = document.getElementById('cash_amount');

            const selectedDestinationDisplay = document.getElementById('selected-destination-display');
            const selectedRegionDisplay = document.getElementById('selected-region-display');
            const selectedPriceDisplay = document.getElementById('selected-price-display');
            const selectedCurrencyDisplay = document.getElementById('selected-currency-display');

            const hiddenDestinationInput = document.getElementById('hidden-destination');
            const hiddenRegionInput = document.getElementById('hidden-region');
            const hiddenPriceInput = document.getElementById('hidden-price');
            const hiddenCurrencyInput = document.getElementById('hidden-currency');

            const creditCardDetailsDiv = document.getElementById('creditCardDetails');
            const paypalDetailsDiv = document.getElementById('paypalDetails');
            const cashDetailsDiv = document.getElementById('cashDetails');

            const paymentMethodError = document.getElementById('payment-method-error');
            const cardNumberInput = document.getElementById('card_number');
            const cardNumberError = document.getElementById('card-number-error');
            const paypalEmailInput = document.getElementById('paypal_email');
            const paypalEmailError = document.getElementById('paypal-email-error');

            const cashAmountError = document.getElementById('cash-amount-error');

            const updatePriceDisplayAndHiddenInputs = () => {
                const currentDestination = destinationSelect.value;
                const currentCurrency = bookingCurrencySelect.value;
                let currentPrice = '';

                if (currentDestination && destinationData[currentDestination] && destinationData[currentDestination].prices[currentCurrency]) {
                     currentPrice = destinationData[currentDestination].prices[currentCurrency];
                     selectedPriceDisplay.textContent = currentPrice;
                     selectedCurrencyDisplay.textContent = currentCurrency;
                     hiddenPriceInput.value = currentPrice;
                     hiddenCurrencyInput.value = currentCurrency;
                     selectedPriceDisplay.closest('p').style.display = 'block';
                } else {
                    selectedPriceDisplay.textContent = '';
                    selectedCurrencyDisplay.textContent = '';
                    hiddenPriceInput.value = '';
                    hiddenCurrencyInput.value = '';
                    if (!currentDestination) {
                         selectedPriceDisplay.closest('p').style.display = 'none';
                    }
                }

                if (paymentMethodSelect.value === 'cash' && currentPrice !== '') {
                    cashAmountInput.value = currentPrice;
                    cashAmountInput.required = true;
                } else if (paymentMethodSelect.value !== 'cash') {
                    cashAmountInput.value = '';
                    cashAmountInput.required = false;
                }
            };


            if (urlDestination && urlRegion) {
                destinationSelect.value = urlDestination;
                regionSelect.value = urlRegion;

                destinationSelect.disabled = true;
                destinationSelect.classList.add('read-only-field');
                regionSelect.disabled = true;
                regionSelect.classList.add('read-only-field');

                if (bookingCurrencySelect.querySelector(`option[value="${urlCurrency}"]`)) {
                     bookingCurrencySelect.value = urlCurrency;
                } else {
                     bookingCurrencySelect.value = 'UGX';
                }

                hiddenDestinationInput.value = urlDestination;
                hiddenRegionInput.value = urlRegion;

                updatePriceDisplayAndHiddenInputs();

            } else {
                destinationSelect.disabled = false;
                destinationSelect.classList.remove('read-only-field');
                regionSelect.disabled = false;
                regionSelect.classList.remove('read-only-field');

                 selectedPriceDisplay.closest('p').style.display = 'none';

                     destinationSelect.addEventListener('change', () => {
                    const selectedDestination = destinationSelect.value;
                    const correspondingRegion = selectedDestination ? destinationData[selectedDestination].region : '';

                    regionSelect.value = correspondingRegion;

                    selectedDestinationDisplay.textContent = selectedDestination || 'Not Selected';
                    selectedRegionDisplay.textContent = correspondingRegion || 'Not Selected';
                    hiddenDestinationInput.value = selectedDestination;
                    hiddenRegionInput.value = correspondingRegion;

                    updatePriceDisplayAndHiddenInputs();
                 });

                 regionSelect.addEventListener('change', () => {
                     selectedRegionDisplay.textContent = regionSelect.value || 'Not Selected';
                     hiddenRegionInput.value = regionSelect.value;
                 });

                 bookingCurrencySelect.addEventListener('change', updatePriceDisplayAndHiddenInputs);


                 hiddenDestinationInput.value = destinationSelect.value;
                 hiddenRegionInput.value = regionSelect.value;
                 hiddenPriceInput.value = '';
                 hiddenCurrencyInput.value = bookingCurrencySelect.value;


                 selectedDestinationDisplay.textContent = destinationSelect.value || 'Not Selected';
                 selectedRegionDisplay.textContent = regionSelect.value || 'Not Selected';
                 selectedPriceDisplay.textContent = '';
                 selectedCurrencyDisplay.textContent = bookingCurrencySelect.value;

            }

            paymentMethodSelect.addEventListener('change', () => {
                 updatePriceDisplayAndHiddenInputs();

                paymentMethodError.style.display = 'none';
                creditCardDetailsDiv.style.display = 'none';
                paypalDetailsDiv.style.display = 'none';
                cashDetailsDiv.style.display = 'none';

                cardNumberInput.required = false;
                paypalEmailInput.required = false;
                cashAmountInput.required = false;

                if (paymentMethodSelect.value === 'creditcard') {
                    creditCardDetailsDiv.style.display = 'block';
                    cardNumberInput.required = true;
                } else if (paymentMethodSelect.value === 'paypal') {
                    paypalDetailsDiv.style.display = 'block';
                    paypalEmailInput.required = true;
                } else if (paymentMethodSelect.value === 'cash') {
                    cashDetailsDiv.style.display = 'block';

                }
            });

             cardNumberInput.addEventListener('input', () => {
                 cardNumberError.style.display = 'none';
              });

             paypalEmailInput.addEventListener('input', () => {
                 paypalEmailError.style.display = 'none';
              });

             cashAmountInput.addEventListener('input', () => {
                 cashAmountError.style.display = 'none';
              });


            let isSubmitting = false;

            const handleFormSubmit = (event) => {
                console.log("Submit button clicked. Starting custom validation.");

                if (isSubmitting) {
                    console.log("Form is already submitting. Allowing native submit.");
                    return;
                }

                event.preventDefault();

                let hasErrors = false;

                if (!paymentMethodSelect.value) {
                    paymentMethodError.textContent = 'Please select a payment method.';
                    paymentMethodError.style.display = 'block';
                    hasErrors = true;
                    console.log("Validation Error: Payment method not selected.");
                } else {
                     paymentMethodError.style.display = 'none';
                }

                if (paymentMethodSelect.value === 'creditcard') {
                    if (!cardNumberInput.value.trim()) {
                        cardNumberError.textContent = 'Please enter your card number.';
                        cardNumberError.style.display = 'block';
                        hasErrors = true;
                         console.log("Validation Error: Card number is empty.");
                    } else {
                         cardNumberError.style.display = 'none';

                    }

                } else if (paymentMethodSelect.value === 'paypal') {
                    if (!paypalEmailInput.value.trim()) {
                        paypalEmailError.textContent = 'Please enter your PayPal email.';
                        paypalEmailError.style.display = 'block';
                        hasErrors = true;
                         console.log("Validation Error: PayPal email is empty.");
                    } else {
                         paypalEmailError.style.display = 'none';

                    }
                } else if (paymentMethodSelect.value === 'cash') {
                    if (!cashAmountInput.value.trim() || parseFloat(cashAmountInput.value) <= 0) {
                        cashAmountError.textContent = 'Please enter a valid cash amount.';
                        cashAmountError.style.display = 'block';
                        hasErrors = true;
                         console.log("Validation Error: Cash amount is invalid.");
                    } else {
                         cashAmountError.style.display = 'none';

                    }
                }


                 if (!document.getElementById('firstname').value.trim()) { hasErrors = true; console.log("Validation Error: First name is empty."); }
                 if (!document.getElementById('lastname').value.trim()) { hasErrors = true; console.log("Validation Error: Last name is empty."); }
                 if (!document.getElementById('email').value.trim()) { hasErrors = true; console.log("Validation Error: Email is empty."); }
                 if (!document.getElementById('contact').value.trim()) { hasErrors = true; console.log("Validation Error: Contact is empty."); }

                 if (urlDestination && urlRegion) {
                      if (!hiddenDestinationInput.value) {
                          console.log("Validation Error: Hidden destination is empty.");
                          hasErrors = true;
                      }
                       if (!hiddenRegionInput.value) {
                          console.log("Validation Error: Hidden region is empty.");
                          hasErrors = true;
                       }
                 } else {
                      if (!destinationSelect.value) {
                            console.log("Validation Error: Destination not selected.");
                            hasErrors = true;
                      }
                       if (!regionSelect.value) {
                            console.log("Validation Error: Region not selected.");
                            hasErrors = true;
                       }
                 }


                 if (!bookingCurrencySelect.value) {
                     console.log("Validation Error: Currency not selected.");
                     hasErrors = true;
                 }


                console.log("Validation complete. hasErrors:", hasErrors);

                if (hasErrors) {
                    console.log("Validation errors found. Stopping form submission.");
                    return;
                }

                console.log("Validation successful. Proceeding with form submission.");
                isSubmitting = true;
                mainBookingForm.submit();
            };

            mainBookingForm.addEventListener('submit', handleFormSubmit);

            updatePriceDisplayAndHiddenInputs();
        });
    </script>

    <footer>
        <div id="footer">
            <div class="left">
                <p class="footer-intro">More Information</p>
                <ul>
                    <li class="info">About Us</li>
                    <li class="info"> About Uganda</li>
                    <li class="info">Special Places</li>
                    <li class="info"> Travel Tips</li>
                </ul>
            </div>
            <div class="middle">
                <p class="footer-intro">Partners</p>
                <a href="https://www.iata.org/">
                    <img class="partner" src="images/partner01.png" alt="IATA Partner">
                </a>
                <a href="https://www.tugata.com/">
                    <img class="partner" src="images/partner02.png" alt="TUGATA Partner">
                </a>
            </div>
            <div class="right">
                <p class="footer-intro">Follow Us</p>
                <div class="social-media">
                <h3>Follow us</h3>

                    <a href="https://www.facebook.com/profile.php?id=61555334879482"> <img class="social-media-icon"
                            src="images/facebook-icon.png" alt="Facebook"></a>
                    <a href="https://www.instagram.com/wildpath_expeditions/"> <img class="social-media-icon"
                                 src="images/instagram-icon.png" alt="Instagram"></a>
                    <a href="https://www.tiktok.com/@wildpathexpeditions"> <img class="social-media-icon"
                                 src="images/tiktok-icon.png" alt="TikTok"></a>
                   
                </div>
            </div>
        </div>
        <p class="copyright">© 2024 Wildpath Expeditions. All rights reserved.</p>
    </footer>
</body>
</html>