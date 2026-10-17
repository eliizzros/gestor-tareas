<?php

require __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$email = \Config\Services::email();

$email->initialize([
    'protocol'    => 'smtp',
    'SMTPHost'    => 'smtp.gmail.com',
    'SMTPUser'    => 'svelasquezr8@miumg.edu.gt',
    'SMTPPass'    => 'bvyzmklisujyxwzd',
    'SMTPPort'    => 587,
    'SMTPCrypto'  => 'tls',
    'SMTPTimeout' => 15,
    'mailType'    => 'html',
    'charset'     => 'UTF-8',
    'CRLF'        => "\r\n",
    'newline'     => "\r\n",
    'DSN'         => true
]);

$email->setFrom('svelasquezr8@miumg.edu.gt', 'Sandra');
$email->setTo('wuicholanguila12@gmail.com');
$email->setSubject('Prueba Directa de Correo - Sandra');
$email->setMessage('<h1>Hola</h1><p>este es el boton para validar su cuenta</p>');

echo "<h2>Iniciando prueba de envío...</h2>";

if ($email->send()) {
    echo "<h3 style='color:green;'>¡CORREO ENVIADO EXITOSAMENTE! Revisa tu bandeja.</h3>";
} else {
    echo "<h3 style='color:red;'>FALLÓ EL ENVÍO. Detalle técnico del error:</h3>";
    echo "<pre>" . print_r($email->printDebugger(['headers', 'subject', 'body']), true) . "</pre>";
}
