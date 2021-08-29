<?php
session_start();

create_session( "success", "Регистрация успешна." );

$email = $_POST['email'];
$password = $_POST['password'];

// Функция валидации EMAIL
function get_email($email){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  Поиск EMAIL в БАЗЕ ДАННЫХ
  $sql = <<<HEARDOC
    SELECT email FROM login WHERE email = :email
HEARDOC;

  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

  if (!empty($result)){
    create_session( "email_false", "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем." );
    redirect( "page_register.php" );
  }

  return $result;
}

// Функция записи в БАЗУ ДАННЫХ
function add_user($email, $password)
{
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  Внести в БАЗУ ДАННЫХ
  $sql = <<<HEARDOC
    INSERT INTO login (email, password) VALUES (:email, :password)
HEARDOC;

  $insert = $pdo->prepare($sql);
  $insert->execute(['email' => $email, 'password' => md5($password)]);
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

get_email($email);
add_user($email, $password);
redirect( "page_login.php" );

