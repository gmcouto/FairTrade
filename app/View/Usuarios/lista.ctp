<h1>Usuários</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Usuario</th>
        <th>Senha</th>
        <th>Telefone</th>
        <th>Nota</th>
    </tr>
    <!-- Here is where we loop through our $posts array, printing out post info -->
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?php echo $usuario['Usuario']['ID_USUARIO']; ?></td>
        <td><?php echo $usuario['Usuario']['NOME']; ?></td>
        <td><?php echo $usuario['Usuario']['LOGIN']; ?></td>
        <td><?php echo $usuario['Usuario']['SENHA']; ?></td>
        <td><?php echo $usuario['Usuario']['TELEFONE']; ?></td>
        <td><?php echo $usuario['Usuario']['NOTA']; ?></td>
    </tr>
<?php endforeach; ?>
<?php unset($usuario); ?>
</table>