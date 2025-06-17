<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "noah_waters");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add type column if it doesn't exist
$checkColumn = "SHOW COLUMNS FROM products LIKE 'type'";
$result = $conn->query($checkColumn);

if ($result->num_rows == 0) {
    $addColumn = "ALTER TABLE products ADD COLUMN type VARCHAR(20) DEFAULT 'regular'";
    if ($conn->query($addColumn) === TRUE) {
        echo "Type column added successfully<br>";
    } else {
        echo "Error adding type column: " . $conn->error . "<br>";
    }
}

// Update existing products
$updateProducts = "UPDATE products SET type = 'borrowed' WHERE name LIKE '%Borrowed%'";
if ($conn->query($updateProducts) === TRUE) {
    echo "Products updated successfully<br>";
} else {
    echo "Error updating products: " . $conn->error . "<br>";
}

// Add image column if it doesn't exist
$checkImageColumn = "SHOW COLUMNS FROM products LIKE 'image'";
$result = $conn->query($checkImageColumn);

if ($result->num_rows == 0) {
    $addImageColumn = "ALTER TABLE products ADD COLUMN image VARCHAR(255) DEFAULT 'default.jpg'";
    if ($conn->query($addImageColumn) === TRUE) {
        echo "Image column added successfully<br>";
    } else {
        echo "Error adding image column: " . $conn->error . "<br>";
    }
}

// Add stock column if it doesn't exist
$checkStockColumn = "SHOW COLUMNS FROM products LIKE 'stock'";
$result = $conn->query($checkStockColumn);

if ($result->num_rows == 0) {
    $addStockColumn = "ALTER TABLE products ADD COLUMN stock INT DEFAULT 100";
    if ($conn->query($addStockColumn) === TRUE) {
        echo "Stock column added successfully<br>";
    } else {
        echo "Error adding stock column: " . $conn->error . "<br>";
    }
}

// Add store_id column if it doesn't exist
$checkStoreColumn = "SHOW COLUMNS FROM products LIKE 'store_id'";
$result = $conn->query($checkStoreColumn);

if ($result->num_rows == 0) {
    $addStoreColumn = "ALTER TABLE products ADD COLUMN store_id INT DEFAULT 1";
    if ($conn->query($addStoreColumn) === TRUE) {
        echo "Store ID column added successfully<br>";
    } else {
        echo "Error adding store ID column: " . $conn->error . "<br>";
    }
}

$conn->close();
echo "Database update completed.";
?> 