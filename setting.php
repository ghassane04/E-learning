<?php 
session_start();
if(isset($_SESSION["email"])){
?><?php
include('back/user.php');
include('back/card.php');
include('back/connection.php');

$connection = new Connection();
$connection->selectDatabase('Projet');
$db = $connection->conn;

$user_id= $_SESSION['user_id'];
$emailValue = $_SESSION['email'];
$usernameValue = $_SESSION['username'];

$errorMesage = "";
$successMesage = "";

$card = new Card($db);
$cardDetails = $card->getCardDetails($user_id);

$client = new Client($usernameValue, $emailValue, "");  // Password not needed for update
$client->getId($user_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $client->username = $_POST['username'];  // Update the username in the object
  $updateStatus = $client->updateClientInfo("Users", $db);
  if ($updateStatus) {
      $_SESSION['username'] = $client->username;
      header('Location: setting.php');
      exit();
  }
    if (isset(user::$successMsg)) {
        $successMesage = user::$successMsg;
    } elseif (isset(user::$errorMsg)) {
        $errorMesage = user::$errorMsg;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-ebook-landing.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/setting.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet"/>   
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
                </ul>   
            </div>
        </div>
    </nav>
    <div class="sidebar hidden-print">
    <br><br><br><br>
      <ul class="nav-links">
        <li>
          <a href="#">
          <i class='bx bx-info-circle'></i>
            <span class="links_name"id=btn >INFORMATION</span>
          </a>
        </li><br><br>
        <li>
          <a href="#" >
          <i class='bx bx-edit-alt' ></i>
            <span class="links_name"id=b >MODIFICATION</span>
          </a>
        </li><br><br>
        <li>
          <a href="carduser.php">
          <i class='bx bx-credit-card'></i>
            <span class="links_name">CARD</span>
          </a>
        </li>
        <li style="margin-top:110%;">
          <a href="back/logout.php">
          <i class='bx bx-exit'></i>
            <span class="links_name">LOG OUT</span>
          </a>
        </li>
      </ul>
    </div>
    <br>
    <form method="POST">
    <div id=a class="a">
    <center><form class="form" method="post">
                <h3>Modification</h3>
    
    <div class="flex-column">
      <br><br>
      <label>New Username</label></div>
      <br>
      <div class="inputForm">
        <input type="text" name="username" value="<?php echo htmlspecialchars($usernameValue); ?>"class="input" placeholder="Enter your New Username">
      </div>
    <div class="flex-column"> 
    <br>
    <button class="button-submit" type="submit" name="submit">Update</button>
    <?php
            if(!empty($successMesage)){
echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>$successMesage</strong>
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
</button>
</div>";
            }
  ?><?php

    if(!empty($errorMesage)){
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>$errorMesage</strong>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
  </button>
  </div>";
    }?>
    </form></center>
    </div>
    </form>
    <div id=c>
        <aside style="margin-left:70%;margin-top:0%;">
        <div id="card-container" >
            <div id="card">
                <div id="front">
                    <div class="reflection"></div>
                    <div class="type">PLATINUM</div>
                    <div class="title-text">CIH Bank</div>
                    <div class="details">
                        <div class="name">Person Name</div>
                        <p id="hidden-number">1111 XXXX XXXX 1452</p>
                    </div>
                    <button id="show-btn">View Card Details</button>
                    <div class="logo">MasterCard</div>
                </div>
                <div id="back">
                    <div class="reflection"></div>
                    <div id="chip">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="title-text">CIH Bank</div>
                    <div class="details">
    <?php if ($cardDetails): ?>
        <div class="name"><?php echo htmlspecialchars($cardDetails['card_holder']); ?></div>
        <p id="hidden-number"><?php echo htmlspecialchars($cardDetails['card_number']); ?></p>
        <span id="cvv">CVV: <?php echo htmlspecialchars($cardDetails['cvv']); ?></span>
        <span id="valid-date">Expiry: <?php echo htmlspecialchars($cardDetails['expiration_date']); ?></span>
    <?php else: ?>
        <p>No card details available.</p>
    <?php endif; ?>
</div>
<button id="hide-btn">Hide Card Details</button>
<div class="logo">MasterCard</div>
                </div>
            </div>
        </div>
        </aside>
        <aside style="margin-left:25%;top:0%">
            <tr><th>USERNAME : </th><br><br><p style="margin-left:5%"><?php echo htmlspecialchars($usernameValue); ?></p><br>
            <th>EMAIL : </th><br><br><p style="margin-left:5%"><?php echo htmlspecialchars($emailValue); ?></p><br><br><br>
        </tr>
        </aside>
    </div>
    <script>
        const b=document.querySelector('#b');
        const a=document.querySelector('#a');
        const btn=document.querySelector('#btn');
        const c=document.querySelector('#c');

        b.addEventListener('click', ()=>{ a.style.display='block';c.style.display='none';});
        btn.addEventListener('click', ()=>{ c.style.display='block';a.style.display='none';});
        flip = () => {
            document.getElementById('card').classList.toggle('flipped')
            document.querySelector('#front .reflection').classList.toggle('move')
            document.querySelector('#back .reflection').classList.toggle('move')
        }
        document.getElementById('show-btn').addEventListener('click', flip)
        document.getElementById('hide-btn').addEventListener('click', flip)
    </script>
</body>
</html>
<?php
} else {
  header("Location: 404.php");
}
?>