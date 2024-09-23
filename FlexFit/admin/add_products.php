<?php
session_start();
include('../includes/header.php');
include('../php/functions.php');
include('../config/dbconfig.php');

if (isset($_POST["submit"])) {
    $productName = $_POST['productName'];
    $productType = $_POST['productType'];
    $productDescription = $_POST['productDescription'];
    $Price = floatval($_POST['Price']); 
    $Size = $_POST['Size'];
    $imageName = $_FILES['imageName']['name'];
    $featured = $_POST['featured'];
    $url = $_POST['url'];
    $quantity = $_POST['quantity'];

    $featured = isset($_POST['featured']) ? 1 : 0;
    $query = "INSERT INTO product (ProductName, ProductType, ProductDescription, Price, Size, ImageName, featured, url, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$productName, $productType, $productDescription, $Price, $Size, $imageName, $featured, $url, $quantity]);

    if ($stmt->rowCount() > 0) {
        echo "Product added successfully.";
    } else {
        echo "Error adding the product.";
    }
}
?>
<link rel="stylesheet" text=" text/css" href="../css/admin.css">

    <form class = "add-product-form" method="post" enctype="multipart/form-data">
        <div>
            <span class="label">Product Name:</span>
            <input type="text" name="productName" required><br>
        </div>
        <div>
            <span class="label">Product Type</span>
            <select name="productType" required>
                <?php
                $cat_info = getCategories($pdo, "product");
                if ($cat_info) {
                    while ($cat = $cat_info->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $cat['productType'] . '">' . $cat['productType'] . '</option>';
                    }
                } else {
                    echo '<option value="">No Categories Found</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <span class="label">Product Description:</span>
            <input type="text" name="productDescription" required><br>
        </div>
        <div>
            <span class="label">Price:</span>
            <input type="number" name="Price" required><br>
        </div>
        <div>
            <span class="label">Size/Flavor:</span>
            <input type="text" name="Size" required><br>
        </div>
        <div>
            <span class="label">Image:</span>
            <input type="file" name="imageName" required><br>
        </div>
        <div>
            <span class="label">Featured:</span>
            <input type="checkbox" name="featured"><br>
        </div>
        <div>
            <span class="label">URL Identifer:</span>
            <input type="text" name="url" required><br>
        </div>
        <div>
            <span class="label">Quantity:</span>
            <input type="number" name="quantity" required><br>
        </div>


        <button type="submit" name="submit">Submit</button>
    </form>
</body>

<?php
include('../includes/footer.php');
?>