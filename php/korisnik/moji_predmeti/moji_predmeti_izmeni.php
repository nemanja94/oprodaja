<?php

session_start();

if (isset($_SESSION['username'])) {

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
        $nazivError = null;
        $opisError = null;
        $cenaError = null;
        $kolicinaError = null;

        // keep track post values
        $naziv = $_POST['naziv'];
        $opis = $_POST['opis'];
        $cena = $_POST['cena'];
        $kolicina = $_POST['kolicina'];
        $email = $_SESSION['username'];

        // validate input
        $valid = true;

        if (empty($naziv)) {

            $nazivError = 'Unesite naziv';
            $valid = false;

        }

        if (empty($opis)) {

            $opisError = 'Unesite opis';
            $valid = false;

        }

        if (empty($cena)) {

            $cenaError = 'Unesite cena';
            $valid = false;

        }

        if (empty($kolicina)) {

            $kolicinaError = 'Unesite kolicinu';
            $valid = false;

        }

        // update data
        if ($valid) {

            try {

                $pdo = Database::connect();

                $query = $pdo->prepare('UPDATE Aukcija.Artikli SET Aukcija.Artikli.artikl_naziv = :naziv, Aukcija.Artikli.artikl_opis = :opis, Aukcija.Artikli.artikl_cena = :cena, Aukcija.Artikli.korisnik_email = :email, Aukcija.Artikli.artikl_kolicina = :kolicina WHERE Aukcija.Artikli.artikl_id = :id;');

                $query->bindParam(':naziv', $naziv);
                $query->bindParam(':opis', $opis);
                $query->bindParam(':cena', $cena);
                $query->bindParam(':email', $email);
                $query->bindParam(':kolicina', $kolicina);
                $query->bindParam(':id', $id);

                $query->execute();

                Database::disconnect();

                header("Location: moji_predmeti.php");

            } catch (PDOException $e) {

                echo $e;

            }

        }

    } else {

        try {

            $pdo = Database::connect();

            $query = $pdo->prepare("SELECT * 
                                        FROM Aukcija.Artikli 
                                        WHERE Aukcija.Artikli.artikl_id = :id");

            $query->bindParam(':id', $id);

            $query->execute();

            $row = $query->fetch(PDO::FETCH_ASSOC);

            $naziv = $row['artikl_naziv'];
            $opis = $row['artikl_opis'];
            $cena = $row['artikl_cena'];
            $kolicina = $row['artikl_kolicina'];

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

        <title>Online prodaja - Izmena predmeta</title>

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
                    <a class="navbar-brand" href="../../../index.php">Online prodaja</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="../lista_zelja/lista_zelja.php">Lista želja</a>
                        </li>
                        <li>
                            <a href="../moj_profil/moj_profil.php">Moj profil</a>
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
             style="border-bottom: 6px solid black; border-radius: 4px; z-index: 1; top: 0px; left: 0px;">
            <div class="container">
                <h1>Online prodaja
                    <small>Izmena predmeta</small>
                </h1>
            </div>
        </div>

        <div class="container">

            <div class="span10 offset1">
                <div class="row">
                    <h3>
                        Predmet: "<?php echo $row['artikl_naziv']; ?>"
                        &nbsp;
                        &nbsp;
                        <a class="btn btn-default" href="moji_predmeti.php">Nazad</a>
                    </h3>
                </div>

                <div class="row" style="width: 300px;">
                    <form class="form-horizontal" action="moji_predmeti_izmeni.php?id=<?php echo $row['artikl_id'] ?>"
                          method="post">

                        <div class="control-group <?php echo !empty($nazivError) ? 'error' : ''; ?>">
                            <label class="control-label">Ime</label>
                            <div class="controls">
                                <input class="form-control" name="naziv" type="text" placeholder="Naziv predmeta"
                                       value="<?php echo !empty($naziv) ? $naziv : ''; ?>">
                                <?php if (!empty($nazivError)): ?>
                                    <span class="help-inline"><?php echo $nazivError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($opisError) ? 'error' : ''; ?>">
                            <label class="control-label">Opis</label>
                            <div class="controls">
                                <input class="form-control" name="opis" type="text" placeholder="Opis predmeta"
                                       value="<?php echo !empty($opis) ? $opis : ''; ?>">
                                <?php if (!empty($opisError)): ?>
                                    <span class="help-inline"><?php echo $opisError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($cenaError) ? 'error' : ''; ?>">
                            <label class="control-label">Cena</label>
                            <div class="controls">
                                <input class="form-control" name="cena" type="number" placeholder="Cena predmeta"
                                       value="<?php echo !empty($cena) ? $cena : ''; ?>">
                                <?php if (!empty($cenaError)): ?>
                                    <span class="help-inline"><?php echo $cenaError; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="control-group <?php echo !empty($kolicinaError) ? 'error' : ''; ?>">
                            <label class="control-label">Količina</label>
                            <div class="controls">
                                <input class="form-control" name="kolicina" type="number" placeholder="Količina"
                                       value="<?php echo !empty($kolicina) ? $kolicina : ''; ?>">
                                <?php if (!empty($kolicinaError)): ?>
                                    <span class="help-inline"><?php echo $kolicinaError; ?></span>
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