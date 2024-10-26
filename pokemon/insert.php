<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Adicionar Pokémon</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

            body {
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
                padding: 10px;
                border-radius: 5px;
                margin-top: 10px;
                display: none;
            }

            .message.success {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .message.error {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
        </style>
    </head>
    <body class="bg-gray-900 text-gray-100">
        <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-5">
            <nav class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <div class="pokeball mr-3"></div>
                    <a href="index.php" class="text-2xl font-bold">Poquedequis</a>
                </div>
                <ul class="flex space-x-6">
                    <li><a href="index.php" class="hover:text-yellow-300 transition-colors duration-300">Início</a></li>
                    <li><a href="api.php" class="hover:text-yellow-300 transition-colors duration-300">API</a></li>
                    <li><a href="insert.php" class="bg-yellow-500 text-gray-900 px-3 py-1 rounded hover:bg-yellow-400 transition-colors duration-300">Inserir</a></li>
                    <li><a href="update.php" class="hover:text-yellow-300 transition-colors duration-300">Modificar</a></li>
                    <li><a href="delete.php" class="hover:text-yellow-300 transition-colors duration-300">Excluir</a></li>
                    <li><a href="documentacao.html" class="hover:text-yellow-300 transition-colors duration-300">Documentação</a></li>
                </ul>
            </nav>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto bg-gray-800 p-8 rounded-lg shadow-lg">
                <h1 class="text-3xl font-bold mb-6">Criar Pokémon</h1>
                <form id="insertForm" class="space-y-4">
                    <div>
                        <label for="id" class="block mb-1">ID:</label>
                        <input type="number" id="id" name="id" max="999999" placeholder="ID do Pokémon" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="nome" class="block mb-1">Nome:</label>
                        <input type="text" id="nome" name="nome" maxlength="100" placeholder="Nome do Pokémon" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="altura" class="block mb-1">Altura (m):</label>
                        <input type="number" step="0.1" id="altura" name="altura" placeholder="Altura do Pokémon" max="9999" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="peso" class="block mb-1">Peso (kg):</label>
                        <input type="number" step="0.1" id="peso" name="peso" max="999999" placeholder="Peso do Pokémon" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="tipo1" class="block mb-1">Tipo 1:</label>
                        <select id="tipo1" name="tipo1" required class="w-full p-2 bg-gray-700 rounded">
                            <option value="" disabled selected>Tipo Primário do Pokémon</option>
                            <option value="Normal">Normal</option>
                            <option value="Fogo">Fogo</option>
                            <option value="Água">Água</option>
                            <option value="Grama">Grama</option>
                            <option value="Elétrico">Elétrico</option>
                            <option value="Gelo">Gelo</option>
                            <option value="Lutador">Lutador</option>
                            <option value="Veneno">Veneno</option>
                            <option value="Terrestre">Terrestre</option>
                            <option value="Voador">Voador</option>
                            <option value="psíquico">Psíquico</option>
                            <option value="Inseto">Inseto</option>
                            <option value="Rocha">Rocha</option>
                            <option value="Fantasma">Fantasma</option>
                            <option value="Dragão">Dragão</option>
                            <option value="Sombrio">Sombrio</option>
                            <option value="Aço">Aço</option>
                            <option value="Fada">Fada</option>
                        </select>
                    </div>
                    <div>
                        <label for="tipo2" class="block mb-1">Tipo 2 (opcional):</label>
                        <select id="tipo2" name="tipo2" class="w-full p-2 bg-gray-700 rounded">
                            <option value="" disabled selected>Tipo Secundário do Pokémon</option>
                            <option value="Normal">Normal</option>
                            <option value="Fogo">Fogo</option>
                            <option value="Água">Água</option>
                            <option value="Grama">Grama</option>
                            <option value="Elétrico">Elétrico</option>
                            <option value="Gelo">Gelo</option>
                            <option value="Lutador">Lutador</option>
                            <option value="Veneno">Veneno</option>
                            <option value="Terrestre">Terrestre</option>
                            <option value="Voador">Voador</option>
                            <option value="psíquico">Psíquico</option>
                            <option value="Inseto">Inseto</option>
                            <option value="Rocha">Rocha</option>
                            <option value="Fantasma">Fantasma</option>
                            <option value="Dragão">Dragão</option>
                            <option value="Sombrio">Sombrio</option>
                            <option value="Aço">Aço</option>
                            <option value="Fada">Fada</option>
                        </select>
                    </div>
                    <div>
                        <label for="fraquezas" class="block mb-1">Fraquezas:</label>
                        <input type="text" id="fraquezas" name="fraquezas" maxlength="255" placeholder="Fraquezas do Pokémon" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="pre_evolucao" class="block mb-1">Pré-evolução (opcional):</label>
                        <input type="text" id="pre_evolucao" name="pre_evolucao" maxlength="100" placeholder="Pré-Evolução do Pokémon" class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="evolucao" class="block mb-1">Evolução (opcional):</label>
                        <input type="text" id="evolucao" name="evolucao" maxlength="100" placeholder="Evolução do Pokémon" class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="genero" class="block mb-1">Gênero:</label>
                        <select id="genero" name="genero" required class="w-full p-2 bg-gray-700 rounded">
                            <option value="" disabled selected>Gênero do Pokémon</option>
                            <option value="Macho">Macho</option>
                            <option value="Fêmea">Fêmea</option>
                            <option value="Macho e Fêmea">Macho e Fêmea</option>
                            <option value="Sem Gênero">Sem Gênero</option>
                        </select>
                    </div>
                    <div>
                        <label for="geracao" class="block mb-1">Geração:</label>
                        <input type="number" id="geracao" name="geracao" max="99" placeholder="Geração do Pokémon" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="regiao" class="block mb-1">Região:</label>
                        <input type="text" id="regiao" name="regiao" maxlength="20" placeholder="Região do Pokémon" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <label for="imagem_url" class="block mb-1">URL da Imagem:</label>
                        <input type="text" id="imagem_url" name="imagem_url" maxlength="255" placeholder="Link da Imagem" required class="w-full p-2 bg-gray-700 rounded">
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Adicionar Pokémon</button>
                    </div>
                </form>
                <div id="message" class="message"></div>
            </div>
        </main>

        <script>
            document.getElementById('insertForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = (new FormData(this));
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                addPokemon(data);
            });

            function addPokemon(data) {
                const xhttp = (new XMLHttpRequest());
                const url = ('http://localhost/pokemon/api.php?');
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-Type', 'application/json');
                xhttp.onload = function() {
                    const messageDiv = (document.getElementById('message'));
                    if (xhttp.status === 200) {
                        try {
                            const result = (JSON.parse(xhttp.responseText));

                            if (result.status === 'success') {
                                messageDiv.textContent = ('Pokémon adicionado com sucesso!');
                                messageDiv.className = ('message success');
                                document.getElementById('insertForm').reset();
                            } else {
                                messageDiv.textContent = ('Erro ao adicionar Pokémon: ' + result.message);
                                messageDiv.className = ('message error');
                            }
                        } catch (e) {
                            messageDiv.textContent = ('Erro ao processar a resposta do servidor.');
                            messageDiv.className = ('message error');
                        }
                    } else {
                        messageDiv.textContent = ('Erro ao comunicar com o servidor.');
                        messageDiv.className = ('message error');
                    }
                    messageDiv.style.display = ('block');
                    setTimeout(() => {
                        messageDiv.style.display = ('none');
                    }, 3000);
                };
                xhttp.onerror = function() {
                    document.getElementById('message').textContent = ('Erro na conexão com o servidor.');
                    document.getElementById('message').className = ('message error');
                    document.getElementById('message').style.display = ('block');
                    setTimeout(() => {
                        document.getElementById('message').style.display = ('none');
                    }, 3000);
                };
                const jsonData = (JSON.stringify(data));
                xhttp.send(jsonData);
            }
        </script>
    </body>
</html>