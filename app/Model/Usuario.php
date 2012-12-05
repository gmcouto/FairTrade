<?php
class Usuario extends AppModel
{
    var $useTable = "USUARIOS";
    var $primaryKey = 'ID_USUARIO';
    var $displayField = 'LOGIN';
    public $actsAs = array('Containable');

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields['NOTA'] = sprintf("IFNULL((SELECT AVG(RANKING_USUARIOS.NOTA) FROM RANKING_USUARIOS WHERE RANKING_USUARIOS.ID_USUARIO_AVALIADO = %s.ID_USUARIO),-1)", $this->alias);
    }

    public $validate = array(
        'NOME' => array(
            'nome_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter um nome!')
            ),
        'LOGIN' => array(
            'login_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter um login!'),
            'login_alpha_numeric' => array('rule'=> 'alphaNumeric','message' => 'Login precisa ser alfa-numérico!'),
            'login_unique' => array('rule'=> 'isUnique','message' => 'Esse login já existe!')
            ),
       'SENHA' => array(
            'senha_min_length' => array('rule'=> array('minLength', 6),'message' => 'O tamanho mínimo da senha é de 6 caracteres!')
            ),
       'SENHA_CONFIRMA' => array(
            'senha_confirma_2' => array('rule'=> array('identicalFieldValues', 'SENHA'),'message' => 'A confirmação de senha está errada!')
            ),
        'TELEFONE' => array(
            'telefone_not_empty' => array('rule'=> 'notEmpty','message' => 'Você precisa ter um telefone!')
            )
    );

    public $hasOne = array(
    	'EnderecoUsuario' => array(
    		'className'    => 'EnderecoUsuario',
    		'foreignKey' => 'ID_USUARIO',
    		'dependent'    => true
    		)
    	);

    public $hasMany = array(
    	'AvaliacoesFeitas' => array(
    		'className'    => 'RankingUsuario',
    		'foreignKey' => 'ID_USUARIO_AVALIADOR',
    		'dependent'    => true
    		),
    	'AvaliacoesRecebidas' => array(
    		'className'    => 'RankingUsuario',
    		'foreignKey' => 'ID_USUARIO_AVALIADO',
    		'dependent'    => true
    		),
        'TrocasFeitas' => array(
            'className'    => 'HistoricoTroca',
            'foreignKey' => 'ID_USUARIO_A',
            'dependent'    => true
            ),
        'TrocasRecebidas' => array(
            'className'    => 'HistoricoTroca',
            'foreignKey' => 'ID_USUARIO_B',
            'dependent'    => true
            )
    );

    public $hasAndBelongsToMany = array(
            'Quero' =>
                array(
                    'className'              => 'Livro',
                    'with'                   => 'UsuarioQuerLivro',
                    'joinTable'              => 'QUER',
                    'foreignKey'             => 'ID_USUARIO',
                    'associationForeignKey'  => 'ID_LIVRO',
                    'unique'                 => true
                ),
            'Tenho' =>
                array(
                    'className'              => 'Livro',
                    'with'                   => 'UsuarioTemLivro',
                    'joinTable'              => 'TEM',
                    'foreignKey'             => 'ID_USUARIO',
                    'associationForeignKey'  => 'ID_LIVRO',
                    'unique'                 => true
                )
        );

    public function lista_quero($id_user)
    {
        return $this->Quero->find(
            'list',
            array(
                'fields' => array('QUER.ID_LIVRO'),
                'conditions' => array(
                    'QUER.ID_USUARIO' => $id_user
                    ),
                'joins' => array(
                    array(
                        'table' => 'QUER',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Quero.ID_LIVRO = QUER.ID_LIVRO'
                            )
                        )
                    )
            )
        );
    }

    public function lista_tenho($id_user)
    {
        return $this->Tenho->find(
            'list',
            array(
                'fields' => array('TEM.ID_LIVRO'),
                'conditions' => array(
                    'TEM.ID_USUARIO' => $id_user
                    ),
                'joins' => array(
                    array(
                        'table' => 'TEM',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Tenho.ID_LIVRO = TEM.ID_LIVRO'
                            )
                        )
                    )
            )
        );
    }

    public function melhores($id_user){
        $livros_quero = $this->lista_quero($id_user);
        $livros_tenho = $this->lista_tenho($id_user);
        $this->recursive=-1;
        //$this->Deseja->contain();
        return $this->find(
            'all',
            array(
                'contain' => array(
                    'Quero' => array(
                        'Assunto',
                        'conditions' => array('Quero.ID_LIVRO'=>$livros_tenho)
                        ),
                    'Tenho'=> array(
                        'Assunto',
                        'conditions' => array('Tenho.ID_LIVRO'=>$livros_quero)
                        )
                    ),
                'conditions' => array(
                    'Usuario.BL_ATIVO' => 1,
                    'QUER.ID_LIVRO' => $livros_tenho,
                    'TEM.ID_LIVRO' => $livros_quero
                    ),
                'joins' => array(
                    array(
                        'table' => 'TEM',
                        'type' => 'INNER',
                        'conditions' => array(
                            'TEM.ID_USUARIO = Usuario.ID_USUARIO'
                            )
                        ),
                    array(
                        'table' => 'QUER',
                        'type' => 'INNER',
                        'conditions' => array(
                            'QUER.ID_USUARIO = Usuario.ID_USUARIO'
                            )
                        )
                    ),
                'order' => array('Usuario.NOTA DESC'),
                'group' => array('Usuario.ID_USUARIO')
            )
        );
    }

    public function bestDeseja($id_livro){
        //debug($this);
        $this->recursive=0;
        //$this->Deseja->contain();
        return $this->find(
            'all',
            array(
                'contain' => array('Deseja'),
                'conditions' => array(
                    'LivroUsuario.BL_DESEJA' => 1
                    ),
                'joins' => array(
                    array(
                        'table' => 'LIVRO_USUARIOS',
                        'alias' => 'LivroUsuario',
                        'type' => 'INNER',
                        'conditions' => array(
                            'LivroUsuario.ID_USUARIO = Usuario.ID_USUARIO'
                            )
                        )
                    ),
                'order' => array('Usuario.NOTA DESC'),
            )
        );
    }

    public function beforeSave($options = array()) {
        //debug($this);
        // if (isset($this->data[$this->alias]['SENHA'])) {
        //     $this->data[$this->alias]['SENHA'] = AuthComponent::password($this->data[$this->alias]['SENHA']);
        // }
        return true;
    }

    public function identicalFieldValues( $field=array(), $compare_field=null )  
    { 
        foreach( $field as $key => $value ){ 
            $v1 = $value; 
            $v2 = $this->data[$this->name][ $compare_field ];                  
            if(isset($v2) && $v1 !== $v2) { 
                return FALSE; 
            } else { 
                continue; 
            } 
        } 
        return TRUE; 
    }

    public function getEndereco($id_usuario){
        return $this->EnderecoUsuario->find('first',array('conditions'=>array('ID_USUARIO'=>$id_usuario)));
    }

    public function temEndereco($id_usuario){
        return $this->EnderecoUsuario->find('count',array('conditions'=>array('ID_USUARIO'=>$id_usuario)))>0;
    }
}