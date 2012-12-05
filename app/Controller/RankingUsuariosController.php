<?php
class RankingUsuariosController extends AppController {
	public $modelClass = "RankingUsuario";

	public $helpers = array('Html', 'Form');

	public $scaffold = "admin";
}