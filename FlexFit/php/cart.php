<?php
session_start();
include('../includes/header.php');
include('functions.php');
include('../config/dbconfig.php');
include('../php/update_cart_quantity.php');
$userId = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
$cartData = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : array();
?>
<link rel="stylesheet" text="text/css" href="../css/cart.css">



<!-- Cart Content-->
<div id="cart-content" class="cart-container">
    <!-- Product table -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        foreach ($cartData as $productId => $quantity) {
            $product = getProductDetails($pdo, $productId);
            if ($product) {
        ?>
                <tr>
                    <td>
                        <div class="product-det">
                            <img src="../images/products/<?= $product['ImageName'] ?>">
                            <div>
                                <h3><?= $product['productName'] ?></h3>
                                <p class="price">$<?= $product['Price'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wrapper" name="quant">
                            <span class="minus dec-button">-</span>
                            <span class="num quantity" data-product-id="<?= $productId ?>">
                                <?= $quantity; ?>
                            </span>
                            <span class="plus inc-button">+</span>
                        </div>
                    </td>
                    <td class="subtotal">$<?= number_format($product['Price'] * $quantity, 2) ?></td>
                    <td>
                        <form method="post" action="functions.php">
                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                            <button type="submit" class="remove-button">Delete</button>
                        </form>
                    </td>
                </tr>
        <?php
            }
        }
        if (empty($cartData)) {
            echo '<tr><td colspan="4">Your cart is empty</td></tr>';
        }
        ?>
    </table>
    <!-- Cart Total-->
    <div class="cart-total">
        <table>
            <tr>
                <th>Cart Total</th>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td id="cart-subtotal">$<?= calculateSubtotal($pdo, $cartData); ?></td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>
                    <?php
                    if (isset($_SESSION['authenticated'])) {
                        if ($_SESSION['authenticated_user']['membership'] === "bronze") {
                    ?> td>9.99</td><?php
                                } elseif ($_SESSION['authenticated_user']['membership'] === "silver") {
                                    ?><td>2</td><?php
                                            } elseif ($_SESSION['authenticated_user']['membership'] === "gold") {
                                                ?><td>1.99</td><?php
                                                            }
                                                        } else {
                                                                ?><td>9.99</td><?php
                                                                            } ?>
        </td>
            </tr>
            <tr>
                <td>Total</td>
                <td id="cart-total">$<?= calculateTotal($pdo, $cartData); ?></td>
            </tr>
        </table>
    </div>

    <!-- Proceed Button -->
    <div class="proceed">
        <a href="payment.php">
            <button id="checkout-button">Proceed to Checkout</button>
        </a>
        <form method="post" action="functions.php">
            <button type="submit" name="clear_cart">Clear Cart</button>
        </form>
    </div>

</div>









<script>
    window.addEventListener("load", quantityCount);
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const decButtons = document.querySelectorAll(".dec-button");
        const incButtons = document.querySelectorAll(".inc-button");

        decButtons.forEach(function(decButton) {
            decButton.addEventListener("click", function() {
                updateQuantity(decButton, -1);
            });
        });

        incButtons.forEach(function(incButton) {
            incButton.addEventListener("click", function() {
                updateQuantity(incButton, 1);
            });
        });
    });

    function updateQuantity(button, change) {
        const wrapper = button.parentElement;
        const num = wrapper.querySelector(".num");
        let currentQuantity = parseInt(num.innerText);
        let newQuantity = currentQuantity + change;

        if (newQuantity >= 1) {
            num.innerText = newQuantity;

            // Get the product ID from the data attribute
            const productId = num.getAttribute("data-product-id");
            console.log("Product ID: " + productId);

            // Send an AJAX request to update the cart
            updateCartQuantity(productId, newQuantity);
        }
    }

    function updateCartQuantity(productId, newQuantity) {
        // Create a data object to send in the AJAX request
        const data = {
            product_id: productId,
            quantity: newQuantity
        };

        // Send an AJAX request to update the cart
        fetch("update_cart_quantity.php", {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Failed to update cart quantity.");
                }
            })
            .then(data => {
                // Update the cart total or handle other responses if needed
            })
            .catch(error => {
                console.error(error);
            });
    }
</script>

<!-- Page Footer-->
<?php include('../includes/footer.php') ?>