<?php
    add_action( 'rest_api_init', 'custom_add_alert_routes' ); 
    add_action( 'rest_api_init', 'custom_remove_alert_delete' ); 
    function custom_add_alert_routes() {
        register_rest_route( 
            'custom/v1',
            '/alert',
            array(
                'methods' => 'POST',
                'callback' => 'add_alert',
            )
        );
    }
    function custom_remove_alert_delete() {
        register_rest_route( 
            'custom/v1',
            '/remove_alert',
            array(
                'methods' => 'POST',
                'callback' => 'remove_alert',
            )
        );
    }

    function add_alert( $data ) {
        header('Content-Type: application/json');

        $userId = '';
        $keyword = 0;

        if( isset($_POST['userid']) ) { 
            $userId = $_POST['userid'];
        }
        if( isset($_POST['keyword']) ) { 
            $keyword = $_POST['keyword'];
        }

        if (wp_get_environment_type() == 'production') {
            $apiDomain = "http://128.199.148.89:8000";
        } else {
            $apiDomain = "http://159.89.196.67:8000";
        }

        $response = wp_remote_post("$apiDomain/api/v1/users/$userId/keyword/add", array(
            'method' => 'POST',
            'body' => array(
              'keyword' => $keyword,
            )
          ));
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo json_encode($response);
            echo 'Something went wrong!';
            return null;
        }

        echo json_encode('success');
    }

    function remove_alert( $data ) {
        header('Content-Type: application/json');

        $userId = $_POST['user_id'];
        $keywordId = $_POST['keyword_id'];

        if( isset($_POST['keyword_id']) ) { 
            $keywordId = $_POST['keyword_id'];
        }
        if( isset($_POST['user_id']) ) { 
            $userId = $_POST['user_id'];
        }

        if (wp_get_environment_type() == 'production') {
            $apiDomain = "http://128.199.148.89:8000";
        } else {
            $apiDomain = "http://159.89.196.67:8000";
        }

        $url = "$apiDomain/api/v1/users/$userId/keyword/delete/$keywordId";
        $args = array(
            'method' => 'DELETE',
        );
        $response = wp_remote_request( $url, $args );
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body = json_decode($response['body']);
        } else {
            echo json_encode($response);
            echo 'Something went wrong!';
            return null;
        }

        echo json_encode('success');
    }
?>