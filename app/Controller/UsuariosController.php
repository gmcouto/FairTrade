<?php
class UsuariosController extends AppController {
	public $modelClass = "Usuario";

	public $helpers = array('Html', 'Form');

	public $scaffold = "admin";

	public function beforeFilter() {
    	parent::beforeFilter();
    	if($this->Auth->loggedIn()){
    		$this->Auth->deny('login','cadastro');
    	} else {
    		$this->Auth->allow('login','cadastro');
    	}
	}

    public function isAuthorized($user = null) {
    	//debug($this);
    	$action = $this->request->params['action'];
    	if($user != null){//USUARIO LOGADO
    		if($action=='login' || $action=='cadastro'){
    			return true;
    		}
    		return true;
    	} else {//USUARIO DESLOGADO
    		if($action=='login' || $action=='cadastro'){
    			return true;
    		}
    		return Parent::isAuthorized($user);
    	}
    }

    public function index(){
        $this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
    }

    public function best_match($id) {
        $username = $this->Session->read('Auth.User')['User']['username'];
        //debug($username);
        $user = $this->Usuario->findByLogin($username);
        //debug($user);

        $data = $this->Usuario->melhores($id);
        debug($data);
    }

    public function lista() {
        //$this->layout = 'ajax';
    	$this->set("title_for_layout", "This is the page title");
        $this->set('usuarios', $this->Usuario->find('all'));

    }
    
    public function delete($id) {
		if ($this->request->is("get")) {
			throw new MethodNotAllowedException();
		}
		if ($this->Usuario->delete($id)) {
			$this->Session->setFlash("The post with id: ".$id ." has been deleted.");
			$this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
		}
    }

    public function login() {
        $user = $this->Session->read('Auth.User');
        if(isset($user['ID_USUARIO']) && isset($user['LOGIN']) && isset($user['NOME'])) {
            $this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
        }
	   if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	            $this->redirect($this->Auth->redirect());
	        } else {
	            $this->Session->setFlash(__('Invalid username or password, try again'));
	        }
	    }
    }
    public function logout() {
    	$this->Auth->logout();
        $this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
    }

    public function cadastro() {
        $user = $this->Session->read('Auth.User');
        if(isset($user['ID_USUARIO']) && isset($user['LOGIN']) && isset($user['NOME'])) {
            $this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
        }
    	if ($this->request->is('post')) {
            //INITIATING TRANSACTION
            $this->Usuario->create();
            //RETRIEVING DATA
            $data = $this->request->data;            
            //FILLING OTHER FIELDS
            $data['Usuario']['BL_ATIVO'] = 1;
            $data['Usuario']['DESDE'] = (new DateTime())->getTimestamp();
            //HASHING PASSOWRDS
            if (isset($data['Usuario']['SENHA']) && strlen($data['Usuario']['SENHA'])>5) {
                $data['Usuario']['SENHA'] = AuthComponent::password($data['Usuario']['SENHA']);
                if (isset($data['Usuario']['SENHA_CONFIRMA']) && strlen($data['Usuario']['SENHA_CONFIRMA'])>5) {
                    $data['Usuario']['SENHA_CONFIRMA'] = AuthComponent::password($data['Usuario']['SENHA_CONFIRMA']);
                }
            }
            //SAVING
            if ($this->Usuario->save($data)) {
                $this->Session->setFlash('Você se cadastrou com sucesso.');
                //$this->redirect(array('action' => 'index'));
                $this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
            } else {
                $this->Session->setFlash('Não foi possível cadastrar o usuário.');
            }
        }
    }

    public function desativar() {
        //debug($this->Session->read('Auth.User'));
        if($this->request->is('post')){
            if(isset($this->request->data['Usuario']['BL_ATIVO']) && $this->request->data['Usuario']['BL_ATIVO']==0) {
                $user = $this->Session->read('Auth.User');
                $this->Usuario->id=intval($user['ID_USUARIO']);
                $this->Usuario->saveField('BL_ATIVO', 0);
                $this->redirect(array('controller' => 'usuarios', 'action' => 'logout'));
            }
        }
    }

    public function editar_endereco() {
        $user = $this->Session->read('Auth.User');
        $user_id = $user['ID_USUARIO'];
        //debug($this->request);
        if($this->request->is('post') || $this->request->is('put')) {
            //debug("post");
            $this->request->data['EnderecoUsuario']['ID_USUARIO'] = $user_id;
            $this->request->data['EnderecoUsuario']['DS_PAIS'] = 'Brasil';
            if($this->Usuario->temEndereco($user_id)){
                //debug("tem endereço");
                $this->request->data['EnderecoUsuario']['ID_ENDERECO_USUARIO'] = $this->Usuario->getEndereco($user_id)['EnderecoUsuario']['ID_ENDERECO_USUARIO'];
            } else {
                $this->Usuario->EnderecoUsuario->create();
                //debug("nao tem endereço");
            }
            if($this->Usuario->EnderecoUsuario->save($this->request->data)){
                //debug("salvo");
                $this->Session->setFlash('Seu endereço foi salvo');
            } else {
                //debug("nao salvo");
                $this->Session->setFlash('Houve um problema ao salvar seu endereço');
            }
        } else {
            //debug("sem post");
            if($this->Usuario->temEndereco($user_id)){
                //debug("lendo dados existentes");
                $this->request->data = $this->Usuario->getEndereco($user_id);
            }
        }
        //debug("fim");
    }

    public function recomendacoes(){
        $user = $this->Session->read('Auth.User');
        $user_id = $user['ID_USUARIO'];
        $recomendacoes = $this->Usuario->melhores($user_id);
        $this->set('recomendacoes',$recomendacoes);
        $this->set('myself',$user);
        //debug($recomendacoes);
    }

    public function troca($user_id_a, $book_id_a, $user_id_b, $book_id_b){
        $this->Usuario->TrocasFeitas->create();
        $data = array();
        $data['TrocasFeitas']['ID_USUARIO_A'] = $user_id_a;
        $data['TrocasFeitas']['ID_LIVRO_A'] = $book_id_a;
        $data['TrocasFeitas']['ID_USUARIO_B'] = $user_id_b;
        $data['TrocasFeitas']['ID_LIVRO_B'] = $book_id_b;
        $data['TrocasFeitas']['DATA_TROCA'] = (new DateTime())->getTimestamp();
        if($this->Usuario->TrocasFeitas->save($data)){
            $this->Usuario->Tenho->deletaTemEQuer($book_id_a, $user_id_a);
            $this->Usuario->Tenho->deletaTemEQuer($book_id_a, $user_id_b);
            $this->Usuario->Tenho->deletaTemEQuer($book_id_b, $user_id_a);
            $this->Usuario->Tenho->deletaTemEQuer($book_id_b, $user_id_b);
            $this->Session->setFlash('Você fez a troca');
            $this->redirect(array('controller' => 'usuarios', 'action' => 'recomendacoes'));
            return;
        }
        $this->Session->setFlash('Houve algum problema');
        $this->redirect(array('controller' => 'usuarios', 'action' => 'recomendacoes'));
        
    }
}