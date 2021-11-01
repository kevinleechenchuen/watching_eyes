<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');


class Upcoming_Auction_Widget extends Widget_Base {

	public function get_name() {
		return 'upcoming-auction-widget';
	}
	
	public function get_title() {
		return 'upcoming-auction-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
		$startDate = date("Y-m-d");
		$endDate = date("Y-m-d", strtotime('+ 1 month'));
        $url = "http://128.199.148.89:8000/api/v1/auction/?auction_start_date__gte=$startDate&auction_end_date__gte=$endDate";
        echo $url;
        
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }
        renderUpcomingAuction($body->auctions);
	}
	
	protected function _content_template() {

    }

    
	
	
}