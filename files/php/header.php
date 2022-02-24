<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= $path_icon ?>">
    <link rel="stylesheet" href="<?= $path_style ?>" />
    <link rel="stylesheet" href="<?= $path_bootstrap ?>" />
    <script src="<?= $path_jquery_js ?>"></script>
    <script src="<?= $path_bootstrap_js ?>"></script>
    <script src="<?= $site ?>files/js/main.js" type="module"></script>
    <script>
        const site = '<?= $site ?>';
    </script>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" />

    <!-- Meta Daten -->
    <meta name="twitter:card" content="summary_small_image">
    <meta id="image-src" name="twitter:image:src" content="<?= $path_icon ?>">
    <meta id="discord" name="twitter:image" content="<?= $path_icon ?>">
    <meta id="embed-title" property="og:title" content="Logic-Riddle">
    <!--DONE: Good Text-->
    <meta id="embed-desc" property="og:description" content="A logic calculator which can create truth tables of boolean expressions. It also includes an inbuilt user system that lets you create, upload and solve riddles made by other users. You have to find the correct expression, which is leading to the given truth table.">
    <meta id="embed-image" property="og:image" content="<?= $path_icon ?>">
    <meta name="theme-color" content="#0fa8d6">

    <!-- Suchmaschinen Meta Daten -->
    <meta name="robots" content="index"/>
    <meta name="description" content="Logic-Riddle Project of Adrian Schauer, Fabian Lasser and Elena Sam." />
    <meta name="keywords" content="Adrian Schauer, Logic, Algorithms, Riddle, Riddles, AND, OR, XOR, Boolean, Boolsche, Expression"/>
</head>

<body>
    <nav class="navbar bg-dark-grey navbar-expand-lg navbar-dark">
        <a id="homepage-icon" class="navbar-brand ms-3" href="<?= $site ?>">
            <!--<i class="fas fa-home fa-2x"></i>-->
            <span class="material-icons-round purple">
                Home
            </span>
        </a>
        <button class="navbar-toggler me-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item ms-3">
                    <a id="logictable" class="nav-link purple" href="<?= $site ?>logictable">Logictable</a>
                </li>
                <li class="nav-item ms-3">
                    <a id="riddles" class="nav-link purple" href="<?= $site ?>riddles">Riddles</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="loggedin invisible nav-item ms-3">
                    <a id="user" class="nav-link purple" href="<?= $site ?>user"><i class="fas fa-user fa-2x"></i></a>
                </li>
                <li class="loggedout invisible nav-item ms-3">
                    <a id="login" class="nav-link purple" href="<?= $site ?>login">Login</a>
                </li>
                <li class="loggedout invisible nav-item ms-3">
                    <a id="signup" class="nav-link purple" href="<?= $site ?>signup">Sign Up</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="content bg-dark-purple">