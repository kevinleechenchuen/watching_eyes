<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');


class Latest_Forum_Widget extends Widget_Base {

	public function get_name() {
		return 'latest-forum-widget';
	}
	
	public function get_title() {
		return 'latest-forum-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
		echo "<div class='flex-container home-section-heading'>
				<h2>Latest Forum Listing​</h2>
				<div class='flex-to-right'>
					<button class='orange-button' onclick=\"location.href='/search?q=&sourceType=Forum'\">VIEW ALL</button>
				</div>
			</div>";
        $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches?source_type__in=Forum";
        
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }
        renderHorizontalListing(array_slice($body->forumWatches, 0, 10), 'latest-forum');
	}
	
	protected function _content_template() {

    }

    
	
	
}