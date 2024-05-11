<?php
// In addtocart.php
require_once 'cart.php';
require_once 'connection.php';

session_start();
$connection = new Connection();
$db = $connection->conn;
$connection->selectDatabase('Projet');
$cart = new Cart($db);

if (isset($_POST['course_id']) && isset($_SESSION['user_id'])) {
    $courseId = $_POST['course_id'];
    $userId = $_SESSION['user_id'];

    if ($cart->addItem($userId, $courseId) === false) {
        // Inform the user that the item is already in the cart
        header('Location: ../lessons.php?status=already_in_cart');
    } else {
        // Item was successfully added
        header('Location: ../lessons.php?status=added');
    }
    
    exit();
}

?>
