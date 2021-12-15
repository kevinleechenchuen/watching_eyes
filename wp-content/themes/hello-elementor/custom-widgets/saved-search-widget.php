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
                <button class='header-search-button' onClick='saveSearch($current_user->ID)'>SAVE</button>
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
                            <a class='delete-saved-search' onclick='removeSaveSearch($item->ID, \"$item->Name\");'>x</a>
                        </div>";
                }
                echo "</div>";
            } else {
                echo "not signed in";
            }
    }
	
	protected function _content_template() {

    }
}