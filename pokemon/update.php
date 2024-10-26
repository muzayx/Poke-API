<?php
    $id = $nome = $altura = $peso = $tipo1 = $tipo2 = $fraquezas = $pre_evolucao = $evolucao = $genero = $geracao = $regiao = $imagem_url = '';
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = (isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '');
        $nome = (isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '');
        $altura = (isset($_GET['altura']) ? htmlspecialchars($_GET['altura']) : '');
        $peso = (isset($_GET['peso']) ? htmlspecialchars($_GET['peso']) : '');
        $tipo1 = (isset($_GET['tipo1']) ? htmlspecialchars($_GET['tipo1']) : '');
        $tipo2 = (isset($_GET['tipo2']) ? htmlspecialchars($_GET['tipo2']) : '');
        $fraquezas = (isset($_GET['fraquezas']) ? htmlspecialchars($_GET['fraquezas']) : '');
        $pre_evolucao = (isset($_GET['pre_evolucao']) ? htmlspecialchars($_GET['pre_evolucao']) : '');
        $evolucao = (isset($_GET['evolucao']) ? htmlspecialchars($_GET['evolucao']) : '');
        $genero = (isset($_GET['genero']) ? htmlspecialchars($_GET['genero']) : '');
        $geracao = (isset($_GET['geracao']) ? htmlspecialchars($_GET['geracao']) : '');
        $regiao = (isset($_GET['regiao']) ? htmlspecialchars($_GET['regiao']) : '');
        $imagem_url = (isset($_GET['imagem_url']) ? htmlspecialchars($_GET['imagem_url']) : '');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Atualizar Pokémon</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

            * {
                font-family: 'Poppins', sans-serif;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }

            .pokemon-img {
                width: 80px;
                animation: float 3s ease-in-out infinite;
            }

            .pokeball {
                width: 30px;
                height: 30px;
                background: linear-gradient(to bottom, #ff0000 50%, #ffffff 50%);
                border-radius: 50%;
                position: relative;
                animation: rotate 3s linear infinite;
            }

            .pokeball::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 10px;
                height: 10px;
                background-color: #ffffff;
                border: 2px solid #000000;
                border-radius: 50%;
            }

            @keyframes rotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .message {
                display: none;
                padding: 1rem;
                border-radius: 0.5rem;
            }

            .message.success {
                background-color: #d4edda;
                color: #155724;
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 1rem;
                font-size: 1rem;
                border: 1px solid #c3e6cb;
            }

            .message.error {
                background-color: #f8d7da;
                color: #721c24;
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 1rem;
                font-size: 1rem;
                border: 1px solid #f5c6cb;
            }
        </style>
    </head>
    <body class="bg-gray-900 text-gray-100">
        <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-5">
            <nav class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <div class="pokeball mr-3"></div>
                    <a href="#" class="text-2xl font-bold">Poquedequis</a>
                </div>
                <ul class="flex space-x-6">
                    <li><a href="index.php" class="hover:text-yellow-300 transition-colors duration-300">Início</a></li>
                    <li><a href="api.php" class="hover:text-yellow-300 transition-colors duration-300">API</a></li>
                    <li><a href="insert.php" class="hover:text-yellow-300 transition-colors duration-300">Inserir</a></li>
                    <li><a href="update.php" class="bg-yellow-500 text-gray-900 px-3 py-1 rounded hover:bg-yellow-400 transition-colors duration-300">Modificar</a></li>
                    <li><a href="delete.php" class="hover:text-yellow-300 transition-colors duration-300">Excluir</a></li>
                    <li><a href="documentacao.html" class="hover:text-yellow-300 transition-colors duration-300">Documentação</a></li>
                </ul>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto bg-gray-800 p-8 rounded-lg shadow-lg">
                <h1 class="text-3xl font-bold mb-6">Atualizar Pokémon</h1>
                <form id="updateForm" class="space-y-4">
                    <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div>
                        <label for="nome" class="block mb-1">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" maxlength="100" required class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="altura" class="block mb-1">Altura:</label>
                        <input type="text" id="altura" name="altura" value="<?php echo $altura; ?>" required class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="peso" class="block mb-1">Peso:</label>
                        <input type="text" id="peso" name="peso" value="<?php echo $peso; ?>" required class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="tipo1" class="block mb-1">Tipo 1:</label>
                        <select id="tipo1" name="tipo1" required class="w-full p-2 bg-gray-700 rounded text-white">
                            <?php
                                $tipos = (["Normal", "Fogo", "Água", "Grama", "Elétrico", "Gelo", "Lutador", "Veneno", "Terrestre", "Voador", "Psíquico", "Inseto", "Rocha", "Fantasma", "Dragão", "Sombrio", "Aço", "Fada"]);
                                foreach ($tipos as $tipo) {
                                    $selected = (($tipo == $tipo1) ? 'selected' : '');
                                    echo("<option value=\"$tipo\" $selected>$tipo</option>");
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="tipo2" class="block mb-1">Tipo 2:</label>
                        <select id="tipo2" name="tipo2" class="w-full p-2 bg-gray-700 rounded text-white">
                            <option value="" <?php echo $tipo2 === '' ? 'selected' : ''; ?>>Nenhum</option>
                            <?php
                                foreach ($tipos as $tipo) {
                                    $selected = (($tipo == $tipo2) ? 'selected' : '');
                                    echo("<option value=\"$tipo\" $selected>$tipo</option>");
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="fraquezas" class="block mb-1">Fraquezas:</label>
                        <input type="text" id="fraquezas" name="fraquezas" value="<?php echo $fraquezas; ?>" required class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="pre_evolucao" class="block mb-1">Pré-evolução:</label>
                        <input type="text" id="pre_evolucao" name="pre_evolucao" value="<?php echo $pre_evolucao; ?>" class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="evolucao" class="block mb-1">Evolução:</label>
                        <input type="text" id="evolucao" name="evolucao" value="<?php echo $evolucao; ?>" class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="genero" class="block mb-1">Gênero:</label>
                        <select id="genero" name="genero" required class="w-full p-2 bg-gray-700 rounded text-white">
                            <?php
                                $generos = (["Macho", "Fêmea", "Macho e Fêmea", "Sem Gênero"]);
                                foreach ($generos as $gen) {
                                    $selected = (($gen == $genero) ? 'selected' : '');
                                    echo("<option value=\"$gen\" $selected>$gen</option>");
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="geracao" class="block mb-1">Geração:</label>
                        <input type="text" id="geracao" name="geracao" value="<?php echo $geracao; ?>" required class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="regiao" class="block mb-1">Região:</label>
                        <input type="text" id="regiao" name="regiao" value="<?php echo $regiao; ?>" required class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <label for="imagem_url" class="block mb-1">URL da Imagem:</label>
                        <input type="text" id="imagem_url" name="imagem_url" value="<?php echo $imagem_url; ?>" required class="w-full p-2 bg-gray-700 rounded text-white">
                    </div>
                    <div>
                        <button type="button" id="update-button" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Atualizar Pokémon</button>
                    </div>
                </form>
                <div id="message" class="mt-4 p-4 rounded hidden"></div>
            </div>
        </main>
        <script>
            document.getElementById('update-button').addEventListener('click', function() {
                const formData = (new FormData(document.getElementById('updateForm')));
                const data = {
                    id: (formData.get('id')),
                    nome: (formData.get('nome')),
                    altura: (formData.get('altura')),
                    peso: (formData.get('peso')),
                    tipo1: (formData.get('tipo1')),
                    tipo2: (formData.get('tipo2')) || null,
                    fraquezas: (formData.get('fraquezas')),
                    pre_evolucao: (formData.get('pre_evolucao')) || null,
                    evolucao: (formData.get('evolucao')) || null,
                    genero: (formData.get('genero')),
                    geracao: (formData.get('geracao')),
                    regiao: (formData.get('regiao')),
                    imagem_url: (formData.get('imagem_url'))
                };
                updatePokemon(data);
            });

            function updatePokemon(data) {
                const xhttp = (new XMLHttpRequest());
                const url = ('http://localhost/pokemon/api.php?');
                xhttp.open("PUT", url, true);
                xhttp.setRequestHeader('Content-Type', 'application/json');
                xhttp.onload = function() {
                    const messageElement = (document.getElementById('message'));
                    if (xhttp.status === 200) {
                        try {
                            const result = (JSON.parse(xhttp.responseText));
                            if (result.status === 'success') {
                                messageElement.textContent = ('Pokémon atualizado com sucesso!');
                                messageElement.className = ('message success');
                            } else {
                                messageElement.textContent = ('Erro ao atualizar Pokémon: ' + result.message);
                                messageElement.className = ('message error');
                            }
                        } catch (e) {
                            messageElement.textContent = ('Erro ao processar a resposta do servidor.');
                            messageElement.className = ('message error');
                        }
                    } else {
                        messageElement.textContent = ('Todos os campos obrigatórios devem estar preenchidos');
                        messageElement.className = ('message error');
                    }
                    messageElement.style.display = ('block');
                    setTimeout(() => {
                        messageElement.style.display = ('none');
                    }, 3000);
                };
                xhttp.onerror = function() {
                    const messageElement = (document.getElementById('message'));
                    messageElement.textContent = ('Erro na conexão com o servidor.');
                    messageElement.className = ('message error');
                    messageElement.style.display = ('block');
                    setTimeout(() => {
                        messageElement.style.display = ('none');
                    }, 3000);
                };
                xhttp.send(JSON.stringify(data));
            }
        </script>
    </body>
</html>