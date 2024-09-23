<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../config/dbconfig.php');

function getAllProducts($pdo, $table, $category = "All Products")
{
  try {
    $query = "SELECT * FROM $table WHERE active = 1";

    if ($category !== "All Products") {
      $query .= " AND productType = :category";
    }

    $statement = $pdo->prepare($query);

    if ($category !== "All Products") {
      $statement->bindParam(':category', $category, PDO::PARAM_STR);
    }

    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return false;
  }
}

//Categories for sorting
function getCategories($pdo, $table){
  $query = "SELECT DISTINCT productType FROM $table";
  $stmt = $pdo->prepare($query);
  $stmt->execute(); 
  return $stmt;
}

//Gets products by ID
function getProductDetails($pdo, $productId)
{
  if (empty($productId) || !is_numeric($productId)) {
    return false; 
  }

  $query = "SELECT * FROM product WHERE ID = :productId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);

  if ($stmt->execute()) {
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    return false; 
  }
}





function getProductURL($pdo, $table, $url)
{
  $query = "SELECT * FROM $table WHERE url = :url LIMIT 1";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':url', $url, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt;
}


function getSize($pdo, $table, $url){
  $query = "SELECT Size FROM $table WHERE url = :url";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':url', $url, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt;
}

function getFeaturedProducts($pdo, $table){
  try {
    $query = "SELECT * FROM product WHERE featured > 0";
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return false;
  }
}

//MEMBERSHIP PAGE QUERIES ---
function getBenefitsMemberLevel($pdo, $table, $memberType)
{
  try 
  {
    $query = "SELECT MEMBER_TYPE, MEMBER_PRICE, MEMBER_DESCRIPTION FROM $table WHERE MEMBER_TYPE = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$memberType]);

    return $statement->fetchALL(PDO::FETCH_ASSOC);
  }
  catch(Exception $e)
  {
    echo 'Error: ' . $e->getMessage();
    return false;
  }

}

function getAllMembership($pdo, $table)
{
  try{
    $query = "SELECT * FROM $table";
    $statement = $pdo->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) 
  {
    echo 'Error: ' . $e->getMessage();
    return false;
  }
}

//function for registration form.
if (isset($_POST['register'])) {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $confirm_pass = $_POST['confirm_pass'];
  $phnumber = $_POST['phnumber'];

  // Check if the passwords match
  if ($pass === $confirm_pass) {
    try {
      $insert_query = "INSERT INTO users (username, fname, lname, email, pass, phnumber) VALUES (:username, :fname, :lname, :email, :pass, :phnumber)";
      $stmt = $pdo->prepare($insert_query);
      $stmt->bindParam(':username', $fname);
      $stmt->bindParam(':fname', $fname);
      $stmt->bindParam(':lname', $lname);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':pass', $pass);
      $stmt->bindParam(':phnumber', $phnumber);
      $stmt->execute();

      $_SESSION['message'] = "Account has been created!";
      header('Location: ../php/login.php');
    } catch (PDOException $e) {
      $_SESSION['message'] = "Issue occurred. Please try again";
      echo "Database Error: " . $e->getMessage();
      header('Location: ../php/registration.php');
    }
  } else {
    $_SESSION['message'] = 'Passwords are not matching. Please try again';
    header('Location: ../php/registration.php');
  }
}



//function for authenticating login
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass = $_POST['pass'];

  try {
    $query = "SELECT * FROM users WHERE email=:email AND pass=:pass";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':pass', $pass);
    $statement->execute();

    if ($statement->rowCount() > 0) {
      $userInfo = $statement->fetch(PDO::FETCH_ASSOC);

      if ($userInfo['active'] == 1) {
        // Account is active
        $_SESSION['authenticated'] = true; // Set the 'authenticated' index to true.
        $_SESSION['authenticated_user'] = [
            'fname' => $userInfo['fname'],
            'email' => $userInfo['email'],
            'role' => $userInfo['role'],
            'id' => $userInfo['id'],
            'membership' => $userInfo['membership'],
            'active' => $userInfo['active'],
            'profileImg' => $userInfo['profileImage']
          ];

        $role = $userInfo['role'];

        if ($role == 1) {
          header('Location: ../admin/index.php');
        } else {
          $_SESSION['message'] = 'Welcome, ' . $userInfo['fname'];
          header('Location: ../php/home.php');
        }
      } else {
        // Account is not active
        $_SESSION['message'] = 'Your account is not active. Please contact the administrator.';
        $_SESSION['authenticated'] = false;
        header('Location: ../php/login.php');
      }
    } else {
      // Invalid credentials
      $_SESSION['message'] = 'Email or Password is not correct.';
      header('Location: ../php/login.php');
    }
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}





// For storing products in the cart cookie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productId = $_POST['product_id'];
  $quantity = (int)$_POST['quantity'];

  // Check if the cart cookie exists and decode its value
  $cartData = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

  if (!isset($cartData[$productId]) || $quantity >= 1) {
    $cartData[$productId] = $quantity;
  } else {
    $cartData[$productId] += $quantity;
  }

  // Encode the cart data as JSON and set it in a cookie
  setcookie('cart', json_encode($cartData), time() + 3600, '/');  // Set the cookie to expire in an hour

  header('Location: ../php/shop.php');
}






//function for getting the total in the cart
function calculateSubtotal($pdo, $cartData)
{
  $subtotal = 0;

  if (!empty($cartData)) {
    foreach ($cartData as $productId => $quantity) {
      $product = getProductDetails($pdo, $productId);

      if ($product) {
        $subtotal += $product['Price'] * $quantity;
      }
    }
  }

  return number_format($subtotal, 2);
}


function calculateTotal($pdo)
{
  $cartData = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : array();
  $subtotal = calculateSubtotal($pdo, $cartData);
  $shipping = 0;

  if (isset($_SESSION['authenticated'])) {
    $membership = $_SESSION['authenticated_user']['membership'];

    // Determine shipping cost based on membership
    if ($membership === "Bronze") {
      $shipping = 9.99;
    } elseif ($membership === "Silver" || $membership === "Gold") {
      $shipping = 1.99;
    }
  } else {
    $shipping = 9.99;
  }

  $total = $subtotal + $shipping;
  return number_format($total, 2);
}









// Function to get IP address
function getIPAdd() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ipAddr = $_SERVER['HTTP_CLIENT_IP'];
  }else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else {
    $ipAddr = $_SERVER['REMOTE_ADDR'];
  }

  //Since this checks for IP, can be a security risk, so use PHP to validate before returning value
  $checkValidationIP = filter_var($ipAddr, FILTER_VALIDATE_IP);
  return $ipAddr;
}


$msg = '';
if (isset($_POST['submit'])) {
  //Attempt login timeout - 1 hour (60 * 60)
  $timer = time() - 30;
  $ip_address = getIPAdd(); //Storing IP address in variable

  $query = "SELECT count(*) as total_count FROM loginLogs WHERE TryTime > :timer AND IpAddress = :ipAddress";
  $stmt = $pdo->prepare($query);
  $stmt->bindparam(':timer', $timer, PDO::PARAM_INT);
  $stmt->bindparam(':ipAddress', $ip_address, PDO::PARAM_STR);
  $stmt->execute();

  //fetch result, store in totalcount (no. of attempts)
  $checkLogin = $stmt->fetch(PDO::FETCH_ASSOC);
  $totalcount = $checkLogin['total_count'];

  //Check for no. attempts < 3
  if ($totalcount == 3 && $_SESSION['authenticated_user']['role'] != 1) {
    $_SESSION['message'] = "To many failed attempts, Login restriction: $timer";
    header("Location: ../php/login.php");
  }else {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM users WHERE email = :email AND pass = :pass";
    $stmt = $pdo->prepare($query);
    $stmt->bindparam(':email', $email, PDO::PARAM_STR);
    $stmt->bindparam(':pass', $pass, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $_SESSION['authenticated'] = true;
      $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

      $_SESSION['authenticated_user'] = [
        'fname' => $userInfo['fname'],
        'lname' => $userInfo['lname'],
        'email' => $userInfo['email'],
        'role' => $userInfo['role'],
        'id' => $userInfo['id'],
        'membership' => $userInfo['membership'],
        'active' => $userInfo['active'],
        'profileImg' => $userInfo['profileImage']
      ];

      $role = $_SESSION['authenticated_user']['role'];
      if ($role === 1) {
        header("Location: ../admin/index.php");
      }else{
        header("Location: ../php/account.php");
      }

    }else {
      //Failed login attempts being incremented
      $totalcount++;
      $residueAttempt = 3 - $totalcount;

      if ($totalcount == 3 && $userInfo['role'] != 1) {
        $_SESSION['message'] = "To many failed attempts, Login restriction: $timer";
        header('Location: ../php/login.php');
      }
      
      if ($residueAttempt != 0) {
        $_SESSION['message'] = "Please enter valid login credentials. $residueAttempt attempts remaining";
      }

      //LOG THE LOGIN ATTEMPTS INTO LoginLogs table

      $attemptTime = time();
      $query = "INSERT INTO loginLogs (IpAddress, TryTime) VALUES (:ipAddress, :tryTime)";
      $stmt = $pdo->prepare($query);
      $stmt->bindparam('ipAddress', $ip_address, PDO::PARAM_STR);
      $stmt->bindparam('tryTime', $attemptTime, PDO::PARAM_INT);
      $stmt->execute();

      header('Location: ../php/login.php');
    }
  }
}



//Getting user infomation function (admin)
function getAllUsers($pdo, $table, $users){
  try{
    $query = "SELECT * FROM $table";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e){
    echo 'Error ' . $e->getMessage();
    return false;
  }
}


function getUserDetails($pdo, $table, $userId)
{
  if (empty($userId) || !is_numeric($userId)) {
    return false;
  }

  $query = "SELECT * FROM $table WHERE id = :user_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

  if ($stmt->execute()) {
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    return false;
  }
}




function themeCookie($theme)
{
  $expiration = time() + 365 * 24 * 60 * 60; // 365 days
  setcookie('theme', $theme, $expiration, '/');
}


function getThemeCookie()
{
  if (isset($_COOKIE['theme'])) {
    return $_COOKIE['theme'];
  }
  return null;
}




if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["fullname"];
  $email = $_POST["email"];
  $message = $_POST["message"];

  if (contactUs($pdo, "contact", $name, $email, $message)) {
    // Successfully inserted the data
    echo "Message sent successfully!";
    header("Location: ../php/contact.php");
  } else {
    // Failed to insert the data
    echo "Error sending the message. Please try again.";
  }
}



function contactUs($pdo, $table, $name, $email, $message)
{
    try {
        $query = "INSERT INTO $table (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}


if (isset($_POST['clear_cart'])) {
  setcookie('cart', '', time() - 3600, '/');
  header('Location: cart.php'); 
  exit;
}

if (isset($_POST['remove_product'])) {
  $productIdToRemove = $_POST['product_id'];

  $cartData = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
  if (isset($cartData[$productIdToRemove])) {
    unset($cartData[$productIdToRemove]);
    setcookie('cart', json_encode($cartData), time() + 3600, '/');  
  }

  header('Location: cart.php');
  exit;
}

?>



