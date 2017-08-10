<?php

session_start();

if (isset($_SESSION['username'])) {

    header('Location: php/korisnik/katalog/katalog.php');

} else {

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <link rel="icon"
              type="image/png"
              href="favico.ico">

        <meta charset="utf-8">

        <!-- Latest compiled and minified jQuery -->
        <script src="jquery/jquery-3.2.1.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="js/bootstrap.js"></script>

        <style media="screen">
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            * {
                box-sizing: border-box
            }

            body {
                font-family: Verdana, sans-serif;
            }

            .mySlides {
                display: none
            }

            /* Slideshow container */
            .slideshow-container {
                max-width: 1000px;
                position: relative;
                margin: auto;
            }

            /* Caption text */
            .text {
                color: #f2f2f2;
                font-size: 15px;
                padding: 8px 12px;
                position: absolute;
                bottom: 8px;
                width: 100%;
                text-align: center;
            }

            /* Number text (1/3 etc) */
            .numbertext {
                color: #f2f2f2;
                font-size: 12px;
                padding: 8px 12px;
                position: absolute;
                top: 0;
            }

            /* The dots/bullets/indicators */
            .dot {
                height: 13px;
                width: 13px;
                margin: 0 2px;
                background-color: #bbb;
                border-radius: 50%;
                display: inline-block;
                transition: background-color 0.6s ease;
            }

            .active {
                background-color: #717171;
            }

            /* On smaller screens, decrease text size */
            @media only screen and (max-width: 300px) {
                .text {
                    font-size: 11px
                }
            }

        </style>

        <title>Online prodaja</title>
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
                    <a class="navbar-brand" href="index.php">Online prodaja</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="php/prijava/prijava.php">Prijavi se</a>
                        </li>
                        <li>
                            <a href="php/registracija/registracija.php">Registruj se</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <!-- jumbotron -->
        <div class="jumbotron  text-center slideDown"
             style="border-bottom: 6px solid black; border-radius: 4px; z-index: 1; top: 0px; left: 0px;">
            <div class="slideshow-container">

                <div class="mySlides fade">
                    <h1>Online Prodaja
                        <small>Kupi ili prodaj</small>
                    </h1>
                    <br>
                    <p class="text-justify">
                        Ovo je mesto gde možete kupiti ili prodati bilo šta.<br>
                        Potrebno je da kreirate profil i možete započeti sa trgovinom.
                    </p>
                    <a class="btn btn-primary" href="php/prijava/prijava.php">Prijavi se</a>
                    <a class="btn btn-primary" href="php/registracija/registracija.php">Registruj se</a>
                </div>

                <div class="mySlides fade">
                    <h1>Online Prodaja
                        <small>Registruj se</small>
                    </h1>
                    <br>
                    <p class="text-justify">
                        Da bi ste započeli sa kupovinom ili prodajom na našoj internet prodavnici, potrebo je da
                        kreirate
                        profil, što možete učiniti klikom na dugme ispod ovog teksta.
                    </p>
                    <a class="btn btn-primary" href="php/registracija/registracija.php">Registruj se</a>
                </div>

                <div class="mySlides fade">
                    <h1>Online Prodaja
                        <small>Prijavi se</small>
                    </h1>
                    <br>
                    <p class="text-justify">
                        Da bi ste započeli sa kupovinom ili prodajom na našoj internet prodavnici, potrebo je da
                        kreirate profil, a zatim da se ulogujete, što možete učiniti klikom na dugme ispod ovog teksta.
                    </p>
                    <a class="btn btn-primary" href="php/prijava/prijava.php">Prijavi se</a>
                </div>

            </div>
            <br>

            <div style="text-align:center">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    </div>

    <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 3000); // Change image every 3 seconds
        }
    </script>

    </body>
    </html>

    <?php

}

?>
