<?php
session_start();
session_unset();
session_destroy();
header('Location: banco/login.php');
exit();
?>
