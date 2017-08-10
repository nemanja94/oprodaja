<?php

session_start();

require '../baza/Database.php';

if (!empty($_POST)) {

    // keep track validation errors
    $emailError = null;
    $passwordError = null;

    // keep track post values
    $email = htmlspecialchars($_POST['email']);
    $password = md5(htmlspecialchars($_POST['lozinka']));

    // validate input
    $valid = true;

    if (empty($email)) {

        $emailError = 'Unesite vašu email adresu';
        $valid = false;

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $emailError = 'Unesite validnu email adresu';
        $valid = false;

    }

    if (empty($password)) {

        $passwordError = 'Unesite vašu lozinku';
        $valid = false;

    }

    // check data
    if ($valid) {

        try {

            $pdo = Database::connect();

            $query = $pdo->prepare('SELECT Aukcija.Korisnici.korisnik_email
                                              FROM Aukcija.Korisnici 
                                              WHERE Aukcija.Korisnici.korisnik_email = :email');

            $query->bindParam(':email', $email);

            $query->execute();

            $row_email = $query->fetch();

            $query = $pdo->prepare('SELECT Aukcija.Korisnici.korisnik_lozinka 
                                              FROM Aukcija.Korisnici 
                                              WHERE Aukcija.Korisnici.korisnik_lozinka = :lozinka');

            $query->bindParam(':lozinka', $password);

            $query->execute();

            $row_password = $query->fetch();


            if ($row_email['korisnik_email'] != $email) {

                $emailError = 'Pogresna email adresa';
                $valid = false;

            }

            if ($row_password['korisnik_lozinka'] != $password) {

                $passwordError = 'Pogresna lozinka';
                $valid = false;

            }


            if ($row_email['korisnik_email'] == $email && $row_password['korisnik_lozinka'] == $password) {

                $_SESSION['username'] = $email;
                header('Location: ../administrator/korisnici/korisnici.php');

            }

            Database::disconnect();

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
          href="../../favico.ico">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified jQuery -->
    <script src="../../jquery/jquery-3.2.1.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="../../js/bootstrap.js"></script>

    <title>Online prodaja - Prijava</title>

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
                <a class="navbar-brand" href="../../index.php">Online prodaja</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="../registracija/registracija.php">Registruj se</a>
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
                <small>Prijavi se</small>
            </h1>
            <p>
                Nakon kreiranja profila, moći ćete da se prijavite na svoj novi profil.
                To će vam omogućiti da pregledate sve predemte koje su postavili drugi članovi, ali i vi ćete moći da
                postavie svoje.
            </p>
        </div>
    </div>

    <div class="container">

        <!--Prijava-->
        <div class="span10 offset1">
            <div class="row">
                <h3>Prijavi se</h3>
            </div>

            <div class="row" style="width: 300px; ">
                <form class="form-horizontal" action="prijava.php" method="post">

                    <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                        <label class="control-label">Email adresa</label>
                        <div class="controls text-danger">
                            <input class="form-control" name="email" type="text" placeholder="Vaša email adresa"
                                   value="<?php echo !empty($email) ? $email : ''; ?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($passwordError) ? 'error' : ''; ?>">
                        <label class="control-label">Lozinka</label>
                        <div class="controls text-danger">
                            <input class="form-control" name="lozinka" type="password" placeholder="Vaša lozinka">
                            <?php if (!empty($passwordError)): ?>
                                <span class="help-inline"><?php echo $passwordError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <br>

                    <div class="form-actions" style="float: right">
                        <button type="submit" class="btn btn-success">Prijavi se</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>