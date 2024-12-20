<?php
$conn = new mysqli('db', 'user', 'password', 'shop_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM orders WHERE id=$id";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    $product_id = $_PUT['product_id'];
    $quantity = $_PUT['quantity'];

  
    $stmt = $conn->prepare("UPDATE orders SET product_id=?, quantity=? WHERE id=?");
    $stmt->bind_param("iii", $product_id, $quantity, $id); 

    if ($stmt->execute()) {
        echo "Order updated successfully";
        echo "<script>window.location.replace('dynamic_page1.php');</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); 
}

$conn->close();
?>

<h2>Update Order</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id";?>">
  Product ID: <input type="number" name="product_id" value="<?php echo htmlspecialchars($order['product_id']); ?>" required><br>
  Quantity: <input type="number" name="quantity" value="<?php echo htmlspecialchars($order['quantity']); ?>" required><br>
  <input type="submit" name="submit" value="Update">
</form>
<a href="dynamic_page1.php">View Orders</a>