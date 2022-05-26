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
                <button id='header-menu-search' class='header-search-button' onClick='search()'></button>
            </div>
            <div class='header-menu-filter'>
            <label class=\"container\">
                <p>Forums</p>
                <input type=\"checkbox\" id=\"forum-search-checkbox\" class=\"source-search-checkbox\" name=\"source-forum-search-checkbox\" value=\"Forum\">
                <span class=\"checkmark\"></span>
            </label>
            <label class=\"container\">
                <p>Dealers</p>
                <input type=\"checkbox\" id=\"dealers-search-checkbox\" class=\"source-search-checkbox\" name=\"source-dealer-search-checkbox\" value=\"Retail\">
                <span class=\"checkmark\"></span>
            </label>
            <label class=\"container\">
                <p>Auctions</p>
                <input type=\"checkbox\" id=\"auction-search-checkbox\" class=\"source-search-checkbox\" name=\"source-auction-search-checkbox\" value=\"Auction\">
                <span class=\"checkmark\"></span>
            </label>
            </div>";
        
	}
	
	protected function _content_template() {

    }

    
	
	
}