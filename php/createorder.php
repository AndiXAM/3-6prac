<?php
$conn = new mysqli('db', 'user', 'password', 'shop_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    
    $stmt = $conn->prepare("INSERT INTO orders (product_id, quantity) VALUES (?, ?)");
    $stmt->bind_param("ii", $product_id, $quantity); 

    if ($stmt->execute()) {
        echo "New order created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); 
}

$conn->close(); 
?>

<h2>Create Order</h2> 
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  Product ID: <input type="number" name="product_id" required><br>
  Quantity: <input type="number" name="quantity" required><br>
  <input type="submit" name="submit" value="Submit">
</form>
<a href="dynamic_page2.php">View Orders</a>