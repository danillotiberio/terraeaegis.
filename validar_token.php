<?php
session_start();

/**
 * PROTOCOLO MASTER 2.0 - VALIDAÇÃO DE ACESSO TERRAE AEGIS
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_cliente = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $token_digitado = strtoupper(trim($_POST['token']));

    // Lógica matemática do Token (mesma que deve ser enviada no e-mail)
    $salt = "TERRAE_AEGIS_2024"; 
    $token_correto = strtoupper(substr(md5($email_cliente . $salt), 0, 6));

    if ($token_digitado === $token_correto) {
        // Cria a credencial de acesso exclusiva para esta sessão
        $_SESSION['autenticado_holding'] = true;
        $_SESSION['cliente_email'] = $email_cliente;
        
        // Redireciona para o diretório de enquadramento
        header("Location: /enquadramento/index.html");
        exit();
    } else {
        // Se o token falhar, volta para a index com alerta
        header("Location: /index.html?status=token_invalido");
        exit();
    }
} else {
    // Bloqueia acesso direto ao arquivo via URL
    header("Location: /index.html");
    exit();
}
?>
