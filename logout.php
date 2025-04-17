<?php
session_start();
session_destroy();  // Distruge sesiunea
header("Location: login.php");  // Redirecționează utilizatorul la login
exit();
?>
