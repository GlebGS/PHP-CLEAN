<?php
session_start();
unset($_SESSION['id'], $_SESSION['role']);

redirect("users.php");
function redirect($link){ header("Location: /$link"); exit(); }