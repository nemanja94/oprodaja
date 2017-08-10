<?php

session_start();

require '../../baza/Database.php';

if (!empty($_POST)) {

    // keep track validation errors
    $nazivError = null;
    $opisError = null;
    $cenaError = null;
    $kolicinaError = null;

    // keep track post values
    $naziv = htmlspecialchars($_POST['naziv']);
    $opis = htmlspecialchars($_POST['opis']);
    $cena = htmlspecialchars($_POST['cena']);
    $kolicina = htmlspecialchars($_POST['kolicina']);
    $email = htmlspecialchars($_SESSION['username']);

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
        $cenaError = 'Unesite cenu';
        $valid = false;
    }

    if (empty($kolicina)) {
        $kolicinaError = 'Unesite kolicinu';
        $valid = false;
    }

    // check data
    if ($valid) {

        try {

            $pdo = Database::connect();

            $query = $pdo->prepare('INSERT INTO Aukcija.Artikli  (artikl_naziv, artikl_opis, artikl_cena, korisnik_email, artikl_kolicina)
                                              VALUES (:naziv, :opis, :cena, :email, :kolicina);');

            $query->bindParam(':naziv', $naziv);
            $query->bindParam(':opis', $opis);
            $query->bindParam(':cena', $cena);
            $query->bindParam(':email', $email);
            $query->bindParam(':kolicina', $kolicina);

            $query->execute();

            Database::disconnect();

            header('Location: moji_predmeti.php');

        } catch (PDOException $e) {

            echo $e->getMessage();

        }

    } else {

        //echo 'nece valid';

    }

} else {

    //echo "nece";

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

    <title>Online prodaja - Dodaj predmet</title>

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
                <small>Dodaj predmet</small>
            </h1>
        </div>
    </div>

    <div class="container">

        <!--Prijava-->
        <div class="span10 offset1">
            <div class="row">
                <h3>Dodaj predmet
                    &nbsp;
                    &nbsp;
                    <a class="btn btn-default" href="moji_predmeti.php">Moji predmeti</a>
                </h3>
            </div>

            <div class="row" style="width: 300px; ">
                <form class="form-horizontal" action="moji_predmeti_dodaj.php" method="post">

                    <div class="control-group <?php echo !empty($nazivError) ? 'error' : ''; ?>">
                        <label class="control-label">Naziv predmeta</label>
                        <div class="controls">
                            <input class="form-control" name="naziv" type="text" placeholder="Naziv predmeta">
                            <?php if (!empty($nazivError)): ?>
                                <span class="help-inline"><?php echo $nazivError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($opisError) ? 'error' : ''; ?>">
                        <label class="control-label">Opis predmeta</label>
                        <div class="controls">
                            <input class="form-control" name="opis" type="text" placeholder="Opis predmeta">
                            <?php if (!empty($opisError)): ?>
                                <span class="help-inline"><?php echo $opisError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($cenaError) ? 'error' : ''; ?>">
                        <label class="control-label">Cena predmeta</label>
                        <div class="controls">
                            <input class="form-control" name="cena" type="number" placeholder="Cena predmeta">
                            <?php if (!empty($cenaError)): ?>
                                <span class="help-inline"><?php echo $cenaError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($kolicinaError) ? 'error' : ''; ?>">
                        <label class="control-label">Količina</label>
                        <div class="controls">
                            <input class="form-control" name="kolicina" type="number" placeholder="Količina">
                            <?php if (!empty($kolicinaError)): ?>
                                <span class="help-inline"><?php echo $kolicinaError; ?></span>
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