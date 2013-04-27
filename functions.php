<?php

// If your PHP version is greater >= 5.4 - feel free to use namespaces
// namespace Wordpress\Themes\NobleStudios

final class Theme {

	private $_theme_information = false;

	public function run()
	{
		$this->_theme_information = $this->_get_theme_information();
		$this->_register_assets();
		$this->_enqueue_assets();
	}

	// ProTip:
	// wp_enqueue_scripts is the proper hook to use when enqueuing items that are meant to appear on the front end.
	// Despite the name, it is used for enqueueing both scripts and styles.
	private function _register_assets()
	{
		add_action('wp_enqueue_scripts', array(&$this, 'register_stylesheets'));
		add_action('wp_enqueue_scripts', array(&$this, 'register_scripts'));
	}

	private function _enqueue_assets()
	{
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_stylesheets'));
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
	}

	private function _get_theme_information()
	{
		return wp_get_theme();
	}

	private function _get_stylesheets()
	{
		$stylesheets = (object) array(
					'application' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/assets/styles/application.css',
						'dependencies' => FALSE,
						'version' => $this->_theme_information->Version
					)
		);
		return $stylesheets;
	}

	private function _get_scripts()
	{
		$scripts = (object) array(
					'application' => (object) array(
						'source' => get_stylesheet_directory_uri() . '/assets/scripts/application.js',
						'dependencies' => FALSE,
						'version' => $this->_theme_information->Version,
						'in_footer' => true
					)
		);
		return $scripts;
	}

	public function register_stylesheets()
	{
		$stylesheets = $this->_get_stylesheets();
		foreach ($stylesheets as $handle => $data)
		{
			wp_register_style(
					$handle, $data->source, $data->dependencies, $data->version
			);
		}
	}

	public function enqueue_stylesheets()
	{
		wp_enqueue_style('application');
	}

	public function register_scripts()
	{
		$scripts = $this->_get_scripts();
		foreach ($scripts as $handle => $data)
		{
			wp_register_script($handle, $data->source, $data->dependencies, $data->version, $data->in_footer);
		}
	}

	public function enqueue_scripts()
	{
		wp_enqueue_script('application');
	}

}

$theme = new Theme();
$theme->run();
