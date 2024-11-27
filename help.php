<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa; /* Light grey background */
        }

        /* Custom link styling */
        a {
            color: #ffa500; /* Orange color */
            text-decoration: none; /* Remove underline */
        }

        a:hover {
            color: #ff7f00; /* Darker orange color on hover */
            text-decoration: none; /* Remove underline on hover */
        }

        .card-header {
            background-color: #ffc107; /* Yellow background for card headers */
            color: #212529; /* Dark text color */
        }

        .card-body {
            background-color: #fff; /* White background for card bodies */
        }

        .card-body h3 {
            color: #ffa500; /* Orange color for section headings */
        }

        .card-body p {
            color: #212529; /* Dark text color for paragraphs */
        }

        .card-body ul li {
            color: #212529; /* Dark text color for list items */
        }

        .card-body ul li a {
            color: #ffa500; /* Orange color for links inside lists */
        }

        .card-body ul li a:hover {
            color: #ff7f00; /* Darker orange color for links inside lists on hover */
        }
       
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php">
        <h1 class="mt-4 mb-4">Help Center</h1></a>
        
        <!-- User Account Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>User Account</h2>
            </div>
            <div class="card-body">
                <ul>
                    <li><a href="#registration">Account Registration</a></li>
                    <li><a href="#login">Login Assistance</a></li>
                    <li><a href="#password">Password Reset</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Shopping Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Shopping</h2>
            </div>
            <div class="card-body">
                <ul>
                    <li><a href="#products">Browsing Products</a></li>
                    <li><a href="#cart">Shopping Cart</a></li>
                    <li><a href="#checkout">Checkout Process</a></li>
                </ul>
            </div>
        </div>
        
        
        <!-- Contact Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Contact</h2>
            </div>
            <div class="card-body">
                <ul>
                    <li><a href="#contactus">Contact Us</a></li>
                    <li><a href="#faq">FAQs</a></li>
                </ul>
            </div>
        </div>

        <!-- Help Content -->
        <div class="card mb-4">
            <div class="card-body">
                <!-- User Account Section -->
                <section id="registration">
                    <h3>Account Registration</h3>
                    <p>To create a new user account, please follow these steps:</p>
                    <ol>
                        <li>Log in to your account using your email address and password.</li>
                        <li>Click on the "My Account" or "Profile" link/button to access your profile settings.</li>
                        <li>From the profile dashboard, you can edit your personal information, such as your name, email address, and shipping address.</li>
                        <li>Make any necessary changes and click the "Save" or "Update" button to save your updated profile.</li>
                    </ol>
                </section>
                <section id="login">
                    <h3>Login Assistance</h3>
                    <p>If you're having trouble logging in to your account, here are some steps you can take to troubleshoot:</p>
                    <ol>
                        <li>Double-check that you're using the correct email address and password for your account.</li>
                        <li>Ensure that your Caps Lock key is not accidentally turned on, as passwords are case-sensitive.</li>
                        <li>If you've forgotten your password, follow the steps outlined in the "Password Reset" section to reset it.</li>
                        <li>Try logging in from a different web browser or device to see if the issue persists.</li>
                        <li>If you're still unable to log in, please contact our customer support team for further assistance.</li>
                    </ol>
                </section>
                <section id="password">
                    <h3>Password Reset</h3>
                    <p>If you've forgotten your password or need to reset it for any reason, you can do so by following these steps:</p>
                    <ol>
                        <li>Visit the login page on our website.</li>
                        <li>Click on the "Forgot Password" or "Reset Password" link.</li>
                        <li>Enter your email address associated with your account.</li>
                        <li>You will receive an email with instructions on how to reset your password.</li>
                        <li>Follow the instructions in the email to create a new password for your account.</li>
                    </ol>
                    <p>If you don't receive the password reset email within a few minutes, please check your spam or junk folder. If you still encounter issues, please contact our customer support team for further assistance.</p>
                </section>

                

                <!-- Browsing Products -->
                <section id="products">
                    <h3>Browsing Products</h3>
                    <p>To browse products on our website, simply navigate to the "Shop" or "Products" section from the main menu.</p>
                    <p>You can use the search bar or browse through different categories to find the products you're interested in.</p>
                    <p>Click on a product to view more details, such as product description, price, and available sizes.</p>
                </section>

                <!-- Shopping Cart -->
                <section id="cart">
                    <h3>Shopping Cart</h3>
                    <p>Your shopping cart stores all the items you've added while browsing our website.</p>
                    <p>You can view your cart by clicking on the shopping cart icon located at the top of the website.</p>
                    <p>From your cart, you can update quantities, remove items, and proceed to checkout to complete your purchase.</p>
                </section>

                <!-- Checkout Process -->
                <section id="checkout">
                    <h3>Checkout Process</h3>
                    <p>Once you've added all the items you wish to purchase to your shopping cart, you can proceed to checkout by following these steps:</p>
                    <ol>
                        <li>Review the items in your cart and make any necessary changes.</li>
                        <li>Enter your shipping address and select a shipping method.</li>
                        <li>Choose your preferred payment method and enter your payment details.</li>
                        <li>Review your order summary and click the "Place Order" or "Complete Purchase" button to finalize your order.</li>
                    </ol>
                </section>



                <!-- Contact Us -->
                <section id="contactus">
                    <h3>Contact Us</h3>
                    <p>If you need further assistance or have any questions, please don't hesitate to contact our customer support team.</p>
                    <p>You can reach us by email at support@example.com or by filling out the contact form on our website.</p>
                </section>

                <!-- FAQs -->
                <section id="faq">
                    <h3>FAQs</h3>
                    <ul>
                        <li><strong>Q:</strong> What payment methods do you accept?</li>
                        <li><strong>A:</strong> We accept major credit cards, PayPal, and other secure payment methods.</li>
                        <li><strong>Q:</strong> Do you offer international shipping?</li>
                        <li><strong>A:</strong> Yes, we offer international shipping to select countries. Please check our shipping policy for more information.</li>
                        <li><strong>Q:</strong> How can I track my order?</li>
                        <li><strong>A:</strong> Once your order has shipped, you will receive a tracking number via email. You can use this number to track your order on the carrier's website.</li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
