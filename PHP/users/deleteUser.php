<?php session_start();

$id = $_REQUEST['id'];

function delete($id){
  $pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

  $sql = <<<HEARDOC
    DELETE login, users, links FROM login 
        INNER JOIN users INNER JOIN links 
    WHERE login.id = '$id' AND users.user_id = '$id' AND links.user_id = '$id'
HEARDOC;
  $delete = $pdo->prepare($sql);
  $delete->execute();

  if ($_SESSION['role'] == 'user' ){
    redirect("page_register.php");
  }else{
      create_session('delete_user', '<strong>Уведомление!</strong> Пользователь был успешно удалён.');
      redirect("users.php");
  }
}

// Создать СЕССИЮ
function create_session( $key, $message ){ $_SESSION["$key"] = $message; }
// Создать путь
function redirect($link){ header("Location: /$link"); exit(); }

delete($id);