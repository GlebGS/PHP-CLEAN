<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// function get user
function get_user($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  looking user with such email and password
  $sql = "SELECT id, email, password FROM `users` WHERE email = :email AND password = :password";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email, 'password' => $password]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

//  create SESSION id
  create_sesID($result['id']);

//  If TRUE
  if (!empty($result)){
    flash_message("log_out", "Выйти");
    flash_message("create_profile", "Профиль успешно обновлен.");
    redirect("users.php");
  }else{
    flash_message( "danger", "<strong>Уведомление!</strong> Не верно введенные данные.");
    redirect("page_login.php");
  }

  return $result;
};

// function create SESSION id
function create_sesID($id){ return $_SESSION['id'] = $id; };
// Set and display flash message
function flash_message( $key, $message ){ $_SESSION["$key"] = $message; };
// Redirect to file
function redirect($link){ header("Location: /$link"); exit(); };

get_user($email, $password);
?>
