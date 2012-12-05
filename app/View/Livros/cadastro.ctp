<h2>Cadastrar Livro</h2>
<?php
echo $this->Form->create('Livro', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => true
    ),
    'type' => 'file'
));
echo $this->Form->input('ID_ASSUNTO', array('type'=>'select', 'options'=>$assuntos, 'label'=>false, 'empty'=>'Assunto'));
echo $this->Form->input('TITULO', array('placeholder'=>'Título'));
echo $this->Form->input('AUTOR', array('placeholder'=>'Autor'));
echo $this->Form->input('EDITORA', array('placeholder'=>'Editora'));
echo $this->Form->input('VERSAO', array('placeholder'=>'Versão(edição)'));
echo $this->Form->input('Imagem.ARQUIVO', array('label'=>'Capa: ','type' => 'file'));
echo $this->Html->div('button', $this->Form->button('Cadastrar Livro', array('class'=>'orange','type'=>'submit')));
echo $this->Form->end();
echo "<hr/>";
echo $this->Html->div('button', $this->Form->button('Mudei de idéia...', array('id'=>"desistir",'class'=>'green','type'=>'button')));
$this->Js->get('#desistir')->event('click',$this->Js->redirect("/livros/consulta"));
?>