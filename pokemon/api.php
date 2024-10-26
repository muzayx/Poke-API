<?php
    require('bdconnecta.php');
    
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');

    $request_method = $_SERVER["REQUEST_METHOD"];

    $id = (isset($_GET['id']) ? $_GET['id'] : '');
    $nome = (isset($_GET['nome']) ? $_GET['nome'] : '');
    $altura = (isset($_GET['altura']) ? $_GET['altura'] : '');
    $peso = (isset($_GET['peso']) ? $_GET['peso'] : '');
    $tipo1 = (isset($_GET['tipo1']) ? $_GET['tipo1'] : '');
    $tipo2 = (isset($_GET['tipo2']) ? $_GET['tipo2'] : '');
    $fraquezas = (isset($_GET['fraquezas']) ? $_GET['fraquezas'] : '');
    $geracao = (isset($_GET['geracao']) ? $_GET['geracao'] : '');
    $regiao = (isset($_GET['regiao']) ? $_GET['regiao'] : '');
    $delete = (isset($_GET['delete']) ? $_GET['delete'] : '');
    $ordenarPor = (isset($_GET['ordenar']) ? $_GET['ordenar'] : 'id');
    $ordenarDirecao = (isset($_GET['direcao']) ? strtolower($_GET['direcao']) : 'asc');
    
    switch ($request_method) {
        case ('GET'):
            $colunas = [];
            $variaveis = [];
            $tipos = [];

            if ($delete) {
                $id = intval($delete);
                if ($id > 0) {
                    deletarPoke($id);
                } else {
                    $json = (json_encode(['status' => 'error', 'message' => 'ID inválido.'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    echo ($json);
                }
            } else {
                $colunas = [];
                $variaveis = [];
                $tipos = [];

                if ($id) {
                    $colunas[] = "id = ?";
                    $variaveis[] = $id;
                    $tipos[] = "i";
                }
                if ($nome) {
                    $colunas[] = "nome LIKE ?";
                    $variaveis[] = $nome . '%';
                    $tipos[] = "s";
                }
                if ($altura) {
                    $colunas[] = "altura = ?";
                    $variaveis[] = $altura;
                    $tipos[] = "d";
                }
                if ($peso) {
                    $colunas[] = "peso = ?";
                    $variaveis[] = $peso;
                    $tipos[] = "d";
                }
                if ($tipo1) {
                    $colunas[] = "tipo1 = ?";
                    $variaveis[] = $tipo1;
                    $tipos[] = "s";
                }
                if ($tipo2) {
                    $colunas[] = "tipo2 = ?";
                    $variaveis[] = $tipo2;
                    $tipos[] = "s";
                }
                if ($fraquezas) {
                    $colunas[] = "fraquezas LIKE ?";
                    $variaveis[] = '%' . $fraquezas . '%';
                    $tipos[] = "s";
                }
                if ($geracao) {
                    $colunas[] = "geracao = ?";
                    $variaveis[] = $geracao;
                    $tipos[] = "i";
                }
                if ($regiao) {
                    $colunas[] = "regiao = ?";
                    $variaveis[] = $regiao;
                    $tipos[] = "s";
                }

                $ordenarPor = in_array($ordenarPor, ['id', 'nome', 'altura', 'peso', 'geracao']) ? $ordenarPor : 'id';
                $ordenarDirecao = $ordenarDirecao === 'desc' ? 'DESC' : 'ASC';
                $ordenacao = "ORDER BY $ordenarPor $ordenarDirecao";

                if (!empty($colunas)) {
                    selectDados($colunas, $variaveis, $tipos, $ordenacao);
                } else {
                    selectAll($ordenacao);
                }
            }
            break;
        case ('POST'):
            criarPokemon();
            break;
        case ('PUT'):
            atualizarPokemon();
            break;
        case ('DELETE'):
            deletarPokemon();
            break;
        default:
            header("HTTP/1.1 405 Method Not Allowed");
            header("Allow: GET, POST, PUT, DELETE");
            $json = (json_encode(['status' => 'error', 'message' => 'Método não permitido'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
            break;
    }

    function selectAll($ordenacao = "") {
        global $conn;
        $sql = ("SELECT id, nome, altura, peso, tipo1, tipo2, fraquezas, pre_evolucao, evolucao, genero, geracao, regiao, imagem_url FROM pokemon 
        $ordenacao");
        $stmt = (mysqli_prepare($conn, $sql));
        if (!$stmt) {
            $json = (json_encode(['status' => 'error', 'message' => 'Falha na preparação da consulta SQL'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        if (!mysqli_stmt_execute($stmt)) {
            $json = (json_encode(['status' => 'error', 'message' => 'Falha ao executar a consulta'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        mysqli_stmt_bind_result($stmt, $id, $nome, $altura, $peso, $tipo1, $tipo2, $fraquezas, $pre_evolucao, $evolucao, $genero, $geracao, 
        $regiao, $imagem_url);
        $pokemon = [];
        while (mysqli_stmt_fetch($stmt)) {
            $pokemon[] = [
                'id' => $id,
                'nome' => $nome,
                'altura' => $altura,
                'peso' => $peso,
                'tipo1' => $tipo1,
                'tipo2' => $tipo2,
                'fraquezas' => $fraquezas,
                'pre_evolucao' => $pre_evolucao,
                'evolucao' => $evolucao,
                'genero' => $genero,
                'geracao' => $geracao,
                'regiao' => $regiao,
                'imagem_url' => $imagem_url
            ];
        }
        if (count($pokemon) > 0) {
            $json = (json_encode($pokemon, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $json = (str_replace('\\/', '/', $json));
            echo($json);
        } else {
            header("HTTP/1.1 404 Not Found");
            $json = (json_encode(['status' => 'error', 'message' => 'Pokémon não encontrado'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);   
        }
        mysqli_stmt_close($stmt);
    }

    function selectDados($colunas, $variaveis, $tipos, $ordenacao) {
        global $conn;
        $condicoes = implode(" AND ", $colunas);
        $sql = ("SELECT id, nome, altura, peso, tipo1, tipo2, fraquezas, pre_evolucao, evolucao, genero, geracao, regiao, imagem_url 
                FROM pokemon 
                WHERE $condicoes $ordenacao");
        $stmt = (mysqli_prepare($conn, $sql));
        if (!$stmt) {
            $json = (json_encode(['status' => 'error', 'message' => 'Falha na preparação da consulta SQL'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        if (!empty($variaveis)) {
            mysqli_stmt_bind_param($stmt, implode('', $tipos), ...$variaveis);
        }
        if (!mysqli_stmt_execute($stmt)) {
            $json = (json_encode(['status' => 'error', 'message' => 'Falha ao executar a consulta'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        mysqli_stmt_bind_result($stmt, $id, $nome, $altura, $peso, $tipo1, $tipo2, $fraquezas, $pre_evolucao, $evolucao, 
        $genero, $geracao, $regiao, $imagem_url);
        $pokemon = [];
        while (mysqli_stmt_fetch($stmt)) {
            $pokemon[] = [
                'id' => $id,
                'nome' => $nome,
                'altura' => $altura,
                'peso' => $peso,
                'tipo1' => $tipo1,
                'tipo2' => $tipo2,
                'fraquezas' => $fraquezas,
                'pre_evolucao' => $pre_evolucao,
                'evolucao' => $evolucao,
                'genero' => $genero,
                'geracao' => $geracao,
                'regiao' => $regiao,
                'imagem_url' => $imagem_url
            ];
        }
        if (count($pokemon) > 0) {
            $json = (json_encode($pokemon, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $json = (str_replace('\\/', '/', $json));
            echo($json);
        } else {
            header("HTTP/1.1 404 Not Found");
            $json = (json_encode(['status' => 'error', 'message' => 'Pokémon não encontrado'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo ($json);
        }
        mysqli_stmt_close($stmt);
    }

    function deletarPoke($id) {
        global $conn;
        $sql = ("SELECT nome FROM pokemon WHERE id = ?");
        $stmt = (mysqli_prepare($conn, $sql));
        if (!$stmt) {
            $json = (json_encode(['status' => 'error', 'message' => 'Falha na preparação da consulta SQL'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $nome);
        mysqli_stmt_fetch($stmt);
        if ($nome) {
            mysqli_stmt_close($stmt);
            $sql = ("DELETE FROM pokemon WHERE id = ?");
            $stmt = (mysqli_prepare($conn, $sql));
            if (!$stmt) {
                $json = (json_encode(['status' => 'error', 'message' => 'Falha na preparação da consulta SQL'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            }
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                $json = (json_encode(['status' => 'success', 'message' => 'Pokémon excluído com sucesso', 'id' => $id, 'nome' => $nome], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            } else {
                $json = (json_encode(['status' => 'error', 'message' => 'Falha ao excluir Pokémon'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            } 
        } else {
            $json = (json_encode(['status' => 'error', 'message' => 'Pokémon não encontrado'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        mysqli_stmt_close($stmt);
    }

    function criarPokemon() {
        global $conn;
        $input = (json_decode(file_get_contents('php://input'), true));
        if (isset($input['id'], $input['nome'], $input['altura'], $input['peso'], $input['tipo1'], $input['fraquezas'], $input['genero'], 
        $input['geracao'], $input['regiao'], $input['imagem_url'])) {
            $sql = ("INSERT INTO pokemon (id, nome, altura, peso, tipo1, tipo2, fraquezas, pre_evolucao, evolucao, genero, geracao, 
            regiao, imagem_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt = (mysqli_prepare($conn, $sql));
            if (!$stmt) {
                $json = (json_encode(['status' => 'error', 'message' => 'Falha na preparação da consulta SQL'], 
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            }
            $tipo2 = (isset($input['tipo2']) && $input['tipo2'] !== '' ? $input['tipo2'] : NULL);
            $pre_evolucao = (isset($input['pre_evolucao']) && $input['pre_evolucao'] !== '' ? $input['pre_evolucao'] : NULL);
            $evolucao = (isset($input['evolucao']) && $input['evolucao'] !== '' ? $input['evolucao'] : NULL);
            mysqli_stmt_bind_param($stmt, "isddsssssssss",
                $input['id'],
                $input['nome'],
                $input['altura'],
                $input['peso'],
                $input['tipo1'],
                $tipo2,
                $input['fraquezas'],
                $pre_evolucao,
                $evolucao,
                $input['genero'],
                $input['geracao'],
                $input['regiao'],
                $input['imagem_url']
            );
            if (!mysqli_stmt_execute($stmt)) {
                $json = (json_encode(['status' => 'error', 'message' => 'Falha ao executar a consulta'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            }
            $json = (json_encode(['status' => 'success'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        } else {
            header("HTTP/1.1 400 Bad Request");
            $json = (json_encode(['status' => 'error', 'message' => 'Dados insuficientes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        mysqli_stmt_close($stmt);
    }

    function atualizarPokemon() {
        global $conn;
        $input = (json_decode(file_get_contents('php://input'), true));

        if (isset($input['id'], $input['nome'], $input['altura'], $input['peso'], $input['tipo1'], $input['fraquezas'], $input['genero'], $input['geracao'], 
        $input['regiao'], $input['imagem_url']) && !empty($input['id']) && !empty($input['nome']) && !empty($input['altura']) && !empty($input['peso']) && 
        !empty($input['tipo1']) && !empty($input['fraquezas']) && !empty($input['genero']) && !empty($input['geracao']) && !empty($input['regiao']) && 
        !empty($input['imagem_url'])) {
            $sql = ("UPDATE pokemon SET 
                    nome = ?, 
                    altura = ?, 
                    peso = ?, 
                    tipo1 = ?, 
                    tipo2 = ?, 
                    fraquezas = ?, 
                    pre_evolucao = ?, 
                    evolucao = ?, 
                    genero = ?, 
                    geracao = ?, 
                    regiao = ?, 
                    imagem_url = ? 
                    WHERE id = ?");
            $stmt = (mysqli_prepare($conn, $sql));
            if (!$stmt) {
                $json = (json_encode(['status' => 'error', 'message' => 'Falha na preparação da consulta SQL'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            }
            $tipo2 = (isset($input['tipo2']) && $input['tipo2'] !== '' ? $input['tipo2'] : NULL);
            $pre_evolucao = (isset($input['pre_evolucao']) && $input['pre_evolucao'] !== '' ? $input['pre_evolucao'] : NULL);
            $evolucao = (isset($input['evolucao']) && $input['evolucao'] !== '' ? $input['evolucao'] : NULL);
            mysqli_stmt_bind_param($stmt, "sddssssssissi", 
                $input['nome'],
                $input['altura'],
                $input['peso'],
                $input['tipo1'],
                $tipo2,
                $input['fraquezas'],
                $pre_evolucao,
                $evolucao,
                $input['genero'],
                $input['geracao'],
                $input['regiao'],
                $input['imagem_url'],
                $input['id']
            );
            if (!mysqli_stmt_execute($stmt)) {
                $json = (json_encode(['status' => 'error', 'message' => 'Falha ao executar a consulta'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            } else {
                $json = (json_encode(['status' => 'success'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo($json);
            }      
        } else {
            header("HTTP/1.1 400 Bad Request");
            $json = (json_encode(['status' => 'error', 'message' => 'Dados insuficientes ou campos vazios'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo($json);
        }
        mysqli_stmt_close($stmt);
    }

    function deletarPokemon() {
        global $conn;
        $id = (isset($_GET['id']) ? intval($_GET['id']) : null);
        if ($id !== null) {
            $sql = "SELECT nome FROM pokemon WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $nome);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt); 
                $sql = ("DELETE FROM pokemon WHERE id = ?");
                $stmt = (mysqli_prepare($conn, $sql));
                mysqli_stmt_bind_param($stmt, 'i', $id);
                if (mysqli_stmt_execute($stmt)) {
                    $json = (json_encode(['status' => 'success', 'message' => 'Pokémon excluído com sucesso!', 'id' => $id, 'nome' => $nome], 
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    echo $json;
                } else {
                    $json = (json_encode(['status' => 'error', 'message' => 'Erro ao excluir Pokémon.'], 
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    echo $json;
                }
            } else {
                $json = (json_encode(['status' => 'error', 'message' => 'Pokémon não encontrado.'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo $json;
            }
            mysqli_stmt_close($stmt);
        } else {
            $json = (json_encode(['status' => 'error', 'message' => 'ID não fornecido.'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo $json;
        }
    }
    mysqli_close($conn);
?>
