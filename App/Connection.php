<?php

namespace App;

use Exception;
use MiniFramework\Controller\Debug;

class Connection {

    /**
     * @method getDb() Realiza a conexão com o serviço de banco de dados
     * @return object Objeto PDO contendo os parâmetros da conexão
     * @return boolean False caso não seja possível se conectar ao banco de dados
     */
    public static function getDb() {

        try {

            $file = 'config/database.ini';
            $ini = parse_ini_file($file, true);
			$a = $ini['database'];

			try {
				$v = $ini['utilize'];
				if (!$v['utilize_db']) {
					return null;
				}
			} catch(Exception $e){
				// continue
			}

            $config = "mysql:host={$a['host']};dbname={$a['database']}";
            $config.= (isset($a['collation'])) ? ";charset={$a['collation']}":'';

            $conn = new \PDO(
                $config,
                $a['username'], $a['password']
            );

            return $conn;

        } catch (\PDOException $e) {

            Debug::show('Não foi possível se conectar ao serviço de banco de dados.', false);
            return false;
        }

    }
}
