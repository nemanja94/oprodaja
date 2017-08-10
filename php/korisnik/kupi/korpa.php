<?php

session_start();

if (isset($_SESSION['username'])) {

    require_once('../../baza/Database.php');

    $email = htmlspecialchars($_SESSION['username']);

    try {

        $pdo = Database::connect();

        $email = $_SESSION['username'];

        $query = $pdo->prepare('SELECT
                                              *
                                          FROM Aukcija.Korpa
                                          JOIN Aukcija.Artikli ON Aukcija.Korpa.artikl_id = Aukcija.Artikli.artikl_id
                                          HAVING Aukcija.Korpa.korisnik_email = :email
                                          ORDER BY Aukcija.Korpa.artikl_id ASC ;');

        $query->bindParam(':email', $email);

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

            <title>Online aukcije - Korpa</title>
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
                        <a class="navbar-brand" href="../../../index.php">Online aukcije</a>
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
                                <a href="../moj_profil/moj_profil.php">Moj profil</a>
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
                    <h1>Online aukcije
                        <small>Korpa</small>
                    </h1>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <h3>
                        Svi predmeti iz korpe
                        &nbsp;
                        &nbsp;
                        <a class="btn btn-default" href="../katalog/katalog.php">Katalog</a>
                    </h3>
                    <br>
                </div>
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>Naziv artikla</th>
                        <th>Cena artikla</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    while ($row = $query->fetch()) {

                        echo '<tr>
                        <td>' . $row['artikl_naziv'] . '</td>
                        <td>' . $row['artikl_cena'] . '$</td>
                        <td class="text-right">';

                        if ($row['artikl_kolicina'] > 0) {

                            echo '<a class="btn btn-sm btn-primary" href="kupi.php?id=' . $row['artikl_id'] . '">Kupi</a>';


                        } else {

                            echo '<p class="text-danger">Nema na stanju</p>';

                        }

                        echo '</td>
                                <td><a class="btn btn-sm btn-danger" href="ukloni_iz_korpe.php?id=' . $row['artikl_id'] . '">Ukloni</a></td>
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

        Database::disconnect();

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

} else {

    header('Location: ../../../index.php');

}

?>


