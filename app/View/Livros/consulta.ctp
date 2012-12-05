<?php
$isAjax = strcmp($this->layout,'ajax')==0;
$form_selector = 'form_consulta';
$query_selector = 'search_input';
$results_selector = 'results';
$loading_selector = 'loading';
if(!$isAjax){
    echo "<h2>Consulta Livro</h2>";
    echo $this->Form->create('Livro', array(
        'inputDefaults' => array(
            'label' => false,
            'div' => true
        ),
        'id' => $form_selector
    ));
    //echo $this->Form->input('Filter.filterFormId', array('type'=>'hidden','value'=>'Livro'));
    echo $this->Form->input('keyword', array('id'=>$query_selector,'placeholder'=>'Palavras-chave da busca'));
    //echo $this->Form->input('AUTOR', array('class'=>'search_query','placeholder'=>'Autor'));
    // echo $this->Html->div('button', $this->Form->button('Buscar', array('class'=>'green','type'=>'submit')));
    //echo $this->Form->button('Buscar', array('class'=>'button green','type'=>'submit'));
    // echo $this->Html->div('button',$this->Form->button('botão', array('class'=>'orange','type'=>'button')));
    // echo $this->Html->div('button',$this->Form->button('botão', array('class'=>'red','type'=>'button')));
    echo $this->Form->end();

    echo $this->Html->div($results_selector." fifty-padding",$this->Html->div("centro fifty-margin","Digite as palavras chave no campo de busca, e os resultados aparecerão aqui."),array('id'=>$results_selector));

    echo $this->Html->div($loading_selector." fifty-margin centro",$this->Html->div($loading_selector.'-image-holder',$this->Html->image('loading.gif', array('alt' => 'CakePHP'))).$this->Html->div('','Carregando...'),array('id'=>$loading_selector));
    $this->Js->buffer($this->Js->get('#'.$loading_selector)->effect('hide'));

    echo $this->Html->div('button', $this->Form->button('Não encontrei o livro...', array('id'=>'cadastra_livro','class'=>'red','type'=>'button')));
    $this->Js->get('#cadastra_livro')->event('click',$this->Js->redirect("/livros/cadastro"));

} else {
    echo $this->element('livros_list');
    return;
}
?>
<script type="text/javascript">
var timeout;
var delay = 600;
var isLoading = false;
function reloadSearch() {
    if (!isLoading) {
        var searchTerm = $("#search_input").val();
        if (searchTerm.length > 1) {
            timeout = setTimeout(function() {
                isLoading = true;
                //console.log("ajax call - " + searchTerm, true);
                $("#loading").show();
                $("#results").hide();
                $.ajax({
                    async:true,
                    // beforeSend:function (XMLHttpRequest) {
                    //     $("#loading").show();
                    //     $("#results").hide();
                    // },
                    complete:function (XMLHttpRequest, textStatus) {
                        $("#loading").hide();
                        $("#results").show();
                        isLoading = false;
                    },
                    data:$("#search_input").closest("form").serialize(),
                    dataType:"html",
                    evalScript:true,
                    success:function (data, textStatus) {
                        $("#results").html(data);
                    },
                    type:"post",
                    url:"/livros/consulta/"}
                    );
                // Simulate a real ajax call
                //setTimeout(function() { isLoading = false; }, 1000);
            }, delay);
        }
        else {
            //console.log("not enough chars");
        }
    }
    else {
        //console.log("still loading last search");
    }
}
$(document).ready(
    function () {
        $("#loading").hide();
        $("#search_input").bind("keyup",
            function (event) {
                if (timeout) {
                     clearTimeout(timeout);   
                }
                
                reloadSearch();
                return false;
            }
        );
    }
);
//]]>
</script>