<?php $this->layout('layout');
/**@var \Project\Mvc\Entity\Video|null $video */
?>
<main class="container">
	<form class="container__formulario"
		enctype="multipart/form-data"
		method="post">
		<h2 class="formulario__titulo">Envie um vídeo!</h2>
		<div class="formulario__campo">
			<label class="campo__etiqueta" for="url">Link embed</label>
			<input name="url"
				value="<?= $video?->url; ?>"
				class="campo__escrita"
				required
				placeholder="Por exemplo: https://www.youtube.com/"
				id='url' />
		</div>

		<div class="formulario__campo">
			<label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
			<input name="titulo"
				value="<?= $video?->title; ?>"
				class="campo__escrita"
				required
				placeholder="Nome do video"
				id='titulo' />
		</div>
		
		<div class="formulario__campo">
			<label class="campo__etiqueta" for="image">Capa do vídeo</label>
			<input name="image"
				type="file"
				accept="image/*"
				class="campo__escrita"
				id='image' />
		</div>

		<input class="formulario__botao" type="submit" value="Enviar" />
	</form>
</main>