<?php echo $this->Html->docType(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		FairTrade
		<?php //echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('fairtrade.generic');

		echo $this->Html->script('jquery'); // Include jQuery library

		// echo $this->fetch('meta');
		// echo $this->fetch('css');
		// echo $this->fetch('script');
	?>
</head>
<body>
	<div class='header'>
		<h1>FairTrade</h1>
	</div>
	<div class='logged-info'>
		<?php
			$user = $this->Session->read('Auth.User');
			if(isset($user['ID_USUARIO']) && isset($user['LOGIN']) && isset($user['NOME'])) {
				echo "<div>logado como ".$user['NOME'].' ('.$this->Html->link('sair', '/usuarios/logout').')</div>';
				echo $this->Html->div('desativar-conta',$this->Html->link('desativar conta', '/usuarios/desativar'));
				echo $this->Html->div('atualizar-endereco',$this->Html->link('atualizar endereço', '/usuarios/editar_endereco'));
				echo $this->Html->div('meus-livros',$this->Html->link('meus livros', '/livros/meus'));
				echo $this->Html->div('recomendacoes',$this->Html->link('recomendações', '/usuarios/recomendacoes'));
				echo $this->Html->div('minhas-trocas',$this->Html->link('minhas trocas', '/historicotrocas/'));
			}
		?>
	</div>
	<div id="container">
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php // echo $this->element('sql_dump'); ?>
	<?php echo $this->Js->writeBuffer(); // Write cached scripts ?>
</body>
</html>
