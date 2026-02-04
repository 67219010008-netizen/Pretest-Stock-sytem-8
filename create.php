<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];//555555555555
    $image = $_POST['image'];

    if ($name && $price && $quantity) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, category, price, quantity, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $category, $price, $quantity, $image]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - NexTech</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <header>
            <a href="index.php" class="logo">
                <i class="fa-solid fa-microchip"></i>
                NexTech Inventory
            </a>
            <a href="index.php" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </header>

        <div class="form-container">
            <div class="form-header">
                <h1 class="form-title">Add New Product</h1>
                <p style="color: var(--text-secondary);">Enter the details of the new item below</p>
            </div>

            <?php if ($message): ?>
                <div
                    style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color); padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem; border: 1px solid rgba(239, 68, 68, 0.2);">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Gaming Laptop X1">
                </div>

                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category" class="form-control">
                        <option value="Laptop">Laptop</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Component">Component (GPU, CPU, RAM)</option>
                        <option value="Accessory">Accessory (Mouse, Keyboard)</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Price (฿) *</label>
                        <input type="number" step="0.01" name="price" class="form-control" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control" required placeholder="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Image URL</label>
                    <input type="url" name="image" class="form-control" placeholder="https://example.com/image.jpg">
                    <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i> Paste a direct link to an image
                    </p>
                </div>

                <button type="submit" class="btn btn-primary"
                    style="width: 100%; justify-content: center; padding: 1rem; font-size: 1rem;">
                    <i class="fa-solid fa-plus"></i> Create Product
                </button>
            </form>
        </div>
    </div>
</body>

</html>