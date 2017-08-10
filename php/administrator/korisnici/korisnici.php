<?php

session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin@mail.com') {

    require_once('../../baza/Database.php');

    $pdo = Database::connect();

    $query = $pdo->prepare('SELECT *
                                      FROM Aukcija.Korisnici
                                      ORDER BY Aukcija.Korisnici.korisnik_id ASC ;');

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

        <title>Admin panel - Spisak svih korisnka</title>
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
                    <small>Spisak svih korisnika</small>
                </h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <form class="form-group" action="korisnik_pretraga.php" method="post"
                      style="margin-right: -16%; float: right;">
                    <label style="float: left">Pronađi korisnika:</label>
                    <br>
                    <input class="form-control" name="pretraga_input" type="search" placeholder="Email korisnika">
                    <br>
                    <input class="btn btn-primary" type="submit" name="pretraga_button" value="Pronađi"
                           style="float: right;">
                </form>
                <h3>
                    Svi korisnici
                    &nbsp;
                    &nbsp;
                    <a class="btn btn-default" href="korisnik_dodaj.php">Dodaj korisnika</a>
                </h3>
            </div>
            <hr>
            <br>
            <table class="table table-responsive table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Korisnik ID</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php

                while ($row = $query->fetch()) {

                    echo '<tr>
                        <td>' . $row['korisnik_id'] . '</td>
                        <td>' . $row['korisnik_fname'] . '</td>
                        <td>' . $row['korisnik_lname'] . '</td>
                        <td>' . $row['korisnik_email'] . '</td>
                        <td class="text-right">
                            <a class="btn btn-sm btn-primary" href="korisnik_detalji.php?id=' . $row['korisnik_id'] . '">Detalji</a>
                            <a class="btn btn-sm btn-success" href="korisnik_izmeni.php?id=' . $row['korisnik_id'] . '">Izmeni</a>
                            <a class="btn btn-sm btn-danger" href="korisnik_ukloni.php?id=' . $row['korisnik_id'] . '">Ukloni</a>
                        </td>
                      </tr>';

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
