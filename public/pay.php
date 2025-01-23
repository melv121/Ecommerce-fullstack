<?php
session_start();
require_once __DIR__ . '/../includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process payment here
    // For demonstration purposes, we'll just display a success message
    $success = "Payment successful!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .payment-methods img {
            width: 50px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Payment</h2>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <form action="pay.php" method="post">
                    <div class="form-group">
                        <label for="cardNumber">Card Number:</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="cardName">Cardholder Name:</label>
                        <input type="text" class="form-control" id="cardName" name="cardName" required>
                    </div>
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date:</label>
                        <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV:</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                    </div>
                    <div class="form-group">
                        <label for="paymentMethod">Payment Method:</label>
                        <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                            <option value="mastercard">Mastercard</option>
                            <option value="visa">Visa</option>
                            <option value="paypal">PayPal</option>
                            <option value="amex">American Express</option>
                            <option value="applepay">Apple Pay</option>
                        </select>
                    </div>
                    <div class="payment-methods text-center mb-3">
                        <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard">
                        <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa">
                        <img src="https://img.icons8.com/color/48/000000/paypal.png" alt="PayPal">
                        <img src="https://img.icons8.com/color/48/000000/amex.png" alt="American Express">
                        <img src="https://img.icons8.com/color/48/000000/apple-pay.png" alt="Apple Pay">
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Pay</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
