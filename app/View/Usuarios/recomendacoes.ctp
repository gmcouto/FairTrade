<h2>Recomendações de Troca</h2>
<div class="troca-list">
    <?php
    foreach ($recomendacoes as $recomendacao):
        foreach($recomendacao['Quero'] as $tenho): //eu tenho o que o usuário encontrado quer
            foreach($recomendacao['Tenho'] as $quero): //eu quero o que usuário encontrado tem
    ?>
    <div class="troca-item centro" data-eu-user="<?php echo $myself['ID_USUARIO']; ?>" data-eu-livro="<?php echo $tenho['ID_LIVRO']; ?>" data-outro-livro="<?php echo $quero['ID_LIVRO']; ?>" data-outro-user="<?php echo $recomendacao['Usuario']['ID_USUARIO']; ?>">
        <div class="book-item troca-tenho">
            <div class="book-details tenho">
                <div class="book-assunto"><?php echo strtoupper($myself['LOGIN']).' (eu)'; ?></div>
                <div class="book-title"><?php echo $tenho['TITULO']; ?></div>
                <div class="book-author"><?php echo $tenho['AUTOR']; ?></div>
                <div class="book-editora"><?php echo $tenho['EDITORA']; ?></div>
                <div class="book-versão"><?php echo $tenho['VERSAO']; ?></div>
                <div class="book-action" data-livro-id="<?php echo $tenho['ID_LIVRO']; ?>">
                </div>
            </div>
            <div class="book-image-holder">
                <img src="/imagens/livro_show/<?php echo $tenho['ID_LIVRO']; ?>" alt="Capa"></img>
            </div>
        </div>
        <div class="book-item book-quero">
            <div class="book-image-holder quero">
                <img src="/imagens/livro_show/<?php echo $quero['ID_LIVRO']; ?>" alt="Capa"></img>
            </div>
            <div class="book-details">
                <div class="book-assunto"><?php 
                $nota = $recomendacao['Usuario__NOTA" FROM "main"']['"USUARIOS" AS "Usuario" INNER JOIN "main"'];
                if($nota<0)
                    $nota = 'sem avaliação';
                echo strtoupper($recomendacao['Usuario']['LOGIN']).' ('.$nota.')'; ?></div>
                <div class="book-title"><?php echo $quero['TITULO']; ?></div>
                <div class="book-author"><?php echo $quero['AUTOR']; ?></div>
                <div class="book-editora"><?php echo $quero['EDITORA']; ?></div>
                <div class="book-versão"><?php echo $quero['VERSAO']; ?></div>
                <div class="book-action" data-livro-id="<?php echo $quero['ID_LIVRO']; ?>">
                </div>
            </div>
        </div>
        <div class="centro">
            <button class="orange action" data-action="quero">Fazer troca (com o <?php echo $recomendacao['Usuario']['LOGIN']; ?>)</button>
        </div>
    </div>
    <?php
            endforeach;
        endforeach;
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