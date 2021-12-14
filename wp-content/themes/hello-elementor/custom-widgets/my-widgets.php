<?php

class My_Elementor_Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
		require_once('login-widget.php');
		require_once('search-widget.php');
		require_once('menu-search-widget.php');
		require_once('filter-widget.php');
		require_once('top-10-watches-widget.php');
		require_once('latest-forum-widget.php');
		require_once('upcoming-auction-widget.php');
		require_once('saved-search-widget.php');
		require_once('auction-widget.php');
		require_once('auction-watches-widget.php');
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}

	public function register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Login_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Search_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Menu_Search_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Filter_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Top_10_Watches_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Latest_Forum_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Upcoming_Auction_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Saved_Search_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Auction_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Auction_Watches_Widget() );
	}

}

add_action( 'init', 'my_elementor_init' );
function my_elementor_init() {
	My_Elementor_Widgets::get_instance();
}