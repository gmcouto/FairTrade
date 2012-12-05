<?php
class ImagensController extends AppController {
	public $modelClass = "Imagem";

	public $helpers = array('Html', 'Form');

	public $scaffold = "admin";

	public function livro_show($id) {
    	$file = $this->Imagem->findByIdLivro($id);
        if(isset($file['Imagem']['DADOS'])){
            header('Content-type: image');
            echo ($file['Imagem']['DADOS']);
            exit(0);
        } else {
            $this->viewClass = 'Media';
            // Render app/webroot/files/example.docx
            $params = array(
                'id'        => 'noimage.gif',
                'name'      => 'noimage',
                'extension' => 'gif',
                'path'      => 'img' . DS
            );
            $this->set($params);
        }
    }
}