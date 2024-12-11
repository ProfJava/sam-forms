<?php

// Exit if accessed directly
if ( ! defined( '\ABSPATH' ) ) exit;

?>

    <h2 id="heading">
        PasswordLess Login
    </h2>
    <form id="samform" class="sam-form">
        <?php wp_nonce_field( 'sam_form', 'sam_form_nonce_check' ) ?>
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active" id="send">
                <strong>Send OTP</strong>
            </li>
            <li id="verify">
                <strong>Verify OTP</strong>
            </li>
            <li id="finish">
                <strong>Finish</strong>
            </li>
        </ul>
        <fieldset class="sam-step-1">
            <div class="form-card">
                <div class="sam-form-group">
                    <label for="email" class="sam-label">
                        Email
                        <span class="sam-is-required"> * </span>
                    </label>
                    <input id="email" type="email" name="email" placeholder="Email Id" class="sam-form-control sam-input" required />
                </div>
            </div>
            <input type="button" name="next" id="sendOTP" class="next action-button" value="Sent OTP" />
        </fieldset>
        <fieldset class="sam-step-2">
            <div class="form-card">
                <div class="sam-form-group">
                    <label for="otp_code" class="sam-label">
                        Code
                        <span class="sam-is-required"> * </span>
                    </label>
                    <input id="otp_code" type="number" name="otp_code" placeholder="Enter OTP Code"/>
                </div>
            </div>
            <input type="button" name="next" id="verifyCode" class="next action-button" value="Verify Code" />
<!--            <input type="button" name="previous" class="previous action-button-previous" value="previous" />-->
        </fieldset>
        <fieldset class="sam-step-3">
            <div class="form-card">
                <div class="user-is-exist">
                    <p class="sam-alert-success">
                        The verification was successful, you are being redirected.
                    </p>
                </div>
                <div class="sam-form-group need-reg" style="display:none">
                    <label for="first_name" class="sam-label">
                        First Name
                        <span class="sam-is-required"> * </span>
                    </label>
                    <input id="first_name" type="text" name="first_name" placeholder="First Name" class="sam-form-control sam-input"/>
                </div>
            </div>
            <input type="button" name="next" id="samFinish" class="next action-button" value="Finish" />
<!--            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />-->
        </fieldset>

    </form>

<?php
