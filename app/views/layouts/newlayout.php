<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?= $title ?></title>

        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Custom styles for this template -->
<!--        <link href="dashboard.css" rel="stylesheet">-->
    </head>

    <body>
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Штатное расписание</a>

            <ul class="navbar-nav px-3">
                <?php if (\app\models\User::isAdmin()) : ?>
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="/logout">Выйти</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="/signin">Войти</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="/positions">
                                    <span data-feather="trello"></span>
                                    Должности
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/workplaces">
                                    <span data-feather="file-text"></span>
                                    Рабочие места
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/departments">
                                    <span data-feather="grid"></span>
                                    Отделы
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/employees">
                                    <span data-feather="users"></span>
                                    Сотрудники
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2"><?= $title ?></h1>
                    </div>

                    <?php echo $content ?>
                </main>
            </div>
        </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <!--<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>-->
    <!--<script src="../../assets/js/vendor/popper.min.js"></script>-->
    <!--<script src="../../dist/js/bootstrap.min.js"></script>-->

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace()
        </script>
    </body>
</html>