<?php
namespace Elementor;
class Saved_Search_Widget extends Widget_Base {

	public function get_name() {
		return 'saved-search-widget';
	}
	
	public function get_title() {
		return 'saved-search-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }
	
	protected function render() {
        $domain = $_SERVER['HTTP_HOST'];
        if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                echo "<div class='header-search-container' style='width=70%;'>
                <input type='text' class='save-search-textbox' name='save-search-textbox' placeholder='Enter keyword...'>
                <script>
                    function saveSearch(){
                        var saveQuery = document.getElementsByName('save-search-textbox')[0].value;

                        if(saveQuery === ''){
                            jQuery('#save-search-textbox-error').html('Keyword cannot be empty!');
                            return null;
                        } else {
                            jQuery.ajax({
                            type: 'POST',
                            url: 'https://{$domain}/wp-json/custom/v1/save_search',
                            dataType: 'jsonp',
                            data: {userid: {$current_user->ID}, query: saveQuery, name: saveQuery},

                            success: function (data) {
                                console.log(data);
                                if(data == 'success') { 
                                    location.reload(); 
                                }    
                            }
                            });
                            jQuery('#save-search-textbox-error').html('');
                        }

                        
                    }
                </script>
                <button class='header-search-button' onClick='saveSearch()'>SAVE</button>
                </div>
                <div>
                    <label id='save-search-textbox-error' class='error-msg'></label>
                </div>
                ";
                global $wpdb;
                $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}saved_search WHERE UserId = {$current_user->ID}", OBJECT );

                echo "<div class='save-search-container'>";
                foreach ($results as $item) {
                    echo "<div class='save-search-item'>
                            <a class='saved-search' href='https://{$_SERVER['HTTP_HOST']}/search?q=$item->Name'>
                                <div class='save-search-item-name'>
                                    $item->Name
                                </div>
                            </a>
                            <a class='delete-saved-search' href='#' onclick='removeSaveSearch($item->ID);'>x</a>
                        </div>";
                }
                echo "</div>
                <script>
                    function removeSaveSearch(id){
                            jQuery.ajax({
                                type: 'DELETE',
                                url: 'https://{$domain}/wp-json/custom/v1/save_search/'+id,
                                dataType: 'jsonp',
                                data: {id: id},

                                success: function (data) {
                                    console.log(data);
                                    if(data == 'success') { 
                                        location.reload(); 
                                    }    
                                }
                            });
                    }
                </script>";
            } else {
                echo "not signed in";
            }
    }
	
	protected function _content_template() {

    }
}