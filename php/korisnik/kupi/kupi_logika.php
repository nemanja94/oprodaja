<?php
session_start();

if (isset($_SESSION['username'])) {

    require_once('../../baza/Database.php');

    $id = htmlspecialchars($_GET['id']);
    $email = htmlspecialchars($_SESSION['username']);
    $row = null;

    try {

        $pdo = Database::connect();

        $query = $pdo->prepare('SELECT Aukcija.Artikli.artikl_kolicina 
                                          FROM Aukcija.Artikli 
                                          WHERE Aukcija.Artikli.artikl_id = :id');

        $query->bindParam(':id', $id);

        $query->execute();

        $row = $query->fetch();

        Database::disconnect();

        header('Location: ../katalog/katalog.php');

    } catch (PDOException $e) {

        echo $e->getMessage();

    }

    if ($row['artikl_kolicina'] > 0) {

        try {

            $kolicina = $row['artikl_kolicina'];
            $kolicina--;

            $pdo = Database::connect();

            $query = $pdo->prepare('UPDATE Aukcija.Artikli 
                                              SET Aukcija.Artikli.artikl_kolicina = :kolicina 
                                              WHERE Aukcija.Artikli.artikl_id = :id');

            $query->bindParam(':kolicina', $kolicina);
            $query->bindParam(':id', $id);

            $query->execute();

            $query = $pdo->prepare('DELETE FROM Aukcija.Korpa
                                              WHERE Aukcija.Korpa.korisnik_email = :email
                                              AND Aukcija.Korpa.artikl_id = :id');

            $query->bindParam(':email', $email);
            $query->bindParam(':id', $id);

            $query->execute();

            Database::disconnect();

            header('Location: korpa.php');

        } catch (PDOException $e) {

            echo $e->getMessage();

        }

    } else if ($row['artikl_kolicina'] == 1) {

        try {

            $pdo = Database::connect();

            $query = $pdo->prepare('DELETE FROM Aukcija.Artikli WHERE Aukcija.Artikli.artikl_id = :id');

            $query->bindParam(':id', $id);

            $query->execute();

            $row = $query->fetch();

            $query = $pdo->prepare('DELETE FROM Aukcija.Korpa
                                              WHERE Aukcija.Korpa.korisnik_email = :email
                                              AND Aukcija.Korpa.artikl_id = :id');

            $query->bindParam(':email', $email);
            $query->bindParam(':id', $id);

            $query->execute();

            Database::disconnect();

            header('Location: ../katalog/katalog.php');

        } catch (PDOException $e) {

            echo $e->getMessage();

        }

    }

} else {

    header('Location: ../../../index.php');

}
