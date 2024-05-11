<?php 
session_start();
if(isset($_SESSION["email"])){
require_once 'back/connection.php';
require_once 'back/cours.php';
require_once 'back/cart.php';
include 'back/categorie.php';

$connection = new Connection();
$db = $connection->conn;
$connection->selectDatabase('Projet');

$query = "SELECT * FROM Courses";
$result = $db->query($query);
$categorie = new Categorie($db);
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;
$categories = $categorie->getCategories();

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome to our website</title>
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
                                <a class="nav-link click-scroll" href="#section_5"><i class='bx bxs-contact'></i>Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="cartdisplay.php"><i class='bx bx-shopping-bag'></i>Cart</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="setting.php"><i class='bx bx-cog'></i>Settings</a>
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
            </nav><br><br><br><br>
            <div class="allpage">
    <div class="categories" style="margin-left: 2%;">
        <h5 style="color:yellow">Categories :</h5>
        <div class="p">
            <ul>
                <?php foreach ($categories as $cat): ?>
                    <li class="li" style="cursor: pointer;"><a style="color:black;" href="lessons.php?category=<?= $cat ?>"> <?= $cat ?> </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="contain">
        <div class="list">
            <?php
            if ($selectedCategory) {
                $categorie->displayCoursesByCategory($selectedCategory);
            } else {
                $query = "SELECT * FROM Courses";
                $result = $db->query($query);
                while ($courseData = $result->fetch_assoc()) {
                    $course = new Course(
                        $courseData['id_C'],
                        $courseData['image'],
                        $courseData['title'],
                        $courseData['category_id'],
                        $courseData['price']
                    );
                    $course->displayCourse();
                }
            }
            ?>
        </div>
    </div>
</div><br><br>
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
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
    </body>
</html>
<?php
} else {
    header("Location: 404.php");
}
?>