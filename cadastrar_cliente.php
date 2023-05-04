<?php
function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str);
}

if(count($_POST) > 0){
    include('conexao.php');
    //var_dump($_POST);
    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    
    if(empty($nome)){
        $erro = "Preencha o Nome";
    }
    if(empty($email) || !filter_var ($email, FILTER_VALIDATE_EMAIL)){
        $erro = "Preencha o Email";
    }

    if(!empty($nascimento)){
        $pedacos = explode('/', $nascimento);
        if(count($pedacos) == 3){
            $nascimento = implode ('-', array_reverse($pedacos));
        }else{
            $erro = "A data de nascimento deve seguir o padrão dia/mês/ano.";
        }
    }

    if(!empty($telefone)){
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11){
            $erro = "O telefone deve ser preenchido no padrão (85)98888-8888.";
        }
    }

    if($erro){
        echo"<p><b>ERRO: $erro</b></p>";
    }else{
        $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data)
        VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if($deu_certo){
            echo"<p><b>Cliente cadastrado com sucesso!!!</b></p>";
            unset($_POST);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>
<body>
    <a href="/clientes.php">Voltar para a lista</a>
    <h1>Cadastro de Clientes</h1>
    <form method="POST" action="">
        <p>
            <label>Nome:</label>
            <input name="nome" type="text"><br>
        </p>
        <p>
            <label>Email:</label>
            <input name="email" type="text"><br>
        </p>
        <p>
            <label>Telefone:</label>
            <input placeholder="(85)98888-8888" name="telefone" type="text"><br>
        </p>
        <p>
            <label>Data de Nascimento:</label>
            <input name="nascimento" type="text"><br>
        </p>
        <p>
            <button type="submit">Cadastrar</button>
        </p>
    </form>
</body>
</html>
