<?php
session_start();
if(isset($_SESSION["admin"])){
    include('back/connection.php');
        //create in instance of class Connection
        $connection = new Connection();
        //call the selectDatabase method
        $connection->selectDatabase('Projet');
        include("back/user.php");

    $totalSales = Admin::calculateTotalSales($connection->conn);
    $formattedTotalSales = number_format($totalSales, 2, '.', ',');
    $totalClients = Admin::countClients($connection->conn);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/courses.css">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/templatemo-ebook-landing.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleadmin.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/setting.css">
    <link href="css/bootstrap-icons.css" rel="stylesheet">

    
    </head>
    <body>
    <nav class="navbar navbar-expand-lg" style="background-color:black">
                <div class="container">
                    <a class="navbar-brand" href="index2.php">
                        <i class="navbar-brand-icon bi-book me-2"></i>
                        <span>SaCourses</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>                   
                </div>
            </nav><br><br>

    <!-- =============== Navigation ================ -->
    <div class="container2">
    <div class="sidebar hidden-print">
     <br><br><br><br>
      <ul class="nav-links">
        <li>
          <a href="admin.php">
          <i class='bx bx-info-circle'></i>
            <span class="links_name"id=b >DASHBOARD</span>
          </a>
        </li><br><br>
        <li>
          <a href="index2.php" >
          <i class='bx bx-home'></i>
            <span class="links_name"id=b >HomePage</span>
          </a>
        </li><br><br><br><br><br><br>
        <li style="margin-top:110%;">
          <a href="back/logout.php">
          <i class='bx bx-exit'></i>
            <span class="links_name">LOG OUT</span>
          </a>
        </li>
      </ul>
    </div>
    <br>

        <!-- ========================= Main ==================== -->
        <div class="main">

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Daily Views</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
    <div>
        <div class="numbers"><?php echo $totalClients; ?></div>
        <div class="cardName">Clients</div>
    </div>
    <div class="iconBx">
        <ion-icon name="people-outline"></ion-icon>
    </div>
</div>
<div class="card">
    <div>
        <div class="numbers">$<?php echo number_format($formattedTotalSales, 2); ?></div>
        <div class="cardName">Earnings</div>
    </div>
    <div class="iconBx">
        <ion-icon name="cash-outline"></ion-icon>
    </div>
</div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Clients</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
            <th>ID</th>
            <th>UserName</th>
            <th>Email</th>
            <th>Date</th>
            <th>Shopping Cart</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $clients=client::selectAllClients('Users',$connection->conn);
        foreach($clients as $row) {
          echo " <tr>
          <td>$row[id]</td>
           <td>$row[username]</td>
           <td>$row[email]</td>
           <td>$row[reg_date]</td>
           <td><a href='admincart.php?id=$row[id];'><h1><i class='bx bx-shopping-bag'></i></h1></a></td>
           <td><a href='back/delete.php?id=$row[id];'>Delete</a></td>
       </tr>";
       }
       ?>
       </tbody>
  
   </table>
   </div>
   <script src="js/jquery.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
<?php
} else {
    header("Location: 404.php");
}
?>