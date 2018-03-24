<?php

/**
 * SmartMag Trendy Skin setup
 */
class Bunyad_Skin_Trendy
{
	public function __construct() 
	{
		add_filter('bunyad_default_block_attribs', array($this, 'default_attribs'));		
		add_action('init', array($this, 'init'));
		
		add_filter('bunyad_image_sizes', array($this, 'image_sizes'));
		add_filter('bunyad_comment_avatar_size', create_function('$i', 'return 50;'));
		
		
		/**
		 * Add extra selectors needed for the skin
		 */
		$opts = Bunyad::options()->defaults;
		$opts['css_main_color']['css']['selectors'] += array(
			'a:hover, 
			.highlights .post-title a:hover,
			.nav-light a:hover,
			.nav-light .mega-menu .featured h2 a:hover,
			.listing-meta .author a' 
				=> 'color: %s'
		);
		
		// More selectors to override for main font changes
		$opts['css_main_font']['css']['selectors'] .=
			',
			.navigation,
			.nav-light-b,
			.breadcrumbs,
			.main-featured .the-date,
			.listing-meta,
			.listing-meta .rate-number span,
			.post .read-more a,
			.post-meta-b,
			.post-share-b,
			.cat-title,
			button, 
			input[type="submit"]';
		
		// commit to options memory
		Bunyad::options()->defaults = $opts;
		
		// adjust number of posts in the mega menu
		//add_filter('bunyad_mega_menu_query_args', array($this, 'mega_menu_number'), 10, 2);
	}
	
	public function init()
	{
		
		// Add "more" text for excerpts
		//Bunyad::posts()->more_html = '<span class="read-more arrow"><a href="%s" title="%s">&rarr;</a></span>';
		Bunyad::core()->add_body_class('skin-tech');
		
		add_filter('bunyad_css_generator_cat', array($this, 'add_dynamic_css'));
		
		// Set listing meta position to below title in this skin
		Bunyad::options()->meta_position = 'below';
		
		add_filter('bunyad_featured_image', array($this, 'adjust_specific_images'), 10, 3);
	}

	/**
	 * Filter callback: Modify image sizes for this skin
	 */
	public function image_sizes($sizes) 
	{
		$modified = array(
			'post-thumbnail' => array('width' => 104, 'height' => 69),
			'main-block' => array('width' => 336, 'height' => 200),
			'list-block' => array('width' => 312, 'height' => 198),
			'slider-right-large' => array('width' => 351, 'height' => 185),
			'focus-grid-small' => array('width' => 163, 'height' => 102),
			'main-featured' => array('width' => 702, 'height' => 459),
		);
		
		return array_merge($sizes, $modified);
	}
	
	/**
	 * Filter callback: Adjust few images at specific locations - swap out defaults
	 * 
	 * @param string $id
	 * @param string $place
	 * @param mixed  $extra
	 */
	public function adjust_specific_images($id, $place, $extra = null)
	{
		// change main-block for default slider
		if ($id == 'main-block' && $place == 'slider-right') {
			$id = 'slider-right-large';
		}

		return $id;
	}
	
	/**
	 * Filter callback: Adjust number of posts in the mega menu
	 */
	public function mega_menu_number($query, $type = '')
	{
		if ($type == 'category-recent') {
			$query['posts_per_page'] = 4;
		}
		
		return $query;
	}
	
	
	/**
	 * Add to dynamic Custom CSS generator
	 */
	public function add_dynamic_css($css)
	{
		$css .= <<<EOF


EOF;

		return $css;
	}
}

// init and make available in Bunyad::get('skin_trendy')
Bunyad::register('skin_trendy', array(
	'class' => 'Bunyad_Skin_Trendy',
	'init' => true
));