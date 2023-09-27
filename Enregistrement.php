<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect('localhost', 'root', '', 'aws_db');
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $nom = verifyInput($_POST['nom']);
    $prenom = verifyInput($_POST['prenom']);
    $numero = verifyInput($_POST['numero']);
    $email = verifyInput($_POST['email']);

    $emailExiste = false;
    $checkEmailQuery = "SELECT * FROM participant WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);
    if ($result->num_rows > 0) {
        $emailExiste = true;
    }
    $numeroExiste = false;
    $checkNumeroQuery = "SELECT * FROM participant WHERE numero = '$numero'";
    $result = $conn->query($checkNumeroQuery);
    if ($result->num_rows > 0) {
        $numeroExiste = true;
    }

    if ($emailExiste) {
        $message = "L'email existe déjà dans la base de données.";
    } elseif ($numeroExiste) {
        $message = "Le numéro de téléphone existe déjà dans la base de données.";
    } else {
        $insertionSQL = "INSERT INTO participant (nom, prenom, numero, email) VALUES ('$nom', '$prenom', '$numero', '$email')";

        if ($conn->query($insertionSQL) === TRUE) {
            $message = "Enregistrement effectué !";
        } else {
            $message = "Erreur lors de l'enregistrement : " . $conn->error;
        }
    }

    
    $conn->close();
}

function verifyInput($var)
{
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Enregistrement.css">
    <title>Enregistrement des participants</title>
</head>
<body>

    <div class="container">
        <h1>Enregistrement des participants</h1>

        <form action="" method="post">

           <input type="text" id="nom" name="nom" required placeholder="Nom du participant">
           <br>
           <input type="text" id="prenom" name="prenom" required placeholder="Prenom du participant">
           <br>
           <input type="tel" id="numero" name="numero" required placeholder=" Numéro de téléphone">
           <br>
           <input type="email" id="email" name="email" required placeholder="Adresse email">
           <br>
           <button type="submit">Enregistrer</button>
           <a href="ListeInscrits.php" class="button-voir-inscrits">Voir les inscrits</a>

        </form>
    </div>
</body>
</html>
