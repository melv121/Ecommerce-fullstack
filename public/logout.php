<?php
session_start();
session_destroy();
header('Location: /ecommerce/public/login.php');
exit;
?>
