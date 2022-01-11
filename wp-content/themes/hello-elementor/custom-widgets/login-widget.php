<?php
namespace Elementor;

class Login_Widget extends Widget_Base {
	
	public function get_name() {
		return 'login-widget';
	}
	
	public function get_title() {
		return 'login-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
	}
	

	
	protected function render() {
		echo  "<div class='login-profile-mini'>";
		echo  "<div class='login-profile-mini flex-to-right'>
					<img src='https://watching.mydemobb.com/wp-content/themes/hello-elementor/assets/images/material-person.svg' alt='profile-image' />
				<div class='login-profile-mini-text'>";
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                echo  "<a href='/profile'>
                            <div>$current_user->display_name</div>
                        </a>";
            } else {
                $login_url = site_url( 'wp-login.php', 'login' );
                $signup_url = wp_registration_url();

                echo "<a href='/log-in'>Login</a> | <a href='/register'>Signup</a>";
			}
		echo  "</div>";
	}
	
	protected function _content_template() {

    }
	
	
}