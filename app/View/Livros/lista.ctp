<html>
<head>
    <title><?php echo $title_for_layout; // pegamos o titulo que setamos no controller ?></title>
</head>
<body>
<h1>Livros</h1>
<table>
    <tr>
        <th>Titulo</th>
        <th>Autor</th>
        <th>Assunto</th>
        <th>Editora</th>
        <th>Versão</th>
        <th>Imagem</th>
    </tr>

    <!-- Here is where we loop through our $posts array, printing out post info -->

    <?php foreach ($livros as $livro): ?>
    <tr>
        <td><?php echo $livro['Livro']['TITULO']; ?></td>
        <td><?php echo $livro['Livro']['AUTOR']; ?></td>
        <td><?php echo $livro['Livro']['EDITORA']; ?></td>
        <td><?php echo $livro['Livro']['VERSAO']; ?></td>
        <td><img src="/livro/get_image/<? echo $livro['Livro']['ID_LIVRO']; ?>"</td>
    </tr>
    <?php endforeach; ?>
    <?php unset($livro); ?>
</table>
</body>
</html>