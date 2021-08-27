<?php
session_start();

flash_message( "success", "Регистрация успешна." );

// data
$email = $_POST['email'];
$password = $_POST['password'];

// function get email
function get_email($email){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  select in data base
  $sql = "SELECT email FROM `users` WHERE email = :email";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

//  If email was found
  if (!empty($result)){
    flash_message( "email_false", "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем." );
    redirect( "page_register.php" );
  }

  return $result;
};

// function insert in data base
function add_user($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  insert data base
  $sql = "INSERT INTO `users` (email, password) VALUES (:email, :password)";
  $insert = $pdo->prepare($sql);
  $insert->execute(['email' => $email, 'password' => $password]);

};

// Set and display flash message
function flash_message( $key, $message ){ $_SESSION["$key"] = $message; };
// Redirect to file
function redirect($link){ header("Location: /$link"); exit(); };

get_email($email);
add_user($email, $password);
redirect( "page_login.php" );
?>
