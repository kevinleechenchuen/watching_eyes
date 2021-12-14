<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');

class Auction_Watches_Widget extends Widget_Base {

	public function get_name() {
		return 'auction-watches-widget';
	}
	
	public function get_title() {
		return 'auction-watches-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
        $current_user = wp_get_current_user();

        $q_auction_start_date = $_GET['auctionStartDate'];
        $q_auction_end_date = $_GET['auctionEndDate'];

        $q_auction_name = $_GET['auctionName'];
        $q_auction_type = $_GET['auctionType'];
        $q_auction_title = $_GET['auctionTitle'];
        $q_auction_min_estimate_price = $_GET['auctionMinEstPrice'];
        $q_auction_max_estimate_price = $_GET['auctionMaxEstPrice'];
        $q_auction_min_current_bid = $_GET['auctionMinBid'];
        $q_auction_max_current_bid = $_GET['auctionMaxBid'];
        $q_auction_status = explode(",", $_GET['auctionStatus']);
        $q_page = $_GET['pg'] == '' ? 1 : $_GET['pg'];
        

        $emptyStartDate = date("Y-m-d");
        $emptyEndDate = date("Y-m-d", strtotime('+ 6 month'));
        
        $encoded_auction_name = encodeURIComponent($q_auction_name);
        $encoded_auction_title = encodeURIComponent($q_auction_title);

        $auctionNameParam = $q_auction_name == '' ? '' : "&auction_name__in=$encoded_auction_name";
        $auctionTypeQueryParam = $q_auction_type == '' ? '' : "&auction_type__in=$q_auction_type";
        $auctionTitleQueryParam = $q_auction_title == '' ? '' : "&auction_title__in=$encoded_auction_title";
        $auctionMinEstPriceQueryParam = $q_auction_min_estimate_price == '' ? '' : "&min_estimate_price__gte=$q_auction_min_estimate_price&min_estimate_price__lte=$q_auction_min_estimate_price";
        $auctionMaxEstPriceQueryParam = $q_auction_max_estimate_price == '' ? '' : "&max_estimate_price__gte=$q_auction_max_estimate_price&max_estimate_price__lte=$q_auction_max_estimate_price";
        $auctionMinBidQueryParam = $q_auction_min_current_bid == '' ? '' : "&current_bid__gte=$q_auction_min_current_bid";
        $auctionMaxBidQueryParam = $q_auction_max_current_bid == '' ? '' : "&current_bid__lte=$q_auction_max_current_bid";
        $pageQueryParam = $q_page == '' ? '' : "&page=$q_page";

        $auctionStatusQueryParam = "";
        foreach ($q_auction_status as $status) {
            $auctionStatusQueryParam = ($status == '') ? "$auctionStatusQueryParam" : "$auctionStatusQueryParam&status__in=$status";
        }
         
        echo "<div class='search-result-label'>
                <h1>$q_auction_name</h1>
                <h7>$q_auction_title</h7>
                <br>
                <h7>Start date: $q_auction_start_date | End date: $q_auction_end_date</h7>
            </div>";

        $url = "http://128.199.148.89:8000/api/v1/auction/watches?$auctionNameParam$auctionTypeQueryParam$auctionTitleQueryParam$auctionMinEstPriceQueryParam$auctionMaxEstPriceQueryParam$auctionMinBidQueryParam$auctionMaxBidQueryParam$auctionStatusQueryParam$pageQueryParam";
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }
        
        echo "<div class='item-card-desc-title'>
                <h5>Filters</h5>
            </div>";
        renderAuctionWatchesResultsWithFilter($body->auctionWatches, (int)$q_page);
	}
	
	protected function _content_template() {

    }

    function encodeURIComponent($str) {
        return str_replace('&', '%26', $str);
    }
}