<?php

namespace App\Model;

use MiniFramework\Model\Model;

class Mensagem extends Model {

	private $destino;
    private $assunto;
    private $mensagem;

    public function __construct() {

		$this->db = false;
		return true;
    }

    /**
     * Get the value of atribute
     */
    public function __get($atribute) {
        return $this->$atribute;
    }

    /**
     * Set the value of atribute
     *
     * @return  self
     */
    public function __set($atribute, $value) {
        $this->$atribute = $value;
    }

    public static function validarMensagem($destino, $assunto, $mensagem) {
        if (empty($destino)) {
            return false;
        }
        return true;
    }

}
