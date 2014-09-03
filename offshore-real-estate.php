<?php
/*
Plugin Name: Offshore Bees Real Estate
Plugin URI: www.offshorebees.com
Description: A Perfect Real Estate Plugin for You
Author: Offshore Bees
Author URI: www.offshorebees.com
Version: 0.1
*/
function ob_script(){
	wp_enqueue_style( 'ob_styles', plugins_url('/css/ob_property.css',__FILE__) );
	/*wp_register_script('script', 'http://sth.sth.com.sth/blahblah');
	wp_enqueue_script('script');
	wp_register_script('myscript', plugins_url('/js/myscript.js',__FILE__));
	wp_enqueue_script('myscript');*/
}
add_action( 'wp_enqueue_scripts', 'ob_script' );

class ob_Post_Type { 

	public function __construct()
	{
		$this->register_post_type();
		$this->taxonomies();
		$this->metaboxes();
	}
	
	public function register_post_type()
	{
		$args = array(
			'labels' => array(
				'name' => 'Properties',
				'singular_name' => 'Property',
				'add_new' => 'Add new Property',
				'add_new_item' => 'Add new Property',
				'edit_item' => 'Edit Property',
				'new_item' => 'Add new Property',
				'view_item' => 'View Property',
				'search_items' => 'Search Property',
				'not_found' => 'No Properties Found',
				'not_found_in_trash' => 'No Properties found in Trash'
			),
			'query_var' => 'properties',
			'rewrite' => array(
				'slug' => 'properties/'
				),
			/*'capability_type' => 'attachment',*/	
			'public' => true,
			//'menu_position' => 5, 
			'supports' => array('title', 'thumbnail', 'editor'),
			'has_archive' => true,
			'menu_icon' => plugins_url( 'offshore_icon.png' , __FILE__ )
		);
		register_post_type('ob_property', $args);
	}
	
	public function taxonomies()
	{
		$taxonomies = array();
		
		$taxonomies['additional_features'] = array(
			'hierarchical' => true,
			'query_var' => 'additional_feature',
			'rewrite' => 'property/additional_features',
			'labels' => array(
				'name' => 'Additional Features',
				'singular_name' => 'Additional Feature',
				'add_new_item' => 'Add Additional Feature',
				'new_item_name' => 'Add new Additional Feature',
				'edit_item' => 'Edit Additional Feature',
				'update_item' => 'Update Additional Feature',
				'all_items' => 'All Additional Features',
				'search_items' => 'Search Additional Features',
				'popular_items' => 'Popular Additional Features',
				'separate_items_with_comments' => 'Separate Additional Features with Comma (,)',
				'add_or_remove_items' => 'Add or Remove Additional Features',
				'choose_from_most_used' => 'Choose from most used Additional Features'
			)
		);
		$taxonomies['property_type'] = array(
			'hierarchical' => true,
			'query_var' => 'property_type',
			'rewrite' => 'property/type',
			'labels' => array(
				'name' => 'Property Type',
				'singular_name' => 'Property Type',
				'add_new_item' => 'Add Property Type',
				'new_item_name' => 'Add new Property Type',
				'edit_item' => 'Edit Property Type',
				'update_item' => 'Update Property Type',
				'all_items' => 'All Property Types',
				'search_items' => 'Search Property Types',
				'popular_items' => 'Popular Property Types',
				'separate_items_with_comments' => 'Separate Property Types with Comma (,)',
				'add_or_remove_items' => 'Add or Remove Property Types',
				'choose_from_most_used' => 'Choose from most used Property Types'
			)
		);
		$taxonomies['location'] = array(
			'hierarchical' => true,
			'query_var' => 'location',
			'rewrite' => 'property/loc',
			'labels' => array(
				'name' => 'Locations',
				'singular_name' => 'Location',
				'add_new_item' => 'Add Location',
				'new_item_name' => 'Add new Location',
				'edit_item' => 'Edit Location',
				'update_item' => 'Update Location',
				'all_items' => 'All Locations',
				'search_items' => 'Search Locations',
				'popular_items' => 'Popular Locations',
				'separate_items_with_comments' => 'Separate Locations with Comma (,)',
				'add_or_remove_items' => 'Add or Remove Locations',
				'choose_from_most_used' => 'Choose from most used Locations'
			)
		);
		/* for additional taxonomies just change the names of the taxonomies below
		$taxonomies['additional_features'] = array(
			'hierarchical' => true,
			'query_var' => 'additional_feature',
			'rewrite' => 'property/additional_features',
			'labels' => array(
				'name' => 'Additional Features',
				'singular_name' => 'Additional Feature',
				'add_new_item' => 'Add Additional Feature',
				'new_item_name' => 'Add new Additional Feature',
				'edit_item' => 'Edit Additional Feature',
				'update_item' => 'Update Additional Feature',
				'all_items' => 'All Additional Features',
				'search_items' => 'Search Additional Features',
				'popular_items' => 'Popular Additional Features',
				'separate_items_with_comments' => 'Separate Additional Features with Comma (,)',
				'add_or_remove_items' => 'Add or Remove Additional Features',
				'choose_from_most_used' => 'Choose from most used Additional Features'
			)
		);
		*/
		
		$this->register_all_taxonomies($taxonomies);
	}
	
	public function register_all_taxonomies($taxonomies)
	{
		foreach($taxonomies as $name => $arr)
		{
			register_taxonomy($name, array('ob_property'), $arr);
		}
	}
	
	public function metaboxes()
	{
		add_action('add_meta_boxes', 'metabox_adding');
		
		function metabox_adding(){
			//css id, title, cb function, page, priority, cb function arguments
			add_meta_box('ob_property_detail', 'Property Details', 'property_detail', 'ob_property','normal', 'high');
			add_meta_box('ob_property_location', 'Property Location', 'property_location', 'ob_property','normal', 'low');
		}
		
		function property_detail($post) {
			//$ob_image = get_post_meta($post->ID, 'ob_image', true);
			//detail
			$ob_featured = get_post_meta($post->ID, 'ob_featured', true);
			$ob_rent_sale = get_post_meta($post->ID, 'ob_rent_sale', true);
			$ob_price = get_post_meta($post->ID, 'ob_price', true);
			$ob_floor = get_post_meta($post->ID, 'ob_floor', true);
			$ob_material = get_post_meta($post->ID, 'ob_material', true);
			$ob_listing_id = get_post_meta($post->ID, 'ob_listing_id', true);
			$ob_bedrooms = get_post_meta($post->ID, 'ob_bedrooms', true);
			$ob_bathrooms = get_post_meta($post->ID, 'ob_bathrooms', true);
			$ob_plot_size = get_post_meta($post->ID, 'ob_plot_size', true);
			$ob_living_area = get_post_meta($post->ID, 'ob_living_area', true);
			$ob_terrace = get_post_meta($post->ID, 'ob_terrace', true);
			$ob_parking = get_post_meta($post->ID, 'ob_parking', true);
			$ob_built_in_year = get_post_meta($post->ID, 'ob_built_in_year', true);
			$ob_expire = get_post_meta($post->ID, 'ob_expire', true);
			//Conditions
			$ob_condition_essential_repair_done = get_post_meta($post->ID, 'ob_condition_essential_repair_done', true);
			$ob_condition_foundation = get_post_meta($post->ID, 'ob_condition_foundation', true);
			$ob_condition_framework = get_post_meta($post->ID, 'ob_condition_framework', true);
			$ob_condition_need_complete_renewal = get_post_meta($post->ID, 'ob_condition_need_complete_renewal', true);
			$ob_condition_need_decoration = get_post_meta($post->ID, 'ob_condition_need_decoration', true);
			$ob_condition_new_building = get_post_meta($post->ID, 'ob_condition_new_building', true);
			$ob_condition_newly_decorated = get_post_meta($post->ID, 'ob_condition_newly_decorated', true);
			$ob_condition_ready = get_post_meta($post->ID, 'ob_condition_ready', true);
			$ob_condition_renovated = get_post_meta($post->ID, 'ob_condition_renovated', true);
			$ob_condition_under_construction = get_post_meta($post->ID, 'ob_condition_under_construction', true);
		?>
        <table>
            <tr>    
            	<td style="text-align:right;"><label for="ob_rent_sale">Rent/Sale: </label></td>
                <td style="padding: 0 0 0 5px;">
                	<input type="radio" name="ob_rent_sale" id="ob_rent" value="Rent" <?php if($ob_rent_sale == 'Rent') echo "checked"; ?> /> Rent
                	<input type="radio" name="ob_rent_sale" id="ob_sale" value="Sale" <?php if($ob_rent_sale == 'Sale') echo "checked"; ?> /> Sale
                </td>
            </tr>
            <tr>
            	<td style="text-align:right;"><label for="ob_price">Price: </label></td>
                <td style="padding: 0 0 0 5px;"><input type="text" name="ob_price" id="ob_price" value="<?php echo esc_attr($ob_price); ?>" /></td>
            </tr>
            <tr>
            	<td style="text-align:right;"><label for="ob_floor">House Floor: </label></td>
                <td style="padding: 0 0 0 5px;"><input type="text" name="ob_floor" id="ob_floor" value="<?php echo esc_attr($ob_floor); ?>" /></td>
            </tr>
            <tr>    
            	<td style="text-align:right;"><label for="ob_material">House Material: </label></td>
                <td style="padding: 0 0 0 5px;">
                	<select name="ob_material" id="ob_material">
                    	<option <?php if($ob_material == "0") echo "selected"; ?> value="0">---Select House Material---</option>
                    	<option <?php if($ob_material == "Brick") echo "selected"; ?> value="Brick">Brick</option>
                    	<option <?php if($ob_material == "Log") echo "selected"; ?> value="Log">Log</option>
                    	<option <?php if($ob_material == "Log Stone") echo "selected"; ?> value="Log Stone">Log Stone</option>
                    	<option <?php if($ob_material == "Monolith") echo "selected"; ?> value="Monolith">Monolith</option>
                    	<option <?php if($ob_material == "Panel") echo "selected"; ?> value="Panel">Panel</option>
                    	<option <?php if($ob_material == "Stone") echo "selected"; ?> value="Stone">Stone</option>
                    	<option <?php if($ob_material == "Wooden") echo "selected"; ?>value="Wooden">Wooden</option>
                	</select>
                </td>
            </tr>    
            <tr>    
            	<td style="text-align:right;"><label for="ob_bedrooms">No. of Bedrooms: </label></td>
                <td style="padding: 0 0 0 5px;">
                	<select name="ob_bedrooms" id="ob_bedrooms">
                    	<option <?php if($ob_bedrooms == 0) echo "selected"; ?> value="0">---Select No. of Bedrooms---</option>
                    	<option <?php if($ob_bedrooms == 1) echo "selected"; ?> value="1">1</option>
                    	<option <?php if($ob_bedrooms == 2) echo "selected"; ?> value="2">2</option>
                    	<option <?php if($ob_bedrooms == 3) echo "selected"; ?> value="3">3</option>
                    	<option <?php if($ob_bedrooms == 4) echo "selected"; ?> value="4">4</option>
                    	<option <?php if($ob_bedrooms == 5) echo "selected"; ?> value="5">5</option>
                    	<option <?php if($ob_bedrooms == 6) echo "selected"; ?> value="6">6</option>
                    	<option <?php if($ob_bedrooms == 7) echo "selected"; ?>value="7">7</option>
                    	<option <?php if($ob_bedrooms == 8) echo "selected"; ?>value="8">8</option>
                    	<option <?php if($ob_bedrooms == 9) echo "selected"; ?>value="9">9</option>
                    	<option <?php if($ob_bedrooms == 10) echo "selected"; ?>value="10">10</option>
                	</select>
                </td>
            </tr>    
            <tr>    
            	<td style="text-align:right;"><label for="ob_bathrooms">No. of Bathrooms: </label></td>
                <td style="padding: 0 0 0 5px;">
                	<select name="ob_bathrooms" id="ob_bathrooms">
                    	<option <?php if($ob_bathrooms == 0) echo "selected"; ?> value="0">---Select No. of Bathrooms---</option>
                    	<option <?php if($ob_bathrooms == 1) echo "selected"; ?> value="1">1</option>
                    	<option <?php if($ob_bathrooms == 2) echo "selected"; ?> value="2">2</option>
                    	<option <?php if($ob_bathrooms == 3) echo "selected"; ?> value="3">3</option>
                    	<option <?php if($ob_bathrooms == 4) echo "selected"; ?> value="4">4</option>
                    	<option <?php if($ob_bathrooms == 5) echo "selected"; ?> value="5">5</option>
                    	<option <?php if($ob_bathrooms == 6) echo "selected"; ?> value="6">6</option>
                    	<option <?php if($ob_bathrooms == 7) echo "selected"; ?>value="7">7</option>
                    	<option <?php if($ob_bathrooms == 8) echo "selected"; ?>value="8">8</option>
                    	<option <?php if($ob_bathrooms == 9) echo "selected"; ?>value="9">9</option>
                    	<option <?php if($ob_bathrooms == 10) echo "selected"; ?>value="10">10</option>
                	</select>
                </td>
            </tr>
            <tr>    
            	<td style="text-align:right;"><label for="ob_plot_size">Plot Size <i>(m<sup>3</sup>)</i>: </label></td>
                <td style="padding: 0 0 0 5px;"><input type="number" name="ob_plot_size" id="ob_plot_size" value="<?php echo esc_attr($ob_plot_size); ?>" /></td>
            </tr>	
            <tr>    
            	<td style="text-align:right;"><label for="ob_living_area">Living Area <i>(m<sup>3</sup>)</i>: </label></td>
                <td style="padding: 0 0 0 5px;"><input type="number" name="ob_living_area" id="ob_living_area" value="<?php echo esc_attr($ob_living_area); ?>" /></td>
            </tr>	
            <tr>    
            	<td style="text-align:right;"><label for="ob_terrace">Terrace Area <i>(m<sup>3</sup>)</i>: </label></td>
                <td style="padding: 0 0 0 5px;"><input type="number" name="ob_terrace" id="ob_terrace" value="<?php echo esc_attr($ob_terrace); ?>" /></td>
            </tr>
            <tr>    
            	<td style="text-align:right;"><label for="ob_parking">Parking: </label></td>
                <td style="padding: 0 0 0 5px;">
                	<input type="text" name="ob_parking" id="ob_parking_yes" />
                </td>
            </tr>
            <tr>    
            	<td style="text-align:right; vertical-align:text-top;"><label>Condition: </label></td>
                <td style="padding: 0 0 0 5px;">
                	<input type="checkbox" name="ob_condition_essential_repair_done" id="ob_condition_essential_repair_done" value="Yes" <?php if($ob_condition_essential_repair_done == 'Yes') echo "checked"; ?>  /> Essential Repair Done<br/>
                	<input type="checkbox" name="ob_condition_foundation" id="ob_condition_foundation" value="Yes" <?php if($ob_condition_foundation == 'Yes') echo "checked"; ?>  /> Foundation<br/>
                	<input type="checkbox" name="ob_condition_framework" id="ob_condition_framework" value="Yes" <?php if($ob_condition_framework == 'Yes') echo "checked"; ?>  /> Framework<br/>
                	<input type="checkbox" name="ob_condition_need_complete_renewal" id="ob_condition_need_complete_renewal" value="Yes" <?php if($ob_condition_need_complete_renewal == 'Yes') echo "checked"; ?>  /> Need Complete Renewal<br/>
                	<input type="checkbox" name="ob_condition_need_decoration" id="ob_condition_need_decoration" value="Yes" <?php if($ob_condition_need_decoration == 'Yes') echo "checked"; ?>  /> Needs Decoration<br/>
                	<input type="checkbox" name="ob_condition_new_building" id="ob_condition_new_building" value="Yes" <?php if($ob_condition_new_building == 'Yes') echo "checked"; ?>  /> New Building<br/>
                	<input type="checkbox" name="ob_condition_newly_decorated" id="ob_condition_newly_decorated" value="Yes" <?php if($ob_condition_newly_decorated == 'Yes') echo "checked"; ?>  /> Newly Decorated<br/>
                	<input type="checkbox" name="ob_condition_ready" id="ob_condition_ready" id="ob_condition_ready" value="Yes" <?php if($ob_condition_ready == 'Yes') echo "checked"; ?>  /> Ready<br/>
                	<input type="checkbox" name="ob_condition_renovated" id="ob_condition_renovated" value="Yes" <?php if($ob_condition_renovated == 'Yes') echo "checked"; ?> /> Renovated<br/>
                	<input type="checkbox" name="ob_condition_under_construction" id="ob_condition_under_construction" value="Yes" <?php if($ob_condition_under_construction == 'Yes') echo "checked"; ?>  /> Under Construction<br/>
                </td>
            </tr>
            <tr>    
            	<td style="text-align:right;"><label for="ob_built_in_year">Constructed Year: </label></td>
                <td style="padding: 0 0 0 5px;"><input type="year" name="ob_built_in_year" id="ob_built_in_year" value="<?php echo esc_attr($ob_built_in_year); ?>" /></td>
            </tr>
            <tr>    
            	<td style="text-align:right;"><label for="ob_expire">Expiry Date: </label></td>
                <td style="padding: 0 0 0 5px;"><input type="date" name="ob_expire" id="ob_expire" value="<?php echo esc_attr($ob_expire); ?>" /></td>
            </tr>
            <tr>    
            	<td style="text-align:right;"><label for="ob_featured"></label></td>
                <td style="padding: 0 0 0 5px;">
                	<input type="checkbox" name="ob_featured" id="ob_featured" value="Yes" <?php if($ob_featured == 'Yes') echo 'checked="checked"'; ?> /> Featured
                </td>
            </tr>
        </table>
        <?php	
		}
		
		function property_location($post) {
			//$ob_image = get_post_meta($post->ID, 'ob_image', true);
			$ob_lat = get_post_meta($post->ID, 'ob_lat', true);
			$ob_long= get_post_meta($post->ID, 'ob_long', true);
		?>
        	<label for="ob_lat">Latitude: </label>
            <input type="text" id="latbox" name="ob_lat" value="<?php echo esc_attr($ob_lat); ?>"/>
        	<label for="ob_long">Longitude: </label>
            <input type="text" id="lngbox" name="ob_long" value="<?php echo esc_attr($ob_long); ?>"/>
            <br/><br/>
            <i>Drag the marker to the location of the property</i>
            <div id="map_canvas">
                <div id="drag_map" style="width:100%; height:350px;"></div>
            </div>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
			var map;
			function initialize() {
				var myLatlng = new google.maps.LatLng(<?php if(esc_attr($ob_lat)==NULL || esc_attr($ob_long)== NULL) {echo "0,0";} else {echo esc_attr($ob_lat).",".esc_attr($ob_long);} ?>);
			
				var myOptions = {
				 zoom: 2,
				 center: myLatlng,
				 mapTypeId: google.maps.MapTypeId.ROADMAP
				 }
				map = new google.maps.Map(document.getElementById("drag_map"), myOptions); 
				
				var marker = new google.maps.Marker({
				draggable: true,
				position: myLatlng, 
				map: map,
				title: "Your location"
				});
			
				google.maps.event.addListener(marker, 'dragend', function (event) {
					document.getElementById("latbox").value = this.getPosition().lat();
					document.getElementById("lngbox").value = this.getPosition().lng();
				});
			}
			google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        <?php	
		}
		add_action('save_post', function($id){
			/*if(isset($_POST['ob_image']))
			{
				update_post_meta($id, 'ob_image', strip_tags($_POST['ob_image']));
					
			}*/
			if(isset($_POST['ob_rent_sale']))
			{
				update_post_meta($id, 'ob_rent_sale', strip_tags($_POST['ob_rent_sale']));
					
			}
			if(isset($_POST['ob_price']))
			{
				update_post_meta($id, 'ob_price', strip_tags($_POST['ob_price']));
					
			}
			if(isset($_POST['ob_floor']))
			{
				update_post_meta($id, 'ob_floor', strip_tags($_POST['ob_floor']));
					
			}
			if(isset($_POST['ob_material']))
			{
				update_post_meta($id, 'ob_material', strip_tags($_POST['ob_material']));
					
			}
			if(isset($_POST['ob_bedrooms']))
			{
				update_post_meta($id, 'ob_bedrooms', strip_tags($_POST['ob_bedrooms']));
					
			}
			if(isset($_POST['ob_bathrooms']))
			{
				update_post_meta($id, 'ob_bathrooms', strip_tags($_POST['ob_bathrooms']));
					
			}
			if(isset($_POST['ob_plot_size']))
			{
				update_post_meta($id, 'ob_plot_size', strip_tags($_POST['ob_plot_size']));
					
			}
			if(isset($_POST['ob_living_area']))
			{
				update_post_meta($id, 'ob_living_area', strip_tags($_POST['ob_living_area']));
					
			}
			if(isset($_POST['ob_terrace']))
			{
				update_post_meta($id, 'ob_terrace', strip_tags($_POST['ob_terrace']));
					
			}
			if(isset($_POST['ob_parking']))
			{
				update_post_meta($id, 'ob_parking', strip_tags($_POST['ob_parking']));
					
			}
			/*else
			{
				update_post_meta($id, 'ob_parking', "0");
					
			}
			*/
			if(isset($_POST['ob_built_in_year']))
			{
				update_post_meta($id, 'ob_built_in_year', strip_tags($_POST['ob_built_in_year']));
					
			}
			if(isset($_POST['ob_expire']))
			{
				update_post_meta($id, 'ob_expire', strip_tags($_POST['ob_expire']));
					
			}
			if(isset($_POST['ob_featured']))
			{
				update_post_meta($id, 'ob_featured', strip_tags($_POST['ob_featured']));
			}
			else
			{
				update_post_meta($id, 'ob_featured', 'No');
			}

			//Conditions
			if(isset($_POST['ob_condition_essential_repair_done']))
			{
				update_post_meta($id, 'ob_condition_essential_repair_done', strip_tags($_POST['ob_condition_essential_repair_done']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_essential_repair_done', 'No');
			}
			if(isset($_POST['ob_condition_foundation']))
			{
				update_post_meta($id, 'ob_condition_foundation', strip_tags($_POST['ob_condition_foundation']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_foundation', 'No');
			}
			if(isset($_POST['ob_condition_framework']))
			{
				update_post_meta($id, 'ob_condition_framework', strip_tags($_POST['ob_condition_framework']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_framework', 'No');
			}
			if(isset($_POST['ob_condition_need_complete_renewal']))
			{
				update_post_meta($id, 'ob_condition_need_complete_renewal', strip_tags($_POST['ob_condition_need_complete_renewal']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_need_complete_renewal', 'No');
			}
			if(isset($_POST['ob_condition_need_decoration']))
			{
				update_post_meta($id, 'ob_condition_need_decoration', strip_tags($_POST['ob_condition_need_decoration']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_need_decoration', 'No');
			}
			if(isset($_POST['ob_condition_new_building']))
			{
				update_post_meta($id, 'ob_condition_new_building', strip_tags($_POST['ob_condition_new_building']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_new_building', 'No');
			}
			if(isset($_POST['ob_condition_newly_decorated']))
			{
				update_post_meta($id, 'ob_condition_newly_decorated', strip_tags($_POST['ob_condition_newly_decorated']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_newly_decorated', 'No');
			}
			if(isset($_POST['ob_condition_ready']))
			{
				update_post_meta($id, 'ob_condition_ready', strip_tags($_POST['ob_condition_ready']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_ready', 'No');
			}
			if(isset($_POST['ob_condition_renovated']))
			{
				update_post_meta($id, 'ob_condition_renovated', strip_tags($_POST['ob_condition_renovated']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_renovated', 'No');
			}
			if(isset($_POST['ob_condition_under_construction']))
			{
				update_post_meta($id, 'ob_condition_under_construction', strip_tags($_POST['ob_condition_under_construction']));
					
			}
			else
			{
				update_post_meta($id, 'ob_condition_under_construction', 'No');
			}
			
			//Google Map
			if(isset($_POST['ob_long']))
			{
				update_post_meta($id, 'ob_long', strip_tags($_POST['ob_long']));
			}
			if(isset($_POST['ob_lat']))
			{
				update_post_meta($id, 'ob_lat', strip_tags($_POST['ob_lat']));
			}

		});
	}}

add_action('init', function(){
	new ob_Post_Type();
    include dirname(__FILE__).'/offshore-real-estate-shortcodes.php';
    include dirname(__FILE__).'/offshore-real-estate-shortcodes-button.php';
    include dirname(__FILE__).'/offshore-real-estate-options.php';
});

//include('offshore-real-estate-options.php');
include('offshore-real-estate-widgets.php');
include('attach_image.php');
?>