<?php
// ... existing code ...
    // Get payment mode
    $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : 'online';
    
    // For guest users, force online payment
    if (!isset($_SESSION['user_id'])) {
        $payment_mode = 'online';
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, email, phone, address, total_amount, payment_mode, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("issssds", $user_id, $name, $email, $phone, $address, $total_amount, $payment_mode);
// ... existing code ... 