<h1>Poke API 🔎</h1>
<p>Uma API desenvolvida por mim e outros integrantes do meu grupo, que faz a busca de pokemons, e devolve suas respectivas informações.</p>

<h1>Como usar?</h1>
<h2>1. Configuração da Conexão com o Banco de Dados</h2>

<p>Abra o arquivo bdconnecta.php e localize a seguinte linha:</p>

```
$conn = mysqli_connect("localhost", "root", "", "22092");
```
> [!Tip]
> <p>Primeiro campo: Substitua "localhost" pelo nome do servidor (normalmente, é localhost)</p>
> <p>Segundo campo: Substitua "root" pelo usuário do banco de dados</p>
> <p>Terceiro campo: Substitua a senha conforme necessário (se não houver senha, deixe em branco)</p>
> <p>Quarto campo: Substitua "22092" pelo nome do banco de dados que você deseja usar</p>

<h2>2. Configuração do Ambiente</h2>

<p>Mova todos os arquivos do projeto para um ambiente de desenvolvimento PHP que suporte interação com o banco de dados, como Laragon, XAMPP, ou outro servidor local de sua escolha.</p>

<h2>3. Importando o Banco de Dados</h2>

- Navegue até a pasta pokemon/db/ e verifique se o arquivo pokemon.sql está presente.
- Acesse o phpMyAdmin (ou outro gerenciador de banco de dados).
- Vá para a aba Importar e selecione o arquivo pokemon.sql dessa pasta.
- Clique em "Executar" para importar as tabelas e dados no banco de dados.

