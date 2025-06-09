<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cantinho do Ipiranga</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet" />
</head>

<body>

    <?php
    // Definição do array de itens do cardápio
    $menuItems = [
        [
            'id' => 1,
            'nome' => 'Hambúrguer Artesanal',
            'descricao' => 'Pão brioche, carne suculenta e queijo derretido.',
            'preco' => 'R$ 35,00',
            'imagem' => 'https://source.unsplash.com/400x300/?burger'
        ],
        [
            'id' => 2,
            'nome' => 'Pizza de Calabresa',
            'descricao' => 'Molho especial, queijo mussarela e calabresa defumada.',
            'preco' => 'R$ 48,00',
            'imagem' => 'https://source.unsplash.com/400x300/?pizza'
        ],
        [
            'id' => 3,
            'nome' => 'Macarrão à Bolonhesa',
            'descricao' => 'Receita italiana autêntica com molho caseiro.',
            'preco' => 'R$ 42,50',
            'imagem' => 'https://source.unsplash.com/400x300/?pasta'
        ],
        [
            'id' => 4,
            'nome' => 'Salmão Grelhado',
            'descricao' => 'Filé de salmão fresco com molho de maracujá e purê de batatas.',
            'preco' => 'R$ 65,00',
            'imagem' => 'https://source.unsplash.com/400x300/?salmon-dish'
        ],
        [
            'id' => 5,
            'nome' => 'Salada Caesar',
            'descricao' => 'Alface americana, croutons, parmesão e molho Caesar.',
            'preco' => 'R$ 28,00',
            'imagem' => 'https://source.unsplash.com/400x300/?caesar-salad'
        ],
        [
            'id' => 6,
            'nome' => 'Brownie com Sorvete',
            'descricao' => 'Delicioso brownie de chocolate com uma bola de sorvete de creme.',
            'preco' => 'R$ 18,00',
            'imagem' => 'https://source.unsplash.com/400x300/?brownie-ice-cream'
        ]
    ];
    ?>

    <header class="hero">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Cantinho do Ipiranga</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sobre-nos">Sobre Nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.instagram.com/cantinhodoipirangaoficial/" target="_blank">Instagram</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#menu">Cardápio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reserva.php">Reserva</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="hero-content">
            <h1>Venha viver uma experiência gastronômica</h1>
            <p>O melhor da culinária com sabor e elegância</p>
            <a href="#menu" class="btn btn-primary btn-lg">Ver Cardápio</a>
        </div>
    </header>

    <section id="menu" class="container py-5">
        <h2 class="text-center mb-4">Nosso Cardápio</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($menuItems as $item) : ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= $item['imagem'] ?>" class="card-img-top" alt="<?= $item['nome'] ?>" />
                        <div class="card-body">
                            <h3 class="card-title"><?= $item['nome'] ?></h3>
                            <p class="card-text"><?= $item['descricao'] ?></p>
                            <p class="card-text"><strong><?= $item['preco'] ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
</body>

</html>