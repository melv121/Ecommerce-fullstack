<?php
require_once '../models/Cart.php';

function getCartItems() {
    return Cart::getAll();
}
?>