<?php
session_start();

function print_arr($arr){
  echo "<pre>";
    print_r($arr);
  echo "</pre>";
}

$email = $_POST['email'];
$password = $_POST['password'];

function get_user($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = "SELECT email, password FROM `registration` WHERE email = :email AND password = :password";
  $select = $pdo->prepare($sql);
  $select->execute(['email' => $email, 'password' => $password]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

  if (!empty($result)){
    header("Location: /users.php");
    exit;
  }else{
    $danger = "<strong>Уведомление!</strong> Не верно введенные данные.";
    $_SESSION['danger'] = $danger;

    header("Location: /page_login.php");
    exit;
  }

  return $result;
};

get_user($email, $password);

?>
