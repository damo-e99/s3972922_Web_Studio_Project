<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include('../includes/header.php');
include('functions.php');
include('../config/dbconfig.php');

if (isset($_GET['product'])) {
    $product_url = $_GET['product'];
    $product_data = getProductURL($pdo, "product", $product_url, $image); // Use the $pdo connection
    $product = $product_data->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $size_data = getSize($pdo, "product", $product['url']);
    }

    if ($product) {
?>

<link rel="stylesheet" text=" text/css" href="../css/shop.css">


        <div class = "product-window">
                <div>
                    <img id="product-image" class='product-image' src='../images/products/<?php echo $product['ImageName']; ?>' alt='<?php echo $product['productName']; ?>'>
                </div>

                <div class="prod-info">
                    <h1 class = "product-name"><?php echo $product['productName']; ?></h1>

                    <p><?php echo $product['productDescription']; ?></p>
                    <p class = "price-tag">Price: <?php echo $product['Price']; ?></p>

                    <p>Select Your Options</p>
                    <select name="Size" id="Size">
                        <?php
                        while ($size = $size_data->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $size['Size'] . '" data-image-name="' . $size['ImageName'] . '">' . $size['Size'] . '</option>';
                        }
                        ?>
                    </select>
                    
                    <form class="single-add" method="POST" action="functions.php">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <input type="submit" value="Add to Cart">
                    </form>
                   
                </div>
        </div>

        <script>
            document.getElementById("Size").addEventListener("change", function() {
                var selectedOption = this.options[this.selectedIndex];
                var imageName = selectedOption.getAttribute("data-image-name");
                var productImage = document.getElementById("product-image");

                productImage.src = '../images/products/' + imageName;
            });
        </script>
<?php
    } else {
        echo "Product not available";
    }
}
?>

<?php
include('../includes/footer.php');
