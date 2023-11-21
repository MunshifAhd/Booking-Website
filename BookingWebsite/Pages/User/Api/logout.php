<?php
if (session_status() === PHP_SESSION_NONE)
  session_start();

unset($_SESSION["userId"]);

if (isset($_SERVER['HTTP_REFERER'])) {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
  header('Location: ./../index.php');
}
exit;
