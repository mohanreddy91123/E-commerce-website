<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $conn->prepare("
    SELECT products.name, products.price, cart.quantity
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($items)) {
    echo "<h2>Your cart is empty.</h2>";
    exit();
}

$grandTotal = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 60%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #f4f4f4; }
        .total { font-weight: bold; }

        .thank-you {
            margin-top: 30px;
            padding: 20px;
            background: #e6ffe6;
            border: 1px solid #4CAF50;
            width: 60%;
            text-align: center;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: green;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Checkout</h2>

<table>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>

<?php foreach ($items as $item): 
    $total = $item['price'] * $item['quantity'];
    $grandTotal += $total;
?>
<tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td>$<?= number_format($item['price'], 2) ?></td>
    <td><?= $item['quantity'] ?></td>
    <td>$<?= number_format($total, 2) ?></td>
</tr>
<?php endforeach; ?>

<tr>
    <td colspan="3" class="total">Grand Total</td>
    <td class="total">$<?= number_format($grandTotal, 2) ?></td>
</tr>
</table>

<div class="thank-you">
    <h3>Thank You for Your Order! 🎉</h3>
    <p>Your order has been placed successfully.</p>
    <p>Total Amount Paid: <strong>$<?= number_format($grandTotal, 2) ?></strong></p>
</div>

<a href="cart.php">Back to Cart</a>

</body>
</html>
