<?php session_start();

$pdo = new PDO("mysql:host=127.0.0.1;dbname=marlin", 'root', '');

$id = $_REQUEST['id'];

$sql = <<<HEARDOC

    SELECT * 
        FROM users 
    INNER JOIN login 
        ON users.id = login.id
    INNER JOIN links 
        ON users.id = links.id

HEARDOC;
$select = $pdo->prepare($sql);
$select->execute();
$user = $select->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
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
                    <li class="nav-item ">
                        <a class="nav-link" href="users.php">Главная</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">

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
            <div class="subheader">
              <?php foreach ($user as $item): ?>
                  <?php if ($item['user_id'] === $id): ?>
                    <h1 class="subheader-title">
                        <i class='subheader-icon fal fa-user'></i> <?php echo $item['name']; ?>
                    </h1>
                <?php endif; ?>
              <?php endforeach; ?>

            </div>
            <div class="row">
              <div class="col-lg-6 col-xl-6 m-auto">
                  <?php foreach ($user as $item): ?>
                      <?php if ($item['user_id'] === $id): ?>

                      <!-- profile summary -->
                        <div class="card mb-g rounded-top">
                            <div class="row no-gutters row-grid">
                                <div class="col-12">
                                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                                        <img src="<?php echo $item['img']; ?>" class="rounded-circle shadow-2 img-thumbnail" alt="<?php echo $item['name']; ?>">
                                        <h5 class="mb-0 fw-700 text-center mt-3">
                                            <?php echo $item['name']; ?>
                                            <small class="text-muted mb-0"><?php echo $item['position']; ?></small>
                                        </h5>
                                        <div class="mt-4 text-center demo">
                                            <a href="javascript:void(0);" class="fs-xl" style="color:#C13584">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="fs-xl" style="color:#4680C2">
                                                <i class="fab fa-vk"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="fs-xl" style="color:#0088cc">
                                                <i class="fab fa-telegram"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 text-center">
                                        <a href="tel:<?php echo $item['phone']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                            <i class="fas fa-mobile-alt text-muted mr-2"></i> <?php echo $item['phone']; ?></a>
                                        <a href="mailto:<?php echo $item['email']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                            <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?php echo $item['email']; ?></a>
                                        <address class="fs-sm fw-400 mt-4 text-muted">
                                            <i class="fas fa-map-pin mr-2"></i> <?php echo $item['address']; ?>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                      <?php endif; ?>
                  <?php endforeach; ?>

               </div>
            </div>
        </main>
    </body>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

        });

    </script>
</html>