<?php
class Categorie {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function getCategories() {
        $query = "SELECT DISTINCT category_name FROM CourseCategories";
        $result = $this->db->query($query);
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['category_name'];
        }
        return $categories;
    }
    public function displayCoursesByCategory($categoryName) {
        $query = "SELECT Courses.*, CourseCategories.category_name FROM Courses INNER JOIN CourseCategories ON Courses.category_id = CourseCategories.category_id WHERE CourseCategories.category_name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<div class='item'>";
            echo "<img src='{$row['image']}' alt='{$row['title']}'><br><br>";
            echo "<div class='title'>{$row['title']}</div>";
            echo "<div class='price'>$ {$row['price']}</div>";
            echo '<form action="back/addtocart.php" method="post">';
            echo '<input type="hidden" name="course_id" value="' . $row['id_C'] . '">';
            echo '<input type="submit" name="add_to_cart" value="Add to Cart">';
            echo '</form>';
            echo "</div>";
        }
    }
}
?>