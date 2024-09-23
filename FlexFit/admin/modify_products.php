<?php
session_start();
include('../includes/header.php');
include('../php/functions.php');
include('../config/dbconfig.php');

$products = getAllProducts($pdo, "product", "All Products");

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $product = getProductDetails($pdo, $product_id);

    if ($product) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newProductName = $_POST['product_name'];
            $newProductDescription = $_POST['product_description'];
            $newProductType = $_POST['productType'];
            $newPrice = $_POST['Price'];
            $newSize = $_POST['Size'];
            $newImageName = $_POST['ImageName'];
            $newQuantity = $_POST['quantity'];
            $newActive = $_POST['active']; // Make sure to give the <select> input a name

            $sql = "UPDATE product SET 
                productName = :product_name,
                productDescription = :product_description,
                productType = :product_type,
                Price = :price,
                Size = :size,
                ImageName = :image_name,
                quantity = :quantity,
                active = :active
                WHERE id = :product_id";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':product_name', $newProductName);
            $stmt->bindParam(':product_description', $newProductDescription);
            $stmt->bindParam(':product_type', $newProductType);
            $stmt->bindParam(':price', $newPrice);
            $stmt->bindParam(':size', $newSize);
            $stmt->bindParam(':image_name', $newImageName);
            $stmt->bindParam(':quantity', $newQuantity);
            $stmt->bindParam(':active', $newActive); // Bind the 'active' parameter
            $stmt->bindParam(':product_id', $product_id);

            if ($stmt->execute()) {
                header("Location: modify_products.php"); // You missed 'Location:'
                exit;
            } else {
                echo "Error updating product in the database.";
            }
        }
?>



        <!-- Form for modifing the selected product -->
        <form method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" value="<?= $product['productName'] ?>"><br>
            <label for="product_description">Product Description:</label>
            <textarea name="product_description"><?= $product['productDescription'] ?></textarea><br>

            <label for="productType">Product Category:</label>
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
            </select><br>

            <label for="Price">Price:</label>
            <input type="number" name="Price" value="<?= $product['Price'] ?>"><br>

            <label for="Size">Size/Flavor:</label>
            <input type="text" name="Size" value="<?= $product['Size'] ?>"><br>

            <label for="ImageName">Image:</label>
            <input type="text" name="ImageName" value="<?= $product['ImageName'] ?>"><br>

            <label for="quantity">Quantity:</label>
            <input type="text" name="quantity" value="<?= $product['quantity'] ?>"><br>

            <label for="active">Status:</label>
            <select id="active" name="active">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>

            <input type="submit" value="Save Changes">
        </form>
<?php
    } else {
        echo "<p class='text-center'>Product not found.</p>";
    }
}
?>

<!-- Linking CSS-->
<link rel="stylesheet" text=" text/css" href="../css/admin.css">

<div class="admin-table">
    <table class="modifyproducts">
        <tr class="product-head">
            <th>ID</th>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Product Description</th>
            <th>Price</th>
            <th>Size/Flavour</th>
            <th>Image Location</th>
            <th>Featured</th>
            <th>URL</th>
            <th>Quantity</th>
            <th>Active Status</th>
            <th></th>
        </tr>

        <tbody>
            <?php
            if ($products) {
                foreach ($products as $item) {
            ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['productName'] ?></td>
                        <td><?= $item['productType'] ?></td>
                        <td><?= $item['productDescription'] ?></td>
                        <td><?= $item['Price'] ?></td>
                        <td><?= $item['Size'] ?></td>
                        <td><?= $item['ImageName'] ?></td>
                        <td><?= $item['featured'] ?></td>
                        <td><?= $item['url'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $item['active'] ?></td>
                        <td>
                            <a href="?product_id=<?= $item['id'] ?>">Edit</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<p class='text-center'>No products available</p>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include('../includes/footer.php');
?>