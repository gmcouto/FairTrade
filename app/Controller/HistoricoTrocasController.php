<?php
class HistoricoTrocasController extends AppController {
	public $modelClass = "HistoricoTroca";

	public $helpers = array('Html', 'Form');

	public $scaffold = "admin";


	public function index(){
		$user = $this->Session->read('Auth.User');
        $user_id = $user['ID_USUARIO'];
        $this->set('myself',$user);
		$this->set('historicos',$this->HistoricoTroca->historico($user_id));
		//debug($user);
	}
}