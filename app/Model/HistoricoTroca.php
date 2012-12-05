<?php
class HistoricoTroca extends AppModel
{
    var $useTable = "HISTORICO_TROCAS";
    var $primaryKey = 'ID_HISTORICO_TROCA';

  	public $belongsTo = array(
    	'UsuarioA' => array(
    		'className'    => 'Usuario',
    		'foreignKey' => 'ID_USUARIO_A',
    		'dependent'    => false
    		),
    	'UsuarioB' => array(
    		'className'    => 'Usuario',
    		'foreignKey' => 'ID_USUARIO_B',
    		'dependent'    => false
    		),
    	'LivroA' => array(
    		'className'    => 'Livro',
    		'foreignKey' => 'ID_LIVRO_A',
    		'dependent'    => false
    		),
    	'LivroB' => array(
    		'className'    => 'Livro',
    		'foreignKey' => 'ID_LIVRO_B',
    		'dependent'    => false
    		)
    	);

    public function historico($id_user){
        return $this->find(
            'all',
            array(
                'contain' => array(
                    'LivroA' => array(
                        'Assunto',
                        ),
                    'LivroB'=> array(
                        'Assunto',
                        ),
                    'UsuarioA',
                    'UsuarioB',
                    ),
                'conditions' => array(
                	'OR' => array(
                		'HistoricoTroca.ID_USUARIO_A'=>$id_user,
                		'HistoricoTroca.ID_USUARIO_B'=>$id_user
                		)
                    ),
                // 'joins' => array(
                //     array(
                //         'table' => 'TEM',
                //         'type' => 'INNER',
                //         'conditions' => array(
                //             'TEM.ID_USUARIO = Usuario.ID_USUARIO'
                //             )
                //         ),
                //     array(
                //         'table' => 'QUER',
                //         'type' => 'INNER',
                //         'conditions' => array(
                //             'QUER.ID_USUARIO = Usuario.ID_USUARIO'
                //             )
                //         )
                //     ),
                'order' => array('HistoricoTroca.DATA_TROCA DESC')
                // 'group' => array('Usuario.ID_USUARIO')
            )
        );
    }
}