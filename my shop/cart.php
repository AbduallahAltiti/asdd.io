<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cart</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
   <style>
      
      body {
         font-family: 'Rubik', sans-serif;
         background-color: #f5f5f5;
         margin: 0;
         padding: 0;
      }
      .heading {
         background-color: #000;
         color: #fff;
         text-align: center;
         padding: 15px;
         font-size: 24px;
      }
      .shopping-cart {
         padding: 20px;
         max-width: 1200px;
         margin: auto;
      }
      .box-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: center;
      }
      .box {
         background: #fff;
         border-radius: 5px;
         box-shadow: 0 4px 8px rgba(0,0,0,0.1);
         padding: 20px;
         margin: 15px;
         text-align: center;
         transition: transform 0.3s, box-shadow 0.3s;
         position: relative;
      }
      .box:hover {
         transform: translateY(-10px);
         box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      }
      .box img {
         width: 100%;
         height: 200px;
         object-fit: cover;
         border-radius: 5px;
      }
      .box .name {
         font-size: 18px;
         color: #333;
         margin: 10px 0;
      }
      .box .price {
         font-size: 20px;
         color: #e67e22;
         margin: 10px 0;
         padding: 0px;
         
      }
      .box .qty {
         width: 100%;
         padding: 10px;
         border-radius: 5px;
         border: 1px solid #ddd;
         margin: 10px 0;
         font-size: 16px;
         color: #333;
      }
      .box .option-btn {
         display: block;
         width: 100%;
         padding: 10px;
         border-radius: 5px;
         background: #e67e22;
         color: #fff;
         font-size: 18px;
         border: none;
         cursor: pointer;
         transition: background 0.3s;
         margin: 10px 0;
      }
      .box .option-btn:hover {
         background: #d35400;
      }
      .box .sub-total {
         font-size: 16px;
         margin-top: 10px;
      }
      .box .fas.fa-times {
         position: absolute;
         top: 10px;
         right: 10px;
         color: red;
         cursor: pointer;
      }
      .cart-total {
         text-align: center;
         margin-top: 30px;
         background: #000;
         color: #fff;
         padding: 20px;
         border-radius: 5px;
      }
      .cart-total h4 {
         font-size: 24px;
         margin-bottom: 10px;
      }
      .cart-total span {
         font-size: 20px;
         color: #e67e22;
      }
      .delete-btn {
         background: red;
         color: #fff;
         padding: 10px;
         border-radius: 5px;
         text-decoration: none;
         display: inline-block;
         margin: 10px 0;
         transition: background 0.3s;
      }
      .delete-btn:hover {
         background: darkred;
      }
      .delete-btn.disabled {
         background: gray;
         pointer-events: none;
      }
      .flex {
         display: flex;
         justify-content: space-between;
         align-items: center;
         margin-top: 20px;
      }
      .flex .option-btn {
         background: green;
      }
      .flex .btn {
         background: red;
      }
      .flex .btn.disabled {
         background: gray;
         pointer-events: none;
      }
   </style>
</head>
<body>
   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Shopping Cart</h3>
   </div>

   <section class="shopping-cart">
      <div class="box-container">
         <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select_cart) > 0){
               while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>
         <div class="box">
            <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
            <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_cart['name']; ?></div>
            <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
            <form action="" method="post">
               <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
               <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
               <input type="submit" name="update_cart" value="update" class="option-btn">
            </form>
            <div class="sub-total"> Sub Total : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span> </div>
         </div>
         <?php
         $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">your cart is empty</p>';
         }
         ?>
      </div>

      <div style="margin-top: 2rem; text-align:center;">
         <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
      </div>

      <div class="cart-total">
         <h4>Grand Total : <span>$<?php echo $grand_total; ?></span></h4>
         <div class="flex">
            <a href="shop.php" class="option-btn">Continue Shopping</a>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proceed To Checkout</a>
         </div>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>
</body>
</html>
