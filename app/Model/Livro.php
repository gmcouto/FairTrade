<?php
class Livro extends AppModel
{
    var $useTable = "LIVROS";
    var $primaryKey = 'ID_LIVRO';
    var $displayField = 'TITULO';

    public $actsAs = array('Containable');

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //$this->virtualFields['IMAGEM'] = sprintf("'BLOB'");
    }

    public $validate = array(
        'TITULO' => array(
            'titulo_not_empty' => array('rule'=> 'notEmpty','message' => 'O livro precisa ter um título!')
            ),
        'AUTOR' => array(
            'autor_not_empty' => array('rule'=> 'notEmpty','message' => 'O livro precisa ter um autor!')
            ),
        'EDITORA' => array(
            'editora_not_empty' => array('rule'=> 'notEmpty','message' => 'O livro precisa ter uma editora!')
            ),
        'VERSAO' => array(
            'versao_not_empty' => array('rule'=> 'notEmpty','message' => 'O livro precisa ter uma versão!')
            ),
        'ID_ASSUNTO' => array(
            'id_assunto_not_empty' => array('rule'=> 'notEmpty','message' => 'O livro precisa ter um assunto!')
            ),
        'IMAGEM.ARQUIVO' => array(
            'imagem_not_empty' => array('rule'=> 'notEmpty','message' => 'O livro precisa ter um assunto!')
            ),
    );

    public $belongsTo = array(
    	'Assunto' => array(
    		'className'    => 'Assunto',
    		'foreignKey' => 'ID_ASSUNTO',
    		'dependent'    => false
    		)
    	);

    public $hasOne = array(
        'Imagem' => array(
            'className'    => 'Imagem',
            'foreignKey' => 'ID_LIVRO',
            'dependent'    => true
            )
        );

    public $hasAndBelongsToMany = array(
            'Querem' =>
                array(
                    'className'              => 'Usuario',
                    'with'                   => 'UsuarioQuerLivro',
                    'joinTable'              => 'QUER',
                    'foreignKey'             => 'ID_LIVRO',
                    'associationForeignKey'  => 'ID_USUARIO',
                    'unique'                 => true
                ),
            'Teem' =>
                array(
                    'className'              => 'Usuario',
                    'with'                   => 'UsuarioTemLivro',
                    'joinTable'              => 'TEM',
                    'foreignKey'             => 'ID_LIVRO',
                    'associationForeignKey'  => 'ID_USUARIO',
                    'unique'                 => true
                ),
        );

    public function deletaQuer($id_livro, $user_id){
        return $this->UsuarioQuerLivro->deleteAll(array('ID_LIVRO'=>$id_livro,'ID_USUARIO'=>$user_id));
    }
    public function deletaTem($id_livro, $user_id){
        return $this->UsuarioTemLivro->deleteAll(array('ID_LIVRO'=>$id_livro,'ID_USUARIO'=>$user_id));
    }
    public function deletaTemEQuer($id_livro, $user_id){
        return $this->deletaQuer($id_livro, $user_id) && $this->deletaTem($id_livro, $user_id);
    }
    public function jaQuer($id_livro, $user_id){
        return $this->UsuarioQuerLivro->find('count',array('conditions'=>array('ID_LIVRO'=>$id_livro,'ID_USUARIO'=>$user_id)));
    }
    public function jaTem($id_livro, $user_id){
        return $this->UsuarioTemLivro->find('count',array('conditions'=>array('ID_LIVRO'=>$id_livro,'ID_USUARIO'=>$user_id)));
    } 
    public function jaTemOuQuer($id_livro, $user_id){
        return $this->jaQuer($id_livro, $user_id) || $this->jaTem($id_livro, $user_id);
    }
}