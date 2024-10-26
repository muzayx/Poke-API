<h1>Poke API 🔎</h1>
<p>Uma API que desenvolvi em colaboração com outros membros do meu grupo, projetada para buscar Pokémon e retornar suas informações detalhadas.</p>

<h1>Como usar?</h1>
<h3>1. Configuração da Conexão com o Banco de Dados</h3>

<p>Abra o arquivo bdconnecta.php e localize a seguinte linha:</p>

```
$conn = mysqli_connect("localhost", "root", "", "22092");
```
> [!Tip]
> <p>Primeiro campo: Substitua "localhost" pelo nome do servidor (normalmente, é localhost)</p>
> <p>Segundo campo: Substitua "root" pelo usuário do banco de dados</p>
> <p>Terceiro campo: Substitua a senha conforme necessário (se não houver senha, deixe em branco)</p>
> <p>Quarto campo: Substitua "22092" pelo nome do banco de dados que você deseja usar</p>

<h3>2. Configuração do Ambiente</h3>

<p>Mova todos os arquivos do projeto para um ambiente de desenvolvimento PHP que suporte interação com o banco de dados, como Laragon, XAMPP, ou outro servidor local de sua escolha.</p>

<h3>3. Importando o Banco de Dados</h3>

- Navegue até a pasta pokemon/db/ e verifique se o arquivo pokemon.sql está presente.
- Acesse o phpMyAdmin (ou outro gerenciador de banco de dados).
- Vá para a aba Importar e selecione o arquivo pokemon.sql dessa pasta.
- Clique em "Executar" para importar as tabelas e dados no banco de dados.

<h3>4. Iniciando o Aplicativo</h3>

<p>Após configurar o banco de dados e o ambiente, o aplicativo estará pronto para ser utilizado.</p>
