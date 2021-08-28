<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Функция ЛОГИНА
function login($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  Проверка EMAIL и PASSWORD
  $sql = "SELECT email, password FROM users WHERE email = :email AND password = :password";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email, 'password' => md5($password)]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

  if (!empty($result)){
    redirect("users.php");
  }
  else{
    create_session( "danger", "<strong>Уведомление!</strong> Не верно введенные данные.");
    redirect("page_login.php");
  }

  return $result;
}

// Записать ID пользователя в СЕССИЮ
function get_userID($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = "SELECT id FROM users WHERE email = :email AND password = :password";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email, 'password' => md5($password)]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

  create_session('id', $result['id']);

  return $result;
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

get_userID($email, $password);
login($email, $password);