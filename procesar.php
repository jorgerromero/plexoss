<?php
// Habilitar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurar correo destinatario
$to = 'plexos.studios@gmail.com';
$subject = 'Nuevo Mensaje desde el Formulario Web';

// Obtener datos del formulario
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$interests = filter_input(INPUT_POST, 'interests', FILTER_SANITIZE_STRING);
$budget = filter_input(INPUT_POST, 'budget', FILTER_SANITIZE_STRING);
$timeline = filter_input(INPUT_POST, 'timeline', FILTER_SANITIZE_STRING);
$custom_budget = filter_input(INPUT_POST, 'custom_budget', FILTER_SANITIZE_STRING);
$custom_timeline = filter_input(INPUT_POST, 'custom_timeline', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

// Usar valores personalizados si se proporcionaron
$final_budget = ($budget === 'custom' && $custom_budget) ? $custom_budget : $budget;
$final_timeline = ($timeline === 'custom' && $custom_timeline) ? $custom_timeline : $timeline;

// Construir el contenido del correo
$email_content = "Nuevo mensaje de contacto:\n\n";
$email_content .= "Nombre: $name\n";
$email_content .= "Empresa: $company\n";
$email_content .= "Email: $email\n";
$email_content .= "Teléfono: $phone\n";
$email_content .= "Interés principal: $interests\n";
$email_content .= "Presupuesto: $final_budget\n";
$email_content .= "Plazo de entrega: $final_timeline\n\n";
$email_content .= "Mensaje:\n$message\n";

// Configurar cabeceras del correo
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Enviar correo
$mail_sent = mail($to, $subject, $email_content, $headers);

// Verificar si el correo se envió correctamente
if ($mail_sent) {
    // Redirigir a la página de agradecimiento
    header('Location: gracias.html');
    exit;
} else {
    // Si hay un error, redirigir a la página de error
    header('Location: error.html');
    exit;
}
