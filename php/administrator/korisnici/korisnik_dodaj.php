<?php

session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin@mail.com') {

    require '../../baza/Database.php';

    if (!empty($_POST)) {

        // keep track validation errors
        $imeError = null;
        $prezimeError = null;
        $emailError = null;
        $lozinkaError = null;

        // keep track post VALUSE
        $ime = htmlspecialchars($_POST['ime']);
        $prezime = htmlspecialchars($_POST['prezime']);
        $email = htmlspecialchars($_POST['email']);
        $lozinka = md5(htmlspecialchars($_POST['lozinka']));


        // validate input
        $valid = true;

        if (empty($ime)) {

            $imeError = 'Unesite korisnikovo ime';
            $valid = false;

        }

        if (empty($prezime)) {

            $prezimeError = 'Unesite korisnikovo prezime';
            $valid = false;

        }

        if (empty($email)) {

            $emailError = 'Unesite korisnikov email';
            $valid = false;

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $emailError = 'Unesite validnu email adresu';
            $valid = false;

        }

        if (empty($lozinka)) {

            $lozinkaError = 'Unesite korisnikovu lozniku';
            $valid = false;

        }

        // check data
        if ($valid) {

            try {

                $pdo = Database::connect();

                $query = $pdo->prepare('INSERT INTO Aukcija.Korisnici  (korisnik_fname, korisnik_lname, korisnik_email, korisnik_lozinka)
                                              VALUES (:ime, :prezime, :email, :lozinka);');

                $query->bindParam(':ime', $ime);
                $query->bindParam(':prezime', $prezime);
                $query->bindParam(':email', $email);
                $query->bindParam(':lozinka', $lozinka);

                $query->execute();

                Database::disconnect();

                header('Location: korisnici.php');

            } catch (PDOException $e) {

                echo $e->getMessage();

            }

        }
    }

} else {

    header('../../../index.php');

}

?>

<!doctype html>
<html lang="en">
<head>
    <link rel="icon"
          type="image/png"
          href="../../../favico.ico">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified jQuery -->
    <script src="../../../jquery/jquery-3.2.1.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../../css/bootstrap.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="../../../js/bootstrap.js"></script>

    <title>Admin panel - Dodaj korisnika</title>

    <style media="screen">
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }
    </style>

</head>

<body>
<div>
    <nav class="navbar navbar-inverse" style="z-index: 2; top: 0px; left: 0px;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                </button>
                <a class="navbar-brand" href="../../../index.php">Admin panel</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="text" href="../../odjava/odjava.php">Odjavi se</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <!-- jumbotron -->
    <div class="jumbotron  text-center slideDown"
         style="border-bottom: 6px solid black; border-radius: 4px; z-index: 1; top: 0px; left: 0px;">
        <div class="container">
            <h1>Admin panel
                <small>Dodaj korisnika</small>
            </h1>
        </div>
    </div>

    <div class="container">

        <!--Prijava-->
        <div class="span10 offset1">
            <div class="row">
                <h3>Dodaj korisnika
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <a class="btn btn-default" href="korisnici.php">Korisnici</a>
                </h3>
            </div>

            <div class="row" style="width: 300px; ">
                <form class="form-horizontal" action="korisnik_dodaj.php" method="post">

                    <div class="control-group <?php echo !empty($imeError) ? 'error' : ''; ?>">
                        <label class="control-label">Ime korisnika</label>
                        <div class="controls">
                            <input class="form-control" name="ime" type="text" placeholder="Ime korisnika">
                            <?php if (!empty($imeError)): ?>
                                <span class="help-inline"><?php echo $imeError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($prezimeError) ? 'error' : ''; ?>">
                        <label class="control-label">Prezime korisnika</label>
                        <div class="controls">
                            <input class="form-control" name="prezime" type="text" placeholder="Prezime korisnika">
                            <?php if (!empty($prezimeError)): ?>
                                <span class="help-inline"><?php echo $prezimeError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                        <label class="control-label">Email korisnika</label>
                        <div class="controls">
                            <input class="form-control" name="email" type="email" placeholder="Email korisnika">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($lozinkaError) ? 'error' : ''; ?>">
                        <label class="control-label">Lozinka korisnika</label>
                        <div class="controls">
                            <input class="form-control" name="lozinka" type="password" placeholder="Lozinka korisnika">
                            <?php if (!empty($lozinkaError)): ?>
                                <span class="help-inline"><?php echo $lozinkaError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <br>

                    <div class="form-actions" style="float: right">
                        <button type="submit" class="btn btn-success">Dodaj</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>