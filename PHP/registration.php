<?php
session_start();

$success = "Регистрация успешна.";
$_SESSION['success'] = $success;

$email = $_POST['email'];
$password = $_POST['password'];

function get_email($email){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = "SELECT email FROM `registration` WHERE email = :email";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

  if (!empty($result)){
    $email_false = "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.";
    $_SESSION['email_false'] = $email_false;

    header("Location: /page_register.php");
    exit();
  }

  return $result;
};

function add_user($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = "INSERT INTO `registration` (email, password) VALUES (:email, :password)";
  $insert = $pdo->prepare($sql);
  $insert->execute(['email' => $email, 'password' => $password]);

  $sqlSelect = "SELECT id FROM `registration`";
  $selectId = $pdo->prepare($sqlSelect);
  $selectId->execute();
  $id = $selectId->fetch(PDO::FETCH_ASSOC);

  return $id;
};

get_email($email);
add_user($email, $password);

header("Location: /page_login.php");
?>
