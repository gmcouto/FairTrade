<?php
class Imagem extends AppModel
{
    var $useTable = "IMAGENS";
    var $primaryKey = 'ID_IMAGEM';
    var $displayField = "ID_LIVRO";

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //$this->virtualFields['DADOS'] = sprintf("'(DADOS)'");
    }

    public $belongsTo = array(
    	'Livro' => array(
    		'className'    => 'Livro',
    		'foreignKey' => 'ID_LIVRO',
    		'dependent'    => true
    		)
    	);
}