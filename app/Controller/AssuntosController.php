<?php
class AssuntosController extends AppController {
	public $modelClass = "Assunto";

	public $helpers = array('Html', 'Form');

	public $scaffold = "admin";
}