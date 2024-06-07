<header class="header">

<div class="flex">

<a href="admin_page.php" 
class="logo">PalestineIn<span>Art</span></a>

   <nav class="navbar">
      <a href="admin_page.php">Home</a>
      <a href="admin_products.php">Products</a>
      <a href="admin_orders.php">Orders</a>
      <a href="admin_users.php">Users</a>
      <a href="admin_contacts.php">Messages</a>
   </nav>
   <div class="icons">
      <div id="user-btn" class="fas fa-user" ></div>
   </div>
  
   <div class="account-box">
   <p>username : 
<span><?php echo $_SESSION['admin_name']; ?></span></p>
    <p>email :  
<span><?php echo $_SESSION['admin_email']; ?></span></p>
   <a href="logout.php" class="delete-btn">logout</a>
 <div>new <a href="login.php">login</a> | 
 <a href="register.php">register</a></div>
      </div>
</div>
<script>
  
   $(document).ready(function(){
      $("#user-btn").click(function(){
         $(".account-box").slideToggle(500);
      });
   });
 
</script>
</header>