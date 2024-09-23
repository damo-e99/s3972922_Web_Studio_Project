<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include('../includes/header.php');
include('functions.php');
include('../config/dbconfig.php');
$category = isset($_POST['categories']) ? $_POST['categories'] : "All Products";
$products = getAllProducts($pdo, "product", $category);
// $size = getSize($pdo, )
?>
<link rel="stylesheet" text=" text/css" href="../css/homeabout.css">
<link rel="stylesheet" text=" text/css" href="../css/shop.css">

<div class="container-heading">
    <h1>FlexFit Products</h1>
</div>

<div class="product-nav">
    <form class="search-bar" action="">
        <label for="psearch">Search a product:</label>
        <input type="text" id="psearch" name="psearch">
    </form>


    <form class="sort-by" method="POST">
        <h3>Filter By:</h3>
        <button name='categories' value='All Products'>All Products</button>
        <button name='categories' value='Creatine'>Creatine</button>
        <button name='categories' value='Protein'>Protein Powder</button>
        <button name='categories' value='Accessories'>Accessories</button>
    </form>
</div>

<div class="container-heading">
    <?php
    echo "<h1>$category</h1>"
    ?>
</div>

<div class="py-5">
    <div class="container">
        <div class="row">
            <?php
            if ($products) {
                foreach ($products as $item) {
            ?>
                    <div class="col-md-3">
                        <a href="product_window.php?product=<?= $item['url']; ?>">
                            <div class="product-card">
                                <div class="card">
                                    <img class="product-image" src="../images/products/<?= $item['ImageName'] ?>" alt="<?= $item['url'] ?>" style="height: 300px;">
                                    <div class="card-body">
                                        <div class="product-details">
                                            <h4 class="card-title"><?= $item['productName'] ?></h4>
                                            <h4 class="size"><?= $item['Size'] ?></h4>
                                            <h3 class="card-price"><?= $item['Price'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <form method="POST" action="<?= $currentPage ?>">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <div class="wrapper" name="quant">
                                <span class="minus dec-button">-</span>
                                <input type="text" class="num quantity" name="quantity" value="1">
                                <span class="plus inc-button">+</span>
                            </div>
                            <input type="submit" value="Add to Cart">
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-center'>No products available</p>";
            }
            ?>
        </div>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        const decButtons = document.querySelectorAll(".dec-button");
        const incButtons = document.querySelectorAll(".inc-button");
        const quantityFields = document.querySelectorAll(".num.quantity");

        decButtons.forEach(function(decButton, index) {
            decButton.addEventListener("click", function(event) {
                event.preventDefault();
                updateQuantity(quantityFields[index], -1);
            });
        });

        incButtons.forEach(function(incButton, index) {
            incButton.addEventListener("click", function(event) {
                event.preventDefault();
                updateQuantity(quantityFields[index], 1);
            });
        });

        function updateQuantity(quantityField, change) {
            let currentQuantity = parseInt(quantityField.value);
            let newQuantity = currentQuantity + change;
1
            if (newQuantity < 1) {
                newQuantity = 1;
            }

            quantityField.value = newQuantity;
        }
    });
</script>



<!-- Page Footer-->
<?php include('../includes/footer.php'); ?>