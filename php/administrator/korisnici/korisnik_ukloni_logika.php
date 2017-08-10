<?php

session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin@mail.com') {

    require_once('../../baza/Database.php');

    $id = htmlspecialchars($_GET['id']);
    echo $korisnik_email = htmlspecialchars($_SESSION['username']);

    try {

        $pdo = Database::connect();

        $query = $pdo->prepare('DELETE FROM Aukcija.Korisnici 
                                        WHERE Aukcija.Korisnici.korisnik_id = :id;');

        $query->bindParam(':id', $id);

        $query->execute();

        Database::disconnect();

        header('Location: korisnici.php');

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

} else {

    header('Location: ../../../index.php');

}