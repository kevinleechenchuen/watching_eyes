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
        $q_auction_title = $_GET['auctionTitle'] != '' ? explode("|", $_GET['auctionTitle']) : [];
        $q_auction_status = explode(",", $_GET['auctionStatus']);
        $q_currency = explode(",", $_GET['currency']);
        $q_brand = explode(",", $_GET['brand']);
        $q_page = $_GET['pg'] == '' ? 1 : $_GET['pg'];
        
        $encoded_auction_name = encodeURIComponent($q_auction_name);

        $auctionNameParam = $q_auction_name == '' ? '' : "&auction_name__in=$encoded_auction_name";
        $auctionTypeQueryParam = $q_auction_type == '' ? '' : "&auction_type__in=$q_auction_type";
        $pageQueryParam = $q_page == '' ? '' : "&page=$q_page";
        $startDateQueryParam = $q_auction_start_date == '' ? '' : "&auction_start_date__gte=$q_auction_start_date";
        $endDateQueryParam = $q_auction_end_date == '' ? '' : "&auction_end_date__lte=$q_auction_end_date";

        $auctionStatusQueryParam = "";
        foreach ($q_auction_status as $status) {
            $auctionStatusQueryParam = ($status == '') ? "$auctionStatusQueryParam" : "$auctionStatusQueryParam&status__in=$status";
        }
        $auctionBrandQueryParam = "";
        foreach ($q_brand as $brand) {
            $encodedBrand = encodeURIComponent($brand);
            $auctionBrandQueryParam = ($encodedBrand == '') ? "$auctionBrandQueryParam" : "$auctionBrandQueryParam&brand__in=$encodedBrand";
        }
        $auctionTitleQueryParam = "";
        foreach ($q_auction_title as $title) {
            $encodedTitle = encodeURIComponent($title);
            $auctionTitleQueryParam = ($encodedTitle == '') ? "$auctionTitleQueryParam" : "$auctionTitleQueryParam&auction_title__in=$encodedTitle";
        }
        $currencyQueryParam = "";
        foreach ($q_currency as $currency) {
            $currencyQueryParam = ($currency == '') ? "$currencyQueryParam" : "$currencyQueryParam&currency__in=$currency";
        }

        $auction_h1_title = ($q_auction_name == '') ? "Auction Lots" : $q_auction_name;
         
        echo "<div class='search-result-label auction'>
                <h1>$auction_h1_title</h1>";

        echo "<div class='search-result-filters'>";
        if($_GET['brand'] != '') {
            $asdasd = explode(",", $_GET['brand']);
            foreach ($asdasd as $item) {
                echo "<div class='search-result-filters-card'>
                            <div class='search-result-filters-card-name'>
                                $item
                            </div>
                            <a class='remove-search-result-filters-card' onclick='removeAuctionWatchesSearchFilter(\"brand\", \"$item\");'>x
                            </a>
                        </div>";
            }
        }
        echo "</div>";

        $auction_h7_title = "";
        foreach ($q_auction_title as $title) {
            $auction_h7_title = $auction_h7_title . $title . " | ";
        }
        echo "<h7>$auction_h7_title</h7>";

        if($_GET['isAll'] != '1' || $auction_h7_title != "") {
            echo "<h7>Start date: $q_auction_start_date | End date: $q_auction_end_date</h7>";
        }

        echo "</div>";

        $url = "http://128.199.148.89:8000/api/v1/auction/watches?$auctionNameParam$auctionTypeQueryParam$auctionTitleQueryParam$auctionStatusQueryParam$auctionBrandQueryParam$pageQueryParam$startDateQueryParam$endDateQueryParam$currencyQueryParam";
        // echo $url;
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }

        $auctionTitleList=array();
        if($auction_h7_title == '')
        {
            $startDate = date("Y-m-d");
		    $endDate = date("Y-m-d", strtotime('+ 1 month'));
            $url = "http://128.199.148.89:8000/api/v1/auction/?auction_start_date__gte=$startDate&auction_end_date__gte=$endDate";
            $response = wp_remote_get($url);
            if ( is_array( $response ) && ! is_wp_error( $response ) ) {
                $body2 = json_decode($response['body']);
            } else {
                return null;
            }

            foreach ($body2->auctions as $item) {
                if (!in_array($item->auction_title, $auctionTitleList)) {
                    array_push($auctionTitleList,$item->auction_title);
                }
            }
        }

        $currencies = array();
        array_push($currencies,'USD');
        array_push($currencies,'GBP');
        array_push($currencies,'EUR');
        array_push($currencies,'CHF');

        renderAuctionWatchesResultsWithFilter($body->auctionWatches, (int)$q_page, $body->filters, $body->pages, $auctionTitleList, $currencies);
	}
	
	protected function _content_template() {

    }

    function encodeURIComponent($str) {
        return str_replace('&', '%26', $str);
    }
}