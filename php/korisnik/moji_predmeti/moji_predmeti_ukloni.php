<?php

session_start();

if (isset($_SESSION['username'])) {

    require_once('../../baza/Database.php');

    $id = htmlspecialchars($_GET['id']);
    $korisnik_email = htmlspecialchars($_SESSION['username']);

    try {

        $pdo = Database::connect();

        $query = $pdo->prepare('DELETE FROM Aukcija.Artikli 
                                        WHERE Aukcija.Artikli.artikl_id = :id 
                                        AND Aukcija.Artikli.korisnik_email = :email;');

        $query->bindParam(':id', $id);
        $query->bindParam(':email', $korisnik_email);

        $query->execute();

        Database::disconnect();

        header('Location: moji_predmeti.php');

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

} else {

    header('Location: ../../../index.php');

}