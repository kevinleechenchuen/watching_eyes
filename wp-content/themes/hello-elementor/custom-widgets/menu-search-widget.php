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
        echo "<div class='header-search-container'>
                <input type='text' class='header-search-textbox' name='header-search-textbox' placeholder='Search for...'>
                <script>
                    function search(){
                        var searchParam = document.getElementsByName('header-search-textbox')[0].value;
                        var sourceTypeCheckedBoxes = document.querySelectorAll('input[name=source-search-checkbox]:checked');
                        var sourceTypes = [];

                        for(var i=0; sourceTypeCheckedBoxes[i]; ++i){
                            sourceTypes.push(sourceTypeCheckedBoxes[i].value);
                        }

                        var sourceParams = sourceTypes.length > 0 ? '&sourceType='+sourceTypes.join(',') : '';

                        console.log(JSON.stringify(sourceTypes));
                        window.location.href = '/search?q='+searchParam+sourceParams;
                    }
                </script>
                <button class='header-search-button' onClick='search()'>SEARCH</button>
            </div>
            <div>
                <input type=\"checkbox\" id=\"forum-search-checkbox\" name=\"source-search-checkbox\" value=\"Forum\"> <label for=\"forum-search-checkbox\"> FORUMS</label>
                <input type=\"checkbox\" id=\"auction-search-checkbox\" name=\"source-search-checkbox\" value=\"Auction\"> <label for=\"auction-search-checkbox\"> AUCTIONS</label>
                <input type=\"checkbox\" id=\"dealers-search-checkbox\" name=\"source-search-checkbox\" value=\"Retail\"> <label for=\"dealers-search-checkbox\"> DEALERS</label>
            </div>";
        
	}
	
	protected function _content_template() {

    }

    
	
	
}