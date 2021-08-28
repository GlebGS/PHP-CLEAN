<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Функция ЛОГИНА
function login($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  Проверка EMAIL и PASSWORD
  $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email, 'password' => md5($password)]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

// Получить ID юзера
  get_userID($result['id']);

  if (!empty($result)){ redirect("users.php"); }
  else{
    create_session( "danger", "<strong>Уведомление!</strong> Не верно введенные данные.");
    redirect("page_login.php");
  }

  return $result;
}

// Получить ID пользователя
function get_userID($id){ create_session('id', $id); }

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

login($email, $password);

