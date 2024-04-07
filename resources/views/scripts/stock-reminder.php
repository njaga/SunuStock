<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Connexion à la base de données
$conn = new mysqli('host', 'username', 'password', 'database');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Requête pour récupérer le nombre de produits et les noms des produits restants dans la base de données
$query = "SELECT COUNT(*) AS count, GROUP_CONCAT(name) AS names FROM products WHERE stock > 0";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $names = $row['names'];

    // Envoi de l'e-mail avec PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.ndiagandiaye.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sunu-stock@ndiagandiaye.com';
        $mail->Password = '2J2KTig~vs@+';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 465;

        // Destinataire, expéditeur, objet et contenu de l'e-mail
        $mail->setFrom('sunu-stock@ndiagandiaye.com', 'Sunu Stock');
        $mail->addAddress('nnjaga01@gmail', 'Ndiaga Ndiaye');
        $mail->isHTML(true);
        $mail->Subject = 'Rappel d\'état des stocks';
        ob_start();
        include 'stock-reminder.html';
        $mail->Body = ob_get_clean();

        // Envoi de l'e-mail
        $mail->send();
        echo 'E-mail envoyé avec succès.';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
} else {
    echo "Aucun produit trouvé dans la base de données.";
}

// Fermer la connexion à la base de données
$conn->close();

?>
