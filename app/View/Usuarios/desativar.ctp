<h2>Desativar Conta</h2>
<?php
    echo $this->Form->create('Usuario', array(
        'inputDefaults' => array(
            'label' => false,
            'div' => true
        ),
        'onsubmit'=>'return confirm("Tem certeza que quer desativar sua conta?\nEssa operação NÃO É REVERSÍVEL!");'
    ));
    echo $this->Form->input('BL_ATIVO', array('type'=>'hidden','value'=>'0'));
    echo $this->Html->div('button',$this->Form->button('DESATIVAR usuário!', array('class'=>'red','type'=>'submit')));
    echo $this->Html->div('button',$this->Form->button('OPA! Me tire daqui!', array('class'=>'green','id'=>'cancel','type'=>'button')));
    //echo $this->Html->div('button',$this->Form->button('DESATIVAR usuário!', array('class'=>'orange','type'=>'submit')));
    //echo $this->Form->button('Buscar', array('class'=>'button green','type'=>'submit'));
    //echo $this->Html->div('button',$this->Form->button('botão', array('class'=>'red','type'=>'button')));
    $this->Form->end();
    $this->Js->get('#cancel');
    $this->Js->event('click', $this->Js->redirect('/livros/consulta'));
?>