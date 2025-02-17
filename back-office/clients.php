<?php
    session_start()
?>
<html>
    <head>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    </head>
    <body>

    <header class="header">
        <h1>Title</h1>
        <?php
        if (isset($_POST['username'])){
            echo "<h3>{$_POST['username']}</h3>";
        }
        ?>
    </header>
    
    <div class="main-content">

    <div class="buttons-container">
        <div class="cliente">
            <h4>Clienti</h4>
            <div class="dettagli ">

            </div>
        </div>
    </div>
    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>