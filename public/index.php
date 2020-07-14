<?php

/**
 * Arquivo inicial do projeto
 * As requisições do PHP acontecem a partir daqui
 * Toda chamada de links externos devem considerar que partirão deste diretório
 */

/* Caso seja necessário enibir exibição de erros padrão do PHP */
// ini_set('error_reporting', 'E_STRICT'); 

require_once '../vendor/autoload.php'; 

/* Instância do sistema de rotas de rotas da aplicação */
$route = new \App\Route; 
