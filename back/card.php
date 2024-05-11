<?php
class Card {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function addCard($userId, $cardNumber, $cardHolder, $expirationDate, $cvv) {
        $insertQuery = "INSERT INTO Cards (user_id, card_number,card_holder,expiration_date, cvv) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $this->db->prepare($insertQuery);
        $insertStmt->bind_param("issss", $userId, $cardNumber,$cardHolder, $expirationDate, $cvv);
        return $insertStmt->execute();
    }
    public function getCardDetails($userId) {
        $stmt = $this->db->prepare("SELECT * FROM Cards WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }  
    public function checkExistingCard($userId) {
        $query = "SELECT * FROM Cards WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>
