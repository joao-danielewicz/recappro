<?php require_once "Views/shared/layout/header.php" ?>

<link rel="stylesheet" href="Views/Home/css/home.css">
<title><?php echo ($titulo) ?></title>

<section id="firstSection" class="align-items-center d-flex shadow-lg">
    <div class="container w-75 d-flex justify-content-between align-items-center">

        <div class="text-start me-5">
            <h1>Organize seus estudos de forma <span>eficiente</span>.</h1>
            <hr class="mb-5">
            <p>O <span>RecapPro</span> te ajuda a <strong>aprender</strong> usando métodos que funcionam.<br>
                Memorize conteúdos com facilidade.<br>
                Estude no <strong>seu</strong> tempo.<br>
                Personalize seu aprendizado.</p>
        </div>
        <div class="flex-grow-1">
            <a href="#tutorial" class="btn btn-light w-100 mb-3">Veja o tutorial</a>
            <a href="#informacoes" class="btn btn-light w-100">Mais informações</a>
        </div>
    </div>
</section>

<section id="tutorial" class="container mt-5">
    <div class="row row-cols-2 align-items-center">
        <div class="col">
            <div class="bg-white shadow p-3 rounded">
                O intuito de nosso sistema é proporcionar um ambiente amigável a qualquer um que deseje estudar.
                <hr>
                Entendemos que a tecnologia pode ser um desafio para muitos, e que no momento de estudo devemos manter o foco. Portanto, buscamos ao máximo manter o fluxo de uso simples e intuitivo.
                <hr>
                Veja ao lado algumas dicas de como utilizar o RecapPro!
            </div>
        </div>
        <div class="col">
            <div class="bg-white shadow p-3 rounded">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-theme="dark">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide $"></button>
                    </div>
                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <img src="Views/home/img/tuto_cadastro.png" class="d-block w-100" alt="...">
                            <div class="mt-3 mb-5 text-center d-none d-md-block">
                                <h5>Crie uma conta</h5>
                                <p>Registre-se para poder utilizar a aplicação.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Views/home/img/tuto_curso.png" class="d-block w-100" alt="...">
                            <div class="mt-3 mb-5 text-center d-none d-md-block">
                                <h5>Curso</h5>
                                <p>Adicione um curso e acesse-o para cadastrar tarefas.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Views/home/img/tuto_tarefa.png" class="d-block w-100" alt="...">
                            <div class="mt-3 mb-5 text-center d-none d-md-block">
                                <h5>Tarefa</h5>
                                <p>Cadastre uma tarefa para começar a estudar. Veja seus detalhes e edite-a.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Views/home/img/tuto_estudo.png" class="d-block w-100" alt="...">
                            <div class="mt-3 mb-5 text-center d-none d-md-block">
                                <h5>Estudo</h5>
                                <p>Receba a pergunta e verifique a resposta. Indique a dificuldade. Finalize a sessão e receba pontos!</p>
                            </div>
                        </div>


                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="informacoes" class="container mt-5">
    <div class="bg-white w-100 rounded p-3 shadow mb-3 text-center">
        <h2>Informações</h2>
        <hr>
        <p>Listamos abaixo algumas informações sobre o projeto que você pode achar interessantes.</p>
    </div>

    <div class="accordion shadow" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    O que é o sistema de repetição espaçada? Por que devo usá-lo?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    De modo geral, nós <strong>aumentamos</strong> o período antes da próxima revisão de uma tarefa caso o usuário identifique-a como fácil, e o <strong>diminuímos</strong> se ela for considerada difícil.
                    <br><br>Estudos afirmam que ao <strong>"forçar"</strong> nossa memória para nos lembrarmos de alguma informação, ela ficará gravada de maneira mais eficaz em nossa mente. Ao <strong>aumentar</strong> o espaço de tempo entre sessões de estudo, ensinamos ao nosso cérebro que ele deve reter a memória de determinadas informações por longos períodos, já que ela será necessária posteriormente. Quando comparada com métodos de <strong>estudo intensivo</strong> (rever todo o conteúdo para uma prova logo antes de fazê-la, por exemplo), a repetição extensiva apresenta uma maior eficácia no ensino propriamente dito, já que ao repetirmos uma informação constantemente podemos criar mais conexões em contextos diferentes.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Esta metodologia funciona em qualquer área?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Tudo dependerá do perfil de aprendizado do usuário.

                    <br><br>De certa forma, os <strong>flashcards</strong> (conjunto pergunta-resposta) são adequados para situações em que um questionamento fará com que o estudante realize um diálogo interno, esforçando-se para unir <strong>dados em informações</strong> e formular uma resposta concreta. Logo, é possível dizer que existem poucos contextos em que o sistema não terá eficácia. É possível aplicá-lo em questões de interpretação de texto, matemática, vocabulário... quanto mais <strong>variada e complexa</strong> for a sua resposta mediante uma pergunta com o passar do tempo, mais eficazes os flashcards estão sendo para você.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    O que é a loja de itens?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Criamos a loja de itens como um método de apoio para a motivação contínua do estudante.

                    <br><br>Por mais que alguém goste de estudar, muitas vezes pode se sentir frustrado ou desanimado. Como estudantes, sabemos da importância de pausas e da criação de um <strong>contexto descontraídoe leve</strong> para estudarmos. Levando isso em consideração, disponibilizamos algumas imagens autorais que podem ser trocadas por Pontos de Estudo. Você ganha pontos ao responder suas tarefas,
                    independentemente da dificuldade encontrada. As imagens que você coletou ficam disponíveis em seu perfil, que poderá ser <strong>customizado</strong> como você desejar.
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once "Views/shared/layout/footer.php";
?>