<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');

class Search_Widget extends Widget_Base {

	public function get_name() {
		return 'search-widget';
	}
	
	public function get_title() {
		return 'search-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
        $current_user = wp_get_current_user();

        $q_query = isset($_GET['q']) ? $_GET['q'] : '';
        $q_brand = isset($_GET['brand']) ? explode(",", $_GET['brand']) : array();
        $q_model = isset($_GET['model']) ? explode(",", $_GET['model']) : array();
        $q_currency = isset($_GET['currency']) ? explode(",", $_GET['currency']) : array(); 
        $q_sourceName = isset($_GET['sourceName']) ? explode(",", $_GET['sourceName']) : array();
        $q_sourceType = isset($_GET['sourceType']) ?explode(",", $_GET['sourceType']) : array();
        $q_priceFrom = isset($_GET['priceFrom']) ? $_GET['priceFrom'] : '';
        $q_priceTo = isset($_GET['priceTo']) ? $_GET['priceTo'] : '';
        $q_page = isset($_GET['pg']) ? $_GET['pg'] : 1;
        $q_sortby = isset($_GET['sort']) ? $_GET['sort'] : 0;
        $q_acc = isset($_GET['acc']) ? $_GET['acc'] : 'false';
        $q_lastUpdated = isset($_GET['lastUpdated']) ? $_GET['lastUpdated'] : '';
        $q_status = isset($_GET['status']) ? explode(",", $_GET['status']) : array();

        switch($q_lastUpdated){
            case 'm_6':
                $lastUpdateDate = date("Y-m-d", strtotime("-6 months"));
                break;
            case 'm_3':
                $lastUpdateDate = date("Y-m-d", strtotime("-3 months"));
                break;
            case 'm_1':
                $lastUpdateDate = date("Y-m-d", strtotime("-1 months"));
                break;
            case 'w_1':
                $lastUpdateDate = date("Y-m-d", strtotime("-1 weeks"));
                break;
        }
        

        $queryParam = $q_query == '' ? '' : "&q=$q_query";
        $priceFromQueryParam = $q_priceFrom == '' ? '' : "&product_price__gte=$q_priceFrom";
        $priceToQueryParam = $q_priceTo == '' ? '' : "&product_price__lte=$q_priceTo";
        $pageQueryParam = $q_page == '' ? '' : "&page=$q_page";
        $sortQueryParam = $q_sortby == '' ? '' : "&sort_by=$q_sortby";
        $accQueryParam = $q_acc == 'true' ? "&acc__in=true" : "&acc__in=false";
        $lastUpdatedQueryParam = $q_lastUpdated == '' ? '' : "&last_post_date__gte=$lastUpdateDate";

        $brandQueryParam = "";
        foreach ($q_brand as $brand) {
            $brand = encodeURIComponent($brand);
            $brandQueryParam = ($brand == '') ? "$brandQueryParam" : "$brandQueryParam&brand__in=$brand";
        }
        $modelQueryParam = "";
        foreach ($q_model as $model) {
            $model = encodeURIComponent($model);
            $modelQueryParam = ($model == '') ? "$modelQueryParam" : "$modelQueryParam&model__in=$model";
        }
        $sourceNameQueryParam = "";
        foreach ($q_sourceName as $sourceName) {
            $sourceName = encodeURIComponent($sourceName);
            $sourceNameQueryParam = ($sourceName == '') ? "$sourceNameQueryParam" : "$sourceNameQueryParam&source__in=$sourceName";
        }
        $sourceTypeQueryParam = "";
        foreach ($q_sourceType as $sourceType) {
            $sourceType = encodeURIComponent($sourceType);
            $sourceTypeQueryParam = ($sourceType == '') ? "$sourceTypeQueryParam" : "$sourceTypeQueryParam&source_type__in=$sourceType";
        }
        $statusQueryParam = "";
        foreach ($q_status as $status) {
            $statusQueryParam = ($status == '') ? "$statusQueryParam" : "$statusQueryParam&status__in=$status";
        }
        $currencyQueryParam = "";
        foreach ($q_currency as $currency) {
            $currencyQueryParam = ($currency == '') ? "$currencyQueryParam" : "$currencyQueryParam&currency__in=$currency";
        }

        $saveSearchHTML = "";
        if(is_user_logged_in()){
            $saveSearchHTML = "
                <button class='button-main-1 save-search' onClick='saveSearch($current_user->ID)'>SAVE THIS SEARCH</button> ";
        } else {
            $saveSearchHTML = "
                <button class='button-main-1 save-search' onClick=\"window.location.href = '/log-in'\">SAVE THIS SEARCH</button> ";
        }

        $saveToAlertsHTML = "";
        if(is_user_logged_in()){
            $saveToAlertsHTML = "
                <button class='button-main-1 save-search' onClick='addAlert($current_user->ID, \"$q_query\")'>ADD TO ALERTS</button> ";
        } else {
            $saveToAlertsHTML = "
                <button class='button-main-1 save-search' onClick=\"window.location.href = '/log-in'\">ADD TO ALERTS</button> ";
        }
        echo "<div class='search-result-label'>";
        echo "<h1>Results</h1>";


        echo "<a href='/search?page=1'>Clear all filters</a>";
        echo "</div>";

        echo "<div class='search-result-filters'>";
        echo $saveSearchHTML;
        echo $saveToAlertsHTML;
        if($_GET['q'] != '') {
            echo "<div class='search-result-filters-card'>
                    <div class='search-result-filters-card-name'>
                        Search: $q_query
                    </div>
                    <a class='remove-search-result-filters-card' onclick='removeSearchFilter(\"query\", \"$q_query\");'>x
                    </a>
                </div>";
        }
        if(isset($_GET['brand'])) {
            $asdasd = explode(",", $_GET['brand']);
            foreach ($asdasd as $item) {
                echo "<div class='search-result-filters-card'>
                            <div class='search-result-filters-card-name'>
                                $item
                            </div>
                            <a class='remove-search-result-filters-card' onclick='removeSearchFilter(\"brand\", \"$item\");'>x
                            </a>
                        </div>";
            }
        }
        if(isset($_GET['model'])) {
            $asdasd = explode(",", $_GET['model']);
            foreach ($asdasd as $item) {
                echo "<div class='search-result-filters-card'>
                            <div class='search-result-filters-card-name'>
                                $item
                            </div>
                            <a class='remove-search-result-filters-card' onclick='removeSearchFilter(\"model\", \"$item\");'>x
                            </a>
                        </div>";
            }
        }
        if(isset($_GET['sourceName'])) {
            $asdasd = explode(",", $_GET['sourceName']);
            foreach ($asdasd as $item) {
                echo "<div class='search-result-filters-card'>
                            <div class='search-result-filters-card-name'>
                                $item
                            </div>
                            <a class='remove-search-result-filters-card' onclick='removeSearchFilter(\"source\", \"$item\");'>x
                            </a>
                        </div>";
            }
        }
        if(isset($_GET['status'])) {
            $asdasd = explode(",", $_GET['status']);
            foreach ($asdasd as $item) {
                echo "<div class='search-result-filters-card'>
                            <div class='search-result-filters-card-name'>
                                $item
                            </div>
                            <a class='remove-search-result-filters-card' onclick='removeSearchFilter(\"status\", \"$item\");'>x
                            </a>
                        </div>";
            }
        }
        if(isset($_GET['currency'])) {
            $asdasd = explode(",", $_GET['currency']);
            foreach ($asdasd as $item) {
                echo "<div class='search-result-filters-card'>
                            <div class='search-result-filters-card-name'>
                                $item
                            </div>
                            <a class='remove-search-result-filters-card' onclick='removeSearchFilter(\"currency\", \"$item\");'>x
                            </a>
                        </div>";
            }
        }
        echo "</div>"; 

        if (wp_get_environment_type() == 'production') {
            $apiDomain = "http://128.199.148.89:8000";
        } else {
            $apiDomain = "http://159.89.196.67:8000";
        }

        $url = "$apiDomain/api/v1/forum_retail/watches?$queryParam$brandQueryParam$modelQueryParam$sourceNameQueryParam$sourceTypeQueryParam$priceFromQueryParam$priceToQueryParam$sortQueryParam$accQueryParam$lastUpdatedQueryParam$pageQueryParam$statusQueryParam$currencyQueryParam";
        // echo $url;
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo json_encode($response);
            echo 'Something went wrong!';
            return null;
        }
        renderSearchResultsWithFilter($body->forumWatches, $body->filters, (int)$q_page, (int)$body->pages, $q_priceFrom, $q_priceTo, $q_sourceType);

        if($q_query != '')
        {
            $userId = get_current_user_id();

            global $wpdb;
            $table_name = $wpdb->prefix.'search_tracker';
            $wpdb->insert(
                    $table_name,
                    array(
                        'UserID'     => $userId,  
                        'SearchTerm'       => $q_query),
            array( '%d', '%s')
            );
        }
	}
	
	protected function _content_template() {

    }

    function encodeURIComponent($str) {
        return str_replace('&', '%26', $str);
    }
}