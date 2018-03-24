<?php
/**
 * Plugin Name: Sphere Core
 * Plugin URI: http://theme-sphere.com
 * Description: Core plugin for ThemeSphere themes.
 * Version: 1.0.0
 * Author: ThemeSphere
 * Author URI: http://theme-sphere.com
 * License: GPL2
 */

class Sphere_Plugin_Core
{
	public $components;
	public $registry;
	
	protected static $instance;
	
	public function __construct() 
	{
		add_action('bunyad_core_pre_init', array($this, 'setup'));
	}
	
	/**
	 * Initialize and include the components
	 * 
	 * Note: Setup is called before after_setup_theme and Bunyad::options()->init() 
	 * at the hook bunyad_core_pre_init.
	 */
	public function setup()
	{
		
		/**
		 * Registered components can be filtered with a hook at bunyad_core_pre_init or in the 
		 * Bunyad::core()->init() bootstrap function via the key sphere_components.
		 */
		$this->components = apply_filters('sphere_plugin_components', array(
			'social-share', 'likes', 'social-follow'
		));
		
		foreach ($this->components as $component) {
			require_once 'components/' . sanitize_file_name($component) . '.php';
			
			$class = 'Sphere_Plugin_' . implode('', array_map('ucfirst', explode('-', $component)));
			$this->registry[$component] = new $class;
		}
	}
	
	/**
	 * Static shortcut to retrieve component object from registry
	 * 
	 * @param  string $component
	 * @return object|boolean 
	 */
	public static function get($component)
	{
		$object = self::instance();
		if (isset($object->registry[$component])) {
			return $object->registry[$component];
		}
		
		return false;
	}
	
	/**
	 * Get singleton object
	 * 
	 * @return Sphere_Plugin_Core
	 */
	public static function instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
}

Sphere_Plugin_Core::instance();