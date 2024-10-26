<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Pokémon</title>
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
                <a href="index.php" class="text-2xl font-bold">Poquedequis</a>
            </div>
            <ul class="flex space-x-6">
                <li><a href="index.php" class="hover:text-yellow-300 transition-colors duration-300">Início</a></li>
                <li><a href="api.php" class="hover:text-yellow-300 transition-colors duration-300">API</a></li>
                <li><a href="insert.php" class="hover:text-yellow-300 transition-colors duration-300">Inserir</a></li>
                <li><a href="update.php" class="hover:text-yellow-300 transition-colors duration-300">Modificar</a></li>
                <li><a href="delete.php" class="bg-yellow-500 text-gray-900 px-3 py-1 rounded hover:bg-yellow-400 transition-colors duration-300">Excluir</a></li>
                <li><a href="documentacao.html" class="hover:text-yellow-300 transition-colors duration-300">Documentação</a></li>
            </ul>
        </nav>
    </header>
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-gray-800 p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6">Apagar Pokémon</h1>
            <form id="deleteForm" class="space-y-6">
                <div>
                    <label for="id" class="block mb-2">ID do Pokémon:</label>
                    <input type="number" id="id" name="id" max="999999" placeholder="ID do Pokémon" required class="w-full p-2 bg-gray-700 rounded text-white">
                </div>
                <div>
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Excluir Pokémon</button>
                </div>
                <div id="message" class="message"></div>
            </form>
        </div>
    </main>
    <script>
        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = (document.getElementById('id').value);

            if (id) {
                deletePokemon(id);
            } else {
                const messageDiv = (document.getElementById('message'));
                messageDiv.textContent = ('Por favor, insira um ID válido.');
                messageDiv.className = ('message error');
                messageDiv.style.display = ('block');

                setTimeout(() => {
                    messageDiv.style.display = ('none');
                }, 3000);
            }
        });

        function deletePokemon(id) {
            const xhttp = new XMLHttpRequest();
            const url = (`http://localhost/pokemon/api.php?id=${id}`);

            xhttp.open("DELETE", url, true);
            xhttp.setRequestHeader('Content-Type', 'application/json');

            xhttp.onload = function() {
                const messageDiv = (document.getElementById('message'));
                if (xhttp.status === 200) {
                    try {
                        const result = JSON.parse(xhttp.responseText);
                        if (result.status === 'success') {
                            messageDiv.textContent = (`Pokémon excluído com sucesso! ID: ${result.id}, Nome: ${result.nome}`);
                            messageDiv.className = ('message success');
                            document.getElementById('deleteForm').reset();
                        } else {
                            messageDiv.textContent = ('Erro ao excluir Pokémon: ' + result.message);
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
                const messageDiv = document.getElementById('message');
                messageDiv.textContent = ('Erro na conexão com o servidor.');
                messageDiv.className = ('message error');
                messageDiv.style.display = ('block');
                setTimeout(() => {
                    messageDiv.style.display = ('none');
                }, 3000);
            };

            xhttp.send();
        }
    </script>
</body>
</html>
