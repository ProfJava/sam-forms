<?php


namespace Prof\SamForms\Forms;

// Exit if accessed directly
if ( ! defined( '\ABSPATH' ) ) exit;

use Prof\SamForms\Helpers;
use Prof\SamForms\Email\Email;

class Login {

    private $email;
    private $otp_transient_prefix;

    public function __construct(Email $email)
    {

        $this->email = $email;
        $this->otp_transient_prefix = 'sam_otp_';

    }


    /**
     * Load hooks
     *
     * @return void
     */
    public function load_hooks(): void
    {

        add_action( 'init' , array( $this , 'create_custom_login_page' ) );
        add_action( 'wp_ajax_nopriv_sam_forms_send_otp'     , array( $this , 'send_otp' ) );
        add_action( 'wp_ajax_nopriv_sam_forms_verify_otp'   , array( $this , 'verify_otp' ) );
        add_action( 'wp_ajax_nopriv_sam_forms_add_new_user' , array( $this , 'add_new_user' ) );

    }

    public function create_custom_login_page()
    {

        // Create a custom login page template
//        add_shortcode( 'sam_login_form' , array( $this , 'login_form' ) );
        add_shortcode( 'sam_forms_otp_login_form' , array( $this , 'otp_login_form' ) );

    }

    public function otp_login_form()
    {

        if ( ! is_user_logged_in() )
            return Helpers::get_template_part("/" , "login-form" , [] , true );

        wp_redirect( home_url() );

    }

    public function send_otp()
    {

        $nonce_check = isset( $_REQUEST['sam_form_nonce_check'] ) ? sanitize_text_field( $_REQUEST['sam_form_nonce_check'] ) : '';
        if ( ! wp_verify_nonce( $nonce_check , 'sam_form') )
            wp_send_json_error( [ 'msg' => 'Error' ] );

        $status     = 'fail';
        $msg        = '';
        $errors     = [];
        $email      = isset( $_REQUEST['email'] ) ? sanitize_email( $_REQUEST['email'] ) : '';

        if ( empty( $email ) ) {

            $errors['email'] = __('Please enter your email address' , 'sam-forms' );

        } elseif ( ! is_email( $email ) ) {

            $errors['email'] = __( 'Please enter a valid email address' , 'sam-forms' );

        }

        if ( empty( $errors ) ) {

            $this->email->set_email( $email );

            $otp = $this->email->generate_otp();

            if ( $this->email->send_otp( $otp ) ) {

                $status = 'success';
                $msg    = 'OTP sent successfully';

            } else {

                $msg = 'Failed to send OTP';

            }

        }

        wp_send_json_success(
            [
                'status'    => $status,
                'msg'       => $msg,
                'errors'    => $errors,
                'request'   => $_REQUEST,
            ]
        );

    }

    public function verify_otp()
    {

        $nonce_check = isset( $_REQUEST['sam_form_nonce_check'] ) ? sanitize_text_field( $_REQUEST['sam_form_nonce_check'] ) : '';
        if ( ! wp_verify_nonce( $nonce_check , 'sam_form') )
            wp_send_json_error( [ 'msg' => 'Error' ] );

        $errors     = [];
        $need_reg   = 'no';
        $status     = 'fail';
        $msg        = '';
        $redirect   = esc_url( home_url() );
        $email      = isset( $_REQUEST['email'] )    ? sanitize_email( $_REQUEST['email'] ) : '';
        $otp        = isset( $_REQUEST['otp_code'] ) ? sanitize_text_field( $_REQUEST['otp_code'] ) : '';

        if ( empty( $otp ) )
            $errors['otp_code'] = __( 'Please enter your Code' , 'sam-forms' );

        if ( empty( $errors ) ) {

            $this->email->set_email( $email );

            if ( $this->email->verify_otp( $otp ) ) {

                $user       = get_user_by('email' , $email );
                $status     = 'success';

                if ( $user ) {

                    $msg = 'Login successful';
                    wp_set_auth_cookie( $user->ID );

                } else {

                    $msg        = 'OTP verified, please complete registration';
                    $need_reg   = 'yes';

                }

            } else {

                $errors['otp_code'] = 'Invalid or expired OTP, Please try again';

            }

        }

        wp_send_json_success(
            [
                'status'    => $status,
                'msg'       => $msg,
                'errors'    => $errors,
                'redirect'  => $redirect,
                'need_reg'  => $need_reg,
                'request'   => $_REQUEST,
                'verify'    => $this->email->verify_otp( $otp ),
            ]
        );

    }

    public function add_new_user()
    {

        $nonce_check = isset( $_REQUEST['sam_form_nonce_check'] ) ? sanitize_text_field( $_REQUEST['sam_form_nonce_check'] ) : '';
        if ( ! wp_verify_nonce( $nonce_check , 'sam_form') )
            wp_send_json_error( [ 'msg' => 'Error' ] );

        $errors     = [];
        $msg        = '';
        $need_reg   = 'no';
        $status     = 'fail';
        $redirect   = esc_url( home_url() );
        $email      = isset( $_REQUEST['email'] )       ? sanitize_email( $_REQUEST['email'] ) : '';
        $first_name = isset( $_REQUEST['first_name'] )  ? sanitize_text_field( $_REQUEST['first_name'] ) : '';

        if ( empty( $first_name ) )
            $errors['first_name'] = __( 'Please enter First Name' , 'sam-forms' );

        if ( empty( $errors ) ) {

            $user = get_user_by( 'email' , $email );

            if ( $user ) {

                $status     = 'success';
                $msg        = 'Login successful';
                wp_set_auth_cookie( $user->ID );

            } else {

                $user_id = wp_insert_user([
                    'user_login'    => $email,
                    'user_email'    => $email,
                    'first_name'    => $first_name,
                    'user_pass'     => wp_generate_password()
                ]);

                if ( ! is_wp_error( $user_id ) ) {

                    $status     = 'success';
                    $msg        = 'Registration successful';

                    wp_set_auth_cookie($user_id);

                } else {

                    $msg = $user_id->get_error_message();

                }

            }

        }

        wp_send_json_success(
            [
                'status'    => $status,
                'msg'       => $msg,
                'errors'    => $errors,
                'redirect'  => $redirect,
                'need_reg'  => $need_reg,
                'request'   => $_REQUEST,
            ]
        );

    }

}