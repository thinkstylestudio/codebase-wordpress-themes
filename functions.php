<?php

// If your PHP version is greater >= 5.4 - feel free to use namespaces
// namespace Wordpress\Themes\NobleStudios

final class Theme {

	private $_theme_information = false;

	public function run() {
		$this->_theme_information = $this->_get_theme_information();
		$this->_register_assets();
		$this->_enqueue_assets();
	}

	// ProTip:
	// wp_enqueue_scripts is the proper hook to use when enqueuing items that are meant to appear on the front end.
	// Despite the name, it is used for enqueueing both scripts and styles.
	private function _register_assets() {
		add_action('wp_enqueue_scripts', array(&$this, 'register_stylesheets'));
		add_action('wp_enqueue_scripts', array(&$this, 'register_scripts'));
	}

	private function _enqueue_assets() {
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_stylesheets'));
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
	}

	private function _get_theme_information() {
		return wp_get_theme();
	}

	private function _get_stylesheets() {
		$stylesheets = (object) array(
					'normalize' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/assets/css/normalize.css',
						'dependencies' => false,
						'version' => 'v1.0.1'
					),
					'h5bp' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/assets/css/h5bp.css',
						'dependencies' => array('normalize'),
						'version' => 'v4.0.0'
					),
					'bootstrap' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css',
						'dependencies' => array('h5bp'),
						'version' => 'v2.1.1'
					),
					'main' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/style.css',
						'dependencies' => array('bootstrap'),
						'version' => $this->_theme_information->Version
					)
		);
		return $stylesheets;
	}

	// TODO: Figure out how to use the net_path URL rather than including the protocol.
	private function _get_scripts() {
		$scripts = (object) array(
					'modernizr' => (object) array(
						'source' => 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js',
						'dependencies' => false,
						'version' => 'v2.6.2',
						'in_footer' => false
					),
					'console-fallback' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/assets/js/console-fallback.js',
						'dependencies' => false,
						'version' => 'v2.1.1',
						'in_footer' => true
					),
					'bootstrap' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js',
						'dependencies' => array('jquery'),
						'version' => 'v2.1.1',
						'in_footer' => true
					),
		);
		return $scripts;
	}

	public function register_stylesheets() {
		$stylesheets = $this->_get_stylesheets();
		foreach ($stylesheets as $handle => $data) {
			wp_register_style(
					$handle, $data->source, $data->dependencies, $data->version
			);
		}
	}

	public function enqueue_stylesheets() {
		wp_enqueue_style('main');
	}

	public function register_scripts() {
		$scripts = $this->_get_scripts();
		foreach ($scripts as $handle => $data) {
			wp_register_script(handle, $data->source, $data->dependencies, $data->version, $data->in_footer);
		}
	}

	public function enqueue_scripts() {
		wp_enqueue_script('modernizr');
		wp_enqueue_script('console-fallback');
		wp_enqueue_script('bootstrap');
	}

}

$theme = new Theme();
$theme->run();
?>
