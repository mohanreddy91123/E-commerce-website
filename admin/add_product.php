<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include '../includes/db.php';

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // Move image to images folder
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");

    // Insert into database
    $stmt = $conn->prepare(
        "INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$name, $price, $description, $image]);

    $success = "Product added successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>

<h2>Add Product</h2>

<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST" enctype="multipart/form-data">

    <label>Product Name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Price</label><br>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>Description</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Image</label><br>
    <input type="file" name="image" required><br><br>

    <button type="submit" name="add_product">Add Product</button>

</form>

<br>
<a href="manage_products.php">Back to Manage Products</a>

</body>
</html>
