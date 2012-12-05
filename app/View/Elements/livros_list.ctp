<?php
if(!isset($acao_remover))
    $acao_remover = false;
if(!isset($acao_tenho))
    $acao_tenho = true;
if(!isset($acao_quero))
    $acao_quero = true;
if(empty($livros)){
    echo $this->Html->div("centro margem","Nenhum livro encontrado!");
    return;
}
?>
<div class="book-list">
    <?php foreach ($livros as $livro): ?>
    <div class="book-item" data-livro-id="<?php echo $livro['Livro']['ID_LIVRO']; ?>">
        <div class="book-image-holder">
            <img src="/imagens/livro_show/<?php echo $livro['Livro']['ID_LIVRO']; ?>" alt="Capa"></img>
        </div>
        <div class="book-details">
            <div class="book-title"><?php echo $livro['Livro']['TITULO']; ?></div>
            <div class="book-author"><?php echo $livro['Livro']['AUTOR']; ?></div>
            <div class="book-editora"><?php echo $livro['Livro']['EDITORA']; ?></div>
            <div class="book-versão"><?php echo $livro['Livro']['VERSAO']; ?></div>
            <div class="book-assunto"><?php echo $livro['Assunto']['DS_ASSUNTO']; ?></div>
            <div class="book-action" data-livro-id="<?php echo $livro['Livro']['ID_LIVRO']; ?>">
                <?php
                    if($acao_remover)
                        echo '<button class="red action" data-action="remover">Remover!</button>';
                    if($acao_tenho)
                        echo '<button class="green action" data-action="tenho">TENHO!</button>';
                    if($acao_quero)
                        echo '<button class="orange action" data-action="quero">QUERO!</button>';
                //     <button class="green action" data-action="tenho">TENHO!</button>
                // <button class="orange action" data-action="quero">QUERO!</button>
                ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php unset($livro); ?>
</div>
<script>
$("button.action").click(
    function(e) {
        var action = $(this).data("action");
        var livro_id = $(this).closest("div.book-action").data("livroId");
        window.location="/livros/"+action+"/"+livro_id;
        return false;
    }
);
</script>