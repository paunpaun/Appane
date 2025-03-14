<?php
session_start();
include 'database/recall.php';

$menu_name = '';
$sql = "SELECT nome FROM tmenu WHERE attivo = TRUE LIMIT 1";
$result = $connessione->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $menu_name = htmlspecialchars($row['nome']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/ordine.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="img/Appane_logo.png" alt="Appane Logo">
            </a>
        </div>
        <div class="header-text">
            <h1>Menu</h1>
        </div>
    </header>

    <div class="main-content">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <div class="main-content-navigation_bar">
            <?php
            if (isset($_SESSION["idUser"])) {
                echo "<a style='margin-right:15px'; href='carrelloUtente.php'>Carrello</a>";
                echo "<a style='margin-right:15px'; href='logout.php'>Logout</a>";
            } else {
                echo "<a style='margin-left:10px'; href='login.php'>Login</a>";
            }
            ?>
        </div>
        <div class="main-content-menu-container">
            <header class="menu-container-header">
                <h2><?php echo $menu_name; ?></h2>
            </header>
            <div class="menu-container-body">
                <label for="category-select">Seleziona Categoria:</label>
                <select id="category-select" onchange="filterByCategory()">
                    <option value="">Tutte</option>
                    <?php
                    $sql = "SELECT nome FROM tcategoria";
                    $result = $connessione->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['nome']) . '">' . htmlspecialchars($row['nome']) . '</option>';
                    }
                    ?>
                </select>
                <div id="products-container">
                    <?php
                    visualizzaMenu();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>
    <script src="js/menu.js"></script>
    <script src="js/carrello.js"></script>

    <script>
        function filterByCategory() {
            let category = document.getElementById('category-select').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'api/filter_products.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('products-container').innerHTML = this.responseText;
                    disableAddToCartButtons();
                }
            };
            xhr.send('categoria_nome=' + encodeURIComponent(category));
        }

        function disableAddToCartButtons() {
            const currentDay = new Date().getDay();
            const addToCartButtons = document.querySelectorAll(".add-to-cart");

            addToCartButtons.forEach(button => {
                if (currentDay < 1 || currentDay > 3) {
                    button.disabled = true;
                    button.style.backgroundColor = "#ccc";
                    button.style.cursor = "not-allowed";
                }
            });
        }
    </script>
</body>

</html>