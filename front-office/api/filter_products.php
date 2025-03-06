<?php
include '../database/recall.php';

$categoria_nome = isset($_POST['categoria_nome']) ? $_POST['categoria_nome'] : '';

visualizzaMenu($categoria_nome);
