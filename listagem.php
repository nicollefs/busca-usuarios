<?php
require('db/conexao.php');

$sql = $pdo->prepare("SELECT * FROM usuarios");
$sql->execute();
$dados = $sql->fetchAll();

$totalRecords = count($dados);
$limit = 5; 
$totalPages = ceil($totalRecords / $limit);

?>
<!DOCTYPE html>
<html lang="pt-br">  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo-listagem.css">
    <title>Listagem de usuários PHP</title>
    <style>
        table{
            border-collapse: collapse;
            width:100%;
        }
        th,td{
            padding:10px;
            text-align:center;
            border:1px solid #ccc;
        }

        th:nth-child(1), td:nth-child(1) { width: 20%; }
        th:nth-child(2), td:nth-child(2) { width: 20%; }
        th:nth-child(3), td:nth-child(3) { width: 20%; }
        th:nth-child(4), td:nth-child(4) { width: 20%; }
        th:nth-child(5), td:nth-child(5) { width: 20%; }

    </style>
</head>
<body>
    <nav class="navbar-php">
        <div class="logo-php">
            <h1>Usuários</h1>
            <img style="max-width: 60% ;margin-left: 5px;" src="img-listagem/logo-ag.png">
        </div>
        <div class="menu-php">
            <a id="botao-php" href="/usuarios-php/index.php">Voltar ao início</a>
        </div>
    </nav>
    <div class="search-box">
        <img style="max-width: 6%; padding-left: 2%;" src="img-listagem/loupe.png" alt="Lupa">
        <input type="text" id="busca" placeholder="Pesquisar nome...">
    </div>
<div class="tabela">
    <table>
        <tr>
            <th>ID da Loja</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Categoria</th>
            <th>Função</th>
        </tr>
        <tbody id='MinhaTabela'>
        </tbody>
    </table>
    <div id='paginacao'>
        <?php
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='#' class='pagina' data-page='".$i."'>".$i."</a> ";
        }
        ?>
    </div>
    <p id="totalUsuarios">Total de <?php echo $totalRecords; ?> usuários encontrados</p>
</div>    
<footer>
        <div class="logo-rodape-php">
            <h1 class="usuarios-php">Usuários AutoGestor</h1>
            <p style="color: white; padding-top: 21px; padding-bottom: 15px;">Site fantasia AG</p>
        </div>
        <b style="color: white; padding-top= 20px;">©Todos os direitos reservados</b>
</footer>
<script src="js/jquery-3.7.1.js"></script>
<script>
    $(document).ready(function (){
        var dadosOriginais = <?php echo json_encode($dados); ?>; 
        var dados = dadosOriginais.slice(); 
        var limit = 5; 
        var page = 1; 

        function renderTable() {
            var start = (page - 1) * limit;
            var end = start + limit;
            var dadosPagina = dados.slice(start, end); 
            $('#MinhaTabela').empty();

            $.each(dadosPagina, function(i, dado) {
                $('#MinhaTabela').append('<tr><td>' + dado.id_loja + '</td><td>' + dado.nome + '</td><td>' + dado.email + '</td><td>' + dado.categoria + '</td><td>' + dado.funcao + '</td></tr>');
            });
        }

        $('#busca').on('keyup', function (){
            var valor = $(this).val().toLowerCase();

            if (valor) {
                var dadosFiltrados = dadosOriginais.filter(function(dado){
                    return dado.nome.toLowerCase().indexOf(valor) > -1;
                });

                dados = dadosFiltrados;
            } else {
                dados = dadosOriginais.slice();
            }

            renderTable();
        });

        $('.pagina').on('click', function(e) {
            e.preventDefault();
            page = $(this).data('page'); 
            renderTable(); 
        });

        renderTable(); 
    });
</script>
</body>
</html>