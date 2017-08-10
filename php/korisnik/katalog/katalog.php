<?php

session_start();

if (isset($_SESSION['username'])) {

    require_once('../../baza/Database.php');

    $korisnicko_ime = $_SESSION['username'];

    $pdo = Database::connect();

    $query = $pdo->prepare('SELECT * 
                                      FROM Aukcija.Artikli
                                      JOIN Aukcija.Korisnici ON Artikli.korisnik_email = Korisnici.korisnik_email
                                      HAVING Aukcija.Korisnici.korisnik_email != :email;');

    $query->bindParam(':email', $korisnicko_ime);

    $query->execute();

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <link rel="icon"
              type="image/png"
              href="../../../favico.ico">
        <meta charset="utf-8">

        <!-- Latest compiled and minified jQuery -->
        <script src="../../../jquery/jquery-3.2.1.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="../../../css/bootstrap.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="../../../js/bootstrap.js"></script>

        <style media="screen">
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }
        </style>

        <title>Online prodaja - Katalog</title>
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
                            <a href="../moji_predmeti/moji_predmeti.php">Moji predmeti</a>
                        </li>
                        <li>
                            <a href="../moj_profil/moj_profil.php">Moj profil</a>
                        </li>
                        <li>
                            <a href="../lista_zelja/lista_zelja.php">Lista želja</a>
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
                    <small>Spisak svih predmeta</small>
                </h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <form class="form-group" action="katalog_pretraga.php" method="post"
                      style="margin-right: -16%; float: right;">
                    <label style="float: left">Pronađi predmet:</label>
                    <br>
                    <input class="form-control" name="pretraga_input" placeholder="Naziv predmeta">
                    <br>
                    <input class="btn btn-primary" type="submit" name="pretraga_button" value="Pronađi"
                           style="float: right;">
                </form>
                <h3>
                    Svi predmeti
                </h3>
            </div>
            <hr>
            <br>
            <table class="table table-responsive table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Naziv artikla</th>
                    <th>Cena artikla</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php

                while ($row = $query->fetch()) {

                    if ($row['artikl_kolicina'] > 0) {

                        echo '<tr>
                        <td>' . $row['artikl_naziv'] . '</td>
                        <td>' . $row['artikl_cena'] . '$</td>
                        <td class="text-right">
                            <a class="btn btn-sm btn-primary" href="../artikl/artikl.php?id=' . $row['artikl_id'] . '">Detalji</a>
                            <a class="btn btn-sm btn-success" href="../kupi/dodaj_u_korpu.php?id=' . $row['artikl_id'] . '">Dodaj u korpu</a>
                            <a class="btn btn-sm btn-warning" href="../lista_zelja/dodaj_zelju.php?id=' . $row['artikl_id'] . '">Dodaj na listu želja</a>
                        </td>
                      </tr>';

                    }

                }

                ?>

                </tbody>
            </table>
        </div>
    </div>
    </body>
    </html>

    <?php

} else {

    header('Location: ../../../index.php');

}

?>