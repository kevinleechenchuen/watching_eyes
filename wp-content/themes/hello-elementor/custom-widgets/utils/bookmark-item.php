<?php
    add_action( 'rest_api_init', 'custom_bookmark_routes' ); 
    function custom_bookmark_routes() {
        register_rest_route( 
            'custom/v1',
            '/bookmark',
            array(
                'methods' => 'POST',
                'callback' => 'custom_bookmark',
            )
        );
    }

    function custom_bookmark() {
        header('Content-Type: application/json');

        $watchId = '';
        $sourceType = '';
        $userId = '';
        $isRemove = '';

        if( isset($_POST['watchId']) ) { 
            $watchId = $_POST['watchId'];
        }
        if( isset($_POST['sourceType']) ) { 

            if($_POST['sourceType'] == 'Retail' || $_POST['sourceType'] == 'Forum'){
                $sourceType = 'forum_retail';
            } else {
                $sourceType = 'auction';
            }
        }
        if( isset($_POST['userId']) ) { 
            $userId = $_POST['userId'];
        }
        if( isset($_POST['isRemove']) ) { 
            $isRemove = $_POST['isRemove'];
        }

        error_log( $isRemove );
        error_log( $userId );
        error_log( $watchId );
        error_log( $sourceType );

        global $wpdb;
        $table_name = $wpdb->prefix.'bookmarked_watches';

        if($isRemove == 'true') {
            $result = wp_remote_post("http://128.199.148.89:8000/api/v1/users/$userId/bookmark/delete?watchid=$watchId", array(
                'method' => 'DELETE'
              ));
              error_log( json_encode($result) );
            $code = $result['response']['code'];
            if($code == 201 || $code == 200){
                $wpdb->delete(
                    $table_name,
                    array(
                        'UserID'    => $userId,  
                        'watchId'   => $watchId),
                    array( '%d', '%d')
                );
            }
        } else {
            $result = wp_remote_post("http://128.199.148.89:8000/api/v1/users/$userId/bookmark/add", array(
                'method' => 'POST',
                'body' => array(
                  'source_type' => $sourceType,
                  'watch_id' => $watchId,
                )
              ));
              error_log( json_encode($result) );
              $code = $result['response']['code'];
            if($code == 201 || $code == 200){
                $wpdb->insert(
                    $table_name,
                    array(
                        'UserID'    => $userId,  
                        'watchId'   => $watchId),
                array( '%d', '%d')
                );
            }
        }
        echo json_encode($result);
    }
?>