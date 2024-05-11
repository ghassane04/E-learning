<?php
class user{
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $reg_date;
    protected $role;

    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct($username, $email, $password ,$role = 'user') {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->role = $role;
    }
    public function getId($id) {
        return $this->id = $id;
    }

public function insertUser($tableName,$conn){

    $sql = "INSERT INTO $tableName (username, email, password ,role)
VALUES ('$this->username', '$this->email', '$this->password','$this->role')";
if (mysqli_query($conn, $sql)) {
self::$successMsg= "New record created successfully";
} else {
    self::$errorMsg ="Error: " . $sql . "<br>" . mysqli_error($conn);
}
$lastInsertedId = $conn->insert_id;
return $lastInsertedId;
}
}
class Client extends User {
    public function updateClientInfo($client, $tableName, $mysqli,$id) {
        // Prepare SQL statement to prevent SQL injection
        if (!$mysqli instanceof mysqli) {
            self::$errorMsg = "Invalid database connection";
            return;
        }
        $sql = "UPDATE $tableName SET username='$client->username' WHERE id='$id'";
        if (mysqli_query($mysqli, $sql)) {
        self::$successMsg= "New record updated successfully.Please re login to update your new username!";
        
        } else {
            self::$errorMsg= "Error updating record: " . mysqli_error($mysqli);
        }
    }
    public static function selectAllClients($tableName,$conn){
        //select all the client from database, and inset the rows results in an array $data[]
        $sql = "SELECT id,username, email ,reg_date FROM $tableName WHERE role='user'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $data=[];
                while($row = mysqli_fetch_assoc($result)) {
                
                    $data[]=$row;
                }
                return $data;
            }
        }
}
class Admin extends User {
    public static function deleteClient($userId, $mysqli) {
        // Start transaction
        $mysqli->begin_transaction();
    
        try {
            // Delete related data from other tables
            $queries = [
                "DELETE FROM Cart WHERE user_id = ?",
                "DELETE FROM Cards WHERE user_id = ?",
            ];
    
            foreach ($queries as $query) {
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }
            // Finally, delete the user
            $stmt = $mysqli->prepare("DELETE FROM Users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            // Commit transaction
            $mysqli->commit();
        } catch (Exception $e) {
            $mysqli->rollback();
            return false;
        }
        return true;
    }
    public static function calculateTotalSales($mysqli) {
        // Adjusted to sum prices from the CartItems table
        $sql = "SELECT SUM(price) AS total_sales FROM CartItems";
        if ($result = $mysqli->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                return $row['total_sales'] ?? 0;  // Return total sales or 0 if null
            }
        }
        return 0;  // Return 0 if query fails or no data exists
    }
    public static function countClients($mysqli) {
        $sql = "SELECT COUNT(*) AS total_clients FROM Users WHERE role='user'";
        if ($result = $mysqli->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                return $row['total_clients'];
            }
        }
        return 0; // Return 0 if there's an error or no clients found
    }
    
}

?>