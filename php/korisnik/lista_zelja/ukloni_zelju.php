<?php

session_start();

if (isset($_SESSION['username'])) {

    require_once('../../baza/Database.php');

    $id = htmlspecialchars($_GET['id']);
    $korisnik_email = htmlspecialchars($_SESSION['username']);

    try {

        $pdo = Database::connect();

        $query = $pdo->prepare('DELETE FROM Aukcija.Lista_zelja WHERE Aukcija.Lista_zelja.artikl_id = :id AND Aukcija.Lista_zelja.korisnik_email = :email;');

        $query->bindParam(':id', $id);
        $query->bindParam(':email', $korisnik_email);

        $query->execute();

        Database::disconnect();

        header('Location: lista_zelja.php');

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

} else {

    header('Location: ../../../index.php');

}