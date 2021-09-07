<?php session_start();

$pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

$sql = <<<HEARDOC
    SELECT * 
        FROM users 
    INNER JOIN login 
        ON users.id = login.id
    WHERE users.id > 1
HEARDOC;

$select = $pdo->prepare($sql);
$select->execute();
$user = $select->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="users.php"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <!--                    ===========================-->

              <?php if (!$_SESSION['id']): ?>
                  <li class="nav-item">
                      <a class="nav-link" href="page_login.php">Войти</a>
                  </li>
              <?php endif; ?>

                <!--                    ===========================-->

              <?php if ($_SESSION['id']): ?>
                  <li class="nav-item">
                      <a class="nav-link" href="PHP/log_out.php">Выйти</a>
                  </li>
              <?php endif; ?>

                <!--                    ===========================-->
            </ul>
        </div>
    </nav>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
            </h1>

          <?php if ($_SESSION['id'] ): ?>
              <span style="margin: 10px 0 0 30px"><?php echo "UserID: " . "<b>" . $_SESSION['id'] . "</b>" . "&ensp;" . "Role: " . "<b>" . $_SESSION['role'] . "</b>" ?></span>
          <?php endif; ?>

        </div>

<!--      Форма для КОНКРЕТНОГО ПОЛЬЗОВАТЕЛЯ-->
      <?php foreach($user as $item): ?>

<!--      Если ADMIN, то может видеть все данные-->
        <?php if ( $_SESSION['role'] == 'admin' ): ?>

<!--        Получить ID из URL -->
        <?php $id = $_REQUEST['id']; ?>

<!--        Если USER_ID равно $id, то TRUE -->
          <?php if ($item['user_id'] === $id): ?>
              <form action="">
                  <div class="row">
                      <div class="col-xl-6">
                          <div id="panel-1" class="panel">


                              <div class="panel-container">
                                  <div class="panel-hdr">
                                      <h2>Общая информация</h2>
                                  </div>
                                  <div class="panel-content">
                                      <!-- username -->
                                      <div class="form-group">
                                          <label class="form-label" for="simpleinput">Имя</label>
                                          <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['name']; ?>">
                                      </div>

                                      <!-- title -->
                                      <div class="form-group">
                                          <label class="form-label" for="simpleinput">Место работы</label>
                                          <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['position'] ?>">
                                      </div>

                                      <!-- tel -->
                                      <div class="form-group">
                                          <label class="form-label" for="simpleinput">Номер телефона</label>
                                          <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['phone']; ?>">
                                      </div>

                                      <!-- address -->
                                      <div class="form-group">
                                          <label class="form-label" for="simpleinput">Адрес</label>
                                          <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['address']; ?>">
                                      </div>
                                      <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                          <button class="btn btn-warning">Редактировать</button>
                                      </div>
                                  </div>
                              </div>


                          </div>
                      </div>
                  </div>
              </form>

          <?php endif; ?>
        <?php endif; ?>

<!--      Если USER, то может видеть только свои данные-->
        <?php if ($_SESSION['role'] == 'user'): ?>
          <?php if ( $item['id'] === $_SESSION['id'] ): ?>

            <form action="">
                <div class="row">
                    <div class="col-xl-6">
                        <div id="panel-1" class="panel">


                            <div class="panel-container">
                                <div class="panel-hdr">
                                    <h2>Общая информация</h2>
                                </div>
                                <div class="panel-content">
                                    <!-- username -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Имя</label>
                                        <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['name']; ?>">
                                    </div>

                                    <!-- title -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Место работы</label>
                                        <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['position'] ?>">
                                    </div>

                                    <!-- tel -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Номер телефона</label>
                                        <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['phone']; ?>">
                                    </div>

                                    <!-- address -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Адрес</label>
                                        <input type="text" id="simpleinput" class="form-control" value="<?php echo $item['address']; ?>">
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Редактировать</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </form>

          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
<!--      Форма для КОНКРЕТНОГО ПОЛЬЗОВАТЕЛЯ-->

    </main>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value === 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value === 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</body>
</html>