<script type="text/javascript" src="../assets/js/burgermenu.js"></script>

<div class="navbar">
    <!-- FlexFit Logo-->
    <div class="logo">
        <h2>FlexFit</h2>
    </div>

    <!-- Hamburger Link -->
    <ul class="hamburger">
        <span class="navline"> </span>
        <span class="navline"> </span>
        <span class="navline"> </span>
    </ul>

    <!-- Main Links -->
    <ul id='topnav' class="active">
        <li><a <?php if ($currentPage === 'home.php') echo 'class="animate"'; ?> href='../php/home.php'>Home</a></li>
        <li><a <?php if ($currentPage === 'shop.php') echo 'class="animate"'; ?> href='../php/shop.php'>Shop</a></li>
        <li><a <?php if ($currentPage === 'about.php') echo 'class="animate"'; ?> href='../php/about.php'>About</a></li>
        <li><a <?php if ($currentPage === 'contact.php') echo 'class="animate"'; ?> href='../php/contact.php'>Contact</a></li>
        <li><a <?php if ($currentPage === 'membership.php') echo 'class="animate"'; ?> href='../php/membership.php'>Membership</a></li>
        <li><a <?php if ($currentPage === 'forum.php') echo 'class="animate"'; ?> href='../php/forum.php'>Forum</a></li>
    </ul>

    <!-- Icon Links -->
    <ul id='iconNav' class="active">
        <li><a href='../php/cart.php'><img src="../images/Home/Main/shopping_cart.png"></a></li>

        <li class='dropdown'>
            <a href='#'>
                <img src="../php/Account/<?= $_SESSION['authenticated_user']['profileImg'] ?>" alt="User profile image" class="navpfp">
            </a>
            <ul class="dropdown-menu">
                <?php
                if (isset($_SESSION['authenticated_user'])) {
                    echo '<li>' . $_SESSION['authenticated_user']['fname'] . '</li>';
                    echo '<li><a href="../php/logout.php">Sign Out</a></li>';
                    echo '<li><a href="../php/account.php">Account Management</a></li>';
                    if (isset($_SESSION['authenticated_user']['role']) && $_SESSION['authenticated_user']['role'] == 1) {
                        echo '<li><a href="../admin/index.php">Admin Config</a></li>';
                    }
                } else {
                    echo '<li><a href="../php/login.php">Login</a></li>';
                    echo '<li><a href="../php/registration.php">Create an Account</a></li>';
                }
                ?>
            </ul>
        </li>

        <!-- Theme Changer -->
        <div class="color-mode">
            <img src="../images/Home/Main/moon.png" id="theme">
        </div>
    </ul>
</div>

