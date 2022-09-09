<?php
require_once 'class_estoque.php';
$p = new Estoque("estoque", "localhost", "root", "");
?>
<!doctype html>
<html lang="PT-BR">

<head>
    <title>Estoque</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Estoque dos Produtos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dados = $p->buscarDados();
                if (count($dados) > 0) {
                    for ($i = 0; $i < count($dados); $i++) {
                        echo '<tr>';
                        foreach ($dados[$i] as $k => $v) {
                            if ($k != "id") {
                                echo "<td>" . $v . "</td>";
                            }
                        }
                ?><td>
                            <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                            <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                        </td><?php
                                
                            }
                        } else {
                            echo "Não tem produto cadastrado";
                        }
                                ?>
                <?php
                if (isset($_POST['produto'])) {
                    //editar
                    if (isset($_GET['id_up']) && !empty($_GET['id_up'])) 
                    {
                        $id_up = addslashes($_GET['id_up']);
                        $produto = addslashes($_POST['produto']);
                        $quantidade = addslashes($_POST['quantidade']);
                        $data_c = addslashes($_POST['data_c']);
                        if (!empty($produto) && !empty($quantidade) && !empty($data_c)) 
                        {//atualiza
                            $p->atualizar($id_up, $produto, $quantidade, $data_c);
                            header('location: index.php');
                        } else {

                            echo 'Preencha todos os campos!';
                        }
                    }
                    //Cadastrar
                    else {
                        $produto = addslashes($_POST['produto']);
                        $quantidade = addslashes($_POST['quantidade']);
                        $data_c = addslashes($_POST['data_c']);
                        if (!empty($produto) && !empty($quantidade) && !empty($data_c)) {
                            if (!$p->cadastrarProduto($produto, $quantidade, $data_c)) {
                                echo "Produto ja cadastrado";
                                header('location: index.php');
                            }
                        } else {

                            echo 'Preencha todos os campos!';
                        }
                    }
                }
                ?>
                <?php
                if (isset($_GET['id_up'])) {
                    $id_updade = addslashes($_GET['id_up']);
                    $res = $p->buscarDadosProduto($id_updade);
                }
                ?>

                <tr>
                    <form method="POST">
                        <td>Cadastrar Produto</td>
                        <td><label for="produto">Produto:
                                <input type="text" name="produto" id="produto" value="<?php if (isset($res)) {
                                                                                            echo $res['produto'];
                                                                                        } ?>">
                            </label></td>
                        <td><label for="quantidade">Quantidade:
                                <input type="text" name="quantidade" id="quantidade" value="<?php if (isset($res)) {
                                                                                                echo $res['quantidade'];
                                                                                            } ?>">
                            </label></td>
                        <td><label for="data">Data:
                                <input type="date" name="data_c" id="data_c" value="<?php if (isset($res)) {
                                                                                        echo $res['data_c'];
                                                                                    } ?>">
                            </label></td>
                        <td><input type="submit" value="<?php if (isset($res)) {
                                                            echo "Atualizar";
                                                        } else {
                                                            echo "Cadastrar";
                                                        } ?>"></td>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
<?php
if (isset($_GET['id'])) {
    $id_produto = addslashes($_GET['id']);
    $p->excluirProduto($id_produto);
    header("location: index.php");
}
?>