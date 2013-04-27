<!DOCTYPE html <?php language_attributes(); ?>>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title('|', true, 'right'); ?></title>
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta name="viewport" content="width=device-width">
		<?php wp_head(); ?>
	</head>
	<body>

<?php

/* End of file functions.php */
/* Location: ./wp-content/themes/%THEMEFOLDER%/functions.php */
