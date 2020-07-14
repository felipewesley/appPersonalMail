<?php

namespace MiniFramework\Model;

class Model {

    /**
     * @property object stdClass Contém métodos de operações referentes ao banco de dados
     */
    protected $db;

    public function __construct($pdo) {
		// Assinatura default is public function __construct(\PDO $pdo)

		if (is_null($pdo)) {
			return $this->db = $pdo;
		}

        return $this->db = new ModelOperations($pdo);
    }

}
