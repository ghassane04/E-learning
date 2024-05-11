<?php
session_start();
if(isset($_SESSION["admin"])){
require_once 'back/connection.php';
require_once 'back/cart.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $connection = new Connection();
    $db = $connection->conn;
    $connection->selectDatabase('Projet');

    $cart = new Cart($db);
    $cartItems = $cart->getCartItems($userId);
    $totalPrice = $cart->getTotalPrice($userId);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Admin Cart</title>
        <!-- CSS FILES -->        
        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link href="css/templatemo-ebook-landing.css" rel="stylesheet">
        <link rel="stylesheet" href="css/courses.css">
        <link rel="stylesheet" href="css/lessons.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body class="">
            <nav class="navbar navbar-expand-lg" style="background-color:black;left:0%">
                <div class="container">
                    <a class="navbar-brand" href="index2.php">
                        <i class="navbar-brand-icon bi-book me-2"></i>
                        <span>SaCourses</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto me-lg-4">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="admin.php"><i class='bx bx-home'></i>List of users</a>
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
            </nav><br><br><br><br><br><br>
<table class="table">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
            </tr>
            <?php while ($row = $cartItems->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_C']; ?></td>
                    <td><img src="<?php echo $row['image']; ?>"style="width:100px; height:auto;"></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table><br><br>
        <?php echo "<p style='margin-left:70%;'>Total Price: $" . number_format($totalPrice, 2) . "</p>";?>
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
    </body>
</html>
<?php
} else {
    echo "User ID not provided.";
}
?>
<?php
} else {
    header("Location: 404.php");
}
?>
