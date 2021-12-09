<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');


class Top_10_Watches_Widget extends Widget_Base {

	public function get_name() {
		return 'top-10-watches-widget';
	}
	
	public function get_title() {
		return 'top-10-watches-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
		echo "<div class='flex-container'>
				<h2>Top 10 Retail Watches​</h2>
				<div class='flex-to-right'>
					<button class='scroll-arrow-left scroll-button'><</button>
					<button class='scroll-arrow-right scroll-button'>></button>
				</div>
			</div>";
        $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches/retail/top";
        echo $url;
        
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }
        renderHorizontalListing($body->topWatches, 'top-10-watches');
	}
	
	protected function _content_template() {

    }

    
	
	
}