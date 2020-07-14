<?php

namespace MiniFramework\Model;

use MiniFramework\Controller\Debug; 

final class ModelOperations {

    private $pdo; 

    function __construct(\PDO $pdo) {
        $this->pdo = $pdo; 
    }

    /**
     * Retorna o resultado da query no Banco de Dados, na tabela especificada em parâmetro
     * @param string $table Tabela onde será executada a query
     * @param array $cols Array simples com as colunas desejadas
     * @return array Array associativo do conteúdo obtido do SELECT
     * @return boolean False caso haja erro ao executar a query
     */
    public function select($table, $cols = ['*']) {
        
        try {
            foreach ($cols as $key => $v) {
                if (!is_int($key)) {
                    throw new \Exception('Parâmetro $cols inválido. Espera array simples não associativo', 1);
                }
            }
            $columns = implode(', ', $cols); 
            $query = "SELECT $columns FROM $table"; 

            try {
                return $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC); 

            } catch (\PDOException $th) {

                throw new \Exception("Error query execute ::PDO", 1); 
            } catch (\Exception $e) {

                throw new \Exception("Error query execute", 1); 
            }

        } catch (\Throwable $th) {
            
            die("<p>$th</p>"); 
        }
        return []; 
        
    }
    /**
     * Retorna o resultado da query na tabela especificada obedecendo a cláusula WHERE
     * @param string $table Tabela onde será executada a query
     * @param array $args Clásula WHERE [coluna] => [valor]
     * @param array $cols Array simples com as colunas desejadas
     * @return array Array associativo do conteúdo filtrado obtido do SELECT com WHERE
     * @return false Boolean false caso haja erro na consulta ao banco de dados
     */
    public function select_where($table, $args, $cols = ['*']) {
    
        try {
            
            if(!is_array($args) || key_exists(0, $args)){
                $e = 'Parâmetro $args deve ser um array associativo [coluna_tabela] => [valor]'; 
            } else if(count($args) == 0) {
                $e = 'Se não houver argumentos utilize o método select'; 
            } else if(!is_array($cols) || !key_exists(0,$cols)) {
                $e = 'Parâmetro $cols deve ser um array simples não associativo'; 
            }

            if(isset($e) && !empty($e)){
                throw new \Exception($e, 7); 
            }
            
            $columns = implode(', ', $cols); 
            
            $query = "SELECT $columns FROM $table"; 
    
            $query.= ' WHERE '; 
            $loop = 1; 
            foreach ($args as $key => $value) {
                if($loop > 1){
                    $query.= ' AND '; 
                }
                $query.= (is_string($value)) ? "$key = '$value'" : "$key = $value"; 
                $loop++; 
            }
        
            return $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC); 
        
        } catch (\Throwable $th) {
            
            Debug::show("<b>Argumentos passados inválidos</b><p>$th</p>"); 
        
        } catch (\Exception $e) {
            return false; 
        } 
        
    }

}