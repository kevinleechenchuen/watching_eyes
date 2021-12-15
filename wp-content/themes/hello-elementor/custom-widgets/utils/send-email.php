<?php
    add_action( 'rest_api_init', 'custom_email_routes' ); 
    function custom_email_routes() {
        register_rest_route( 
            'custom/v1',
            '/email',
            array(
                'methods' => 'POST',
                'callback' => 'send_email',
            )
        );
    }

    function send_email( $data ) {
        $to = 'kevinleechenchuen@gmail.com';
        $subject = 'The subject';
        $body = 'The email body content';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail( $to, $subject, $body, $headers );
        echo json_encode('success');
    }
?>