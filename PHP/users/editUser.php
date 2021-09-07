<?php
session_start();

// DATA
$name = $_POST['name'];
$position = $_POST['position'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Найти нужный ID ПОЛЬЗОВАТЕЛЯ
function get_editUser($name, $position, $phone, $address){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

//  ID текущего пользователя
  $id = $_REQUEST['id'];

  $sql = <<<HEARDOC
    SELECT * FROM users WHERE user_id = $id
HEARDOC;
  $select = $pdo->prepare($sql);
  $select->execute();

  $result = $select->fetch(PDO::FETCH_ASSOC);

  if ( !empty($name) OR !empty($position) OR !empty($phone) OR !empty($address) ){
    add_editUser($name, $position, $phone, $address);

    create_session("edit_user", "Профиль успешно редактирован.");
    redirect("users.php");
  }

  return $result;
}

// Редактировать ПОЛЬЗОВАТЕЛЯ
function add_editUser($name, $position, $phone, $address){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin;charset=UTF8", 'root', '');

//  ID текущего пользователя
  $id = $_REQUEST['id'];

  $sql = <<<HEARDOC
    UPDATE `users`
        SET
    name = :name,
    position = :position,
    phone = :phone,
    address = :address 
        WHERE user_id = $id
HEARDOC;
  $update = $pdo->prepare($sql);
  $update->execute([ 'name' => $name, 'position' => $position, 'phone' => $phone, 'address' => $address ]);
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

get_editUser($name, $position, $phone, $address);