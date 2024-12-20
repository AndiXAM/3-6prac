<?php
$conn = new mysqli('db', 'user', 'password', 'shop_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        echo "Order deleted successfully";
        echo "<script>window.location.replace('dynamic_page1.php');</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); 
}

$conn->close();
?>

<h2>Delete Order</h2>
<p>Are you sure you want to delete this order?</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id";?>">
    <input type="submit" name="submit" value="Delete">
</form>
<a href="dynamic_page2.php">Cancel</a>