<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "online";

// Connect to the database
$con = mysqli_connect($servername, $username, $password, $database);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submissions for product management
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $stock_quantity = $_POST['stock_quantity'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $product_id = $_POST['product_id'] ?? 0;

    if (isset($_POST['insert'])) {
        $sql = "INSERT INTO products (product_name, description, stock_quantity, price) 
                VALUES ('$product_name', '$description', $stock_quantity, $price)";
        mysqli_query($con, $sql);
    }

    if (isset($_POST['update'])) {
        $sql = "UPDATE products SET product_name='$product_name', description='$description', 
                stock_quantity=$stock_quantity, price=$price WHERE product_id=$product_id";
        mysqli_query($con, $sql);
    }

    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM products WHERE product_id=$product_id";
        mysqli_query($con, $sql);
    }
}

// Fetch all products
$result = mysqli_query($con, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zokolo Shoppy</title>
    <style>
        body {
            background-color: whitesmoke;
            color: rgb(0, 91, 85);
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: rgb(107, 128, 0);
            padding: 10px;
            text-align: center;
        }
        header h1 {
            color: aqua;
            margin: 0;
        }
        nav {
            margin: 10px 0;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .section {
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1><marquee>Welcome To ZOKOLO SHOPPY</marquee></h1>
        <nav>
            <a href="#categories">Categories</a>
            <a href="#products">Products</a>
            <a href="#about">About Us</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

    <div class="section">
        <h2 id="categories">Product Categories</h2>
        <ul>
            <li>Smartphones</li>
            <li>Laptops</li>
            <li>Headphones</li>
        </ul>
    </div>

    <div class="section">
        <h2 id="products">Product Management</h2>
        <form method="post">
            <h3>Add Product</h3>
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="number" name="stock_quantity" placeholder="Stock Quantity" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <button type="submit" name="insert">Insert Product</button>
        </form>

        <form method="post">
            <h3>Update Product</h3>
            <input type="number" name="product_id" placeholder="Product ID" required>
            <input type="text" name="product_name" placeholder="New Product Name" required>
            <input type="text" name="description" placeholder="New Description" required>
            <input type="number" name="stock_quantity" placeholder="New Stock Quantity" required>
            <input type="number" step="0.01" name="price" placeholder="New Price" required>
            <button type="submit" name="update">Update Product</button>
        </form>

        <form method="post">
            <h3>Delete Product</h3>
            <input type="number" name="product_id" placeholder="Product ID" required>
            <button type="submit" name="delete">Delete Product</button>
        </form>

        <h3>Product List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['stock_quantity']}</td>
                        <td>{$row['price']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found.</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="section">
        <h2 id="about">About Zokolo Shoppy</h2>
        <p>We provide essentials for day-to-day living. Our brand has been popular since 1999.</p>
    </div>

    <footer>
        <p>&copy; 2024 Zokolo Shoppy. All rights reserved.</p>
    </footer>

    <?php mysqli_close($con); ?>
</body>
</html>
