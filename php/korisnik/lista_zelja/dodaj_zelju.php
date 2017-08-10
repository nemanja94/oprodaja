<?php

session_start();

if (isset($_SESSION['username'])) {

    require_once('../../baza/Database.php');


    $id = htmlspecialchars($_GET['id']);
    $korisnik_email = htmlspecialchars($_SESSION['username']);

    $row = array();

    //Trazi podatke iz tablele
    try {

        $pdo = Database::connect();

        $query = $pdo->prepare('SELECT Aukcija.Lista_zelja.korisnik_email, Aukcija.Lista_zelja.artikl_id 
                                          FROM Aukcija.Lista_zelja 
                                          WHERE Aukcija.Lista_zelja.korisnik_email = :email AND Aukcija.Lista_zelja.artikl_id = :id;');

        $query->bindParam(':email', $korisnik_email);
        $query->bindParam(':id', $id);

        $query->execute();

        $row = $query->fetch();

        Database::disconnect();

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

    //Proverava da li je predmet vec unet u listu zelja
    if ($row['korisnik_email'] != $korisnik_email || $row['artikl_id'] != $id) { //Ako nije dodace ga

        //Unosi predmet u listu zelja
        try {

            $pdo = Database::connect();

            $query = $pdo->prepare('INSERT INTO Aukcija.Lista_zelja (Aukcija.Lista_zelja.korisnik_email, Aukcija.Lista_zelja.artikl_id) 
                                          VALUES (:korisnik_email, :artikl_id);');

            $query->bindParam(':korisnik_email', $korisnik_email);
            $query->bindParam(':artikl_id', $id);

            $query->execute();

            Database::disconnect();

            header('Location: ../katalog/katalog.php');

        } catch (PDOException $e) {

            echo $e->getMessage();

        }

    } else { //Ako je u listi, vratice se na katalog.php

        header('Location: ../katalog/katalog.php');

    }

} else {

    header('Location: ../../../index.php');

}