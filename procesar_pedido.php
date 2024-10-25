<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Reemplaza con tu clave secreta de reCAPTCHA
    $secretKey = "TU_SECRET_KEY_AQUI";
    $captcha = $_POST['g-recaptcha-response'];
    $ip = $_SERVER['REMOTE_ADDR'];

    // Validación de reCAPTCHA
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $captcha . '&remoteip=' . $ip;
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {
        // Procesar el formulario
        $codigo = $_POST['codigo'];
        $telefono = $_POST['telefono'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $direccion = $_POST['direccion'];
        $poblacion = $_POST['poblacion'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $consentimiento = isset($_POST['consentimiento']) ? 'Sí' : 'No';

        $to = "miprueba@miprueba.es";
        $subject = "Nuevo Pedido de Combustible";
        $message = "Detalles del Pedido:\n\n"
                 . "Código: $codigo\n"
                 . "Teléfono: $telefono\n"
                 . "Nombre: $nombre\n"
                 . "Email: $email\n"
                 . "Dirección: $direccion\n"
                 . "Población: $poblacion\n"
                 . "Producto: $producto\n"
                 . "Cantidad: $cantidad litros\n"
                 . "Consentimiento para tratamiento de datos: $consentimiento";

        $headers = "From: $email";

        // Enviar correo
        if (mail($to, $subject, $message, $headers)) {
            echo "Pedido enviado exitosamente.";
        } else {
            echo "Hubo un problema al enviar el pedido. Intenta nuevamente.";
        }
    } else {
        echo "Validación de CAPTCHA fallida. Por favor, inténtelo de nuevo.";
    }
} else {
    echo "Acceso no permitido.";
}
?>