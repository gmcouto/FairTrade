<?php
App::uses('File', 'Utility');
App::uses('Sanitize', 'Utility');
class LivrosController extends AppController {
	public $modelClass = "Livro";

	public $helpers = array('Html', 'Form');

	public $components = array('Paginator');

	public $paginate = array();

	public $scaffold = "admin";

    public function consulta() {
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        }
        if($this->request->is('post')){
            $keyword = $this->params->data['Livro']['keyword'];         
            // $keywords=split(' ',$this->params->data['Livro']['keyword']);
            // $count=0;
            // $cond=array('OR'=>array());
            // foreach ($keywords as $keyword):
            //     if(empty($keyword))
            //         continue;
            //     if(strcmp($keyword,'')==0)
            //         continue;
            //     $count++;
            //     array_push($cond['OR'],"Livro.Titulo LIKE '"."%".$keyword."%"."'");
            //     array_push($cond['OR'],"Livro.Autor LIKE '"."%".$keyword."%"."'");
            //     array_push($cond['OR'],"Livro.Editora LIKE '"."%".$keyword."%"."'");
            // endforeach;
            $count=1;
            $keyword='%'.$keyword.'%';
            $cond=array('OR'=>array("Livro.Titulo LIKE '$keyword'","Livro.Autor LIKE '$keyword'", "Livro.Editora LIKE '$keyword'") );
            if($count>0)
                $this->set('livros',$this->Livro->find('all',array('conditions'=>$cond,'contain'=>'Assunto')));
            else
                $this->set('livros',array());
        } else {
            $this->set('livros',array());
        }
    }

    public function quero($id){
        $user = $this->Session->read('Auth.User');
        $user_id = $user['ID_USUARIO'];
        if($this->Livro->jaTemOuQuer($id,$user_id)) { // JA POSSUI OU QUER UM LIVRO = NÃO PODE
            $this->Session->setFlash('Você não pode querer um livro que já tem, ou ter um livro que quer!');
            $this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
            return;
        }
        $this->Livro->UsuarioQuerLivro->create();
        $quer = array('UsuarioQuerLivro'=>array());
        $quer['UsuarioQuerLivro']['ID_LIVRO'] = $id;
        $quer['UsuarioQuerLivro']['ID_USUARIO'] = $user_id;
        if($this->Livro->UsuarioQuerLivro->save($quer)){
            $this->Session->setFlash('Pronto! As outras pessoas já podem te oferecer esse livro.');
        } else {
            $this->Session->setFlash('Ocorreu um erro. Talvez você já queira esse livro.');
        }
        $this->redirect(array('controller' => 'livros', 'action' => 'meus'));
    }

    public function tenho($id){
        $user = $this->Session->read('Auth.User');
        $user_id = $user['ID_USUARIO'];
        if($this->Livro->jaTemOuQuer($id,$user_id)) { // JA POSSUI OU QUER UM LIVRO = NÃO PODE
            $this->Session->setFlash('Você não pode ter um livro que já tem, ou ter um livro que quer!');
            $this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
            return;
        }
        $this->Livro->UsuarioTemLivro->create();
        $tem = array('UsuarioTemLivro'=>array());
        $tem['UsuarioTemLivro']['ID_LIVRO'] = $id;
        $tem['UsuarioTemLivro']['ID_USUARIO'] = $user_id;
        if($this->Livro->UsuarioTemLivro->save($tem)){
            $this->Session->setFlash('Pronto! As outras pessoas já podem te solicitar esse livro.');
        } else {
            $this->Session->setFlash('Ocorreu um erro. Talvez você já tenha esse livro.');
        }
        $this->redirect(array('controller' => 'livros', 'action' => 'meus'));
    }

    public function meus(){
        $user = $this->Session->read('Auth.User');
        $user_id = $user['ID_USUARIO'];
        $tenho_results = $this->Livro->find('all',array('conditions'=>array('Livro.ID_LIVRO'=>$this->Livro->Teem->lista_tenho($user_id)),'contain'=>'Assunto'));
        $this->set('tenho',$tenho_results);
        //debug($tenho);
        $quero_results = $this->Livro->find('all',array('conditions'=>array('Livro.ID_LIVRO'=>$this->Livro->Querem->lista_quero($user_id)),'contain'=>'Assunto'));
        $this->set('quero',$quero_results);
        //debug($quero);
    }

    public function cadastro(){
        $this->set('assuntos',$this->Livro->Assunto->find('list',array('order'=>'Assunto.DS_ASSUNTO ASC')));
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->Livro->create();
            if ($this->Livro->save($data)) {
                if(isset($data['Imagem']['ARQUIVO']['tmp_name']) && !empty($data['Imagem']['ARQUIVO']['tmp_name']) && is_uploaded_file($data['Imagem']['ARQUIVO']['tmp_name'])){
                    $id_livro = intval($this->Livro->id);
                    $file_name = $data['Imagem']['ARQUIVO']['tmp_name'];
                    $contents = bin2hex(file_get_contents($file_name));
                    $sql = "INSERT INTO IMAGENS(ID_LIVRO,DADOS) VALUES('$id_livro',x'$contents')";
                    $this->Livro->Imagem->query($sql);
                }
                $this->Session->setFlash('Você cadastrou o livro com sucesso.');
                $this->redirect(array('controller' => 'livros', 'action' => 'consulta'));
            } else {
                $this->Session->setFlash('Não foi possível cadastrar o livro.');
            }
        }
    }

    public function remover($id){
        $user = $this->Session->read('Auth.User');
        $user_id = $user['ID_USUARIO'];
        $this->Livro->deletaTemEQuer($id,$user_id);
        $this->Session->setFlash('Livro removido da sua lista com sucesso.');
        $this->redirect(array('controller' => 'livros', 'action' => 'meus'));
    }
}