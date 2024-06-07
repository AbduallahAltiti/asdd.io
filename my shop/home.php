<?php
include 'config.php';
include 'cart_functions.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart!';
    }
}

$cart_items_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
$cart_items = [];
while ($row = mysqli_fetch_assoc($cart_items_query)) {
    $cart_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <img src="p1.png" alt="Advertisement" class="img-fluid">
    </div>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-lg-2 sidebar">
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#">Category 1</a>
                    <a class="nav-link" href="#">Category 2</a>
                    <a class="nav-link" href="#">Category 3</a>
                </nav>
            </div>
            <div class="col-lg-10">
                <div class="row">
                    <?php  
                    $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
                    if(mysqli_num_rows($select_products) > 0){
                        while($fetch_products = mysqli_fetch_assoc($select_products)){
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card product-card h-100">
                            <img class="card-img-top" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
                                <p class="card-text">$<?php echo $fetch_products['price']; ?>/-</p>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        echo '<p class="text-center">No products added yet!</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
