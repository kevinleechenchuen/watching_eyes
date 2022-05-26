<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');

class Auction_Widget extends Widget_Base {

	public function get_name() {
		return 'auction-widget';
	}
	
	public function get_title() {
		return 'auction-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
        wp_register_script('slider', '/wp-content/themes/hello-elementor/assets/js/slider.js', array('jquery'),'1.1', true);
        wp_enqueue_script('slider');
        $current_user = wp_get_current_user();

        $q_auction_name = $_GET['auctionName'];
        $q_auction_type = explode(",", $_GET['auctionType']);
        $q_auction_start_date = $_GET['auctionStartDate'];
        $q_auction_end_date = $_GET['auctionEndDate'];

        $emptyStartDate = date("Y-m-d");
		$emptyEndDate = date("Y-m-d", strtotime('+ 6 month'));

        $auctionNameParam = $q_auction_name == '' ? '' : "&auction_name__in=$q_auction_name";
        $auctionStartQueryParam = $q_auction_start_date == '' ? "" : "&auction_start_date__gte=$q_auction_start_date";
        $auctionEndQueryParam = $q_auction_end_date == '' ? "" : "&auction_end_date__gte=$q_auction_end_date";
        
        $auctionTypeQueryParam = "";
        foreach ($q_auction_type as $type) {
            $auctionTypeQueryParam = $type == '' ? "$auctionTypeQueryParam" : "$auctionTypeQueryParam&auction_type__in=$type";
        }
        // $auctionStartQueryParam = $q_auction_start_date == '' ? "&auction_start_date__gte=$emptyStartDate" : "&auction_start_date__gte=$q_auction_start_date";
        // $auctionEndQueryParam = $q_auction_end_date == '' ? "&auction_end_date__gte=$emptyEndDate" : "&auction_end_date__gte=$q_auction_end_date";

        echo "<div class='search-result-label'>
                <h1>Auction Calendar</h1>
            </div>";

        $url = "http://128.199.148.89:8000/api/v1/auction?$auctionNameParam$auctionTypeQueryParam$auctionStartQueryParam$auctionEndQueryParam";
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }
        renderAuctionResultsWithFilter($body->auctions, $body->filters);
	}
	
	protected function _content_template() {

    }

    
	
	
}