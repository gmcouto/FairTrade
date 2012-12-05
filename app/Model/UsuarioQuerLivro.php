<?php
class UsuarioQuerLivro extends AppModel
{
    var $useTable = "QUER";
    var $primaryKey = 'ID_QUER';
    public $actsAs = array('Containable');
}