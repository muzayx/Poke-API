<h1>Poke API 🔎</h1>
<p>Uma API desenvolvida por mim e outros integrantes do meu grupo, que faz a busca de pokemons, e devolve suas respectivas informações.</p>

<h1>Como usar?</h1>
<h3>1. Configuração da Conexão com o Banco de Dados</h3>

<p>Abra o arquivo bdconnecta.php e localize a seguinte linha:</p>

```
$conn = mysqli_connect("localhost", "root", "", "22092");
```
> [!TIP]
> <p>Primeiro campo: Substitua "localhost" pelo nome do servidor (normalmente, é localhost)</p>
> Segundo campo: Substitua "root" pelo usuário do banco de dados.
> Terceiro campo: Substitua a senha conforme necessário (se não houver senha, deixe em branco).
> Quarto campo: Substitua "22092" pelo nome do banco de dados que você deseja usar.

