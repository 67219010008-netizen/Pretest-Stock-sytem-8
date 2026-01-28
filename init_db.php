<?php
require 'db.php';

try {
    // Create products table
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Table 'products' created successfully (or already exists).<br>";

    // Insert dummy data if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    if ($stmt->fetchColumn() == 0) {
        $dummy_data = "INSERT INTO products (name, category, price, quantity, image) VALUES
            ('Gaming Laptop ROG Strix', 'Laptop', 45000.00, 10, 'https://dlcdnwebimgs.asus.com/gain/47fe734c-6229-4d6d-9d48-6603aebf9076/w800'),
            ('RTX 4090 Graphics Card', 'Component', 65000.00, 5, 'https://dlcdnwebimgs.asus.com/gain/9d9f5647-1906-444e-9d29-6744883907c1/w800'),
            ('Mechanical Keyboard RGB', 'Accessory', 3500.00, 50, 'https://m.media-amazon.com/images/I/71fC7oG1XaL.jpg'),
            ('curved Gaming Monitor 34\"', 'Monitor', 12900.00, 15, 'https://dlcdnwebimgs.asus.com/gain/1c0106f0-514d-4504-95c5-179377484d2f/w800'),
            ('Wireless Gaming Mouse', 'Accessory', 1200.00, 30, 'https://resource.logitech.com/w_692,c_lpad,ar_4:3,q_auto:best,f_auto,dpr_1.0/content/dam/logitech/en/products/mice/mx-master-3s/gallery/mx-master-3s-mouse-top-view-graphite.png')";
        $pdo->exec($dummy_data);
        echo "Dummy data inserted successfully.";
    }

} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>