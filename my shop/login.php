<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = md5($_POST['password']);

$select_users = mysqli_query($conn, "SELECT * FROM users WHERE 
email = '$email' AND password = '$pass'");

if(mysqli_num_rows($select_users) > 0){

   $row = mysqli_fetch_assoc($select_users);
   if($row['user_type'] == 'admin'){

    $_SESSION['admin_name'] = $row['name'];
    $_SESSION['admin_email'] = $row['email'];
    $_SESSION['admin_id'] = $row['id'];
    header('location:admin_page.php');

 }elseif($row['user_type'] == 'user'){

    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_id'] = $row['id'];
    header('location:home.php');
 }

}else{$message="wrong email or password";}
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/
   ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    <?php include 'css/style.css'; ?>
</style>
</head>
<body>
<?php
if(isset($message)){
   
      echo $message  ;
   
}
?>
<div class="form-container">
   <form action="" method="post">
      <h3>Login Now</h3>
      <input type="email" name="email" 
      placeholder="enter your email" required class="box">
      <input type="password" name="password" 
      placeholder="enter your password" required class="box">
      <input type="submit" name="submit" 
      value="login now" class="btn">
      <p>Don't Have An Account? 
          <a href="register.php">Register Now</a></p>
   </form>
</div>
</body>
</html>