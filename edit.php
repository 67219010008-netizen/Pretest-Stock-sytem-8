<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: index.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image'];

    if ($name && $price && $quantity) {
        try {
            $sql = "UPDATE products SET name=?, category=?, price=?, quantity=?, image=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $category, $price, $quantity, $image, $id]);
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
    <title>Edit Product - NexTech</title>
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
                <h1 class="form-title">Edit Product</h1>
                <p style="color: var(--text-secondary);">Update information for: <strong>
                        <?php echo htmlspecialchars($product['name']); ?>
                    </strong></p>
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
                    <input type="text" name="name" class="form-control"
                        value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category" class="form-control">
                        <option value="Laptop" <?php echo $product['category'] == 'Laptop' ? 'selected' : ''; ?>>Laptop
                        </option>
                        <option value="Monitor" <?php echo $product['category'] == 'Monitor' ? 'selected' : ''; ?>
                            >Monitor</option>
                        <option value="Component" <?php echo $product['category'] == 'Component' ? 'selected' : ''; ?>
                            >Component (GPU, CPU, RAM)</option>
                        <option value="Accessory" <?php echo $product['category'] == 'Accessory' ? 'selected' : ''; ?>
                            >Accessory (Mouse, Keyboard)</option>
                        <option value="Other" <?php echo $product['category'] == 'Other' ? 'selected' : ''; ?>>Other
                        </option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Price (฿) *</label>
                        <input type="number" step="0.01" name="price" class="form-control"
                            value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control"
                            value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Image URL</label>
                    <input type="url" name="image" class="form-control"
                        value="<?php echo htmlspecialchars($product['image']); ?>">
                </div>

                <button type="submit" class="btn btn-primary"
                    style="width: 100%; justify-content: center; padding: 1rem; font-size: 1rem;">
                    <i class="fa-solid fa-save"></i> Save Changes
                </button>
            </form>
        </div>
    </div>
</body>

</html>