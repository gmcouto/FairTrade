<h2>Histórico de Trocas</h2>
<div class="troca-list">
    <?php
    foreach ($historicos as $historico):
        $usuario_eu = 'UsuarioA';
        $usuario_outro = 'UsuarioB';
        $livro_eu = 'LivroA';
        $livro_outro = 'LivroB';
        if(intval($historico['UsuarioB']['ID_USUARIO'])==intval($myself['ID_USUARIO'])) {
            $usuario_eu = 'UsuarioB';
            $usuario_outro = 'UsuarioA';
            $livro_eu = 'LivroB';
            $livro_outro = 'LivroA';
        }
    ?>
    <div class="troca-item centro"
    data-eu-user="<?php echo $myself['ID_USUARIO']; ?>"
    data-eu-livro="<?php echo $historico[$livro_eu]['ID_LIVRO']; ?>"
    data-outro-livro="<?php echo $historico[$livro_outro]['ID_LIVRO']; ?>"
    data-outro-user="<?php echo $historico[$usuario_outro]['ID_USUARIO']; ?>">
        <div class="book-item troca-tenho">
            <div class="book-details tenho">
                <div class="book-assunto"><?php echo strtoupper($myself['LOGIN']); ?></div>
                <div class="book-title"><?php echo $historico[$livro_eu]['TITULO']; ?></div>
                <div class="book-author"><?php echo $historico[$livro_eu]['AUTOR']; ?></div>
                <div class="book-editora"><?php echo $historico[$livro_eu]['EDITORA']; ?></div>
                <div class="book-versão"><?php echo $historico[$livro_eu]['VERSAO']; ?></div>
                <div class="book-action" data-livro-id="<?php echo $historico[$livro_eu]['ID_LIVRO']; ?>">
                </div>
            </div>
            <div class="book-image-holder">
                <img src="/imagens/livro_show/<?php echo $historico[$livro_eu]['ID_LIVRO']; ?>" alt="Capa"></img>
            </div>
        </div>
        <div class="book-item book-quero">
            <div class="book-image-holder quero">
                <img src="/imagens/livro_show/<?php echo $historico[$livro_outro]['ID_LIVRO']; ?>" alt="Capa"></img>
            </div>
            <div class="book-details">
                <div class="book-assunto"><?php echo strtoupper($historico[$usuario_outro]['LOGIN']); ?></div>
                <div class="book-title"><?php echo $historico[$livro_outro]['TITULO']; ?></div>
                <div class="book-author"><?php echo $historico[$livro_outro]['AUTOR']; ?></div>
                <div class="book-editora"><?php echo $historico[$livro_outro]['EDITORA']; ?></div>
                <div class="book-versão"><?php echo $historico[$livro_outro]['VERSAO']; ?></div>
                <div class="book-action" data-livro-id="<?php echo $historico[$livro_outro]['ID_LIVRO']; ?>">
                </div>
            </div>
        </div>
        <div class="centro">
            <div>
                <?php echo date('d/m/Y',$historico['HistoricoTroca']['DATA_TROCA']); ?>
            </div>
            <button class="orange action" data-action="quero">Dar nota para <?php echo $historico[$usuario_outro]['LOGIN']; ?></button>
        </div>
    </div>
    <?php
    endforeach;
    ?>
    <?php unset($recomendacoes); unset($myself); ?>
</div>
<script>
$("button.action").click(
    function(e) {
        var user_id_a = $(this).closest("div.troca-item").data("euUser");
        var book_id_a = $(this).closest("div.troca-item").data("euLivro");
        var user_id_b = $(this).closest("div.troca-item").data("outroUser");
        var book_id_b = $(this).closest("div.troca-item").data("outroLivro");
        window.location="/usuarios/troca/"+user_id_a+"/"+book_id_a+"/"+user_id_b+"/"+book_id_b;
        return false;
    }
);
</script>