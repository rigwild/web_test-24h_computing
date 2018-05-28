<?php
include 'functions.php';
session_destroy();
redirectNotification("ko", "Vous avez été déconnecté.", "index.php");
?>