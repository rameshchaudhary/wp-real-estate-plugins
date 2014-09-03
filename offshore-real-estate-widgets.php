<?php
//error_reporting(E_ALL);
class ob_property_list extends WP_Widget {
	
	function __construct()
	{
		$params = array(
			'description' => 'List of OB Properties',
			'name' => 'Offshore Real Estate Property List'
		);
		parent::__construct('ob_property_list', '', $params);
	}
	
	public function form($instance)
	{ 
		extract($instance);
		?>
        <table>
        	<tr>
            	<td>
                    <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                </td>
                <td>
                    <input
                        type="text"
                        class="widefat"
                        id="<?php echo $this->get_field_id('title'); ?>"
                        name="<?php echo $this->get_field_name('title'); ?>"
                        value="<?php if(isset($title)) echo esc_attr($title); if($title == NULL) echo "Offshore Property List"; ?>"/>
               </td>
            </tr> 
            <tr>
            	<td>
		           <label for="<?php echo $this->get_field_id('num_properties'); ?>">No. of properties:</label>
                </td>
                <td>
                    <input
                    	type="number"
                        size="3"
                        id="<?php echo $this->get_field_id('num_properties'); ?>"
                        name="<?php echo $this->get_field_name('num_properties'); ?>"
                        value="<?php if(isset($num_properties)) echo esc_attr($num_properties); if($num_properties == NULL) echo 5; ?>"/>
                </td>
            </tr>    
            <tr>
            	<td>
		        	<label for="<?php echo $this->get_field_id('display'); ?>">Display:</label>
                </td>
                <td>
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('display'); ?>"
                        value="all"
                        name="<?php echo $this->get_field_name('display'); ?>"
                        <?php if($display == 'all' || $display == NULL) echo "checked='checked'"; ?>/> All Properties
                    <br/>    
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('display'); ?>"
                        value="featured"
                        name="<?php echo $this->get_field_name('display'); ?>"
                        <?php if($display == 'featured') echo "checked='checked'"; ?>/> Featured Properties Only
                </td>
            </tr>    
            <tr>
            	<td>
		        	<label for="<?php echo $this->get_field_id('rent_sale'); ?>">Rent/Sale:</label>
                </td>
                <td>
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('rent_sale'); ?>"
                        value="all"
                        name="<?php echo $this->get_field_name('rent_sale'); ?>"
                        <?php if($rent_sale == 'all' || $rent_sale == NULL) echo "checked='checked'"; ?>/> Rent or Sale
                    <br/>    
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('rent_sale'); ?>"
                        value="rent"
                        name="<?php echo $this->get_field_name('rent_sale'); ?>"
                        <?php if($rent_sale == 'rent') echo "checked='checked'"; ?>/> Rent Only
                    <br/>    
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('rent_sale'); ?>"
                        value="sale"
                        name="<?php echo $this->get_field_name('rent_sale'); ?>"
                        <?php if($rent_sale == 'sale') echo "checked='checked'"; ?>/> Sale Only
                </td>
            </tr>    
            <tr>
            	<td>
		        	<label for="<?php echo $this->get_field_id('sort'); ?>">Sort:</label>
                </td>
                <td>
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('sort'); ?>"
                        value="random"
                        name="<?php echo $this->get_field_name('sort'); ?>"
                        <?php if($sort == 'random' || $sort == NULL) echo "checked='checked'"; ?>/> Random
                    <br/>    
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('sort'); ?>"
                        value="recent"
                        name="<?php echo $this->get_field_name('sort'); ?>"
                        <?php if($sort == 'recent') echo "checked='checked'"; ?>/> Recent
                </td>
            </tr>    
            <tr>
            	<td>
		        	<label for="<?php echo $this->get_field_id('price'); ?>">Show Price:</label>
                </td>
                <td>
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('price'); ?>"
                        value="Yes"
                        name="<?php echo $this->get_field_name('price'); ?>"
                        <?php if($price == 'Yes' || $price == NULL) echo "checked='checked'"; ?>/> Yes
                    <br/>    
                    <input
                        type="radio"
                        id="<?php echo $this->get_field_id('price'); ?>"
                        value="No"
                        name="<?php echo $this->get_field_name('price'); ?>"
                        <?php if($price == 'No') echo "checked='checked'"; ?>/> No
                </td>
            </tr>
            <tr>
            	<td>
		        	<label for="<?php echo $this->get_field_id('location'); ?>">Location:</label>
                </td>
                <td>
					<?php
                    $categories2 = get_categories('taxonomy=location');
                    
                    $select2 = "<select name='".$this->get_field_name('location')."' id='".$this->get_field_id('location')."' class='widefat'>";
                    $select2 .= "<option value='all'>Location (All)</option>";
                    
                    foreach($categories2 as $category2){
                        if($category2->count > 0){
                            $select2 .= "<option value='".$category2->slug."'";
							if($location == $category2->slug) {
								 $select2 .= " selected='selected'";
							}
							$select2 .= ">".$category2->name."</option>";
                        }
                    }
                    $select2 .= "</select>";
					echo $select2;
                    ?>
                </td>
            </tr>    
            <tr>
            	<td>
		        	<label for="<?php echo $this->get_field_id('ptype'); ?>">Type:</label>
                </td>
                <td>
                <?php
                   $categories =  get_categories('taxonomy=property_type');
                     echo "<br/>";
                     foreach ($categories as $cat) {
                         $option = '<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
                            if (is_array($instance['cats'])) {
                                foreach ($instance['cats'] as $cats) {
                                    if($cats == $cat->term_id) {
                                         $option .= ' checked="checked"';
                                    }
                                }
                            }
                            else {
								 $option = $option.' checked="checked"';
                            }
                            $option .= ' value="'.$cat->term_id.'" />';
							$option .= '&nbsp;';
                            $option .= $cat->cat_name;
                            $option .= '<br />';
                            echo $option;
                         }
                    ?>
                </td>
            </tr>    
        </table>       
        <?php
	}
	
	public function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		//echo '<pre>', print_r($args,true), '</pre><br/><hr/><br/>';
		//echo '<pre>', print_r($instance,true), '</pre>';
		$widget_args = array();
		$widget_args['post_type'] = "ob_property";

		if(empty($title))
		{
			$title = "Offshore Property List";
		}
		if(empty($num_properties))
		{
			$num_properties = 5;
		}
		$widget_args['posts_per_page'] = $num_properties;
		
		if($sort == 'recent' )
		{
			$widget_args['orderby'] = "date";
			$widget_args['order'] = "DESC";
		}
		else
		{
			$widget_args['orderby'] = "rand";
		}
		if($display != "all" || $rent_sale !== "all")
		{
			$widget_args['meta_query']['relation'] = "AND";

			if($display != "all")
			{					
				$widget_args['meta_query'][] = array(
                    'key' => 'ob_featured',
                    'value' => 'Yes',
                    'compare' => '=',
				);
			}
			if($rent_sale != "all")
			{
				if($rent_sale == "rent")
				{					
					$widget_args['meta_query'][] = array(
						'key' => 'ob_rent_sale',
						'value' => 'rent',
						'compare' => '=',
					);
				}
				if($rent_sale == "sale")
				{					
					$widget_args['meta_query'][] = array(
						'key' => 'ob_rent_sale',
						'value' => 'sale',
						'compare' => '=',
					);
				}
			}
		}
		$widget_args['tax_query']['relation'] = 'AND';
		$widget_args['tax_query'][] =	array(
			'taxonomy' => 'property_type',
			'field' => 'slug',
			'terms' => array(),
			'operator' => 'OR'
		);
		if(is_array($ptype))
		{	
			foreach($ptype as $type)
			{
				$widget_args['tax_query'][0]['terms'][] = $type;
			}
		}
		
		if($location == "all" || $location == "Location (All)")
		{
			$widget_args['location'] = array();
		}
		else
		{
			$widget_args['location'] = $location;
		}
		
		//echo '<pre>', print_r($widget_args,true), '</pre>';

		$loop3=new WP_Query($widget_args);
		echo $before_widget;
			echo $before_title . $title . $after_title;
			
		if($loop3->have_posts()){
			$output3='<ul>';
	
			while($loop3->have_posts()){
				$loop3->the_post();
				$meta=get_post_meta(get_the_id(),'');
				$output3.='
					<li>
						<div><a href="' .get_permalink(). '">'.
							get_the_post_thumbnail().'<br/>'.
							get_the_title();
				if($price == "Yes")			
					$output3.='<br/>$'.$meta[ob_price][0];
				$output3 .=	'</a></div><br/>	
					</li>';
			}
			$output3 .= '</ul>';
			echo $output3;

		}
		echo $after_widget;

	}
}
add_action('widgets_init', 'register_ob_property_list_widget');
function register_ob_property_list_widget()
{
	register_widget('ob_property_list');
}
?>