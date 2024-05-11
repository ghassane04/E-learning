<?php

include('connection.php');

$connection = new Connection();
$connection->createDatabase('Projet');

// Users Table
$query_users = "
CREATE TABLE Users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role ENUM('admin', 'user') DEFAULT 'user'  
)";

// CourseCategories Table
$query_course_categories = "
CREATE TABLE CourseCategories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50)
)";

// Courses Table
$query_courses = "
CREATE TABLE Courses (
    id_C INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(100) NOT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES CourseCategories(category_id)
)";

// Cart Table
$query_cart = "
CREATE TABLE Cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    total_price DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";

// CartItems Table
$query_cart_items = "
CREATE TABLE CartItems (
    cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    course_id INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (cart_id) REFERENCES Cart(cart_id),
    FOREIGN KEY (course_id) REFERENCES Courses(id_C)
)";

// UserTotals Table
/*$query_user_totals = "
CREATE TABLE UserTotals (
    user_total_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    card_id INT,
    total_amount DECIMAL(10, 2) DEFAULT 0.00,
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (card_id) REFERENCES Cards(card_id)
    ON DELETE CASCADE ON UPDATE CASCADE
)";

$connection->createTable($query_user_totals);
*/
// Cards Table
$query_cards = "
CREATE TABLE Cards (
    card_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    card_number VARCHAR(16),
    card_holder VARCHAR(16),
    expiration_date VARCHAR(7),
    cvv INT,
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";


$connection->selectDatabase('Projet');

// Create tables in the correct order
$connection->createTable($query_users);
$connection->createTable($query_course_categories);
$connection->createTable($query_courses);
$connection->createTable($query_cart);
$connection->createTable($query_cart_items);
$connection->createTable($query_cards);

?>
