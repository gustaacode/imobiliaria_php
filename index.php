<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Adicionando Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Adicionando Tailwind Css -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Adicionando JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Adicionando Javascript -->
    <script>

        $(document).ready(function () {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function () {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#endereco").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>
    <title>G&A Imobiliária</title>
</head>

<body class="bg-gray-100">

    <!-- Header -->
    <header class="p-none">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#">
                <img src="img/logo_imobiliaria.png" alt="Logo G&A Imobiliária" class="h-40">
            </a>
            <nav>
                <ul class="flex space-x-4 text-xl font-semibold space-x-11 mr-7">
                    <li><a href="index.php" class="text-blue-900 hover:text-yellow-500">Home</a></li>
                    <li><a href="propriedades.php" class="text-blue-900 hover:text-yellow-500">Propriedades</a></li>
                    <li><a href="index.php#anunciar-prop" class="text-blue-900 hover:text-yellow-500">Anunciar</a></li>
                    <li><a href="index.php#servicos" class="text-blue-900 hover:text-yellow-500">Serviços</a></li>
                    <li><a href="index.php#contato" class="text-blue-900 hover:text-yellow-500">Contato</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Search Filter -->
    <section class="relative bg-cover bg-center h-96" style="background-image: url('img/banner-front-page.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-25 flex items-center justify-center">
            <div class="container mx-10 p-6 bg-white bg-opacity-75 rounded-lg">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="finalidade" class="block text-gray-700">Finalidade</label>
                        <select id="finalidade" name="finalidade" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">Selecione</option>
                            <option value="compra">Compra</option>
                            <option value="locação">Locação</option>
                        </select>
                    </div>
                    <div>
                        <label for="property-type" class="block text-gray-700">Tipo de Imóvel</label>
                        <select id="property-type" name="property-type"
                            class="w-full p-2 border border-gray-300 rounded">
                            <option value="">Selecione</option>
                            <option value="2">Casa</option>
                            <option value="1">Apartamento</option>
                            <option value="3">Sala Comercial</option>
                        </select>
                    </div>
                    <div>
                        <label for="location" class="block text-gray-700">Localização</label>
                        <input type="text" id="location" name="location"
                            class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div>
                        <label for="price" class="block text-gray-700">Preço Máximo</label>
                        <input type="number" id="price" name="price" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div class="md:col-span-3 text-center">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Pesquisar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <main class="container mx-auto mt-6 p-4">

        <!-- Serviços -->
        <section class="mb-8" id="servicos">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Nossos Serviços</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800">Venda de Imóveis</h3>
                    <p class="text-gray-600 mt-2">Serviço completo de venda de imóveis, desde a avaliação até a
                        conclusão da venda.</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800">Locação de Imóveis</h3>
                    <p class="text-gray-600 mt-2">Encontre o imóvel perfeito para alugar com nosso serviço de locação.
                    </p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800">Consultoria Imobiliária</h3>
                    <p class="text-gray-600 mt-2">Oferecemos consultoria especializada para ajudar você a tomar as
                        melhores decisões.</p>
                </div>
            </div>
        </section>

        <!-- Anunciar -->
        <section id="anunciar-prop" class="relative mb-none bg-yellow-400 shadow-lg bg-center">
            <div class="container mx-auto">
                <div id="banner-anuncie" class="grid grid-cols-1 md:grid-cols-2 gap-4 py-12">
                    <!-- Coluna de texto e imagem -->
                    <div class="flex justify-center items-center">
                        <div class="text-center bg-white rounded-lg shadow-lg p-6 bg-opacity-100">
                            <h1 class="text-3xl font-bold mb-4">Anuncie o seu imóvel na G&A</h1>
                            <div class="mb-4">
                                <p><img src="https://www.helmerimoveis.com.br/assets/icons/icon-check.svg"
                                        class="inline-block mr-2" /> Seu imóvel negociado com segurança e transparência
                                    pelos nossos corretores.</p>
                                <p><img src="https://www.helmerimoveis.com.br/assets/icons/icon-check.svg"
                                        class="inline-block mr-2" /> Fotos do seu imóvel sem nenhum custo adicional.</p>
                                <p><img src="https://www.helmerimoveis.com.br/assets/icons/icon-check.svg"
                                        class="inline-block mr-2" /> Tenha seu imóvel divulgado em todos os nossos meios
                                    de comunicação.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Coluna do formulário -->
                    <div class="flex justify-center items-center">
                        <div class="w-full max-w-lg bg-white bg-opacity-100 rounded-lg shadow-lg p-6">
                            <form id="anunciarForm" class="grid grid-cols-1 md:grid-cols-8 gap-4"
                                enctype="multipart/form-data" method="POST" action="upload.php">

                                <div class="md:col-span-4">
                                    <label for="tp_imovel" class="block text-gray-700">Tipo do Imóvel</label>
                                    <select id="tp_imovel" name="tp_imovel"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                        <option value="">Selecione o tipo de imóvel</option>
                                        <option value="2">Casa</option>
                                        <option value="1">Apartamento</option>
                                        <option value="3">Sala Comercial</option>
                                    </select>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="cep" class="block text-gray-700">CEP</label>
                                    <input type="text" id="cep" name="cep" placeholder="Digite o CEP"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="cidade" class="block text-gray-700">Cidade</label>
                                    <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade"
                                        class="w-full p-2 border border-gray-300 rounded" readonly>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="bairro" class="block text-gray-700">Bairro</label>
                                    <input type="text" id="bairro" name="bairro" placeholder="Digite o bairro"
                                        class="w-full p-2 border border-gray-300 rounded" readonly>
                                </div>

                                <div class="md:col-span-6">
                                    <label for="endereco" class="block text-gray-700">Endereço</label>
                                    <input type="text" id="endereco" name="endereco" placeholder="Digite o endereço"
                                        class="w-full p-2 border border-gray-300 rounded" readonly>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="nmr_casa" class="block text-gray-700">Número</label>
                                    <input type="number" id="nmr_casa" name="nmr_casa" placeholder="Nº"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="dsp_venda" class="block text-gray-700">Disponibilidade para
                                        Venda</label>
                                    <select id="dsp_venda" name="dsp_venda"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                        <option value="">Selecione</option>
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="dsp_aluguel" class="block text-gray-700">Disponibilidade para
                                        Aluguel</label>
                                    <select id="dsp_aluguel" name="dsp_aluguel"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                        <option value="">Selecione</option>
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="preco" class="block text-gray-700">Preço (R$)</label>
                                    <input type="number" id="preco" name="preco" placeholder="Digite o preço"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="nmr_vaga_garagem" class="block text-gray-700">Número de Vagas na
                                        Garagem</label>
                                    <input type="number" id="nmr_vaga_garagem" name="nmr_vaga_garagem"
                                        placeholder="Digite o número de vagas"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-8">
                                    <label for="descricao" class="block text-gray-700">Descrição</label>
                                    <textarea id="descricao" name="descricao" placeholder="Digite a descrição"
                                        class="w-full p-2 border border-gray-300 rounded" required></textarea>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="andar" class="block text-gray-700">Andar</label>
                                    <input type="number" id="andar" name="andar" placeholder="Digite o andar"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="valor_condominio" class="block text-gray-700">Valor do Condomínio
                                        (R$)</label>
                                    <input type="number" id="valor_condominio" name="valor_condominio"
                                        placeholder="Digite o valor do condomínio"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="possui_portaria" class="block text-gray-700">Possui Portaria</label>
                                    <select id="possui_portaria" name="possui_portaria"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                        <option value="">Selecione</option>
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="qtd_sala_jantar" class="block text-gray-700">Quantidade de Salas de
                                        Jantar</label>
                                    <input type="number" id="qtd_sala_jantar" name="qtd_sala_jantar"
                                        placeholder="Digite a quantidade de salas"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="qtd_banheiros" class="block text-gray-700">Quantidade de
                                        Banheiros</label>
                                    <input type="number" id="qtd_banheiros" name="qtd_banheiros"
                                        placeholder="Digite a quantidade de banheiros"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="qtd_comodos" class="block text-gray-700">Quantidade de Cômodos</label>
                                    <input type="number" id="qtd_comodos" name="qtd_comodos"
                                        placeholder="Digite a quantidade de cômodos"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="qtd_quartos" class="block text-gray-700">Quantidade de Quartos</label>
                                    <input type="number" id="qtd_quartos" name="qtd_quartos"
                                        placeholder="Digite a quantidade de quartos"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="qtd_suites" class="block text-gray-700">Quantidade de Suítes</label>
                                    <input type="number" id="qtd_suites" name="qtd_suites"
                                        placeholder="Digite a quantidade de suítes"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="qtd_sala_estar" class="block text-gray-700">Quantidade de Salas de
                                        Estar</label>
                                    <input type="number" id="qtd_sala_estar" name="qtd_sala_estar"
                                        placeholder="Digite a quantidade de salas"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>

                                <div class="md:col-span-4">
                                    <label for="area" class="block text-gray-700">Área (m²)</label>
                                    <input type="number" id="area" name="area" placeholder="Digite a área em m²"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>
                                <!-- Foto do Imóvel -->
                                <div class="md:col-span-8">
                                    <label for="imagem" class="block text-gray-700">Foto do Imóvel</label>
                                    <input type="file" id="imagem" name="imagem"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                </div>
                                <!-- Botão de Enviar -->
                                <div class="md:col-span-8 text-center">
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 uppercase">Anunciar
                                        Imóvel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contato -->
        <section id="contato" class="relative mb-none bg-cover shadow-lg bg-center"
            style="background-image: url('img/img_contato.jpeg');">
            <div id="id-contato" class="container mx-auto px-4 py-12">
                <div id="banner-anuncie-contato" class="flex flex-wrap justify-around items-center">
                    <div class="w-full md:w-1/2 lg:w-1/3 px-4">
                        <div id="container-texto-banner-contato" class="text-center md:text-left text-white">
                            <h1 class="text-3xl font-bold mb-4">Informações de contato</h1>
                            <p class="mb-2">
                                <img src="https://www.helmerimoveis.com.br/assets/icons/icon-map-branco.svg"
                                    class="inline-block mr-2" />
                                Rua Alfredo Zurlo, 74 - São Vicente, Colatina - ES, 29700-430
                            </p>
                            <p class="mb-2">
                                <a href="tel:997133145">
                                    <img src="https://www.helmerimoveis.com.br/assets/icons/icon-phone-branco.svg"
                                        style="width: 21px;" class="inline-block mr-2" />
                                    (27) 99713-3145
                                </a>
                            </p>
                            <p class="mb-2">
                                <a href="https://api.whatsapp.com/send?phone=27997133145&text=Olá, vim através do site da imobiliária."
                                    class="link-contato">
                                    <img src="https://www.helmerimoveis.com.br/assets/icons/redes-sociais/icon-whatsapp-branco.svg"
                                        style="width: 21px;" class="inline-block mr-2" />
                                    (27) 9 9713-3145
                                </a>
                            </p>
                            <p class="mb-2">
                                <a href="https://api.whatsapp.com/send?phone=27997781674&text=Olá, vim através do site da imobiliária."
                                    class="link-contato">
                                    <img src="https://www.helmerimoveis.com.br/assets/icons/redes-sociais/icon-whatsapp-branco.svg"
                                        style="width: 21px;" class="inline-block mr-2" />
                                    (27) 9 9778-1674
                                </a>
                            </p>
                            <p class="mb-2">
                                <a href="mailto:gaimobiliaria.contato@gaimobiliaria.com.br" class="link-contato">
                                    <img src="https://www.helmerimoveis.com.br/assets/icons/icon-email-branco.png"
                                        style="width: 20px;" class="inline-block mr-2" />
                                    gaimobiliaria.contato@gaimobiliaria.com.br
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/3 px-4 text-gray-600">
                        <div class="form-contato bg-white p-6 rounded-lg md:grid-cols-8">
                            <h3 class="text-center mb-6">Deixe sua mensagem que em breve entraremos em contato</h3>
                            <form id="contact-form">
                                <div class="mb-4">
                                    <label class="label-form">Nome</label>
                                    <input id="nome_cont" type="text"
                                        class="form-control form-text w-full py-2 px-3 border rounded-md"
                                        placeholder="Seu nome" required>
                                </div>
                                <div class="mb-4">
                                    <label class="label-form">E-mail</label>
                                    <input id="email_cont" type="email"
                                        class="form-control form-text w-full py-2 px-3 border rounded-md"
                                        placeholder="E-mail" required>
                                </div>
                                <div class="mb-4">
                                    <label class="label-form">Telefone</label>
                                    <input id="tel_cont" type="text"
                                        class="form-control form-text w-full py-2 px-3 border rounded-md"
                                        placeholder="(27) 0 0000-0000" required>
                                </div>
                                <div class="mb-4">
                                    <label class="label-form">Fixo</label>
                                    <input id="fixo_cont" type="text"
                                        class="form-control form-text w-full py-2 px-3 border rounded-md"
                                        placeholder="(27) 0000-0000">
                                </div>
                                <div class="mb-4">
                                    <label class="label-form">Descrição</label>
                                    <textarea class="form-control w-full py-2 px-3 border rounded-md"
                                        id="descricao_cont" rows="3" placeholder="Sua mensagem" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs my-4">Ao informar meus dados, eu concordo com a
                                        <a href="https://www.helmerimoveis.com.br/politica-privacidade" target="_blank"
                                            class="text-blue-500 underline">Política de Privacidade</a>.
                                    </p>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 uppercase md:col-span-8">Fazer
                                        contato</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 py-6">
        <div class="container mx-auto text-center text-white">
            <p>&copy; 2023 G&A Imobiliária. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        document.getElementById('contact-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Impede o envio do formulário padrão

            // Obtém os valores dos campos do formulário
            const nome = document.getElementById('nome_cont').value;
            const email = document.getElementById('email_cont').value;
            const telefone = document.getElementById('tel_cont').value;
            const fixo = document.getElementById('fixo_cont').value;
            const descricao = document.getElementById('descricao_cont').value;

            // Formata a mensagem para o WhatsApp
            const mensagem = `Olá, meu nome é ${nome}. Meu e-mail é ${email}, meu telefone é ${telefone}, e meu telefone fixo é ${fixo}. Mensagem: ${descricao}`;

            // Codifica a mensagem para usar na URL
            const mensagemEncoded = encodeURIComponent(mensagem);

            // Cria a URL do WhatsApp com a mensagem
            const whatsappURL = `https://api.whatsapp.com/send?phone=27997781674&text=${mensagemEncoded}`;

            // Redireciona o usuário para a URL do WhatsApp
            window.location.href = whatsappURL;
        });
    </script>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</body>

</html>