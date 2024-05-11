<?php
session_start();
if(isset($_SESSION["email"])){
?><?php
require_once 'back/card.php'; 
require_once 'back/connection.php';
$errorMsg = '';
$successMsg = '';
$connection = new Connection();
$db = $connection->conn;
$connection->selectDatabase('Projet');

if (isset($_POST['submit'])) {
    $cardNumber = $_POST['card_number'];
    $expirationDate = $_POST['expiration_date'];
    $cvv = $_POST['cvv'];
    $cardHolder = $_POST['card_holder'];
    $userId = $_SESSION['user_id'];

    if (empty($cardNumber) || empty($expirationDate) || empty($cvv) || empty($cardHolder)) {
        $errorMsg = 'Please fill in all the fields.';
    }
    elseif (!preg_match('/^(0[1-9]|1[0-2])-(\d{2})$/', $expirationDate)) {
        $errorMsg = 'Invalid expiration date format. Use MM-YY.';
    } 
    else {
        $card = new Card($db);
        if ($card->checkExistingCard($userId)) {
            $errorMsg = 'You already have a registered card.';
        }
        else {
            if ($card->addCard($userId, $cardNumber,$cardHolder, $expirationDate, $cvv)) {
                $successMsg = 'Card details saved successfully.';
            } else {
                $errorMsg = 'Error saving card details. Please check your information.';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Preview</title>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-ebook-landing.css" rel="stylesheet">
    <link href="css/card.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg"style="background-color:black">
                <div class="container">
                    <a class="navbar-brand" href="index1.php">
                        <i class="navbar-brand-icon bi-book me-2"></i>
                        <span>SaCourses</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto me-lg-4">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index1.php"><i class='bx bx-home'></i>Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="lessons.php"><i class='bx bx-book-open'></i>Courses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_5"><i class='bx bxs-contact'></i>Contact</a>
                            </li>
                        </ul>
                        <div class="d-none d-lg-block">
                            <a href="back/logout.php" data-toggle="modal" data-target="#modal-form"class="btn custom-btn custom-border-btn btn-naira btn-inverted">
                                <i class="btn-icon"></i>
                                <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav><br><br>
            <?php
if(!empty($errorMsg)){
echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
<strong>$errorMsg</strong>
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
</button>
</div>";
}
   ?>
   <?php
            if(!empty($successMsg)){
echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>$successMsg</strong>
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
</button>
</div>";
            }
  ?>
    <div id="main-container" style="font-family: serif;">
        <div class="content-box">
            <div class="preview">
                <div class="card">
                    <div class="front">
                        <div class="title">CIH Bank</div>
                        <div id="chip">
                            <span></span><span></span><span></span><span></span><span></span>
                        </div>
                        <div class="card-number">0000 0000 0000 0000</div>
                        <div class="card-name">Name Surname</div>
                        <div class="validity-box">
                            <span>
                                <p>VALID</p>
                                <p>THRU</p>
                            </span>
                            <span>►</span><span class="card-validity">00/00</span>
                        </div>
                        <div class="logo">MasterCard</div>
                    </div>
                    <div class="back">
                        <div class="top-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</div>
                        <div class="strip"></div>
                        <div class="box">
                            <div class="signature"></div>
                            <div class="card-cvv">000</div>
                        </div>
                        <div class="text">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error quod accusamus!</p>
                        </div>
                    </div>
                </div>
            </div>
            <form action="carduser.php" method="post">
                <div class="field">
                    <input type="text" id="number" oninput="UpdateAccountNumber(this);"name="card_number" placeholder="Enter your Card Number" required maxlength="19">
                </div>
                <div class="field">
                    <label for="name">Card Holder</label>
                    <input type="text" id="name" oninput="updateCardHolder(this);"name="card_holder" placeholder="Enter your name" required maxlength="25">
                </div>
                <div class="field">
                    <label for="validity">Valid upto (MM-YY)</label>
                    <input type="text" id="validity" oninput="updateValidity(this)"name="expiration_date" placeholder="Expiration Date (MM-YY)" required maxlength="5">
                </div>
                <div class="field">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" oninput="updateCardCvv(this)"name="cvv" placeholder="CVV" required maxlength="3">
                </div>
                <input type="submit" name="submit" value="Save Card">
            </form>
        </div>
    </div>
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
                            <br><br><a rel="nofollow" href="https://templatemo.com" target="_blank">Designed by Ghassane & Ali</a></p>
                        </div>
                    </div>
                </div>
            </section>
    <script>
        const card = document.querySelector('.card')
const cardNumber = document.querySelector('.card-number')
const cardHolder = document.querySelector('.card-name')
const cardValidity = document.querySelector('.card-validity')
const cardCvv = document.querySelector('.card-cvv')
const inputElement = document.querySelectorAll('input')
const cvvInput = document.querySelector('#cvv');

const dummy = {
    number: '0000 0000 0000 0000',
    name: 'Name Surname',
    validity: '00-00',
    cvv: '000'
}

inputElement.forEach((elem) => {

    elem.addEventListener('input', () => {
        if (elem.value.trim() === '') {
            const key = elem.getAttribute('id');
            const className = 'card-' + key;
            document.querySelector(`.${className}`).innerText = dummy[key]
        }
    })
})

function UpdateAccountNumber(input) {

    let inputValue = input.value.replace(/\D/g, '');
    let formattedValue = '';
    for (let i = 0; i < inputValue.length; i++) {
        if (i > 0 && i % 4 === 0) {
            formattedValue += '\u00A0';
        }
        formattedValue += inputValue[i];
    }
    input.value = formattedValue;
    cardNumber.innerText = formattedValue
}

function updateCardHolder(input) {
    let inputValue = input.value.replace(/[^A-Z a-z]/g, '');
    input.value = inputValue;
    cardHolder.innerText = inputValue
}

function updateValidity(input) {
    let inputValue = input.value.replace(/\D/g, '');
    let formattedValue = '';

    for (let i = 0; i < inputValue.length; i++) {
        const digit = parseInt(inputValue[i]);

        if ((i === 0 && digit > 1) || (i === 1 && digit > 2 && parseInt(inputValue[0]) != 0)) {
            break;
        }

        else if (i === 2) {
            formattedValue += '-';
        }
        formattedValue += digit;
    }
    input.value = formattedValue;
    cardValidity.innerText = formattedValue
}

function updateCardCvv(input) {
    let inputValue = input.value.replace(/\D/g, '');
    input.value = inputValue;
    cardCvv.innerText = inputValue
}

cvvInput.addEventListener('focus', () => card.classList.add('flipped'))
cvvInput.addEventListener('blur', () => card.classList.remove('flipped'))

    </script>
</body>
</html>
<?php
} else {
    header("Location: 404.php");
}
?>