<?php session_start();

$email = $_POST['email'];
$password = $_POST['password'];


function getData($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  ID текущего ПОЛЬЗОВАТЕЛЯ
  $id = $_REQUEST['id'];

  $sql = <<<HEARDOC
    SELECT login.id, users.user_id, email 
        FROM login JOIN users 
    ON login.id = '$id' 
        WHERE login.id = '$id' 
          AND users.user_id = '$id'
          AND email = :email
          AND password = :password
HEARDOC;
  $select = $pdo->prepare($sql);
  $select->execute([ 'email' => $email, 'password' => $password ]);
  $result = $select->fetch(PDO::FETCH_ASSOC);

//  Если такой пользователь с таким EMAIL уже существует - FALSE
  if (!empty($result)){
    create_session('email_false', '<strong>Уведомление!</strong> Такой EMAIL уже существует');
  }else{
    addDataSecurity($email, $password);
  }

  redirect("security.php?id=$id");
}

function addDataSecurity($email, $password){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

//  ID текущего ПОЛЬЗОВАТЕЛЯ
  $id = $_REQUEST['id'];

  $sql = "UPDATE login SET email = :email, password = :password WHERE id = '$id'";
  $update = $pdo->prepare($sql);

//  Если один из INPUT пуст - FALSE
  if (!empty($email) && !empty($password)){
    $update->execute([ 'email' => $email, 'password' => md5($password) ]);
    create_session('email_true', '<strong>Уведомление!</strong> Данные успешно изменены');
  }else{
    create_session('data_false', '<strong>Уведомление!</strong> Введите данные');
  }
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

getData($email, $password);