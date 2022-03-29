<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

	<head>
		<meta charset="<?php echo bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="description" content="<?php echo bloginfo('description'); ?>">
		<title>
			<?php 
				wp_title(''); 
				if (wp_title('', false)) { echo ': '; }
				bloginfo('name');
			?>
		</title>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css.map">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/extra.css">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png"
			type="image/x-icon">
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/modernizr-2.8.3.min.js"></script>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>


		<div class="header">
			<nav id="menu-superior">
				<div class="menu-superior_holder">

					<ul class="lang_menu">
						<li class="lang-item lang-item-74 lang-item-es lang-item-first current-lang"><a lang="es-ES"
								hreflang="es-ES" href="https://esdmadrid.es/">es</a></li>
						<li class="lang-item lang-item-77 lang-item-en"><a lang="en-GB" hreflang="en-GB"
								href="https://esdmadrid.es/en/">en</a></li>

					</ul>
					<ul class="corporate_menu">
						<li><a href="http://biblioteca.esdmadrid.es/" target="_blank">Biblioteca</a></li>
						<li><a href="http://esdmadrid.net/aula/" target="_blank">Aula Virtual</a></li>
						<li><a href="https://www.facebook.com/EscuelaSuperiorDeDisenoDeMadrid?hc_location=stream"
								target="_blank">Facebook</a></li>
						<li><a href="https://www.instagram.com/esdmadrid/" target="_blank">Instagram</a></li>
					</ul>
				</div>
			</nav>
		</div>