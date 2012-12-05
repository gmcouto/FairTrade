<?php
class EnderecoUsuario extends AppModel
{
    var $useTable = "ENDERECO_USUARIOS";
    var $primaryKey = 'ID_ENDERECO_USUARIO';

    public $belongsTo = array(
    	'Usuario' => array(
    		'className'    => 'Usuario',
    		'foreignKey' => 'ID_USUARIO',
    		'dependent'    => false
    		)
    	);

    public $validate = array(
        'DS_ENDERECO' => array(
            'endereco_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter um endereço!')
            ),
        'DS_BAIRRO' => array(
            'bairro_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter um bairro!')
            ),
        'NR_CEP' => array(
            'cep_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter um CEP!')
            ),
        'DS_CIDADE' => array(
            'cidade_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter uma cidade!')
            ),
        'UF' => array(
            'uf_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter um estado!')
            )
    );
}