<?php
namespace Elementor;
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/hello-elementor/custom-widgets/models/search-cards.php');


class Alerts_Widget extends Widget_Base {

	public function get_name() {
		return 'alerts-widget';
	}
	
	public function get_title() {
		return 'alerts-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }

	
	protected function render() {
		$domain = $_SERVER['HTTP_HOST'];
        if (is_user_logged_in()) {
			$current_user = wp_get_current_user();
			echo "<div class='header-search-container' style='width=70%;'>
			<input type='text' class='alert-search-textbox' name='alert-search-textbox' placeholder='Enter alert keyword...'>
			<button class='header-search-button' onClick='addAlert($current_user->ID)'>SAVE</button>
			</div>
			<div>
			    <label id='alert-textbox-error' class='error-msg'></label>
			</div>
			";

			if (wp_get_environment_type() == 'production') {
				$apiDomain = "http://128.199.148.89:8000";
			} else {
				$apiDomain = "http://159.89.196.67:8000";
			}

			$userId = $current_user->data->ID;
			$url = "$apiDomain/api/v1/users/$userId/keyword";
			// echo $url;
			$response = wp_remote_get($url);
			if ( is_array( $response ) && ! is_wp_error( $response ) ) {
				$body = json_decode($response['body']);
			} else {
				echo 'something went wrong!';
				return null;
			}

			echo "<div class='alert-search-container'>";
			foreach ($body->keyword as $item) {
				echo "<div class='alert-search-item'>
						<div class='alert-search-item-name'>
							$item->keyword
						</div>
						<a class='delete-alert-search' onclick='removeAlert($userId, $item->id);'>x</a>
					</div>";
			}
			echo "</div>";
		} else {
			echo "<div class='flex-container'>
				<h4><a href='/log-in'>Log in</a> to view your alert keywords.</h4>
			</div>";
		}
	}
	
	protected function _content_template() {

    }

    
	
	
}