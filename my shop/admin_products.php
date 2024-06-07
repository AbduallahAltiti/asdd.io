<?php

include 'config.php';

session_start();

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
  
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;




   $select_product_name = mysqli_query($conn, 
   "SELECT name FROM products WHERE name = '$name'");

   if(mysqli_num_rows($select_product_name) > 0){
      $message = 'product name already added';
   }
   else
   {
      $add_product_query = mysqli_query($conn, 
      "INSERT INTO products(name, price, image) 
      VALUES('$name', '$price', '$image')");

      move_uploaded_file($image_tmp_name, $image_folder);
            $message = 'product added successfully!';
         }          
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, 
   "SELECT image FROM products WHERE id = '$delete_id'") ;
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM products WHERE id='$delete_id'");
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE products SET name = 
   '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
  
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
     
         mysqli_query($conn, "UPDATE products SET image = 
         '$update_image' WHERE id = '$update_p_id'") ;
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
      header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


   <style>
    <?php include 'css/admin_style.css'; ?>
</style> 
<script src="jquery-3.4.1.min.js"></script>
<script>
   function myf(){
   
           $(".edit-product-form").css({"display": "none"});
  
   }
   </script>
</head>
<body>
   
<?php include 'admin_header.php'; ?>


<section class="add-products">

   <h1 class="title">Shop Products</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add Product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>


<section class="show-products">
   <div class="box-container">
      <?php
         $select_products = mysqli_query($conn, 
         "SELECT * FROM products");
         if(mysqli_num_rows($select_products) > 0){
while($fetch_products =mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
         <div class="buttons">
         <a href="admin_products.php?update=
         <?php echo $fetch_products['id']; ?>" 
         class="option-btn">Update</a>

         <a href="admin_products.php?delete=
         <?php echo $fetch_products['id']; ?>" 
         class="delete-btn" onclick=
         "return confirm('delete this product?');">Delete</a>
</div>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>
<section class="edit-product-form">
   
<?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'");
         
            ($fetch_update = mysqli_fetch_assoc($update_query))
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="button" value="cancel" id="close-update" class="btn" onclick="myf()">
   </form>
   <?php
         }
      
      else{
         echo '<script>myf();</script>';
      }
   ?>

</section>



</body>
</html>