<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <li><a href="#servicos" class="text-blue-900 hover:text-yellow-500">Serviços</a></li>
                    <li><a href="#" class="text-blue-900 hover:text-yellow-500">Contato</a></li>
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
                            <option value="casa">Casa</option>
                            <option value="apartamento">Apartamento</option>
                            <option value="sala_comercial">Sala Comercial</option>
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

    <!-- Main Content -->
    <main class="container mx-auto mt-6 p-4">
        <!-- Featured Properties -->
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Propriedades em Destaque</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img class="w-full h-48 object-cover"
                        src="https://st3.idealista.pt/news/arquivos/styles/imagen_big_lightbox/public/2020-08/05.jpg?sv=RkjXYLuF&itok=a1juXSla"
                        alt="Propriedade 1">
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800">Propriedade 1</h3>
                        <p class="text-gray-600 mt-2">Descrição breve da propriedade 1.</p>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img class="w-full h-48 object-cover" src="property2.jpg" alt="Propriedade 2">
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800">Propriedade 2</h3>
                        <p class="text-gray-600 mt-2">Descrição breve da propriedade 2.</p>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img class="w-full h-48 object-cover" src="property3.jpg" alt="Propriedade 3">
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800">Propriedade 3</h3>
                        <p class="text-gray-600 mt-2">Descrição breve da propriedade 3.</p>
                    </div>
                </div>
            </div>
        </section>

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
        <section id="anunciar-prop" class="relative mb-8 bg-cover shadow-lg bg-center"
            style="background-image: url('https://algarveproperty.proppycrm.com/ContentFiles/347/1637768104_4.jpg?quality=80&mode=crop');">
            <div class="container mx-auto">
                <div id="banner-anuncie" class="grid grid-cols-1 md:grid-cols-2 gap-4 py-12">
                    <!-- Coluna de texto e imagem -->
                    <div class="flex justify-center items-center">
                        <div class="text-center bg-white rounded-lg shadow-lg p-6 bg-opacity-80">
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
                        <div class="w-full max-w-lg bg-white bg-opacity-80 rounded-lg shadow-lg p-6">
                            <form id="anunciarForm" class="grid grid-cols-1 md:grid-cols-8 gap-4"
                                enctype="multipart/form-data" method="POST" action="upload.php">

                                <div class="md:col-span-4">
                                    <label for="tp_imovel" class="block text-gray-700">Tipo do Imóvel</label>
                                    <select id="tp_imovel" name="tp_imovel"
                                        class="w-full p-2 border border-gray-300 rounded" required>
                                        <option value="">Selecione o tipo de imóvel</option>
                                        <option value="casa">Casa</option>
                                        <option value="apartamento">Apartamento</option>
                                        <option value="sala_comercial">Sala Comercial</option>
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
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Enviar
                                        Anúncio</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contato -->
        <section class="relative mb-8 bg-cover shadow-lg bg-center">
            <!-- Contato Section -->
            <div id="id-contato" class="container-fluid">
                <div id="banner-anuncie-contato" class="row justify-content-around align-items-center">
                    <div class="d-flex align-items-center col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div id="container-texto-banner-contato"
                            class="row d-flex flex-column justify-content-start align-items-center">
                            <div class="col-12">
                                <h1 class="text-3xl font-bold mb-4">Informações de contato</h1>
                                <p class="">
                                    <img src="https://www.helmerimoveis.com.br/assets/icons/icon-map-branco.svg" /> Av.
                                    Barra de São Francisco, 884 - Colina, Linhares - ES, 29900-401
                                </p>
                                <p class="">
                                    <a class="link-contato" href="tel:2733710767">
                                        <img style="width: 21px;"
                                            src="https://www.helmerimoveis.com.br/assets/icons/icon-phone-branco.svg" />
                                        (27) 3371-0767
                                    </a>
                                </p>
                                <p class="">
                                    <a class="link-contato"
                                        href="https://api.whatsapp.com/send?phone=2733710767&text=Olá, vim através do site da Helmer Imóveis.">
                                        <img style="width: 21px;"
                                            src="https://www.helmerimoveis.com.br/assets/icons/redes-sociais/icon-whatsapp-branco.svg" />
                                        (27) 3371-0767
                                    </a>
                                </p>
                                <p class="">
                                    <a class="link-contato"
                                        href="https://api.whatsapp.com/send?phone=27999466368&text=Olá, vim através do site da Helmer Imóveis.">
                                        <img style="width: 21px;"
                                            src="https://www.helmerimoveis.com.br/assets/icons/redes-sociais/icon-whatsapp-branco.svg" />
                                        (27) 9 9946-6368
                                    </a>
                                </p>
                                <p class="">
                                    <a class="link-contato" href="mailto:helmerimoveis@helmerimoveis.com.br">
                                        <img style="width: 20px"
                                            src="https://www.helmerimoveis.com.br/assets/icons/icon-email-branco.png" />
                                        helmerimoveis@helmerimoveis.com.br
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex justify-content-around align-items-center col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="form-anuncie">
                            <div class="form-row">
                                <h3 class="text-center">Deixe sua mensagem que em breve entraremos em contato</h3>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <label class="label-form">Nome</label>
                                    <div class="input-group">
                                        <input id="nome_cont" type="text" class="form-control form-text"
                                            placeholder="Seu nome">
                                        <img class="gif-check lazyload"
                                            data-src="https://www.helmerimoveis.com.br/assets/img/gif/check.gif" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <label class="label-form">E-mail</label>
                                    <input id="email_cont" type="text" class="form-control form-text"
                                        placeholder="E-mail">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label class="label-form">Telefone</label>
                                    <div class="">
                                        <input id="tel_cont" type="text" class="form-control form-text"
                                            placeholder="(27) 0 0000-0000">
                                        <img class="gif-check lazyload"
                                            data-src="https://www.helmerimoveis.com.br/assets/img/gif/check.gif" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label class="label-form">Fixo</label>
                                    <div class="">
                                        <input id="fixo_cont" type="text" class="form-control form-text"
                                            placeholder="(27) 0000-0000">
                                        <img class="gif-check lazyload"
                                            data-src="https://www.helmerimoveis.com.br/assets/img/gif/check.gif" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <label class="label-form">Descrição</label>
                                    <div class="input-group input-group-lg">
                                        <textarea class="form-control" id="descricao_cont" rows="3"></textarea>
                                        <img class="gif-check lazyload"
                                            data-src="https://www.helmerimoveis.com.br/assets/img/gif/check.gif" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="padding-top: 10px;">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img id="gif-form-cont" style="width: 50px"
                                        src="https://www.helmerimoveis.com.br/assets/img/gif/loading.gif" />
                                    <div id="alert-form_cont" class="alert alert-success" role="alert">
                                        <p>Obrigado pelo contato, nossa equipe vai orientar nos próximos passos.</p>
                                        <p>Aguarde contato!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" style="padding-top: 20px; padding-bottom: 20px;">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <p style="font-size: 13px;" class="my-4">Ao informar meus dados, eu concordo com a
                                        <a style="color:#007bff !important"
                                            class="text-primary fs-1 text-decoration-underline"
                                            href="https://www.helmerimoveis.com.br/politica-privacidade"
                                            target="_blank">Política de Privacidade</a>.</p>
                                    <button id="submit-contato"
                                        class="btn btn-light btn-lg btn-primario btn-block">Fazer contato</button>
                                </div>
                            </div>
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

</body>

</html>