<?php
//add a button to the content editor, next to the media button
//this button will show a popup that contains inline content
add_action('media_buttons_context', 'add_my_custom_button');

//add some content to the bottom of the page 
//This will be shown in the inline modal
add_action('admin_footer', 'add_inline_popup_content');

//action to add a custom button to the content editor
function add_my_custom_button($context) {
  
  //path to my icon
  $img = plugins_url( 'penguin.png' , __FILE__ );
  
  //the id of the container I want to show in the popup
  $container_id = 'popup_container';
  
  //our popup's title
  $title = 'An Inline Popup!';

  //append the icon
  //$context .= "<a class='button' onclick='insertShortcode();'>Offshore Property List</a>";
  $context = "<a href='#TB_inline?width=400&inlineId=popup_container'
    class='thickbox button' title='Offshore Real Estate Shortcodes'>Offshore Real Estate Shortcodes</a>";
  return $context;
}

function add_inline_popup_content() {
?>
<script type="text/javascript">
function insertShortcode_property_list_column() {
    window.parent.send_to_editor('[offshore_property list=4]');
    window.parent.tb_remove();
}
function insertShortcode_property_list_row() {
    window.parent.send_to_editor('[offshore_property_rows row=4]');
    window.parent.tb_remove();
}
function insertShortcode_property_search() {
    window.parent.send_to_editor('[offshore_property_search]');
    window.parent.tb_remove();
}
function insertShortcode_property_search_form() {
    window.parent.send_to_editor('[offshore_property_search_form]');
    window.parent.tb_remove();
}
function insertShortcode_property_detail() {
    window.parent.send_to_editor('[offshore_property_details]');
    window.parent.tb_remove();
}
function insertShortcode_property_map() {
    window.parent.send_to_editor('[offshore_property_map]');
    window.parent.tb_remove();
}
</script>
<div id="popup_container" style="display:none;">
    <h2>List of shortcodes in OffShore Real Estate Plugin</h2>
    <a class='button' onclick='insertShortcode_property_list_column();'>Offshore Property List Column</a><br/><br/>
    <a class='button' onclick='insertShortcode_property_list_row()();'>Offshore Property List Row</a><br/><br/>
    <a class='button' onclick='insertShortcode_property_search()();'>Offshore Property Search</a><br/><br/>
    <a class='button' onclick='insertShortcode_property_search_form()();'>Offshore Property Search Form</a><br/><br/>
    <a class='button' onclick='insertShortcode_property_detail()();'>Offshore Property Detail</a><br/><br/>
    <a class='button' onclick='insertShortcode_property_map()();'>Offshore Property Map</a><br/><br/>
</div>
<?php
}
?>
