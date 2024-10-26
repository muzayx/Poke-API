<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Pokémon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
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
        
        .json-viewer {
            white-space: pre-wrap; /* Preserva os espaços em branco e as quebras de linha */
            background-color: #1a1a1a;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto; /* Permite rolagem horizontal */
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-5">
        <nav class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Pokémon API Consulta</a>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-gray-800 p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6">Consultar Pokémon</h1>
            <form id="pokemonForm" class="space-y-4">
                <div>
                    <label for="pokemon" class="block mb-1">Nome do Pokémon:</label>
                    <input type="text" id="pokemon" name="pokemon" placeholder="ex: pikachu" required class="w-full p-2 bg-gray-700 rounded text-white">
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Consultar Pokémon</button>
                </div>
            </form>
            <div id="message" class="message mt-4"></div>
            <div id="pokemonResult" class="mt-6">
                <p id="pokemonLink">Direto link para resultados: <a href="#" id="apiLink" class="text-blue-400 underline">Nenhum Pokémon consultado ainda</a></p>
                <div id="jsonResult" class="json-viewer mt-4">Nenhum dado JSON exibido ainda.</div>
                <button id="downloadBtn" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300 mt-4" style="display: none;">Baixar JSON</button>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('pokemonForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            const pokemonName = document.getElementById('pokemon').value.trim();
            if (pokemonName) {
                fetchPokemon(pokemonName);
            } else {
                displayMessage('Por favor, insira um nome válido de Pokémon.', 'error');
            }
        });

        function fetchPokemon(name) {
            const url = `http://localhost/pokemon/api.php?nome=${encodeURIComponent(name)}`;

            // Atualiza o hyperlink com a URL da API
            document.getElementById('apiLink').href = url;
            document.getElementById('apiLink').textContent = url;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Pokémon não encontrado ou erro na API.');
                    }
                    return response.json();
                })
                .then(data => {
                    const jsonResultDiv = document.getElementById('jsonResult');
                    jsonResultDiv.textContent = JSON.stringify(data, null, 2); // Exibe o JSON formatado

                    // Habilita o botão de download
                    const downloadBtn = document.getElementById('downloadBtn');
                    downloadBtn.style.display = 'block';

                    // Define o comportamento de download
                    downloadBtn.onclick = function() {
                        const jsonBlob = new Blob([JSON.stringify(data, null, 2)], { type: 'text/plain' });
                        const downloadLink = document.createElement('a');
                        downloadLink.href = URL.createObjectURL(jsonBlob);
                        downloadLink.download = `${name}.txt`;
                        downloadLink.click();
                    };

                    displayMessage('Pokémon encontrado com sucesso!', 'success');
                })
                .catch(error => {
                    displayMessage(error.message, 'error');
                });
        }


        function displayMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = message;
            messageDiv.className = `message ${type}`;
            messageDiv.style.display = 'block';

            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>
