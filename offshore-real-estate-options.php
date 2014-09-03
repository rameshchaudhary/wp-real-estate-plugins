<?php
class OB_Settings{
	public $options;
	public function __construct()
	{
		$this->options = get_option('ob_properties_settings');
		$this->register_settings_and_fields();
	}
	public function add_menu_page()
	{
		add_options_page('Offshore Bees Property Settings', 'Offshore Bees Property Settings', 'administrator', __FILE__, array('OB_Settings', 'display_settings_page'));
	}
	public function display_settings_page()
	{
		?>
		<div class="wrap">
            <h2>Offshore Bees Property Settings</h2>
            <?php
			$o = get_option('ob_properties_settings');
			// echo "<pre>".print_r($o)."</pre>";
			 ?>
            <form method="post" action="options.php" enctype="multipart/form-data" >
            	<?php settings_fields('ob_properties_settings'); ?>	
            	<?php do_settings_sections(__FILE__); ?>
                
                <p class="submit">
                	<input name="submit" type="submit" class="button-primary" value="Save Changes" />.
                </p>
            </form>
        </div>
		<?php
	}
	public function register_settings_and_fields()
	{
		register_setting('ob_properties_settings', 'ob_properties_settings'); //3rd param = optional cb.
		add_settings_section('ob_unit_section', 'Unit Settings', array($this, 'ob_unit_section_cb'), __FILE__); //id, title of the section, cb, page.
		add_settings_field('ob_currency', 'Currency', array($this, 'ob_currency_setting'), __FILE__, 'ob_unit_section');
		add_settings_field('ob_area_unit', 'Area Unit', array($this, 'ob_area_unit_setting'), __FILE__, 'ob_unit_section');
	}
	public function ob_unit_section_cb()
	{
		//optional
	}
	/*
	*
	*
	Inputs
	*
	*
	*/
	public function ob_currency_setting() 
	{
		$o = get_option('ob_properties_settings');
		//$items = array('&#36;', '&pound;', '&yen;', '&euro;' );
		//$items_value = array('Dollar', 'Pound', 'Yen', 'Euro' );
		echo "<select name='ob_properties_settings[ob_currency]' />";

		echo "<option value='Dollar'"; if($o['ob_currency'] == 'Dollar'){echo 'selected="selected"';}
		echo " >Dollar (&#36;)</option>";

		echo "<option value='Pound'"; if($o['ob_currency'] == 'Pound'){echo 'selected="selected"';}
		echo " >Pound (&pound;)</option>";

		echo "<option value='Yen'"; if($o['ob_currency'] == 'Yen'){echo 'selected="selected"';}
		echo " >Yen (&yen;)</option>";

		echo "<option value='Euro'"; if($o['ob_currency'] == 'Euro'){echo 'selected="selected"';}
		echo " >Euro (&euro;)</option>";

		/*echo "<option value='Dollar'"; if($o['ob_currency'] == 'Dollar'){echo 'selected="selected"';}
		echo " >Dollar (&#36;)</option>";*/

		echo "</select>";
	}
	public function ob_area_unit_setting() 
	{
		$o = get_option('ob_properties_settings');
		echo "<select name='ob_properties_settings[ob_area]' />";

		echo "<option value='sq_meter'"; if($o['ob_area'] == 'sq_meter'){echo 'selected="selected"';}
		echo " >Square Meter (m&sup2;)</option>";

		echo "<option value='sq_kilometer'"; if($o['ob_area'] == 'sq_kilometer'){echo 'selected="selected"';}
		echo " >Square Kilometer (km&sup2;)</option>";

		echo "<option value='sq_feet'"; if($o['ob_area'] == 'sq_feet'){echo 'selected="selected"';}
		echo " >Square Feet (ft&sup2;)</option>";

		echo "<option value='sq_yard'"; if($o['ob_area'] == 'sq_yard'){echo 'selected="selected"';}
		echo " >Square Yard (yd&sup2;)</option>";

		echo "<option value='sq_mile'"; if($o['ob_area'] == 'sq_mile'){echo 'selected="selected"';}
		echo " >Square Mile (mi&sup2;)</option>";

		/*echo "<option value='sq_feet'"; if($o['ob_area'] == 'sq_feet'){echo 'selected="selected"';}
		echo " >Square Feet (ft&sup2;)</option>";*/

		echo "</select>";
	}
}
add_action('admin_menu', function(){
	OB_Settings::add_menu_page();
});
add_action('admin_init', function(){
	new OB_Settings();
});
?>