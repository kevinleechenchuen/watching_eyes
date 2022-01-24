<?php
namespace Elementor;

class Menu_Search_Widget extends Widget_Base {

	public function get_name() {
		return 'menu-search-widget';
	}
	
	public function get_title() {
		return 'menu-search-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
        $q_query = $_GET['q'];
        echo "<div class='header-search-container'>
                <input type='text' id='header-search-textbox' class='header-search-textbox' name='header-search-textbox' placeholder='Search for...' value='$q_query'>
                <script>
                    var input = document.getElementById('header-search-textbox');
                    input.addEventListener('keyup', function(event) {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                        document.getElementById('header-menu-search').click();
                    }
                    });
                    function search(){
                        var searchParam = encodeURIComponent(document.getElementsByName('header-search-textbox')[0].value);
                        var sourceTypeCheckedBoxes = document.querySelectorAll('input[name=source-search-checkbox]:checked');
                        var sourceTypes = [];

                        for(var i=0; sourceTypeCheckedBoxes[i]; ++i){
                            sourceTypes.push(sourceTypeCheckedBoxes[i].value);
                        }

                        var sourceParams = sourceTypes.length > 0 ? '&sourceType='+encodeURIComponent(sourceTypes.join(',')) : '';

                        window.location.href = '/search?q='+searchParam+sourceParams;
                    }
                </script>
                <button id='header-menu-search' class='header-search-button' onClick='search()'></button>
            </div>
            <div class='header-menu-filter'>
            <label class=\"container\">All Watches
                <input type=\"checkbox\" id=\"all-search-checkbox\" checked=\"checked\">
                <span class=\"checkmark\"></span>
            </label>
            <label class=\"container\">Forums
                <input type=\"checkbox\" id=\"forum-search-checkbox\" name=\"source-search-checkbox\" value=\"Forum\">
                <span class=\"checkmark\"></span>
            </label>
            <label class=\"container\">Auctions
                <input type=\"checkbox\" id=\"auction-search-checkbox\" name=\"source-search-checkbox\" value=\"Auction\">
                <span class=\"checkmark\"></span>
            </label>
            <label class=\"container\">Dealers
                <input type=\"checkbox\" id=\"dealers-search-checkbox\" name=\"source-search-checkbox\" value=\"Retail\">
                <span class=\"checkmark\"></span>
            </label>
            </div>";
        
	}
	
	protected function _content_template() {

    }

    
	
	
}