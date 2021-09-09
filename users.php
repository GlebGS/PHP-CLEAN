<?php session_start();
error_reporting(0);

$pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

$sql = <<<HEARDOC

    SELECT * 
        FROM users 
    INNER JOIN login 
        ON users.id = login.id
    INNER JOIN links 
        ON users.id = links.id
    WHERE login.id > 1

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
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
</head>
    <body class="mod-bg-1 mod-nav-link">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
            <a class="navbar-brand d-flex align-items-center fw-500" href="users.php"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">

<!--                    ===========================-->

                    <?php if (isset($_SESSION['id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="page_profile.php?id=<?php echo $_SESSION['id']; ?>">Профиль</a>
                        </li>
                    <?php endif; ?>

<!--                    ===========================-->

                    <?php if (!isset($_SESSION['id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="page_login.php">Войти</a>
                        </li>
                    <?php endif; ?>

                    <!--                    ===========================-->

                    <?php if (isset($_SESSION['id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="PHP/log_out.php">Выйти</a>
                        </li>
                    <?php endif; ?>

<!--                    ===========================-->

                </ul>
            </div>
        </nav>

        <main id="js-page-content" role="main" class="page-content mt-3">

<!--                    ===========================-->
<!--          FLASH-СООБЩЕНИЕ при создание пользователя -->

            <?php if (isset($_SESSION['create_user'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['create_user']; unset($_SESSION['create_user']); ?>
                </div>
            <?php endif; ?>

<!--                    ===========================-->
<!--          FLASH-СООБЩЕНИЕ при редактирование пользователя -->

            <?php if (isset($_SESSION['edit_user'])): ?>
                <div class="alert alert-success">
                  <?php echo $_SESSION['edit_user']; unset($_SESSION['edit_user']); ?>
                </div>
            <?php endif; ?>

<!--                    ===========================-->

            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Список пользователей
                </h1>

              <?php if ($_SESSION['id'] ): ?>
                  <span style="margin: 10px 0 0 30px"><?php echo "UserID: " . "<b>" . $_SESSION['id'] . "</b>" . "&ensp;" . "Role: " . "<b>" . $_SESSION['role'] . "</b>" ?></span>
              <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-xl-12">

<!--                    ===========================-->

                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a class="btn btn-success" href="create_user.php">Добавить</a>
                    <?php else: ?>
                        <p></p>
                    <?php endif; ?>

<!--                    ===========================-->


                      <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">

                          <label for="js-filter-contacts"></label><input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">

                          <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                              <label class="btn btn-default active">
                                  <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                              </label>
                              <label class="btn btn-default">
                                  <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                              </label>
                          </div>
                      </div>

                </div>
            </div>

<!--                ==================================================-->

            <div class="row" id="js-contacts">

              <?php foreach($user as $item): ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>

    <!--                        Если ADMIN, то он может добавить ПОЛЬЗОВАТЕЛЯ и весь прочий функционал-->

                            <div class="col-xl-4">
                                <div id="<?php echo "c_" . $item['id']; ?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?php echo $item['name']; ?>">
                                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                        <div class="d-flex flex-row align-items-center">
                                                    <span class="status status-<?php echo $item['status']; ?> mr-3">
                                                        <span class="rounded-circle profile-image d-block " style="background-image:url('<?php echo $item['img']; ?>'); background-size: cover;"></span>
                                                    </span>
                                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#<?php echo "c_" . $item['id']; ?> > .card-body + .card-body" aria-expanded="false">
                                                <span class="collapsed-hidden">+</span>
                                                <span class="collapsed-reveal">-</span>
                                            </button>
                                            <div class="info-card-text flex-1">
                                                <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                                    <?php echo $item['name']; ?>
                                                    <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                                    <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                                </a>


                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="edit.php?id=<?php echo $item['user_id']; ?> ">
                                                        <i class="fa fa-edit"></i>
                                                        Редактировать</a>
                                                    <a class="dropdown-item" href="security.php?id=<?php echo $item['user_id']; ?>">
                                                        <i class="fa fa-lock"></i>
                                                        Безопасность</a>
                                                    <a class="dropdown-item" href="status.php?id=<?php echo $item['user_id']; ?>">
                                                        <i class="fa fa-sun"></i>
                                                        Установить статус</a>
                                                    <a class="dropdown-item" href="media.php?id=<?php echo $item['user_id']; ?>">
                                                        <i class="fa fa-camera"></i>
                                                        Загрузить аватар
                                                    </a>
                                                    <a href="PHP/users/deleteUser.php?id=<?php echo $item['user_id']; ?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                                        <i class="fa fa-window-close"></i>
                                                        Удалить
                                                    </a>
                                                </div>


                                                <span class="text-truncate text-truncate-xl"><?php echo $item['position']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 collapse show">
                                        <div class="p-3">
                                            <a href="tel:<?php echo $item['phone']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                                <i class="fas fa-mobile-alt text-muted mr-2"></i><?php echo $item['phone']; ?></a>
                                            <a href="mailto:<?php echo $item['email']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                                <i class="fas fa-mouse-pointer text-muted mr-2"></i><?php echo $item['email']; ?></a>
                                            <address class="fs-sm fw-400 mt-4 text-muted">
                                                <i class="fas fa-map-pin mr-2"></i><?php echo $item['address']; ?></address>

                                            <div class="d-flex flex-row">
                                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                                                    <i class="fab fa-vk"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                                                    <i class="fab fa-telegram"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                  <?php elseif(isset($_SESSION['role']) == 'user'): ?>
<!--                    Если USER, то он не может ДОБАВИТЬ пользователя и ИЗМЕНЯТЬ его-->

                            <div class="col-xl-4">
                                <div id="<?php echo "c_" . $item['id']; ?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?php echo $item['name']; ?>">
                                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                        <div class="d-flex flex-row align-items-center">
                                                    <span class="status status-<?php echo $item['status']; ?> mr-3">
                                                        <span class="rounded-circle profile-image d-block " style="background-image:url('<?php echo $item['img']; ?>'); background-size: cover;"></span>
                                                    </span>
                                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#<?php echo "c_" . $item['id']; ?> > .card-body + .card-body" aria-expanded="false">
                                                <span class="collapsed-hidden">+</span>
                                                <span class="collapsed-reveal">-</span>
                                            </button>
                                            <div class="info-card-text flex-1">
                                                <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-secondary" data-toggle="dropdown" aria-expanded="false">

<!--                                                  Получить нужного USER -->

                                                  <?php if ($item['user_id'] === $_SESSION['id']): ?>

                                                      <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                                        <?php echo $item['name']; ?>
                                                          <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                                          <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                                      </a>

                                                      <div class="dropdown-menu">
                                                          <a class="dropdown-item" href="edit.php?id=<?php echo $item['user_id']; ?>">
                                                              <i class="fa fa-edit"></i>
                                                              Редактировать</a>
                                                          <a class="dropdown-item" href="security.php?id=<?php echo $item['user_id']; ?>">
                                                              <i class="fa fa-lock"></i>
                                                              Безопасность</a>
                                                          <a class="dropdown-item" href="status.php?id=<?php echo $item['user_id']; ?>">
                                                              <i class="fa fa-sun"></i>
                                                              Установить статус</a>
                                                          <a class="dropdown-item" href="media.php?id=<?php echo $item['user_id']; ?>">
                                                              <i class="fa fa-camera"></i>
                                                              Загрузить аватар
                                                          </a>
                                                          <a href="PHP/users/deleteUser.php?id=<?php echo $item['user_id']; ?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                                              <i class="fa fa-window-close"></i>
                                                              Удалить
                                                          </a>
                                                      </div>

                                                  <?php else:?>
                                                    <?php echo $item['name']; ?>
                                                  <?php endif; ?>

                                                </a>

                                                <span class="text-truncate text-truncate-xl"><?php echo $item['position']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 collapse show">
                                        <div class="p-3">
                                            <a href="tel:<?php echo $item['phone']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                                <i class="fas fa-mobile-alt text-muted mr-2"></i><?php echo $item['phone']; ?></a>
                                            <a href="mailto:<?php echo $item['email']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                                <i class="fas fa-mouse-pointer text-muted mr-2"></i><?php echo $item['email']; ?></a>
                                            <address class="fs-sm fw-400 mt-4 text-muted">
                                                <i class="fas fa-map-pin mr-2"></i><?php echo $item['address']; ?></address>

                                            <div class="d-flex flex-row">
                                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                                                    <i class="fab fa-vk"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                                                    <i class="fab fa-telegram"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                <?php else: ?>

    <!--                        Если пользователь НЕ АВТОРИЗОВАН, то он не может ни ДОБАВИТЬ, ни ПОСМОТРЕТЬ ПОДРОБНУЮ ИНФОРМАЦИЮ о данном пользователе -->

                            <div class="col-xl-4">
                                <div id="<?php echo "c_" . $item['id']; ?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?php echo $item['name']; ?>">
                                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                        <div class="d-flex flex-row align-items-center">
                                            <span class="status status-<?php echo $item['status']; ?> mr-3">
                                                <span class="rounded-circle profile-image d-block " style="background-image:url('<?php echo $item['img']; ?>'); background-size: cover;"></span>
                                            </span>

                                            <div class="info-card-text flex-1">
                                                <p href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-secondary" data-toggle="dropdown" aria-expanded="false">
                                                  <?php echo $item['name']; ?>
                                                </p>

                                                <span class="text-truncate text-truncate-xl"><?php echo $item['position']; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    <?php endif; ?>
              <?php endforeach; ?>

            </div>

<!--                ==================================================-->

        </main>

        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">2020 © Учебный проект</span>
            </div>
            <div>
                <ul class="list-table m-0">
                    <li><a href="intel_introduction.html" class="text-secondary fw-700">Home</a></li>
                    <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">About</a></li>
                </ul>
            </div>
        </footer>

    </body>

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
</html>