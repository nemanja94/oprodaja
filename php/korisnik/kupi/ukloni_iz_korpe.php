<?php

session_start();

if (isset($_SESSION['username'])) {

    require_once('../../baza/Database.php');

    $id = htmlspecialchars($_GET['id']);
    $korisnik_email = htmlspecialchars($_SESSION['username']);

    try {

        $pdo = Database::connect();

        $query = $pdo->prepare('DELETE FROM Aukcija.Korpa 
                                          WHERE Aukcija.Korpa.artikl_id = :id AND Aukcija.Korpa.korisnik_email = :email;');

        $query->bindParam(':id', $id);
        $query->bindParam(':email', $korisnik_email);

        $query->execute();

        Database::disconnect();

        header('Location: korpa.php');

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

} else {

    header('Location: ../../../index.php');

}