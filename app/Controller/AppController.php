<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $helpers = array('Html', 'Form','Js' => array('Jquery'));
    
    // AppController's components are NOT merged with defaults,
    // so session component is lost if it's not included here!
    var $components = array(
    	'Auth' => array(
    		'authenticate' => array(
    			'Form' => array(
    				'userModel' => 'Usuario',
    				'fields' => array(
    					'username' => 'LOGIN',
    					'password' => 'SENHA'
    				),
                    'scope' => array('Usuario.BL_ATIVO' => 1)
    			)
    		),
    		'authorize' => 'controller',
			'loginAction' => array(
				'controller' => 'usuarios',
				'action' => 'login',
				'plugin' => null
			),
			'logoutRedirect' => array(
				'controller' => 'usuarios',
				'action' => 'login',
				'plugin' => null
			),
    		'scope' => array('Usuario.BL_ATIVO' => 1)
    	),
    	'Session',
        'RequestHandler');

    public function beforeFilter() {
        //debug($this->params['prefix']);
        // if (empty($this->params['prefix'])) {
        //     $this->Auth->allow($this->action);
        // } else {
        //     $this->layout = 'admin';
        // }
        // $this->Auth->allow('admin');
        if(strcmp($this->params['prefix'],"admin")==0){
            $this->Auth->allow($this->action);
        }
    }
    public function isAuthorized($user = null) {
        if(strcmp($this->params['prefix'],"admin")==0){
            $this->Auth->allow($this->action);
            return true;
        }
    	if($user!=null){
    		return true;
    	}
    	return false;
    	// debug($this);
    	// exit(0);
    	// return true;
    }
}