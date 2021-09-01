<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Функция ЛОГИНА
function login($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  Проверка EMAIL и PASSWORD
  $sql = <<<HEARDOC
    SELECT email, password FROM login WHERE email = :email AND password = :password
HEARDOC;

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

// Записать ID и ROLE пользователя в СЕССИЮ
function get_userStatus($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = <<<HEARDOC
    SELECT id, role FROM login WHERE email = :email AND password = :password
HEARDOC;

  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email, 'password' => md5($password)]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

  create_session('id', $result['id']);
  create_session('role', $result['role']);

  return $result;
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

get_userStatus($email, $password);
login($email, $password);