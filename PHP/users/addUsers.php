<?php
session_start();

// DATA
$email = $_POST['email'];
$password = $_POST['password'];

// USER INFO
$name = $_POST['name'];
$position = $_POST['position'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Проверить, существует ли такой Email
function get_userInfo($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = "SELECT email, password FROM login WHERE email = :email";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => "$email"]);

  $result = $select->fetch(PDO::FETCH_ASSOC);

//  Если Email пуст, вывести СООБЩЕНИЕ и ВЕРНУТЬ ОБРАТНО
  if (empty($email)) {
    create_session("error_againCreateUserPassword", "<strong>Уведомление!</strong> Вы не указали Email");
    redirect("create_user.php");
  }

//  Если такого EMAIL нет, то добавить пользователя
//  В противном случае ВЕРНУТЬ ОБРАТНО и ВЫВЕСТИ СООБЩЕНИЕ
  if (empty($result)){
    addData($email, $password);
  }else{
    create_session("error_createUserEmail", "<strong>Уведомление!</strong> Такой Email уже существует.");
  }

  create_session("create_user", "Профиль успешно обновлен.");

  redirect("create_user.php");
}

// Записать EMAIL и PASSWORD
// получить последний ID
function addData($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = "INSERT INTO login(email, password) VALUES (:email, :password)";
  $insert = $pdo->prepare($sql);

  if (!empty($password)){
    $insert->execute([ 'email' => $email, 'password' => $password]);
    $user_id = $pdo->lastInsertId();

    add_lastUserID($user_id);
  }else{
    create_session("error_createUserPassword", "<strong>Уведомление!</strong> Вы не указали пароль");
    redirect("create_user.php");
  }
}

function add_lastUserID($user_id){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = "INSERT INTO users(user_id) VALUES ('$user_id')";
  $insert = $pdo->prepare($sql);
  $insert->execute();
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

get_userInfo($email, $password);