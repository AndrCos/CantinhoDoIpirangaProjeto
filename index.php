<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurante Topzera</title>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet" />
</head>

<body>

    <?php
    // Definição do array de itens do cardápio
    // Você pode adicionar mais itens aqui, ou modificar os existentes.
    // Lembre-se de que o 'id' é apenas um identificador, não precisa ser sequencial.
    $menuItems = [
        [
            'id' => 1,
            'nome' => 'Hambúrguer Artesanal',
            'descricao' => 'Pão brioche, carne suculenta e queijo derretido.',
            'preco' => 'R$ 35,00',
            'imagem' => 'https://source.unsplash.com/400x300/?burger' // Imagens de exemplo Unsplash
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
                <a class="navbar-brand" href="#">Restaurante Topzera</a>
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
                            <a class="nav-link" href="https://www.instagram.com/seuinstagram" target="_blank">Instagram</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#menu">Cardápio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contato">Contato</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <video autoplay muted loop playsinline>
            <source src="https://www.w3schools.com/howto/rain.mp4" type="video/mp4" />
        </video>
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

    <section id="contato" class="container py-5">
        <h2 class="text-center mb-4">Entre em Contato</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form action="contato.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensagem" class="form-label">Mensagem</label>
                        <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Enviar Mensagem</button>
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
                <a href="#" class="text-white mx-2"><span>📷</span></a>
                <a href="#" class="text-white mx-2"><span>📘</span></a>
                <a href="#" class="text-white mx-2"><span>📞</span></a>
            </div>
            <iframe src="https://maps.google.com/maps?q=restaurante%20em%20s%C3%A3o%20paulo&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
            <p class="mt-3 mb-0">© 2025 Restaurante Topzera</p>
        </div>
    </footer>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>