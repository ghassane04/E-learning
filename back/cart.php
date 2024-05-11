
<?php
class Cart {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function createCartForUser($userId) {
        $query = "INSERT INTO Cart (user_id) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }

    public function isCartExistForUser($userId) {
        $query = "SELECT cart_id FROM Cart WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    public function addItem($userId, $courseId) {
        if ($this->isItemInCart($userId, $courseId)) {
            return false;
        }

        // Get course price
        $coursePriceStmt = $this->db->prepare("SELECT price FROM Courses WHERE id_C = ?");
        $coursePriceStmt->bind_param("i", $courseId);
        $coursePriceStmt->execute();
        $courseResult = $coursePriceStmt->get_result();
        $courseData = $courseResult->fetch_assoc();
        $coursePrice = $courseData['price'];

        // Add item to CartItems
        $addItemStmt = $this->db->prepare("INSERT INTO CartItems (cart_id, course_id, price) SELECT cart_id, ?, ? FROM Cart WHERE user_id = ?");
        $addItemStmt->bind_param("idi", $courseId, $coursePrice, $userId);
        $addItemStmt->execute();

        // Update total price
        $this->updateTotalPrice($userId);
    }

    public function deleteCartItem($cartItemId, $userId) {
        // Delete the item from CartItems
        $deleteItemStmt = $this->db->prepare("DELETE FROM CartItems WHERE cart_item_id = ?");
        $deleteItemStmt->bind_param("i", $cartItemId);
        $deleteItemStmt->execute();

        // Update total price
        $this->updateTotalPrice($userId);
    }
    private function updateTotalPrice($userId) {
        // Calculate new total price
        $calcTotalStmt = $this->db->prepare("SELECT SUM(price) AS total_price FROM CartItems JOIN Cart ON CartItems.cart_id = Cart.cart_id WHERE Cart.user_id = ?");
        $calcTotalStmt->bind_param("i", $userId);
        $calcTotalStmt->execute();
        $result = $calcTotalStmt->get_result();
        $data = $result->fetch_assoc();
        $newTotalPrice = $data['total_price'];

        // Update total price in Cart
        $updateTotalStmt = $this->db->prepare("UPDATE Cart SET total_price = ? WHERE user_id = ?");
        $updateTotalStmt->bind_param("di", $newTotalPrice, $userId);
        $updateTotalStmt->execute();
    }
    private function isItemInCart($userId, $courseId) {
        $stmt = $this->db->prepare("SELECT * FROM CartItems WHERE course_id = ? AND cart_id = (SELECT cart_id FROM Cart WHERE user_id = ?)");
        $stmt->bind_param("ii", $courseId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    public function getCartItems($userId) {
        $query = "SELECT CartItems.cart_item_id, Courses.id_C, Courses.title, CourseCategories.category_name, Courses.price, Courses.image 
                  FROM CartItems 
                  JOIN Courses ON CartItems.course_id = Courses.id_C 
                  JOIN CourseCategories ON Courses.category_id = CourseCategories.category_id 
                  JOIN Cart ON CartItems.cart_id = Cart.cart_id 
                  WHERE Cart.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalPrice($userId) {
        $query = "SELECT total_price FROM Cart WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total_price'] ?? 0;
    }
}
?>
