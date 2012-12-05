<h2>Editar Endereço</h2>
<?php
echo $this->Form->create('EnderecoUsuario', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => true
    )
));
echo $this->Form->input('DS_ENDERECO', array('label'=>'Endereço: ', 'placeholder'=>'endereço'));
echo $this->Form->input('DS_BAIRRO', array('label'=>'Bairro: ', 'placeholder'=>'bairro'));
echo $this->Form->input('NR_CEP', array('label'=>'CEP: ', 'placeholder'=>'CEP'));
echo $this->Form->input('DS_CIDADE', array('label'=>'Cidade: ', 'placeholder'=>'cidade'));
echo $this->Form->input('UF', array('label'=>'Estado(sigla): ', 'placeholder'=>'UF'));
echo $this->Html->div('button', $this->Form->button('Salvar', array('class'=>'orange','type'=>'submit')));
echo $this->Form->end();
echo "<hr/>";
echo $this->Html->div('button', $this->Form->button('Voltar', array('id'=>"voltar",'class'=>'green','type'=>'button')));
$this->Js->get('#voltar')->event('click',$this->Js->redirect("/livros/consulta"));
?>