<?php
function rimuoviDalCarrello($idProdotto)
{
    if (isset($_SESSION['carrello'][$idProdotto])) {
        unset($_SESSION['carrello'][$idProdotto]);
    }
}
