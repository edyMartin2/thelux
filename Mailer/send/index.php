<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$mail = new PHPMailer(true);


@$callback = $_GET['callback'];
function fillPost($keys, $exclude = null)
{
    $array = array();
    foreach ($_REQUEST as $key => $val) {
        if (is_array($keys)) {
            if (in_array($key, $keys)) {
                $array[$key] = $val;
            }
        } elseif ($keys == "ALL") {
            if (isset($exclude)) {
                if (is_array($exclude)) {
                    if (!in_array($key, $exclude)) {
                        $array[$key] = $val;
                    }
                } else {
                    if ($key != $exclude) {
                        $array[$key] = $val;
                    }
                }
            } else {
                $array[$key] = $val;
            }
        } else {
            return $_REQUEST[$keys];
        }
    }
    return $array;
}

@$variables = fillPost('ALL');

@$Nombre = $variables['Name'];
@$Correo = $variables['Mail'];
@$Subject = $variables['Subject'];
@$Mensaje = $variables['Message'];

try {
    $mail->SMTPDebug = 2;                   // Enable verbose debug output
    $mail->isSMTP();                        // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';    // Specify main SMTP server
    $mail->SMTPAuth   = true;               // Enable SMTP authentication
    $mail->Username   = 'edgar.edgarroman@gmail.com';     // SMTP username
    $mail->Password   = 'cbvucxcrupyccqiz';         // SMTP password
    $mail->SMTPSecure = 'tls';              // Enable TLS encryption, 'ssl' also accepted
    $mail->Port       = 587;                // TCP port to connect to

    $mail->setFrom('from@gfg.com', 'Name');           // Set sender of the mail

    $mail->addAddress('edgar.edgarroman@gmail.com');           // Add a recipient
    $mail->addAddress('edgar.edgarroman@gmail.com', 'Edy');   // Name is optional
    $mail->isHTML(true);
    $mail->Subject = $Subject;
    $mail->Body    =  "Nuevo mensage de {$Nombre} <br> con correo {$Correo} : {$Mensaje}";
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
} catch (Exception $e) {
    echo  $e;
}
