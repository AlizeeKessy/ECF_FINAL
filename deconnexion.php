<?php
session_start();
$_SESSION = []; // Réinitialise toutes les variables de session
session_destroy();
echo '<meta http-equiv="refresh" content="0;url=index.php">'; // Redirection vers la page de connexion
exit;
?>