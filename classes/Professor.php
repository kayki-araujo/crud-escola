<?php

/**
 * Esta classe representa a tabela 'professor' no banco de dados
 * @author Kayki Garcia de Araujo
 * @version 1.0
 * @access public
 */
class Professor {
    /**
     * Representa a coluna 'codigo'
     * @access private
     * @name codigo 
     */
    private $codigo;

    /**
     * Representa a coluna 'nome'
     * @access private
     * @name codigo 
     */
    private $nome;

    /**
     * Insere valores nos parametros da classe
     * @access public
     * @name setProfessor
     * @param Int $codigo Codigo do Professor
     * @param String $nome Nome do Professor
     * @return void
     */
    public function setProfessor($codigo, $nome) {
        $this->codigo = $codigo;
        $this->nome = $nome;
    }

    /**
     * Retorno codigo do professor
     * @access public
     * @name getCodigo
     * @return Int codigo
     */
    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function salvar() {
        try {
            $db = Database::conexao();
            if (empty($this->codigo)) {
                $stm = $db->prepare("INSERT INTO professor (nome) VALUES (:nome)");
                $stm->execute(array(":nome" => $this->getNome()));
            } else {
                $stm = $db->prepare("UPDATE professor SET nome=:nome WHERE codigo=:codigo");
                $stm->execute(array(":nome" => $this->nome, ":codigo" => $this->codigo));
            }
            #ppegar o id do registro no banco de dados
            #setar o id do objeto
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage() . "<br>";
            return false;
        }
        return true;
    }

    public function delete() {
    }

    public static function listar() {
        $db = Database::conexao();
        $professores = null;
        $retorno = $db->query("SELECT * FROM professor");
        while ($item = $retorno->fetch(PDO::FETCH_ASSOC)) {
            $professor = new Professor();
            $professor->setProfessor($item['codigo'], $item['nome']);

            $professores[] = $professor;
        }

        return $professores;
    }


    public static function getProfessor($codigo) {
        $db = Database::conexao();
        $retorno = $db->query("SELECT * FROM professor WHERE codigo= $codigo");
        if ($retorno) {
            $item = $retorno->fetch(PDO::FETCH_ASSOC);
            $professor = new Professor();
            $professor->setProfessor($item['codigo'], $item['nome']);
            return $professor;
        }
        return false;
    }

    public static function excluir($codigo) {
        $db = Database::conexao();
        $professor = null;
        if ($db->query("DELETE FROM professor WHERE codigo=$codigo")) {
            return true;
        }
        return false;
    }
}