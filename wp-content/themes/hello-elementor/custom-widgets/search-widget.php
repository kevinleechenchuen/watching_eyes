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
        wp_register_script('slider', '/wp-content/themes/hello-elementor/assets/js/slider.js', array('jquery'),'1.1', true);
        wp_enqueue_script('slider');
        $current_user = wp_get_current_user();

        $q_query = $_GET['q'];
        $q_brand = explode(",", $_GET['brand']);
        $q_model = explode(",", $_GET['model']);
        $q_sourceName = explode(",", $_GET['sourceName']);
        $q_sourceType = explode(",", $_GET['sourceType']);
        $q_priceFrom = $_GET['priceFrom'];
        $q_priceTo = $_GET['priceTo'];
        $q_page = $_GET['page'];

        $queryParam = $q_query == '' ? '' : "&q=$q_query";
        $priceFromQueryParam = $q_priceFrom == '' ? '' : "&product_price__gte=$q_priceFrom";
        $priceToQueryParam = $q_priceTo == '' ? '' : "&product_price__lte=$q_priceTo";
        $pageQueryParam = $q_page == '' ? '' : "page=$q_page";

        $brandQueryParam = "";
        foreach ($q_brand as $brand) {
            $brandQueryParam = ($brand == '') ? "$brandQueryParam" : "$brandQueryParam&brand__in=$brand";
        }
        $modelQueryParam = "";
        foreach ($q_model as $model) {
            $modelQueryParam = ($model == '') ? "$modelQueryParam" : "$modelQueryParam&model__in=$model";
        }
        $sourceNameQueryParam = "";
        foreach ($q_sourceName as $sourceName) {
            $sourceNameQueryParam = ($sourceName == '') ? "$sourceNameQueryParam" : "$sourceNameQueryParam&forum_name__in=$sourceName";
        }
        $sourceTypeQueryParam = "";
        foreach ($q_sourceType as $sourceType) {
            $sourceTypeQueryParam = ($sourceType == '') ? "$sourceTypeQueryParam" : "$sourceTypeQueryParam&source_type__in=$sourceType";
        }

        $saveSearchHTML = "<script>
                    function saveSearchWithoutQuery(){
                        jQuery.ajax({
                            type: 'POST',
                            url: 'https://{$_SERVER['HTTP_HOST']}/wp-json/custom/v1/save_search',
                            dataType: 'jsonp',
                            data: { userid: {$current_user->ID}, query: '$q_query', name: '$q_query'},

                            success: function (data) {
                                console.log(data);
                                if(data == 'success') { 
                                    location.reload(); 
                                }    
                            }
                        });
                        // window.location.href = 'https://{$_SERVER['HTTP_HOST']}/profile-saved-search/';
                        // location.reload();   
                        alert('Successful!');
                    }
                </script>
                <button class='button-main-1' onClick='saveSearchWithoutQuery()'>SAVE THIS SEARCH</button> ";
        
        if($q_query == ''){
            echo "<div class='search-result-label'>
                <h1>Results</h1>
            </div>";
            
        } else {
            echo "<div class='search-result-label'>
                <h1>Results For '$q_query'</h1>
                $saveSearchHTML
            </div>";
        }

        $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches?$queryParam$brandQueryParam$modelQueryParam$sourceNameQueryParam$sourceTypeQueryParam$priceFromQueryParam$priceToQueryParam";
        // $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches?brand__in=rolex";
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
        renderSearchResultsWithFilter($body->forumWatches, $body->filters);
	}
	
	protected function _content_template() {

    }

    
	
	
}