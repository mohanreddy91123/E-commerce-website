<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include '../includes/db.php';

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
</head>
<body>

<h2>Manage Products</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id']; ?></td>
        <td><?= htmlspecialchars($product['name']); ?></td>
        <td><?= $product['price']; ?></td>
        <td><?= htmlspecialchars($product['description']); ?></td>
        <td>
            <img src="../images/<?= $product['image']; ?>" width="50">
        </td>
        <td>
            <a href="edit_product.php?id=<?= $product['id']; ?>">Edit</a> |
            <a href="delete_product.php?id=<?= $product['id']; ?>"
               onclick="return confirm('Are you sure?');">
               Delete
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
