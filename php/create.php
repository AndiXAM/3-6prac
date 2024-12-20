<?php
$conn = new mysqli('db', 'user', 'password', 'shop_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    
    $stmt = $conn->prepare("INSERT INTO products (product_name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $product_name, $price);

    if ($stmt->execute()) {
        echo "New product created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); 
}

$conn->close(); 
?>

<h2>Create Product</h2> 
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  Product Name: <input type="text" name="product_name" required><br>
  Price: <input type="number" step="0.01" name="price" required><br>
  <input type="submit" name="submit" value="Submit">
</form>
<a href="dynamic_page1.php">View Products</a>