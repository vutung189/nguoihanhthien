<?php

/**
 * Updates plugins packaged with the theme
 */

class Bunyad_Plugin_Updates 
{
	
	public $tracking = array();
	public $plugins_info = array();
	public $latest_meta;
	
	public function __construct() 
	{
		add_action('admin_init', array($this, 'init'));
		
		// check for version difference via the typical update hook
		add_filter('pre_set_site_transient_update_plugins', array($this, 'check_update'), 99);
		
		// add info for the plugin api
		add_filter('plugins_api', array(&$this, 'set_info'), 99, 3);
	}
	
	/**
	 * Setup the plugins to be tracked for local updates
	 */
	public function init()
	{
		// set the plugins being tracked based on packaged_plugin data
		$this->latest_meta = Bunyad::registry()->packaged_plugins;
		$this->tracking    = apply_filters('bunyad_plugin_updates_tracking', array_keys($this->latest_meta));
		
		// cache existing data for tracked plugins
		$installed = get_plugins();

		foreach ($installed as $id => $plugin) {
			$slug = dirname($id);
			
			// track updates for this plugin?
			if (!in_array($slug, $this->tracking)) {
				continue;
			}
			
			$this->plugins_info[$slug] = array_merge($plugin, array('file' => $id));
		}
	}

	/**
	 * Information of plugin for Plugin API
	 * 
	 * @param boolean|object  $existing
	 * @param string  $action
	 * @param object  $arg
	 */
	public function set_info($existing, $action, $arg) 
	{
		if (!empty($existing)) {
			return $existing;
		}

		if (!empty($arg->slug) && in_array($arg->slug, $this->tracking)) {
			$info = array('slug' => $arg->slug);
			
			if (!empty($this->latest_meta[$arg->slug]['info'])) {
				$info = array_merge($info, (array) $this->latest_meta[$arg->slug]['info']);
			}
			
			return (object) $info;
		}

		return false;
	}
	
	/**
	 * Check for local plugin updates
	 * 
	 * @param object $transient
	 */
	public function check_update($transient)
	{	
		if (empty($transient->checked)) {
			return $transient;
		}

		// check local updates for all tracked plugins
		foreach ($this->tracking as $plugin) {

			if (!isset($this->plugins_info[$plugin])) {
				continue;
			}
			
			$info = $this->plugins_info[$plugin];			
			$latest_version = $this->get_latest_version($plugin);

			// if a newer version is available, add the update
			if (version_compare($info['Version'], $latest_version, '<')) {
				
				// generate plugin update data from local source
				$update_url  = get_template_directory_uri() . '/lib/vendor/plugins/' . $plugin . '.zip';
				$update_data = array(
					'slug'    => $plugin,
					'url'     => $info['PluginURI'],
					'plugin'  => $info['file'],
					'package' => $update_url,
					'new_version' => $latest_version,
				);

				$transient->response[$info['file']] = (object) $update_data;
			}
		}
		
		return $transient;
	}
	
	/**
	 * Get latest version information
	 * 
	 * @param string $slug
	 */
	public function get_latest_version($slug)
	{
		return (!empty($this->latest_meta[$slug]['version']) ? $this->latest_meta[$slug]['version'] : 0);
	}
	
}

// init and make available in Bunyad::get('plugin-updates')
Bunyad::register('plugin-updates', array(
	'class' => 'Bunyad_Plugin_Updates',
	'init' => true
));