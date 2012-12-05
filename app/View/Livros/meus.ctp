<h2>Livros que eu Tenho</h2>
<?php
	$this->set('livros',$tenho);
	$this->set('acao_remover',true);
	$this->set('acao_tenho',false);
	$this->set('acao_quero',false);
	echo $this->element('livros_list');
?>
<br/>
<hr/>
<br/>
<h2>Livros que eu Quero</h2>
<?php
	$this->set('livros',$quero);
	$this->set('acao_remover',true);
	$this->set('acao_tenho',false);
	$this->set('acao_quero',false);
	echo $this->element('livros_list');
?>
<br/>
<hr/>
<br/>
<?php
echo $this->Html->div('button', $this->Form->button('quero voltar...', array('id'=>'voltar','class'=>'green','type'=>'button')));
$this->Js->get('#voltar')->event('click',$this->Js->redirect("/livros/consulta"));