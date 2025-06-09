<?php
// Incluir os arquivos do PHPMailer
// Certifique-se de que o caminho 'phpmailer/' está correto
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; // Adicionar para usar SMTP

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Inicializa as variáveis de mensagem
$message_success = '';
$message_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars(strip_tags(trim($_POST["nome"])));
    $email = htmlspecialchars(strip_tags(trim($_POST["email"])));
    
    // ATENÇÃO: Os campos CPF e Telefone serão enviados sem as máscaras.
    // Para validar e salvar em banco de dados, é bom remover as máscaras novamente.
    $cpf = preg_replace('/[^0-9]/', '', htmlspecialchars(strip_tags(trim($_POST["cpf"])))); // Limpa CPF, deixa só números
    $telefone = preg_replace('/[^0-9]/', '', htmlspecialchars(strip_tags(trim($_POST["telefone"])))); // Limpa Telefone, deixa só números

    $data_reserva = htmlspecialchars(strip_tags(trim($_POST["data"])));
    $hora_reserva = htmlspecialchars(strip_tags(trim($_POST["hora"])));
    $num_pessoas = htmlspecialchars(strip_tags(trim($_POST["pessoas"])));
    $mensagem_adicional = htmlspecialchars(strip_tags(trim($_POST["mensagem_adicional"])));

    // Validação dos dados obrigatórios
    if (empty($nome) || empty($email) || empty($telefone) || empty($data_reserva) || empty($hora_reserva) || empty($num_pessoas)) {
        $message_error = "Por favor, preencha todos os campos obrigatórios do formulário (Nome, E-mail, Telefone, Data, Hora, Número de Pessoas).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message_error = "O formato do e-mail é inválido. Por favor, corrija.";
    } elseif (strlen($telefone) < 10 || strlen($telefone) > 11) { // Validação simples de telefone (DDD + 8 ou 9 dígitos)
        $message_error = "O telefone deve ter 10 ou 11 dígitos (incluindo DDD).";
    }
    // Adicione mais validações aqui, como para CPF se for obrigatório e você quiser validar formato real.
    
    else {
        // --- Configuração e Envio de E-mail com PHPMailer ---
        $mail = new PHPMailer(true);

        try {
            // Configurações do Servidor SMTP (utilizando Gmail como exemplo)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'and.cos92@gmail.com'; // **SEU EMAIL GMAIL REAL (o que você usa para enviar)**
            $mail->Password   = 'ipwl afbl mynx aovd'; // **SUA SENHA DE APP DO GOOGLE (NÃO A SENHA NORMAL DO GMAIL!)**
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // Destinatários do E-mail
            $mail->setFrom('and.cos92@gmail.com', 'Cantinho do Ipiranga - Site');
            $mail->addAddress('and.cos91@gmail.com'); // Para quem o e-mail será enviado
            $mail->addReplyTo($email, $nome);

            // Conteúdo do E-mail
            $mail->isHTML(false); // Definir que o formato do e-mail é texto plano
            $mail->Subject = "Nova Reserva no Cantinho do Ipiranga de: " . $nome;
            $body_email = "Nome: " . $nome . "\n"
                             . "Email: " . $email . "\n";
            
            // Reformatar CPF e Telefone para exibição no e-mail, se preferir o formato mascarado
            $cpf_formatted = '';
            if (strlen($cpf) == 11) {
                $cpf_formatted = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
            } else {
                $cpf_formatted = $cpf; // Caso não tenha 11 dígitos (não obrigatório, pode vir incompleto se não validado)
            }

            $telefone_formatted = '';
            if (strlen($telefone) == 11) { // Celular (com 9º dígito)
                $telefone_formatted = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
            } elseif (strlen($telefone) == 10) { // Telefone fixo ou celular antigo (sem 9º dígito)
                $telefone_formatted = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
            } else {
                $telefone_formatted = $telefone; // Caso o telefone não tenha 10 ou 11 dígitos válidos
            }

            if (!empty($cpf_formatted)) {
                $body_email .= "CPF: " . $cpf_formatted . "\n";
            }
            
            $body_email .= "Telefone: " . ($telefone_formatted ?: "Não informado") . "\n" // Usa o formatado
                             . "Data da Reserva: " . $data_reserva . "\n"
                             . "Hora da Reserva: " . $hora_reserva . "\n"
                             . "Número de Pessoas: " . $num_pessoas . "\n\n";
            
            if (!empty($mensagem_adicional)) {
                $body_email .= "Mensagem Adicional:\n" . $mensagem_adicional;
            } else {
                $body_email .= "Nenhuma mensagem adicional.";
            }

            $mail->Body    = $body_email;

            // Enviar o E-mail
            $mail->send();
            $message_success = "Obrigado! Sua reserva foi enviada com sucesso. Em breve entraremos em contato.";

        } catch (Exception $e) {
            $message_error = "Ocorreu um erro ao enviar a reserva. Por favor, tente novamente mais tarde.";
            // Para fins de depuração (debug), você pode descomentar a linha abaixo para ver o erro detalhado do PHPMailer
            // $message_error .= " Erro do PHPMailer: {$mail->ErrorInfo}";
        }
    }
}

// Implementação do padrão Post/Redirect/Get (PRG)
if (!empty($message_success) && $_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: reserva.php?status=success");
    exit();
}

// Verifica se há status de sucesso na URL (após o redirecionamento PRG)
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $message_success = "Obrigado! Sua reserva foi enviada com sucesso. Em breve entraremos em contato.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cantinho do Ipiranga - Reserva</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet" />
</head>

<body>

    <header class="hero-contact">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Cantinho do Ipiranga</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#sobre-nos">Sobre Nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.instagram.com/cantinhodoipirangaoficial/" target="_blank">Instagram</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#menu">Cardápio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="reserva.php">Reserva</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="hero-content">
            <h1>Faça sua Reserva</h1>
            <p>Preencha o formulário para garantir sua mesa!</p>
        </div>
    </header>

    <section id="form-reserva" class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <?php if (!empty($message_success)) : ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?= $message_success ?>
                    </div>
                <?php elseif (!empty($message_error)) : ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= $message_error ?>
                    </div>
                <?php endif; ?>

                <form action="reserva.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF (opcional)</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex: 123.456.789-00">
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone (com DDD)</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required>
                    </div>
                    <div class="mb-3">
                        <label for="data" class="form-label">Data da Reserva</label>
                        <input type="date" class="form-control" id="data" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora" class="form-label">Hora da Reserva</label>
                        <input type="time" class="form-control" id="hora" name="hora" required>
                    </div>
                    <div class="mb-3">
                        <label for="pessoas" class="form-label">Número de Pessoas</label>
                        <input type="number" class="form-control" id="pessoas" name="pessoas" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensagem_adicional" class="form-label">Mensagem Adicional (opcional)</label>
                        <textarea class="form-control" id="mensagem_adicional" name="mensagem_adicional" rows="3" placeholder="Ex: Preferência por mesa na janela, restrições alimentares, etc."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Confirmar Reserva</button>
                </form>
            </div>
        </div>
    </section>

    <div class="ifood-float">
        <a href="https://www.ifood.com.br" target="_blank">
            <img src="imagens/iFood-Logo-site.png" alt="iFood" />
        </a>
    </div>

    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>Siga-nos nas redes sociais</p>
            <div class="social-icons mb-3">
                <a href="https://www.instagram.com/cantinhodoipirangaoficial/" target="_blank" class="text-white mx-2">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="text-white mx-2">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="tel:+55XXYYYYZZZZZ" class="text-white mx-2">
                    <i class="fa-solid fa-phone"></i>
                </a>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8750.714430228954!2d-46.61933132388312!3d-23.588314362584498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5bdc9713efa7%3A0x2cebae0eeb7ea658!2sCantinho%20do%20Ipiranga!5e1!3m2!1spt-BR!2sbr!4v1749479400307!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <p>R. da Imprensa, 310 - Ipiranga, São Paulo - SP, 04265-000</p>
                <p>(11)3297-8305</p>
            <p class="mt-3 mb-0">© 2025 Cantinho do Ipiranga</p>
        </div>
    </footer>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            const telefoneInput = document.getElementById('telefone');

            // Função de máscara para CPF/CNPJ ou telefone
            function formatInput(input, maskPattern) {
                let value = input.value.replace(/\D/g, ''); // remove tudo que não for dígito
                let formattedValue = '';
                let maskIndex = 0;

                if (!value) { // limpa o campo se o valor for vazio
                    input.value = '';
                    return;
                }

                for (let i = 0; i < value.length; i++) {
                    if (maskPattern[maskIndex] === '9') { 
                        formattedValue += value[i];
                        maskIndex++;
                    } else if (maskPattern[maskIndex] && maskPattern[maskIndex] !== '9') { 
                        formattedValue += maskPattern[maskIndex];
                        maskIndex++;
                        i--; 
                    } else {
                        break; 
                    }
                }
                input.value = formattedValue;
            }

            // Máscara para CPF
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); 
                let mask = '';
                if (value.length <= 11) { // CPF
                    mask = '999.999.999-99';
                }
                // adicione else if para CNPJ se precisar futuramente
                formatInput(e.target, mask);
            });

            // Máscara para elefone 
            telefoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); 
                let mask = '';
                if (value.length <= 10) { // formato (XX) XXXX-XXXX 
                    mask = '(99) 9999-9999';
                } else if (value.length <= 11) { // formato (XX) XXXXX-XXXX (celular com 9º dígito)
                    mask = '(99) 99999-9999';
                }
                formatInput(e.target, mask);
            });

            cpfInput.setAttribute('pattern', '[0-9]{3}\\.?[0-9]{3}\\.?[0-9]{3}\\-?[0-9]{2}');
            cpfInput.setAttribute('maxlength', '14'); // ex 123.456.789-00

            telefoneInput.setAttribute('pattern', '\\(?[0-9]{2}\\)?\\s?[0-9]{4,5}\\-?[0-9]{4}');
            telefoneInput.setAttribute('maxlength', '15'); // ex (11) 99999-9999
        });
    </script>

</body>

</html>