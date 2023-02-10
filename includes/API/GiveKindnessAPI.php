<?php

namespace Give_Kindness\API;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use Give_Kindness\User; 
use Give_Kindness\GiveKindnessEmail; 

class GiveKindnessAPI
{

    private $restBase = 'give-kindness/v1';

    /**
     * Initialize the class
     */
    function __construct() {
      add_action( 'rest_api_init', [ $this, 'customize_rest_cors' ], 15 );
      add_action( 'rest_api_init', [ $this, 'register_api' ] );
    }


    /**
    * Filter rest
    * 
    * @param none
    * @return string
    */
    function customize_rest_cors() {

      remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
      add_filter( 'rest_pre_serve_request', function( $value ) {
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: POST, GET' );
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Access-Control-Expose-Headers: Link', false );
        header( 'Access-Control-Allow-Headers: X-Requested-With' );
        return $value;
      } );

    }
 
    /**
    * Register the API
    * 
    * @param none
    * @return void
    */
    public function register_api() {

      register_rest_route( $this->restBase, '/register', [
        'methods'  => WP_REST_SERVER::CREATABLE,
        'callback' => [ $this, 'try_register' ],
        'permission_callback' => '__return_true'
      ]);

      register_rest_route( $this->restBase, '/send-verify-email', [
        'methods'  => WP_REST_SERVER::CREATABLE,
        'callback' => [ $this, 'send_verify_email' ],
        'permission_callback' => '__return_true'
      ]);

    }

    /**
     * User registration
     *
     * @param array
     * @return array
     */
    public function try_register( WP_REST_Request $request ) {

      $user = new User();
      $response = $user->user_register($_POST);

      if($response['status'] == 201 ){
        $user_id = $response['user_id'];
        $user = get_user_by( 'id', $user_id ); 

        $email = new GiveKindnessEmail(); 
        $message = $email->prepare_verification_email( $user );
        $subject = $message['subject'];
        $text = $message['message'];
        $email->send( $user->user_email, $subject, $text, '');

      }
    
      return new WP_REST_Response($response, 123);
      
    }

    /**
    * User registration
    *
    * @param array
    * @return array
    */
    public function send_verify_email( WP_REST_Request $request ) {
      
      $user_id = sanitize_text_field($_POST['user_id']);
      $user = get_user_by( 'id', $user_id ); 

      $email = new GiveKindnessEmail(); 
      $message = $email->prepare_verification_email( $user );
      $subject = $message['subject'];
      $text = $message['message'];
      $response = $email->send( $user->user_email, $subject, $text, '');

      return new WP_REST_Response($response, 123);

    }


}