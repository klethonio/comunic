<?php
ob_start();
session_start();
unset($_SESSION['adUser']);
setcookie('adUser', "", time()-3600);
header('Location: '.BASE);
ob_end_flush();
?>