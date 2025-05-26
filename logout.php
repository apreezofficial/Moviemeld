<?php
session_start();
session_destroy();
session_start();
$_SESSION['message'] = "LOGOUT SUCCESSFUL";
                header("Location: index.php");
                exit;
?>