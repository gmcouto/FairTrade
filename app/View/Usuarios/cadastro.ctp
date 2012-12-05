<h2>Cadastrar Usuário</h2>
<?php
echo $this->Form->create('Usuario', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => true
    )
));
echo $this->Form->input('NOME', array('placeholder'=>'Nome'));
echo $this->Form->input('LOGIN', array('placeholder'=>'Login'));
$error='';
if ($this->Form->isFieldError('SENHA')) {
    $error=$error.$this->Form->error('SENHA');
}
echo $this->Html->div('input text password', $this->Form->password('SENHA',array('placeholder'=>'senha','error')).$error);;
$error='';
if ($this->Form->isFieldError('SENHA_CONFIRMA')) {
    $error=$error.$this->Form->error('SENHA_CONFIRMA');
}
echo $this->Html->div('input text password', $this->Form->password('SENHA_CONFIRMA',array('placeholder'=>'confirme senha')).$error);
echo $this->Form->input('TELEFONE', array('placeholder'=>'Telefone'));
echo $this->Html->div('button', $this->Form->button('Cadastrar', array('class'=>'orange','type'=>'submit')));
echo $this->Form->end();
echo "<hr/>";
echo $this->Html->div('button', $this->Form->button('Já tenho uma conta', array('id'=>"logar",'class'=>'green','type'=>'button')));
$this->Js->get('#logar')->event('click',$this->Js->redirect("/usuarios/login"));
?>