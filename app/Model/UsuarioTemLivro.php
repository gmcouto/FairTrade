<?php
class UsuarioTemLivro extends AppModel
{
    var $useTable = "TEM";
    var $primaryKey = 'ID_TEM';
    public $actsAs = array('Containable');
}