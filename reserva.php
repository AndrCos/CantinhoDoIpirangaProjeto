<?php
// Incluir os arquivos do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Variáveis para mensagens de feedback
$message_success = '';
$message_error = '';

// Bloco de Processamento do Formulário (POST Request) 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e sanitização dos dados do formulário
    $nome = htmlspecialchars(strip_tags(trim($_POST["nome"])));
    $email = htmlspecialchars(strip_tags(trim($_POST["email"])));

    // Limpa CPF e telefone, deixando apenas números
    $cpf = preg_replace('/[^0-9]/', '', htmlspecialchars(strip_tags(trim($_POST["cpf"]))));
    $telefone = preg_replace('/[^0-9]/', '', htmlspecialchars(strip_tags(trim($_POST["telefone"]))));

    $data_reserva_str = htmlspecialchars(strip_tags(trim($_POST["data"])));
    $hora_reserva_str = htmlspecialchars(strip_tags(trim($_POST["hora"])));
    $num_pessoas = htmlspecialchars(strip_tags(trim($_POST["pessoas"])));
    $mensagem_adicional = htmlspecialchars(strip_tags(trim($_POST["mensagem_adicional"])));

    // Validação dos dados obrigatórios
    if (empty($nome) || empty($email) || empty($telefone) || empty($data_reserva_str) || empty($hora_reserva_str) || empty($num_pessoas)) {
        $message_error = "Por favor, preencha todos os campos obrigatórios do formulário (Nome, E-mail, Telefone, Data, Hora, Número de Pessoas).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message_error = "O formato do e-mail é inválido. Por favor, corrija.";
    } elseif (strlen($telefone) < 10 || strlen($telefone) > 11) {
        $message_error = "O telefone deve ter 10 ou 11 dígitos (incluindo DDD).";
    } else {
        // Validação da data e hora da reserva
        $data_hora_reserva_str = $data_reserva_str . ' ' . $hora_reserva_str;
        $data_hora_reserva = DateTime::createFromFormat('Y-m-d H:i', $data_hora_reserva_str);
        $agora = new DateTime();

        if (!$data_hora_reserva || $data_hora_reserva < $agora) {
            $message_error = "A data e/ou hora da reserva não pode ser no passado. Por favor, selecione uma data e hora futura válida.";
        } else {
            // Configuração e envio de email com PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configurações do Servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'and.cos92@gmail.com';
                $mail->Password   = 'ipwl afbl mynx aovd'; // use uma senha de aplicativo para segurança
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                // Destinatários do E-mail
                $mail->setFrom('and.cos92@gmail.com', 'Cantinho do Ipiranga - Site');
                $mail->addAddress('and.cos91@gmail.com'); // para quem o e-mail será enviado
                $mail->addReplyTo($email, $nome);

                // Conteúdo do E-mail
                $mail->isHTML(false); // define o formato do e-mail como texto puro
                $mail->Subject = "Nova Reserva no Cantinho do Ipiranga de: " . $nome;

                // formata CPF para o e-mail
                $cpf_formatted = '';
                if (strlen($cpf) == 11) {
                    $cpf_formatted = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
                } else {
                    $cpf_formatted = $cpf; 
                }

                // formata telefone para o e-mail
                $telefone_formatted = '';
                if (strlen($telefone) == 11) { // celular 
                    $telefone_formatted = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
                } elseif (strlen($telefone) == 10) { // telefone fixo ou celular antigo
                    $telefone_formatted = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
                } else {
                    $telefone_formatted = $telefone; 
                }

                // corpo do e-mail
                $body_email = "Detalhes da Reserva:\n\n"
                                . "Nome: " . $nome . "\n"
                                . "Email: " . $email . "\n";

                if (!empty($cpf_formatted)) {
                    $body_email .= "CPF: " . $cpf_formatted . "\n";
                }

                $body_email .= "Telefone: " . $telefone_formatted . "\n"
                                . "Data da Reserva: " . date('d/m/Y', strtotime($data_reserva_str)) . "\n" // formata data para o e-mail
                                . "Hora da Reserva: " . $hora_reserva_str . "\n"
                                . "Número de Pessoas: " . $num_pessoas . "\n\n";

                if (!empty($mensagem_adicional)) {
                    $body_email .= "Mensagem Adicional:\n" . $mensagem_adicional;
                } else {
                    $body_email .= "Nenhuma mensagem adicional.";
                }

                $mail->Body = $body_email;

                $mail->send();
                $message_success = "Obrigado! Sua reserva foi enviada com sucesso. Em breve entraremos em contato.";

            } catch (Exception $e) {
                $message_error = "Ocorreu um erro ao enviar a reserva. Por favor, tente novamente mais tarde. Erro: {$mail->ErrorInfo}";
            }
        }
    }
}

// implementação do padrão Post/Redirect/Get para evitar reenvio de formulário
if (!empty($message_success) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // redireciona para a mesma página com um parâmetro de sucesso
    header("Location: reserva.php?status=success");
    exit();
}

// verifica se há status de sucesso na URL 
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
                <a class="navbar-brand d-lg-none" href="index.php">
                    <img src="imagens/IpirangaLogo.png" alt="Cantinho do Ipiranga Logo" class="navbar-logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#sobre-nos">Sobre Nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#menu">Cardápio</a>
                        </li>
                    </ul>

                    <a class="navbar-brand d-none d-lg-block mx-auto" href="index.php">
                        <img src="imagens/IpirangaLogo.png" alt="Cantinho do Ipiranga Logo" class="navbar-logo-centered">
                    </a>

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.ifood.com.br/delivery/sao-paulo-sp/cantinho-do-ipiranga-vila-sao-jose-ipiranga/a7039bdc-b685-4b1a-86a8-cf2f926dd49f?utm_medium=share&fbclid=PAZXh0bgNhZW0CMTEAAae5ox62cJaiAVWLLPoua0yLLaAuo8qnJP9EufgvkSnFfvrefOerAjl36dJeYg_aem_doV1joC9SgTClAa35_YmQw" target="_blank">iFood</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.instagram.com/cantinhodoipirangaoficial/" target="_blank">Instagram</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-reserva active" aria-current="page" href="reserva.php">Reserva</a>
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
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>Siga-nos nas redes sociais</p>
            <div class="social-icons mb-3">
                <a href="https://www.instagram.com/cantinhodoipirangaoficial/" target="_blank" class="text-white mx-2">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/cantinhodoipiranga" target="_blank" class="text-white mx-2">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="tel:+55XXYYYYZZZZZ" class="text-white mx-2">
                    <i class="fa-solid fa-phone"></i>
                </a>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4375.357215114477!2d-46.61933132388312!3d-23.588314362584498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5bdc9713efa7%3A0x2cebae0eeb7ea658!2sCantinho%20do%20Ipiranga!5e1!3m2!1spt-BR!2sbr!4v1749482284095!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
            const dataReservaInput = document.getElementById('data');
            const horaReservaInput = document.getElementById('hora');

            // função genérica de máscara
            function applyMask(inputElement, maskPattern) {
                inputElement.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // remove tudo que não for dígito
                    let formattedValue = '';
                    let maskIndex = 0;
                    let valueIndex = 0;

                    if (!value) {
                        e.target.value = '';
                        return;
                    }

                    while (maskIndex < maskPattern.length && valueIndex < value.length) {
                        if (maskPattern[maskIndex] === '9') {
                            formattedValue += value[valueIndex];
                            valueIndex++;
                        } else {
                            formattedValue += maskPattern[maskIndex];
                        }
                        maskIndex++;
                    }
                    e.target.value = formattedValue;
                });
            }

            // aplica máscara para CPF
            if (cpfInput) {
                applyMask(cpfInput, '999.999.999-99');
            }

            // aplica máscara para Telefone 
            if (telefoneInput) {
                telefoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    let mask = '';
                    if (value.length <= 10) { // Formato (XX) XXXX-XXXX
                        mask = '(99) 9999-9999';
                    } else { // Formato (XX) XXXXX-XXXX
                        mask = '(99) 99999-9999';
                    }
                    let formattedValue = '';
                    let maskIndex = 0;
                    let valueIndex = 0;

                    if (!value) {
                        e.target.value = '';
                        return;
                    }

                    while (maskIndex < mask.length && valueIndex < value.length) {
                        if (mask[maskIndex] === '9') {
                            formattedValue += value[valueIndex];
                            valueIndex++;
                        } else {
                            formattedValue += mask[maskIndex];
                        }
                        maskIndex++;
                    }
                    e.target.value = formattedValue;
                });
            }

            // validação de data e hora futuras
            if (dataReservaInput && horaReservaInput) {
                const validateDateTime = () => {
                    const selectedDate = dataReservaInput.value;
                    const selectedTime = horaReservaInput.value;

                    if (!selectedDate || !selectedTime) {
                        dataReservaInput.setCustomValidity(''); // reseta a validação se campos vazios
                        horaReservaInput.setCustomValidity('');
                        return;
                    }

                    const selectedDateTime = new Date(`${selectedDate}T${selectedTime}:00`);
                    const now = new Date();

                    if (selectedDateTime < now) {
                        dataReservaInput.setCustomValidity('A data e hora da reserva não podem ser no passado.');
                        horaReservaInput.setCustomValidity('A data e hora da reserva não podem ser no passado.');
                    } else {
                        dataReservaInput.setCustomValidity('');
                        horaReservaInput.setCustomValidity('');
                    }
                };

                dataReservaInput.addEventListener('change', validateDateTime);
                horaReservaInput.addEventListener('change', validateDateTime);

                // define a data mínima para o input de data como hoje
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const yyyy = today.getFullYear();
                const minDate = `${yyyy}-${mm}-${dd}`;
                dataReservaInput.setAttribute('min', minDate);
            }
        });
    </script>
</body>

</html>