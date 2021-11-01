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
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                echo  "<a href='/my-account'>
                            <div>$current_user->display_name</div>
                        </a>";
            } else {
                $login_url = site_url( 'wp-login.php', 'login' );
                $signup_url = wp_registration_url();

                echo "<a href='$login_url'>Login</a> | <a href='$signup_url'>Signup</a>";
            }
	}
	
	protected function _content_template() {

    }
	
	
}