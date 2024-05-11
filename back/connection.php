<?php
if (!class_exists('Connection')) {
class Connection{

private $servername="localhost:3306";
private $username="root";
private $password="";
public $conn;

public function __construct(){
$this->conn = mysqli_connect($this->servername, $this->username, $this->password);
// Check connection
if (!$this->conn){
die("Connection failed: " . mysqli_connect_error());
}
}
public function getConn() {
    return $this->conn; // Assuming $conn is your mysqli connection object
}
public function createDatabase($dbName){
    //creating a database with the conn in the class ($this->conn)
    $sql = "CREATE DATABASE $dbName";
if (mysqli_query($this->conn, $sql)){
echo " Database created successfully";
} else {
echo "Error creating database: " . mysqli_error($this->conn);
}
}
public function selectDatabase($dbName){
    //select database with the conn of the class, using mysqli_select..
    mysqli_select_db( $this->conn,$dbName);
}
public function createTable($query){
    if (mysqli_query($this->conn, $query)) {
        echo "Table created successfully";
        } else {
        echo "Error creating table: " . mysqli_error($this->conn);
        }
}
}
}
?>
