<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// function get user
function get_user($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  looking user with such email and password
  $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email, 'password' => $password]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

// get user ID
  get_userID($result['id']);

//  If TRUE
  if (!empty($result)){ redirect("users.php"); }
  else{
    create_session( "danger", "<strong>Уведомление!</strong> Не верно введенные данные.");
    redirect("page_login.php");
  }

  return $result;
}

// get user ID
function get_userID($id){ create_session('id', $id); }

// Set and display flash message
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Redirect to file
function redirect($link){ header("Location: /$link"); exit(); }

get_user($email, $password);

