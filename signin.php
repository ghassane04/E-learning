<?php
include('back/connection.php');
include('back/cart.php');
include('back/user.php');

$connection = new Connection();
$connection->selectDatabase('Projet');
$db = $connection->conn;
$cart = new Cart($db);
$emailValue = "";
$usernameValue = "";
$adminCode = isset($_POST["adminCode"]) ? $_POST["adminCode"] : "";
$passwordValue = "";
$errorMessage = "";
$successMessage = "";

if (isset($_POST["submit"])) {
    $emailValue = $_POST["email"];
    $usernameValue = $_POST["username"];
    $passwordValue = $_POST["password"];
    $passwordConfirmValue = $_POST["confirm-password"];
    
    if (empty($emailValue) || empty($usernameValue) || empty($passwordValue) || empty($passwordConfirmValue)) {
        $errorMessage = "All fields must be filled out!";
    } else if (strlen($passwordValue) < 8) {
        $errorMessage = "Password must contain at least 8 characters.";
    } else if (!preg_match("/[A-Z]+/", $passwordValue)) {
        $errorMessage = "The password must contain at least one capital letter!";
    } else if ($passwordValue !== $passwordConfirmValue) {
        $errorMessage = "The passwords do not match!";
    } else {
        if (!empty($adminCode) && $adminCode != "123456789") {
            $errorMessage = "Admin code incorrect, please try again.";
        } else {
            $role = empty($adminCode) ? 'user' : 'admin';
            $user = new User($usernameValue, $emailValue, $passwordValue, $role);
            $userId = $user->insertUser('Users', $db);
            if ($role === 'user' && !$cart->isCartExistForUser($userId)) {
                $cart->createCartForUser($userId);
            }
            $successMessage = "User registered successfully!";
            $successMesage = user::$successMsg;
            $errorMesage = user::$errorMsg;
            $emailValue = "";
            $usernameValue = "";
            echo "<script>setTimeout(function(){ window.location.href = 'login.php'; }, 3000);</script>";
            
        }
    }
}
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Sign in</title>
        <!-- CSS FILES -->        
        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link href="css/signin.css" rel="stylesheet">
        <link href="css/templatemo-ebook-landing.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <main>
            <nav class="navbar navbar-expand-lg"style="background-color:black">
                <div class="container">
                    <a class="navbar-brand" href="index.php">
                        <i class="navbar-brand-icon bi-book me-2"></i>
                        <span>SaCourses</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto me-lg-4">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_5">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <br><br><br><br>
            <center><form class="form" method="post">
                <h3>Sign Up</h3>
                <?php
    if(!empty($errorMessage)){
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>$errorMessage</strong>
  </div>";
    }
       ?>
      <div class="inputForm">
        <input type="text" name="username"value="<?php echo $usernameValue ?>"class="input" placeholder="Enter your Username"autocomplete="off">
      </div>
      <div class="inputForm">
        <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3" data-name="Layer 3"><path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
        <input type="email" name="email" value="<?php echo $emailValue ?>" class="input" placeholder="Enter your Email"autocomplete="off">
      </div>
      <div class="inputForm">
        <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>        
        <input type="password" name="password" class="input" placeholder="Enter your Password"autocomplete="off">
        <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
      </div>
      <div class="inputForm">
        <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>        
        <input type="password" name="confirm-password" class="input" placeholder="Confirm your Password"autocomplete="off">
        <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
      </div>
      <div class="inputForm">
    <input type="password" name="adminCode" value="<?php echo htmlspecialchars($adminCode); ?>" class="input" placeholder="Enter admin code (if applicable)">
        </div>

    <button class="button-submit" type="submit" name="submit">Sign Up</button>
    <p class="p">Already have an account ? <a href="login.php"><span class="span">Login</span></a>
    <?php
            if(!empty($successMesage)){
echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>$successMesage</strong>
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
</button>
</div>";
            }
  ?>
    </form></center>
            <section class="contact-section section-padding" id="section_5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-12"style="margin-left:50%;">
                            <h6 class="mt-5">Let us a comment or talk to us</h6>
                            <h2 class="mb-4">Contact</h2>
                            <p class="mb-3">
                                <i class="bi-geo-alt me-2"></i>
                                Marrakech, Morocco
                            </p>
                            <p class="mb-2">
                                <a href="tel: +212(6)50-81-13-09" class="contact-link">
                                    +212(6)50-81-13-09
                                </a>
                            </p>
                            <p>
                                <a href="mailto:info@company.com" class="contact-link">
                                    info@gmail.com
                                </a>
                            </p>
                            <h6 class="site-footer-title mt-5 mb-3">Social</h6>
                            <ul class="social-icon mb-4">
                                <li class="social-icon-item">
                                    <a href="https://www.instagram.com/" class="social-icon-link bi-instagram"></a>
                                </li>
                                <li class="social-icon-item">
                                    <a href="https://twitter.com/" class="social-icon-link bi-twitter"></a>
                                </li>
                                <li class="social-icon-item">
                                    <a href="https://www.facebook.com/" class="social-icon-link bi-facebook"></a>
                                </li>
                                <li class="social-icon-item">
                                    <a href="" class="social-icon-link bi-whatsapp"></a>
                                </li>
                            </ul>
                            <p class="copyright-text">Copyright © 2023 e-learning
                            <br><br><a rel="nofollow" href="" target="_blank">Designed by Ghassane & Ali</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- JAVASCRIPT FILES -->
        <script src="js/scripthome.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
    </body>
</html>