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
		$startDate = date("Y-m-d", strtotime('- 1 month'));
		$endDate = date("Y-m-d", strtotime('+ 1 month'));
		echo "<div class='flex-container home-section-heading'>
				<h2>Upcoming Auctions</h2>
				<div class='flex-to-right'>
					<a href='/auction-watches?sourceType=Auction&auctionStartDate=$startDate&auctionEndDate=$endDate&isAll=1&auctionStatus=Upcoming'>
						<button class='orange-button'>VIEW ALL</button>
					</a>
				</div>
			</div>";
		
        $url = "http://128.199.148.89:8000/api/v1/auction/?auction_start_date__gte=$startDate&auction_end_date__gte=$endDate";
        $response = wp_remote_get($url);
		// echo $url;
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