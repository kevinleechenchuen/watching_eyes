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
        wp_enqueue_script('slider');
        $current_user = wp_get_current_user();

        $q_query = $_GET['q'];
        $q_brand = explode(",", $_GET['brand']);
        $q_model = explode(",", $_GET['model']);
        $q_sourceName = explode(",", $_GET['sourceName']);
        $q_sourceType = explode(",", $_GET['sourceType']);
        $q_priceFrom = $_GET['priceFrom'];
        $q_priceTo = $_GET['priceTo'];
        $q_page = $_GET['pg'] == '' ? 1 : $_GET['pg'];
        $q_sortby = $_GET['sort'] == '' ? 0 : $_GET['sort'];

        $queryParam = $q_query == '' ? '' : "&q=$q_query";
        $priceFromQueryParam = $q_priceFrom == '' ? '' : "&product_price__gte=$q_priceFrom";
        $priceToQueryParam = $q_priceTo == '' ? '' : "&product_price__lte=$q_priceTo";
        $pageQueryParam = $q_page == '' ? '' : "&page=$q_page";
        $sortQueryParam = $q_sortby == '' ? '' : "&sort_by=$q_sortby";

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

        $saveSearchHTML = "";
        if(is_user_logged_in()){
            $saveSearchHTML = "
                <button class='button-main-1' onClick='saveSearchWithoutQuery($current_user->ID)'>SAVE THIS SEARCH</button> ";
        } else {
            $saveSearchHTML = "
                <button class='button-main-1' onClick=\"window.location.href = '/log-in'\">SAVE THIS SEARCH</button> ";
        }
        echo "<div class='search-result-label'>";
        if($q_query == ''){
            
            echo "<h1>Results</h1>";
            
        } else {
            echo "<h1>Results For '$q_query'</h1>
                $saveSearchHTML";
        }
        echo "<div class='search-result-filters'>";
        if($_GET['brand'] != '') {
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
        if($_GET['model'] != '') {
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
        if($_GET['sourceName'] != '') {
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
        // if($_GET['sourceType'] != '') echo "<div><h7>Source type: ".$_GET['sourceType']."</h7></div>";
        // if($_GET['priceFrom'] != '') echo "<div><h7>Price from: ".$_GET['priceFrom']."</h7></div>";
        // if($_GET['priceTo'] != '') echo "<div><h7>Price to: ".$_GET['priceTo']."</h7></div>";
        echo "</div>";
        echo "</div>"; 

        $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches?$queryParam$brandQueryParam$modelQueryParam$sourceNameQueryParam$sourceTypeQueryParam$priceFromQueryParam$priceToQueryParam$sortQueryParam$pageQueryParam";
        // $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches?brand__in=rolex";
        echo $url;
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }
        
        echo "<div class='item-card-desc-title'>
                <h2>Filters</h2>
            </div>";
        renderSearchResultsWithFilter($body->forumWatches, $body->filters, (int)$q_page, (int)$body->pages, $q_priceFrom, $q_priceTo);
	}
	
	protected function _content_template() {

    }

    function encodeURIComponent($str) {
        return str_replace('&', '%26', $str);
    }
}