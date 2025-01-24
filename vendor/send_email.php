<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure PHPMailer via Composer ou manuellement
require 'autoload.php'; // Si vous utilisez Composer
// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $from_name = htmlspecialchars($_POST['from_name']);
    $reply_to = htmlspecialchars($_POST['reply_to']);
    $message = htmlspecialchars($_POST['message']);

    // Initialiser PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();  
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com'; // Serveur SMTP de Gmail
        $mail->Username = 'falloudioum216@gmail.com'; // Ton adresse email
        $mail->Password = 'yqcr mniw xtsn hvmb'; // Ton mot de passe (à ne jamais exposer publiquement)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Méthode de sécurité (STARTTLS)
        $mail->Port = 587; // Port pour TLS
        $mail->CharSet = 'UTF-8'; // Encodage des caractères

        // Options SSL pour ignorer la vérification des certificats
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Destinataire
        $mail->setFrom($reply_to, $from_name);
        $mail->addAddress('falloudioum216@gmail.com'); // Email de destination
        $mail->addReplyTo($reply_to, $from_name);
        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message du formulaire de contact';
        $mail->Body = "<p><strong>Nom :</strong> $from_name</p>
                       <p><strong>Email :</strong> $reply_to</p>
                       <p><strong>Message :</strong></p>
                       <p>$message</p>";

        // Envoyer l'email
        if ($mail->send()) {
            $response['status'] = 'success';
            $response['message'] = 'Message envoyé avec succès.';
        }
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = 'Erreur : ' . $mail->ErrorInfo;
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Méthode non autorisée.';
}

// Retourner la réponse JSON
echo json_encode($response);
?>