<html>
    <head>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    </head>
    <body>

    <header class="header">
        <h1>Title</h1>
    </header>
    
    <div class="main-content">
        <?php
        if (isset($_POST['username'])){
            echo "<h3>{$_POST['username']}</h3>";
        }
        ?>

    <div class="buttons-container">
        <div class="cliente">
            <h4>Menu</h4>
            <div class="dettagli ">

            </div>
        </div>
    </div>
    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>