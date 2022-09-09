<?php
    class Estoque {

        private $pdo;

        public function __construct($dbname, $host, $user, $senha)
        {
            try
            {
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
            }
            catch(PDOException $e) {
                echo "Erro banco de dados".$e->getMessage();
                exit();
            }
            catch(Exception $e) {
                echo "Erro ".$e->getMessage();
                exit();
            }
            
        }
        public function buscarDados()
        {
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM estoque ORDER BY produto");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        public function cadastrarProduto($produto, $quantidade, $data_c) 
        {
            //verificar produto cadastrado
            $cmd = $this->pdo->prepare("SELECT id FROM estoque WHERE produto = :p");
            $cmd->bindValue(":p",$produto);
            $cmd->execute();
            if($cmd->rowCount() > 0) {
                return false;
            }else {
                $cmd = $this->pdo->prepare("INSERT INTO estoque (produto, quantidade, data_c) VALUES (:p, :q, :d) ");
                $cmd->bindValue(":p",$produto);
                $cmd->bindValue(":q",$quantidade);
                $cmd->bindValue(":d",$data_c);
                $cmd->execute();
                return true;
            }
        }
        public function excluirProduto($id) 
        {
            $cmd = $this->pdo->prepare("DELETE FROM estoque WHERE id = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        }
        public function buscarDadosProduto($id)
        {
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM estoque WHERE id = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $res= $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
        public function atualizar($id, $produto, $quantidade, $data_c)       
        {
            
            $cmd = $this->pdo->prepare("UPDATE estoque set produto = :p, quantidade = :q, data_c = :d WHERE id= :id");
            $cmd->bindValue(":p",$produto);
            $cmd->bindValue(":q",$quantidade);
            $cmd->bindValue(":d",$data_c);
            $cmd->bindValue(":id",$id);
            $cmd->execute();
            
        }
    }

