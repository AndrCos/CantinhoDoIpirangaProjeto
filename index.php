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
// Definição do array de itens do cardápio (mantido inalterado)
$menuItems = [
    //  Pratos do Dia 
    [
        'id' => 1,
        'categoria' => 'Pratos do Dia',
        'nome' => 'Segunda-feira: Virado à Paulista',
        'descricao' => '1 pessoa', 
        'preco' => 'R$ 35,00',
        'imagem' => 'imagens/virado-a-paulista.jpg'
    ],
    [
        'id' => 2,
        'categoria' => 'Pratos do Dia',
        'nome' => 'Terça-feira: Medalhão ao molho madeira com champignon',
        'descricao' => '1 pessoa',
        'preco' => 'R$ 48,00',
        'imagem' => 'imagens/medalhao.jpg'
    ],
    [
        'id' => 3,
        'categoria' => 'Pratos do Dia',
        'nome' => 'Quarta-feira: Feijoada',
        'descricao' => '(1 pessoa / 2 pessoas)',
        'preco' => 'R$ 44,00 / R$ 89,00',
        'imagem' => 'imagens/Feijoada.jpg'
    ],
    [
        'id' => 4,
        'categoria' => 'Pratos do Dia',
        'nome' => 'Quinta-feira: Talharim ao molho branco com filé mignon',
        'descricao' => '',
        'preco' => 'R$ 46,00',
        'imagem' => 'imagens/talharim-ao-molho.jpg'
    ],
    [
        'id' => 5,
        'categoria' => 'Pratos do Dia',
        'nome' => 'Sexta-feira: Salmão da Casa',
        'descricao' => 'Acompanha arroz, purê',
        'preco' => 'R$ 56,00',
        'imagem' => 'imagens/salmao-casa.jpg'
    ],
    [
        'id' => 6,
        'categoria' => 'Pratos do Dia',
        'nome' => 'Sábado: Feijoada',
        'descricao' => '(1 pessoa / 2 pessoas)',
        'preco' => 'R$ 44,00 / R$ 84,00',
        'imagem' => 'imagens/Feijoada.jpg'
    ],

    //  Salmão 
    [
        'id' => 7,
        'categoria' => 'Salmão',
        'nome' => 'Grelhado com batata sauté',
        'descricao' => '(Arroz e feijão)',
        'preco' => 'R$ 51,00',
        'imagem' => 'imagens/Salmao-grelhado-com-batatas-2.png'
    ],
    [
        'id' => 8,
        'categoria' => 'Salmão',
        'nome' => 'Grelhado com legumes',
        'descricao' => '(Arroz e feijão)',
        'preco' => 'R$ 51,00',
        'imagem' => 'imagens/salmao-grelhado-legumes.jpg'
    ],

    //  Carnes - Contra Filé 
    [
        'id' => 9,
        'categoria' => 'Carnes',
        'subcategoria' => 'Contra Filé',
        'nome' => 'Com legumes',
        'descricao' => '(Arroz e feijão)',
        'preco' => 'R$ 34,00',
        'imagem' => 'imagens/contra-file-legumes.jpeg'
    ],
    [
        'id' => 10,
        'categoria' => 'Carnes',
        'subcategoria' => 'Contra Filé',
        'nome' => 'À brasileira',
        'descricao' => '(Arroz, feijão, fritas, vinagrete e farofa)',
        'preco' => 'R$ 35,00',
        'imagem' => 'imagens/contra-file-brasileira.jpg'
    ],

    //  Carnes - Filé de Frango 
    [
        'id' => 11,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé de Frango',
        'nome' => 'Com creme de milho',
        'descricao' => '(Arroz e fritas)',
        'preco' => 'R$ 31,00',
        'imagem' => 'imagens/frango-milho.jpg'
    ],
    [
        'id' => 12,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé de Frango',
        'nome' => 'Grelhado com legumes',
        'descricao' => '(Arroz e feijão)',
        'preco' => 'R$ 31,00',
        'imagem' => 'imagens/frango-grelhado-legumes.png'
    ],
    [
        'id' => 13,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé de Frango',
        'nome' => 'Grelhado com fritas',
        'descricao' => '(Arroz e feijão)',
        'preco' => 'R$ 29,00',
        'imagem' => 'imagens/frango-fritas.jpg'
    ],
    [
        'id' => 14,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé de Frango',
        'nome' => 'À parmegiana',
        'descricao' => '(Arroz e fritas)',
        'preco' => 'R$ 39,00',
        'imagem' => 'imagens/file-parmegiana-fritas.jpg'
    ],

    //  Carnes - Filé Mignon 
    [
        'id' => 15,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé Mignon',
        'nome' => 'À brasileira',
        'descricao' => '(Arroz, feijão, fritas, vinagrete e farofa)',
        'preco' => 'R$ 51,00',
        'imagem' => 'imagens/filemignon-barasileira.jpg'
    ],
    [
        'id' => 16,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé Mignon',
        'nome' => 'À parmegiana',
        'descricao' => '(Arroz e fritas)',
        'preco' => 'R$ 54,00',
        'imagem' => 'imagens/file-a-parmegiana.jpg'
    ],
    [
        'id' => 17,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé Mignon',
        'nome' => 'Com legumes',
        'descricao' => '(Arroz e feijão)',
        'preco' => 'R$ 53,00',
        'imagem' => 'imagens/filemignon-legumes.jpg'
    ],
    [
        'id' => 18,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé Mignon',
        'nome' => 'Com queijo Minas e molho barbecue',
        'descricao' => '(Arroz, provolone e milanesa)',
        'preco' => 'R$ 66,00',
        'imagem' => 'imagens/file-queijo.jpg'
    ],
    [
        'id' => 19,
        'categoria' => 'Carnes',
        'subcategoria' => 'Filé Mignon',
        'nome' => 'Medalhão ao molho gorgonzola e nozes',
        'descricao' => '(Arroz, provolone e milanesa)',
        'preco' => 'R$ 69,00',
        'imagem' => 'imagens/file-gorgonzola.jpg'
    ],

    // Carnes - Picanha 
    [
        'id' => 20,
        'categoria' => 'Carnes',
        'subcategoria' => 'Picanha',
        'nome' => 'À brasileira',
        'descricao' => '(Arroz, feijão, fritas, vinagrete e farofa)',
        'preco' => 'R$ 51,00',
        'imagem' => 'imagens/picanha-brasileira.jpg'
    ],
    [
        'id' => 21,
        'categoria' => 'Carnes',
        'subcategoria' => 'Picanha',
        'nome' => 'Com legumes',
        'descricao' => '(Arroz e feijão)',
        'preco' => 'R$ 53,00',
        'imagem' => 'imagens/picanha-legumes.jpg'
    ],

    //  Massas 
    [
        'id' => 22,
        'categoria' => 'Massas',
        'nome' => 'Talharim ao molho branco',
        'descricao' => '',
        'preco' => 'R$ 32,00',
        'imagem' => 'imagens/talharim-molho.png'
    ],
    [
        'id' => 23,
        'categoria' => 'Massas',
        'nome' => 'Talharim ao molho sugo',
        'descricao' => '',
        'preco' => 'R$ 32,00',
        'imagem' => 'imagens/talharim-ao-sugo.jpg'
    ],

    //  Especial da Casa 
    [
        'id' => 24,
        'categoria' => 'Especial da Casa',
        'nome' => 'Costelinha ao molho barbecue',
        'descricao' => '(Arroz e fritas)',
        'preco' => 'R$ 43,00',
        'imagem' => 'imagens/costelinha-frias-arroz.jpg'
    ]
];
?>

    <header class="hero">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="imagens/IpirangaLogo.png" alt="Cantinho do Ipiranga Logo" class="navbar-logo">
                </a>
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

        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="imagens/slide1.jpg" class="d-block w-100 hero-carousel-img" alt="Ambiente do Restaurante 1">
                </div>
                <div class="carousel-item">
                    <img src="imagens/slide2.jpeg" class="d-block w-100 hero-carousel-img" alt="Prato Especial">
                </div>
                <div class="carousel-item">
                    <img src="imagens/slide3.jpg" class="d-block w-100 hero-carousel-img" alt="Ambiente do Restaurante 2">
                </div>
                <div class="carousel-item">
                    <img src="imagens/slide4.jpg" class="d-block w-100 hero-carousel-img" alt="Outro Prato/Ambiente">
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="hero-content">
            <h1>É melhor ir conhecer o Ipiranga</h1>
            <p>O melhor da culinária com sabor e elegância</p>
            <a href="#menu" class="btn btn-primary btn-lg">Ver Cardápio</a>
        </div>
    </header>

    <section id="menu" class="container py-5">
        <h2 class="text-center mb-4">Nosso Cardápio</h2>

        <?php
        $categorizedItems = [];
        foreach ($menuItems as $item) {
            $categorizedItems[$item['categoria']][] = $item;
        }

        foreach ($categorizedItems as $categoryName => $items) :
            echo '<h3 class="mt-5 mb-3 menu-category-title">' . $categoryName . '</h3>';

            $subCategories = [];
            foreach ($items as $item) {
                $subCategoryKey = isset($item['subcategoria']) ? $item['subcategoria'] : 'default';
                $subCategories[$subCategoryKey][] = $item;
            }

            foreach ($subCategories as $subCategoryName => $subItems) :
                if ($subCategoryName !== 'default') {
                    echo '<h4 class="mt-3 mb-2 menu-subcategory-title">' . $subCategoryName . '</h4>';
                }
        ?>
                <div id="<?= strtolower(str_replace(' ', '-', $categoryName)) ?>-carousel<?= ($subCategoryName !== 'default' ? '-' . strtolower(str_replace(' ', '-', $subCategoryName)) : '') ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Loop para criar os slides do carrossel, com 2 cards por slide
                        for ($i = 0; $i < count($subItems); $i += 2) :
                            $isActive = ($i === 0) ? 'active' : ''; // Primeiro slide ativo
                        ?>
                            <div class="carousel-item <?= $isActive ?>">
                                <div class="row justify-content-center g-4">
                                    <?php
                                    $item1 = $subItems[$i];
                                    ?>
                                    <div class="col-12 col-md-6 d-flex justify-content-center">
                                        <div class="card h-100 w-100 carousel-card-item">
                                            <img src="<?= $item1['imagem'] ?>" class="card-img-top" alt="<?= $item1['nome'] ?>" />
                                            <div class="card-body">
                                                <h3 class="card-title"><?= $item1['nome'] ?></h3>
                                                <?php if (!empty($item1['descricao'])) : ?>
                                                    <p class="card-text text-muted"><?= $item1['descricao'] ?></p>
                                                <?php endif; ?>
                                                <p class="card-text"><strong><?= $item1['preco'] ?></strong></p>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($subItems[$i + 1])) :
                                        $item2 = $subItems[$i + 1];
                                    ?>
                                        <div class="col-12 col-md-6 d-flex justify-content-center">
                                            <div class="card h-100 w-100 carousel-card-item">
                                                <img src="<?= $item2['imagem'] ?>" class="card-img-top" alt="<?= $item2['nome'] ?>" />
                                                <div class="card-body">
                                                    <h3 class="card-title"><?= $item2['nome'] ?></h3>
                                                    <?php if (!empty($item2['descricao'])) : ?>
                                                        <p class="card-text text-muted"><?= $item2['descricao'] ?></p>
                                                    <?php endif; ?>
                                                    <p class="card-text"><strong><?= $item2['preco'] ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <?php if (count($subItems) > 2) :  
                    ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#<?= strtolower(str_replace(' ', '-', $categoryName)) ?>-carousel<?= ($subCategoryName !== 'default' ? '-' . strtolower(str_replace(' ', '-', $subCategoryName)) : '') ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#<?= strtolower(str_replace(' ', '-', $categoryName)) ?>-carousel<?= ($subCategoryName !== 'default' ? '-' . strtolower(str_replace(' ', '-', $subCategoryName)) : '') ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    <?php endif; ?>
                </div>
        <?php
            endforeach; 
        endforeach; 
        ?>
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.974591461946!2d-46.60835942544487!3d-23.570180462002764!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c11867dd53%3A0xc4b7274092b7713d!2sR.%20da%20Imprensa%2C%20310%20-%20Ipiranga%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2004265-000!5e0!3m2!1spt-BR!2sbr!4v1717616656730!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <p>R. da Imprensa, 310 - Ipiranga, São Paulo - SP, 04265-000</p>
            <p>(11)3297-8305</p>
            <p class="mt-3 mb-0">© 2025 Cantinho do Ipiranga</p>
        </div>
    </footer>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuSection = document.getElementById('menu');
            const footerSection = document.querySelector('footer');
            const ifoodButton = document.querySelector('.ifood-float');

            if (!menuSection || !footerSection || !ifoodButton) {
                return;
            }

            function checkButtonVisibility() {
                const menuRect = menuSection.getBoundingClientRect();
                const footerRect = footerSection.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                const shouldShowButton = (menuRect.top < windowHeight && menuRect.bottom >= 0) && (footerRect.top > (windowHeight - 50));

                if (shouldShowButton) {
                    ifoodButton.style.opacity = '1';
                    ifoodButton.style.visibility = 'visible';
                } else {
                    ifoodButton.style.opacity = '0';
                    ifoodButton.style.visibility = 'hidden';
                }
            }

            window.addEventListener('scroll', checkButtonVisibility);

            checkButtonVisibility();
        });
    </script>
</body>

</html>