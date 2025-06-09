<?php
// Incluir os arquivos do PHPMailer
// Certifique-se de que o caminho 'phpmailer/' está correto
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; // Adicionar para usar SMTP

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars(strip_tags(trim($_POST["nome"])));
    $email = htmlspecialchars(strip_tags(trim($_POST["email"])));
    $mensagem = htmlspecialchars(strip_tags(trim($_POST["mensagem"])));

    // Validação básica dos dados
    if (empty($nome) || empty($email) || empty($mensagem)) {
        echo "<p style='color: red; text-align: center;'>Por favor, preencha todos os campos do formulário.</p>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color: red; text-align: center;'>O formato do e-mail é inválido. Por favor, corrija.</p>";
        exit;
    }

    // --- Configuração e Envio de E-mail com PHPMailer ---
    $mail = new PHPMailer(true); // 'true' permite que as exceções sejam lançadas para tratamento de erros

    try {
        // Configurações do Servidor SMTP (utilizando Gmail como exemplo)
        $mail->isSMTP();                                            // Usar SMTP para enviar
        $mail->Host       = 'smtp.gmail.com';                       // Servidor SMTP do Gmail
        $mail->SMTPAuth   = true;                                   // Habilitar autenticação SMTP
        $mail->Username   = 'and.cos92@gmail.com';         // **SEU EMAIL GMAIL REAL (o que você usa para enviar)**
        $mail->Password   = 'ipwl afbl mynx aovd';            // **SUA SENHA DE APP DO GOOGLE (NÃO A SENHA NORMAL DO GMAIL!)**
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Usar STARTTLS para segurança (recomendado para porta 587)
                                                                    // Ou PHPMailer::ENCRYPTION_SMTPS para porta 465 (se o host suportar)
        $mail->Port       = 587;                                    // Porta TCP para conectar (587 para STARTTLS, 465 para SMTPS)
        $mail->CharSet    = 'UTF-8';                                // Codificação para caracteres especiais (acentos, ç, etc.)

        // Destinatários do E-mail
        // Quem envia o e-mail (geralmente o mesmo email do Username acima)
        $mail->setFrom('and.cos92@gmail.com', 'Cantinho do Ipiranga - Site');
        // Para quem o e-mail será enviado (seu email real, onde você quer receber as mensagens)
        $mail->addAddress('and.cos91@gmail.com');
        // Adiciona um "Responder Para" para que, ao responder o e-mail, ele vá para o e-mail do cliente
        $mail->addReplyTo($email, $nome);

        // Conteúdo do E-mail
        $mail->isHTML(false); // Definir que o formato do e-mail é texto plano (false) ou HTML (true)
        $mail->Subject = "Nova Mensagem do Restaurante Topzera de: " . $nome;
        $mail->Body    = "Nome: " . $nome . "\n"
                       . "Email: " . $email . "\n\n"
                       . "Mensagem:\n" . $mensagem;
        // Se isHTML for true, você pode adicionar um AltBody para clientes que não suportam HTML
        // $mail->AltBody = 'Este é o corpo da mensagem em texto puro para clientes de e-mail que não suportam HTML';

        // Enviar o E-mail
        $mail->send();
        echo "<p style='color: green; text-align: center;'>Obrigado! Sua mensagem foi enviada com sucesso para o e-mail.</p>";

    } catch (Exception $e) {
        echo "<p style='color: red; text-align: center;'>Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente mais tarde.</p>";
        // Para fins de depuração (debug), você pode descomentar a linha abaixo para ver o erro detalhado do PHPMailer
        // echo "<p style='color: red; text-align: center;'>Erro do PHPMailer: {$mail->ErrorInfo}</p>";
    }
    // --- Fim do Envio de E-mail com PHPMailer ---

} else {
    // Se a requisição não for POST, redireciona para a página principal
    header("Location: index.php");
    exit;
}
?>