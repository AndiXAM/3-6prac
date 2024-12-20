<?php
$conn = new mysqli('db', 'user', 'password', 'shop_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id=$id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    $product_name = $_PUT['product_name'];
    $price = $_PUT['price'];


    $stmt = $conn->prepare("UPDATE products SET product_name=?, price=? WHERE id=?");
    $stmt->bind_param("sdi", $product_name, $price, $id);

    if ($stmt->execute()) {
        echo "Product updated successfully";
        echo "<script>window.location.replace('dynamic_page1.php');</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<h2>Update Product</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id";?>">
  Product Name: <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br>
  Price: <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>
  <input type="submit" name="submit" value="Update">
</form>
<a href="dynamic_page1.php">View Products</a>

<!--

http://localhost/update.php?id=1

-->