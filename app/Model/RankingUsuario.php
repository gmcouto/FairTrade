<?php
class RankingUsuario extends AppModel
{
    var $useTable = "RANKING_USUARIOS";
    var $primaryKey = 'ID_RANKING_USUARIO';

    //var $recursive = -1;

    public $belongsTo = array(
		'AVALIADOR' => array(
			'className'    => 'Usuario',
			'foreignKey' => 'ID_USUARIO_AVALIADOR',
			'dependent'    => false
			),
		'AVALIADO' => array(
			'className'    => 'Usuario',
			'foreignKey' => 'ID_USUARIO_AVALIADO',
			'dependent'    => false
			)
	);
}