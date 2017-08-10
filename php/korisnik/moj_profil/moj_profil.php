<?php

session_start();

if (isset($_SESSION['username'])) {

    require('../../baza/Database.php');

    $id = null;
    $email = htmlspecialchars($_SESSION['username']);

    if (!empty($_POST)) {

        // keep track validation errors
        $fnameError = null;
        $lnameError = null;
        $passwordError = null;

        // keep track post values
        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']);
        $password = md5(htmlspecialchars($_POST['password']));

        // validate input
        $valid = true;

        if (empty($fname)) {

            $fnameError = 'Unesite ime';
            $valid = false;

        }

        if (empty($lname)) {

            $lnameError = 'Unesite prezime';
            $valid = false;

        }

        if (empty($password)) {

            $passwordError = 'Unesite lozinku';
            $valid = false;

        }

        // update data
        if ($valid) {

            try {

                $pdo = Database::connect();

                $query = $pdo->prepare('UPDATE Aukcija.Korisnici 
                                                  SET 
                                                    Aukcija.Korisnici.korisnik_fname = :fname,
                                                    Aukcija.Korisnici.korisnik_lname = :lname,
                                                    Aukcija.Korisnici.korisnik_lozinka = :password
                                                    WHERE Aukcija.Korisnici.korisnik_email = :email');

                $query->bindParam(':fname', $fname);
                $query->bindParam(':lname', $lname);
                $query->bindParam(':password', $password);
                $query->bindParam(':email', $email);

                $query->execute();

                Database::disconnect();

                header("Location: ../katalog/katalog.php");

            } catch (PDOException $e) {

                echo $e;

            }

        }

    } else {

        try {

            $pdo = Database::connect();

            $query = $pdo->prepare("SELECT Aukcija.Korisnici.korisnik_fname,  Aukcija.Korisnici.korisnik_lname, Aukcija.Korisnici.korisnik_email
                                        FROM Aukcija.Korisnici 
                                        WHERE Aukcija.Korisnici.korisnik_email = :email;");

            $query->bindParam(':email', $email);

            $query->execute();

            $row = $query->fetch(PDO::FETCH_ASSOC);

            $fname = $row['korisnik_fname'];
            $lname = $row['korisnik_lname'];
            //$password = $row['korisnik_lozinka'];

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

        <title>Online prodaja - Moj profil</title>

        <style media="screen">
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }
        </style>

    </head>

    <body>
    <nav class="navbar navbar-inverse" style="z-index: 2; top: 0; left: 0;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                </button>
                <a class="navbar-brand" href="../../../index.php">Online prodaja</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="../lista_zelja/lista_zelja.php">Lista želja</a>
                    </li>
                    <li>
                        <a href="../moji_predmeti/moji_predmeti.php">Moji predmeti</a>
                    </li>
                    <li>
                        <a href="../kupi/korpa.php">Korpa</a>
                    </li>
                    <li>
                        <a class="text" href="../../odjava/odjava.php">Odjavi se</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <!-- jumbotron -->
    <div class="jumbotron  text-center slideDown"
         style="border-bottom: 6px solid black; border-radius: 4px; z-index: 1; top: 0; left: 0;">
        <div class="container">
            <h1>Online prodaja
                <small>Moj profil - izmena</small>
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
                    <a class="btn btn-default" href="../katalog/katalog.php">Katalog</a>
                </h3>
            </div>

            <div class="row" style="width: 300px;">
                <form class="form-horizontal" action="moj_profil.php" method="post">

                    <div class="control-group <?php echo !empty($fnameError) ? 'error' : ''; ?>">
                        <label class="control-label">Ime</label>
                        <div class="controls">
                            <input class="form-control" name="fname" type="text" placeholder="Vaše ime"
                                   value="<?php echo !empty($fname) ? $fname : ''; ?>">
                            <?php if (!empty($fnameError)): ?>
                                <span class="help-inline"><?php echo $fnameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($lnameError) ? 'error' : ''; ?>">
                        <label class="control-label">Prezime</label>
                        <div class="controls">
                            <input class="form-control" name="lname" type="text" placeholder="Vaše prezime"
                                   value="<?php echo !empty($lname) ? $lname : ''; ?>">
                            <?php if (!empty($lnameError)): ?>
                                <span class="help-inline"><?php echo $lnameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($passwordError) ? 'error' : ''; ?>">
                        <label class="control-label">Lozinka</label>
                        <div class="controls">
                            <input class="form-control" name="password" type="password" placeholder="Vaša lozinka">
                            <?php if (!empty($passwordError)): ?>
                                <span class="help-inline"><?php echo $passwordError; ?></span>
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
    </body>
    </html>

    <?php

} else {


    header('Location../../../index.php');

}