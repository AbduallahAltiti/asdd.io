<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin PalestineIn</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   
<style>
    <?php include 'css/admin_style.css'; ?>
</style>
   <script src="jquery-3.4.1.min.js"></script>
   
</head>
<body>
   <?php @include 'admin_header.php'; ?>

   <section class="dashboard">
      <h1 class="title">DASHBOARD</h1>
      <div class="box-container">
         <div class="box">
            <?php
               $total_pendings = 0;
               $select_pending = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status = 'pending'");
               if(mysqli_num_rows($select_pending) > 0){
                  while($row = mysqli_fetch_assoc($select_pending)){
                     $total_price = $row['total_price'];
                     $total_pendings += $total_price;
                  }
               }
            ?>
            <h3>$<?php echo $total_pendings; ?>/-</h3>
            <p>Total Pendings</p>
         </div>

         <div class="box">
            <?php
               $total_completed = 0;
               $select_completed = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status = 'completed'");
               if(mysqli_num_rows($select_completed) > 0){
                  while($row = mysqli_fetch_assoc($select_completed)){
                     $total_price = $row['total_price'];
                     $total_completed += $total_price;
                  }
               }
            ?>
            <h3>$<?php echo $total_completed; ?>/-</h3>
            <p>Total Completed</p>
         </div>

         <div class="box">
            <?php 
               $select_users = mysqli_query($conn, "SELECT * FROM users WHERE user_type = 'admin'");
               $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>Admin users</p>
         </div>

         <div class="box">
            <?php 
               $select_users = mysqli_query($conn, "SELECT * FROM users WHERE user_type = 'user'");
               $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>Normal Users</p>
         </div>

         <div class="box">
            <?php 
               $select_products = mysqli_query($conn, "SELECT * FROM products");
               $number_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>Products added</p>
         </div>

         <div class="box">
            <?php 
               $select_users = mysqli_query($conn, "SELECT * FROM users");
               $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>All users</p>
         </div>
      </div>
   </section>
</body>
</html>
 