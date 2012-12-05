<?php
    echo "<h2>Fazer Login</h2>";
    echo $this->Session->flash('auth');
	echo $this->Form->create('Usuario', array(
    	'inputDefaults' => array(
        	'label' => false,
        	'div' => true
    	)
	));
    echo $this->Form->input('LOGIN',array('placeholder'=>'nome de usuário'));
    echo $this->Html->div('input text password', $this->Form->password('SENHA',array('placeholder'=>'senha')));
    echo $this->Html->div('button', $this->Form->button('Logar', array('class'=>'green','type'=>'submit')));
    echo $this->Form->end();
    echo "<hr/>";
    echo $this->Html->div('button', $this->Form->button('Cadastrar-se', array('id'=>"cadastrar",'class'=>'red','type'=>'button')));
    $this->Js->get('#cadastrar')->event('click',$this->Js->redirect("/usuarios/cadastro"));
?>
