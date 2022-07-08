<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');


class Bookmarked_Lots_Widget extends Widget_Base {

	public function get_name() {
		return 'bookmarked-lots-widget';
	}
	
	public function get_title() {
		return 'bookmarked-lots-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
		$current_user = wp_get_current_user();
		$q_page = isset($_GET['pg']) ? $_GET['pg'] : 1;
		$q_query = isset($_GET['bookmarkQuery']) ? $_GET['bookmarkQuery'] : '';

		$pageQueryParam = $q_page == '' ? '' : "&page=$q_page";
		$searchQueryParam = $q_query == '' ? '' : "&q=$q_query";

		if(isset($current_user->data->ID))
		{
			$userId = $current_user->data->ID;
			$url = "http://128.199.148.89:8000/api/v1/users/$userId/bookmark?$pageQueryParam$searchQueryParam&source_type=auction";
			// echo $url;
			$response = wp_remote_get($url);
			if ( is_array( $response ) && ! is_wp_error( $response ) ) {
				$body = json_decode($response['body']);
			} else {
				echo 'something went wrong!';
				return null;
			}

			echo "<div class='header-bookmark-search-container'>
                <input type='text' class='bookmark-search-textbox' id='bookmark-search-textbox' name='bookmark-search-textbox' placeholder='Enter keyword...'>
                <button class='header-search-button' onClick='searchBookmark(\"auction\")'>SEARCH</button>
                </div>
                <div>
                    <label id='bookmark-search-textbox-error' class='error-msg'></label>
                </div>
                ";
			renderBookmarkedWatches($body->bookmarkedWatches, $userId, $body->page, $body->pages);
		} else {
			echo "<div class='flex-container'>
					<h4>Log in to view bookmarked watches</h4>
				</div>";
		}
		
	}
	
	protected function _content_template() {

    }

    
	
	
}