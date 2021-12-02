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

        $q_query = $_GET['q'];
        $q_brand = $_GET['brand'];
        $q_model = $_GET['model'];
        $q_sourceName = $_GET['sourceName'];
        $q_sourceType = $_GET['sourceType'];
        $q_priceFrom = $_GET['priceFrom'];
        $q_priceTo = $_GET['priceTo'];

        $queryParam = $q_query == '' ? '' : "&q=$q_query";
        $brandQueryParam = $q_brand == '' ? '' : "&brand__in=$q_brand";
        $modelQueryParam = $q_model == '' ? '' : "&model__in=$q_model";
        $sourceNameQueryParam = $q_sourceName == '' ? '' : "&forum_name__in=$q_sourceName";
        $sourceTypeQueryParam = $q_sourceType == '' ? '' : "&source_type__in=$q_sourceType";
        $priceFromQueryParam = $q_priceFrom == '' ? '' : "&product_price__gte=$q_priceFrom";
        $priceToQueryParam = $q_priceTo == '' ? '' : "&product_price__lte=$q_priceTo";

        echo "<h4>Seach result for '$q_query'</h4>";
        echo "<div>
                <script>
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
                <button class='button-main-1' onClick='saveSearchWithoutQuery()'>SAVE THIS SEARCH</button> 
            </div>";

        $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches?$queryParam$brandQueryParam$modelQueryParam$sourceNameQueryParam$sourceTypeQueryParam$priceFromQueryParam$priceToQueryParam";
        // $url = "http://128.199.148.89:8000/api/v1/forum_retail/watches?brand__in=rolex";
        echo $url;
        
        $response = wp_remote_get($url);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo 'something went wrong!';
            return null;
        }
        renderSearchResultsWithFilter($body->forumWatches, $body->filters);
	}
	
	protected function _content_template() {

    }

    
	
	
}