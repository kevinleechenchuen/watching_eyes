<?php
    add_action( 'rest_api_init', 'custom_save_search_routes' ); 
    add_action( 'rest_api_init', 'custom_save_search_delete' ); 
    function custom_save_search_routes() {
        register_rest_route( 
            'custom/v1',
            '/save_search',
            array(
                'methods' => 'POST',
                'callback' => 'custom_save_search',
            )
        );
    }
    function custom_save_search_delete() {
        register_rest_route( 
            'custom/v1',
            '/save_search/(?P<id>\d+)',
            array(
                'methods' => 'DELETE',
                'callback' => 'custom_remove_save_search',
            )
        );
    }

    function custom_save_search( $data ) {
        header('Content-Type: application/json');

        $userId = '';
        $query = '';
        $name = '';

        if( isset($_POST['userid']) ) { 
            $userId = $_POST['userid'];
        }
        if( isset($_POST['query']) ) { 
            $query = $_POST['query'];
        }
        if( isset($_POST['name']) ) { 
            $name = $_POST['name'];
        }

        global $wpdb;
        $table_name = $wpdb->prefix.'saved_search';
        $wpdb->insert(
                    $table_name,
                    array(
                        'UserID'     => $userId,  
                        'Name'       => $name,     
                        'Query'      => $query),
            array( '%d', '%s', '%s')
            );
        echo json_encode('success');
    }

    function custom_remove_save_search( $data ) {
        header('Content-Type: application/json');

        $id = $data['id'];

        global $wpdb;
        $table_name = $wpdb->prefix.'saved_search';
        $wpdb->delete(
                    $table_name,
                    array(
                        'ID'     => $id),
            array('%d')
            );

        echo json_encode('success');
    }
?>