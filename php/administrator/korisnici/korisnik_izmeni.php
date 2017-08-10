<?php

session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin@mail.com') {

    require('../../baza/Database.php');

    $id = null;

    if (!empty($_GET['id'])) {

        $id = htmlspecialchars($_REQUEST['id']);

    }

    if (null == $id) {

        header("Location: moji_predmeti.php");

    }

    if (!empty($_POST)) {

        // keep track validation errors
        $imeError = null;
        $prezimeError = null;
        $emailError = null;
        $lozinkaError = null;

        // keep track post values
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $email = $_POST['email'];
        $lozinka = md5($_POST['lozinka']);


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

        // update data
        if ($valid) {

            try {

                $pdo = Database::connect();

                $query = $pdo->prepare('UPDATE Aukcija.Korisnici 
                                                  SET 
                                                      Aukcija.Korisnici.korisnik_fname = :ime, 
                                                      Aukcija.Korisnici.korisnik_lname = :prezime, 
                                                      Aukcija.Korisnici.korisnik_email = :email, 
                                                      Aukcija.Korisnici.korisnik_lozinka = :lozinka 
                                                  WHERE 
                                                      Aukcija.Korisnici.korisnik_id = :id;');

                $query->bindParam(':ime', $ime);
                $query->bindParam(':prezime', $prezime);
                $query->bindParam(':email', $email);
                $query->bindParam(':lozinka', $lozinka);
                $query->bindParam(':id', $id);

                $query->execute();

                Database::disconnect();

                header("Location: korisnici.php");

            } catch (PDOException $e) {

                echo $e->getMessage();

            }

        }

    } else {

        try {

            $pdo = Database::connect();

            $query = $pdo->prepare("SELECT * 
                                        FROM Aukcija.Korisnici 
                                        WHERE Aukcija.Korisnici.korisnik_id = :id");

            $query->bindParam(':id', $id);

            $query->execute();

            $row = $query->fetch();

            $ime = $row['korisnik_fname'];
            $prezime = $row['korisnik_lname'];
            $email = $row['korisnik_email'];
            $lozinka = $row['korisnik_lozinka'];

            Database::disconnect();

        } catch (PDOException $e) {

            echo $e->getMessage();

        }

    }

    ?>

    <!﻿DOCTYPE html>
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

        <title>Admin panel - Izmena profila korisnika</title>

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
                    <a class="navbar-brand" href="korisnici.php">Admin panel</a>
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
                    <small>Izmena profila korisnika</small>
                </h1>
            </div>
        </div>

        <div class="container">

            <div class="span10 offset1">
                <div class="row">
                    <h3>
                        Korisnik: "<?php echo $row['korisnik_email']; ?>"
                        &nbsp;
                        &nbsp;
                        <a class="btn btn-default" href="korisnici.php">Korisnici</a>
                    </h3>
                </div>

                <div class="row" style="width: 300px;">
                    <form class="form-horizontal" action="korisnik_izmeni.php?id=<?php echo $row['korisnik_id'] ?>"
                          method="post">

                        <div class="control-group <?php echo !empty($imeError) ? 'error' : ''; ?>">
                            <label class="control-label">Ime</label>
                            <div class="controls">
                                <input class="form-control" name="ime" type="text" placeholder="Ime korisnika"
                                       value="<?php echo !empty($ime) ? $ime : ''; ?>">
                                <?php if (!empty($imeError)): ?>
                                    <span class="help-inline"><?php echo $imeError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($prezimeError) ? 'error' : ''; ?>">
                            <label class="control-label">Prezime</label>
                            <div class="controls">
                                <input class="form-control" name="prezime" type="text" placeholder="Prezime korisnika"
                                       value="<?php echo !empty($prezime) ? $prezime : ''; ?>">
                                <?php if (!empty($prezimeError)): ?>
                                    <span class="help-inline"><?php echo $prezimeError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                            <label class="control-label">Email</label>
                            <div class="controls">
                                <input class="form-control" name="email" type="email" placeholder="Email korisnika"
                                       value="<?php echo !empty($email) ? $email : ''; ?>">
                                <?php if (!empty($emailError)): ?>
                                    <span class="help-inline"><?php echo $emailError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($lozinkaError) ? 'error' : ''; ?>">
                            <label class="control-label">Lozinka</label>
                            <div class="controls">
                                <input class="form-control" name="lozinka" type="password"
                                       placeholder="Lozinka korisnika">
                                <?php if (!empty($lozinkaError)): ?>
                                    <span class="help-inline"><?php echo $lozinkaError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <br>

                        <div class="form-actions text-right">
                            <button type="submit" class="btn btn-success">Izmeni</button>
                        </div>
                    </form>
                </div>
            </div>

        </div> <!-- /container -->
    </div>
    </body>
    </html>

    <?php

} else {


    header('Location../../../index.php');

}