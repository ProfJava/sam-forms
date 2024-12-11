<?php

namespace Prof\SamForms\Email;

// Exit if accessed directly
if ( ! defined( '\ABSPATH' ) ) exit;

use Prof\SamForms\Helpers;

class Email {

    private $email;
    private $otp_transient_prefix = 'sam_otp_';

    public function __construct()
    {



    }


    /**
     * Load hooks
     *
     * @return void
     */
    public function load_hooks(): void
    {



    }

    public function set_email( $email )
    {

        $this->email = $email;

    }

    public function generate_otp(): string
    {

        if ( empty( $this->email ) ) {
            throw new \Exception( 'Email not set.' );
        }

        // Generate a 6-digit OTP
        $otp = sprintf("%06d", wp_rand( 1 , 999999 ) );

        // Store OTP with expiration
        set_transient(
            $this->otp_transient_prefix . md5( $this->email ),
            $otp,
            5 * MINUTE_IN_SECONDS
        );

        return $otp;

    }

    public function send_otp( $otp , $msg = '' )
    {

        if ( empty( $this->email ) ) {
            throw new \Exception( 'Email not set.' );
        }

        $subject = 'Your Login OTP';
        $message = "Your One-Time Password (OTP) is: {$otp}\n";
        $message .= "This OTP will expire in 5 minutes.";

        if ( ! empty( $msg ) )
            $message = $msg;

        $args = [
            'title' => $subject,
            'desc'  => $message,
        ];

        // Generate email content using the template
        $email_template = Helpers::get_template_part( "/", "email-template", $args, true );

        // Set email headers for HTML content
        $headers = [
            'Content-Type: text/html; charset=UTF-8'
        ];

        // Send email
        return wp_mail( $this->email, $subject, $email_template, $headers );

    }

    public function verify_otp( $user_otp ): bool
    {

        if ( empty( $this->email ) ) {
            throw new \Exception( 'Email not set.' );
        }

        $transient_key  = $this->otp_transient_prefix . md5( $this->email );
        $stored_otp     = get_transient( $transient_key );

        if ( $stored_otp && $stored_otp === $user_otp ) {

            // Delete the transient after successful verification
            delete_transient( $transient_key );
            return true;

        }

        return false;

    }

}