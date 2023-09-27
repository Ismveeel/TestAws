<?php
$conn = mysqli_connect('localhost', 'root', '', 'aws_db');
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$selectSQL = "SELECT * FROM participant";
$result = $conn->query($selectSQL);

$participants = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ListeInscrits.css">
    <title>Liste des inscrits</title>
</head>
<body>
    <div class="container">
        <h1>Liste des inscrits</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro de téléphone</th>
                    <th>Adresse email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($participants as $participant) : ?>
                    <tr>
                        <td><?= $participant['nom']; ?></td>
                        <td><?= $participant['prenom']; ?></td>
                        <td><?= $participant['numero']; ?></td>
                        <td><?= $participant['email']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="Enregistrement.php">Ajouter un nouveau participant</a>
    </div>
</body>
</html>
