<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

<body class="bg-gray-900 text-gray-100 font-sans" onload="loadData()">
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-5">
        <nav class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div class="pokeball mr-3"></div>
                <a href="index.php" class="text-2xl font-bold">Poquedequis</a>
            </div>
            <ul class="flex space-x-6">
                <li><a href="index.php"
                        class="bg-yellow-500 text-gray-900 px-3 py-1 rounded hover:bg-yellow-400 transition-colors duration-300">Início</a>
                </li>
                <li><a href="api.php" class="hover:text-yellow-300 transition-colors duration-300">API</a></li>
                <li><a href="insert.php" class="hover:text-yellow-300 transition-colors duration-300">Inserir</a></li>
                <li><a href="update.php" class="hover:text-yellow-300 transition-colors duration-300">Modificar</a></li>
                <li><a href="delete.php" class="hover:text-yellow-300 transition-colors duration-300">Excluir</a></li>
                <li><a href="documentacao.html"
                        class="hover:text-yellow-300 transition-colors duration-300">Documentação</a></li>
            </ul>
        </nav>
    </header>

    <div class="container mx-auto p-8">
        <div id="dynamicInputs" class="space-y-4"></div>

        <div class="mt-6 space-x-4 flex justify-left">
            <button onclick="loadData()"
                class="bg-blue-800 text-white font-bold py-2 px-4 rounded transition-colors duration-300 transform hover:scale-105 flex items-center justify-between space-x-2 w-35">
                <span>Pesquisar</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
            </button>

            <button onclick="document.getElementById('filterModal').classList.remove('hidden')"
                class="bg-yellow-500 text-gray-900 font-bold py-2 px-4 rounded transition-colors duration-300 transform hover:scale-105 flex items-center justify-between space-x-2 w-30">
                <span>Filtrar Preferências</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.447.894l-4 2.5A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
            </button>
        </div>

        <div class="mt-8 overflow-x-auto">
            <table id="pokemonTable" class="w-full bg-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Nome</th>
                        <th class="p-3 text-left">Altura</th>
                        <th class="p-3 text-left">Peso</th>
                        <th class="p-3 text-left">Tipo 1</th>
                        <th class="p-3 text-left">Tipo 2</th>
                        <th class="p-3 text-left">Fraquezas</th>
                        <th class="p-3 text-left">Pré-evolução</th>
                        <th class="p-3 text-left">Evolução</th>
                        <th class="p-3 text-left">Gênero</th>
                        <th class="p-3 text-left">Geração</th>
                        <th class="p-3 text-left">Região</th>
                        <th class="p-3 text-left">Imagem</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="message" class="mt-4 p-4 rounded hidden"></div>
            <div id="pokemonPanels" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        </div>
    </div>


    <div id="filterModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-gray-800">
            <div class="mt-6">
                <h2 class="text-2xl font-bold text-poke-yellow mb-4">Filtros de Pesquisa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Atributos:</h3>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="id" onchange="toggleInput('ID', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>ID</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="nome" onchange="toggleInput('Nome', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>Nome</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="altura" onchange="toggleInput('Altura', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>Altura</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="peso" onchange="toggleInput('Peso', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>Peso</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="tipo1"
                                    onchange="toggleSelect('Tipo Primário', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>Tipo Primário</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="tipo2"
                                    onchange="toggleSelect('Tipo Secundário', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>Tipo Secundário</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="fraquezas" onchange="toggleSelect('Fraqueza', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>Fraqueza</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" id="geracao" onchange="toggleInput('Geração', this.id, this)"
                                    class="form-checkbox text-poke-blue">
                                <span>Geração</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Ordenar:</h3>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort" value="id" checked class="form-radio text-poke-yellow">
                                <span>ID</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort" value="nome" class="form-radio text-poke-yellow">
                                <span>Nome</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort" value="peso" class="form-radio text-poke-yellow">
                                <span>Peso</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort" value="altura" class="form-radio text-poke-yellow">
                                <span>Altura</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort" value="geracao" class="form-radio text-poke-yellow">
                                <span>Geração</span>
                            </label>
                        </div>
                        <h3 class="text-lg font-semibold mt-4 mb-2">Direção:</h3>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort_direction" value="asc" checked
                                    class="form-radio text-poke-yellow">
                                <span>Crescente</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort_direction" value="desc"
                                    class="form-radio text-poke-yellow">
                                <span>Decrescente</span>
                            </label>
                        </div>
                        <h3 class="text-lg font-semibold mt-4 mb-2">Mostrar em:</h3>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort_display" value="tabela" checked
                                    class="form-radio text-poke-yellow">
                                <span>Tabela</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="sort_display" value="painel"
                                    class="form-radio text-poke-yellow">
                                <span>Painéis</span>
                            </label>
                        </div>
                    </div>
                </div>
                <button onclick="document.getElementById('filterModal').classList.add('hidden')"
                    class="mt-6 bg-red-700 mt-10 w-full text-white font-bold py-2 px-4 rounded transition-colors duration-300">
                    Fechar
                </button>
            </div>
        </div>
    </div>
    <a href="#top"
        class="fixed bottom-10 right-10 bg-blue-600 text-white px-4 py-3 rounded-full shadow-lg transform transition-all duration-300 hover:bg-blue-700 hover:scale-110 flex items-center justify-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </a>
    <script>
        function toggleSelect(atributo, newID, checkbox) {
            const container = document.getElementById('dynamicInputs');
            let selectField = document.getElementById(`select_${newID}`);

            if (checkbox.checked) {
                if (!selectField) {
                    selectField = document.createElement('select');
                    selectField.id = `select_${newID}`;
                    selectField.classList.add('w-full', 'p-2', 'bg-gray-700', 'text-white', 'rounded', 'mt-2');

                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = `Selecione ${atributo}`;
                    defaultOption.disabled = true;
                    defaultOption.selected = true;
                    selectField.appendChild(defaultOption);

                    const options = [
                        { value: 'normal', text: 'Normal' },
                        { value: 'fogo', text: 'Fogo' },
                        { value: 'agua', text: 'Água' },
                        { value: 'grama', text: 'Grama' },
                        { value: 'eletrico', text: 'Elétrico' },
                        { value: 'gelo', text: 'Gelo' },
                        { value: 'lutador', text: 'Lutador' },
                        { value: 'veneno', text: 'Veneno' },
                        { value: 'terra', text: 'Terrestre' },
                        { value: 'voador', text: 'Voador' },
                        { value: 'psiquico', text: 'Psíquico' },
                        { value: 'inseto', text: 'Inseto' },
                        { value: 'rocha', text: 'Rocha' },
                        { value: 'fantasma', text: 'Fantasma' },
                        { value: 'dragao', text: 'Dragão' },
                        { value: 'sombrio', text: 'Sombrio' },
                        { value: 'metal', text: 'Metálico' },
                        { value: 'fada', text: 'Fada' }
                    ];

                    options.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option.value;
                        optionElement.textContent = option.text;
                        selectField.appendChild(optionElement);
                    });

                    container.appendChild(selectField);
                }
            } else {
                if (selectField) {
                    container.removeChild(selectField);
                }
            }
        }

        function toggleInput(atributo, newID, checkbox) {
            const container = document.getElementById('dynamicInputs');
            let inputField = document.getElementById(`input_${newID}`);

            if (checkbox.checked) {
                if (!inputField) {
                    inputField = document.createElement('input');
                    inputField.type = 'text';
                    inputField.id = `input_${newID}`;
                    inputField.placeholder = `${atributo} do Pokemon`;
                    inputField.classList.add('w-full', 'p-2', 'bg-gray-700', 'text-white', 'rounded', 'mt-2');
                    container.appendChild(inputField);
                }
            }
            else {
                if (inputField) {
                    container.removeChild(inputField);
                }
            }
            if (['id', 'peso', 'altura'].includes(newID)) {
                if (checkbox.checked) {
                    inputField.type = 'number';
                } else {
                    inputField.type = 'text';
                }
            }
        }

        function loadData() {
            const baseUrl = ('http://localhost/pokemon/api.php?');

            const inputs = document.querySelectorAll('#dynamicInputs input');
            const selects = document.querySelectorAll('#dynamicInputs select');
            let queryParams = [];

            inputs.forEach(input => {
                if (input.value) {
                    queryParams.push(`${input.id.split('_')[1].toLowerCase()}=${encodeURIComponent(input.value)}`);
                }
            });

            selects.forEach(select => {
                if (select.value) {
                    queryParams.push(`${select.id.split('_')[1].toLowerCase()}=${encodeURIComponent(select.value)}`);
                }
            });

            const sortRadio = document.querySelector('input[name="sort"]:checked');
            if (sortRadio) queryParams.push(`ordenar=${sortRadio.value}`);

            const sortDirectionRadio = document.querySelector('input[name="sort_direction"]:checked');
            if (sortDirectionRadio) queryParams.push(`direcao=${sortDirectionRadio.value}`);

            const displayModeRadio = document.querySelector('input[name="sort_display"]:checked').value;

            const url = `${baseUrl}${queryParams.join('&')}`;
            console.log('URL gerada:', url);

            const xhttp = new XMLHttpRequest();

            xhttp.open("GET", url, true);

            xhttp.onload = function() {
                const messageDiv = document.getElementById('message');

                if (xhttp.status === 200) {
                    try {
                        const pokemonData = JSON.parse(xhttp.responseText);

                        document.querySelector("#pokemonTable tbody").innerHTML = "";
                        document.querySelector("#pokemonPanels").innerHTML = "";

                        if (displayModeRadio === "tabela") {
                            displayTable(pokemonData);
                        } else if (displayModeRadio === "painel") {
                            displayPanels(pokemonData);
                        }
                    } catch (e) {
                        messageDiv.textContent = ('Erro ao processar a resposta do servidor.');
                        messageDiv.className = ('message error');
                        messageDiv.style.display = ('block');
                    }
                } else {
                    document.querySelector("#pokemonTable tbody").innerHTML = "";
                    document.querySelector("#pokemonPanels").innerHTML = "";
                    messageDiv.textContent = ('Pokémon não encontrado!');
                    messageDiv.className = ('message error');
                    messageDiv.style.display = ('block');
                    setTimeout(() => {
                        messageDiv.style.display = 'none';
                    }, 3000);
                }
            };

            xhttp.onerror = function() {
                const messageDiv = document.getElementById('message');
                messageDiv.textContent = ('Erro na conexão com o servidor.');
                messageDiv.className = ('message error');
                messageDiv.style.display = ('block');
            };

            xhttp.send();
        }


        function displayTable(pokemonData) {
            document.getElementById("pokemonTable").classList.remove("hidden");
            document.getElementById("pokemonPanels").classList.add("hidden");

            const tableBody = document.querySelector("#pokemonTable tbody");

            pokemonData.forEach(pokemon => {
                const row = document.createElement("tr");
                row.classList.add("hover:bg-gray-700", "transition-colors", "duration-200");
                row.innerHTML = (`
                    <td class="p-3">${pokemon.id}</td>
                    <td class="p-3">${pokemon.nome}</td>
                    <td class="p-3">${pokemon.altura} m</td>
                    <td class="p-3">${pokemon.peso} kg</td>
                    <td class="p-3">${pokemon.tipo1}</td>
                    <td class="p-3">${pokemon.tipo2 ? pokemon.tipo2 : ''}</td>
                    <td class="p-3">${pokemon.fraquezas}</td>
                    <td class="p-3">${pokemon.pre_evolucao ? pokemon.pre_evolucao : ''}</td>
                    <td class="p-3">${pokemon.evolucao ? pokemon.evolucao : ''}</td>
                    <td class="p-3">${pokemon.genero}</td>
                    <td class="p-3">${pokemon.geracao}</td>
                    <td class="p-3">${pokemon.regiao}</td>
                    <td class="p-3"><img src="${pokemon.imagem_url}" alt="${pokemon.nome}" class="w-24 h-24 object-contain animate-float"></td>
                `);
                row.dataset.pokemon = JSON.stringify(pokemon);
                tableBody.appendChild(row);
            });

            tableBody.querySelectorAll('tr').forEach(row => {
                row.addEventListener('click', () => {
                    const pokemon = JSON.parse(row.dataset.pokemon);
                    redirectToUpdate(pokemon);
                });
            });
        }

        function displayPanels(pokemonData) {
            document.getElementById("pokemonTable").classList.add("hidden");
            document.getElementById("pokemonPanels").classList.remove("hidden");

            const panelsContainer = document.querySelector("#pokemonPanels");

            pokemonData.forEach(pokemon => {
                const panel = document.createElement("div");
                panel.classList.add("bg-gray-800", "p-6", "rounded-lg", "shadow-lg", "hover:shadow-xl", "transition-shadow", "duration-300", "flex", "flex-col", "items-center");
                panel.dataset.pokemon = JSON.stringify(pokemon);

                panel.innerHTML = `
                    <img src="${pokemon.imagem_url}" alt="${pokemon.nome}" class="w-48 h-48 object-contain animate-float mb-4">
                    <h3 class="text-xl font-bold mb-2">${pokemon.nome} (#${pokemon.id})</h3>
                    <p class="text-sm">Altura: ${pokemon.altura} m | Peso: ${pokemon.peso} kg</p>
                    <p class="text-sm">Tipo 1: ${pokemon.tipo1} ${pokemon.tipo2 ? "| Tipo 2: " + pokemon.tipo2 : ""}</p>
                    <p class="text-sm">Fraquezas: ${pokemon.fraquezas}</p>
                    <p class="text-sm">Pré-evolução: ${pokemon.pre_evolucao ? pokemon.pre_evolucao : 'Nenhuma'}</p>
                    <p class="text-sm">Evolução: ${pokemon.evolucao ? pokemon.evolucao : 'Nenhuma'}</p>
                    <p class="text-sm">Gênero: ${pokemon.genero}</p>
                    <p class="text-sm">Geração: ${pokemon.geracao} | Região: ${pokemon.regiao}</p>
                `;
                panelsContainer.appendChild(panel);
            });

            panelsContainer.querySelectorAll('div').forEach(panel => {
                panel.addEventListener('click', () => {
                    const pokemon = JSON.parse(panel.dataset.pokemon);
                    redirectToUpdate(pokemon);
                });
            });
        }

        function redirectToUpdate(pokemon) {
            const params = new URLSearchParams(pokemon).toString();
            window.location.href = (`update.php?${params}`);
        }
    </script>
</body>

</html>