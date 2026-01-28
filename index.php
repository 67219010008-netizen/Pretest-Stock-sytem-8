<?php
require 'db.php';

// Fetch all products
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexTech Stock System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header>
            <a href="index.php" class="logo">
                <i class="fa-solid fa-microchip"></i>
                NexTech Inventory
            </a>
            <div class="header-actions">
                <a href="create.php" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Add Product
                </a>
            </div>
        </header>

        <!-- Stats Overview (Optional) -->
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <div
                style="background: var(--card-bg); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border-color);">
                <div style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 0.5rem;">Total Products
                </div>
                <div style="font-size: 2rem; font-weight: 700;"><?php echo count($products); ?></div>
            </div>
            <div
                style="background: var(--card-bg); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border-color);">
                <div style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 0.5rem;">Total Value</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--success-color);">
                    ฿<?php
                    $total = 0;
                    foreach ($products as $p)
                        $total += $p['price'] * $p['quantity'];
                    echo number_format($total, 2);
                    ?>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                    <?php else: ?>
                        <div class="product-image"
                            style="display: flex; align-items: center; justify-content: center; background: #0f172a; color: var(--text-secondary);">
                            <i class="fa-regular fa-image fa-3x"></i>
                        </div>
                    <?php endif; ?>

                    <div class="product-info">
                        <div class="product-category"><?php echo htmlspecialchars($product['category']); ?></div>
                        <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="product-price">฿<?php echo number_format($product['price'], 2); ?></div>

                        <div class="product-meta">
                            <?php
                            $statusClass = 'status-in-stock';
                            $statusText = 'In Stock';
                            if ($product['quantity'] <= 0) {
                                $statusClass = 'status-out-stock';
                                $statusText = 'Out of Stock';
                            } elseif ($product['quantity'] < 5) {
                                $statusClass = 'status-low-stock';
                                $statusText = 'Low Stock';
                            }
                            ?>
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo $product['quantity']; ?> Units
                            </span>

                            <div class="product-actions">
                                <a href="edit.php?id=<?php echo $product['id']; ?>" class="action-btn" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="delete.php?id=<?php echo $product['id']; ?>" class="action-btn" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this item?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($products) == 0): ?>
            <div style="text-align: center; padding: 4rem; color: var(--text-secondary);">
                <i class="fa-solid fa-box-open fa-4x" style="margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>No products found. Start by adding one!</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>