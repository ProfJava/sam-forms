(function ($){

    let ajax_url    = sam_forms_ajax_object.ajax_url,
        ajax_nonce  = sam_forms_ajax_object.ajax_nonce,
        lang        = document.documentElement.lang,
        overlay         = $('.sam-overlay');

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    // Step 1
    // Sent OTP
    $("#sendOTP").click(function (e) {

        e.preventDefault();

        current_fs  = $(this).parent();
        next_fs     = $(this).parent().next();

        // Show overlay and disable the button
        overlay.css('display', 'block');
        $(this).prop('disabled', true);

        let formData = $('form#samform').serializeArray();
        formData.push({ name: 'action', value: 'sam_forms_send_otp' });

        console.log( formData );

        // Remove error class from all inputs
        $('.sam-step-1').find('.sam-input').removeClass("sam-input-error");

        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url,
            data: formData,
            success: function (response) {

                // Handle the response
                if (response.success) {

                    let formStatus  = response.data.status,
                        formErrors  = response.data.errors,
                        msg         = response.data.msg;

                    if ( formStatus === 'success' ) {

                        toastr.success( msg , 'Success' );

                        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                        next_fs.show();

                        current_fs.animate(
                            { opacity: 0 },
                            {
                                step: function (now) {
                                    // for making fielset appear animation
                                    opacity = 1 - now;

                                    current_fs.css({
                                        display: "none",
                                        position: "relative"
                                    });
                                    next_fs.css({ opacity: opacity });
                                },
                                duration: 500
                            }
                        );

                    } else {

                        $.each( formErrors , function ( key, val ) {

                            $('#' + key).addClass("sam-input-error");
                            toastr.error( val , 'Error' );

                        });

                    }

                }
            }
        });

        overlay.css('display', 'none');
        $(this).prop('disabled', false);

    });

    // Step 2
    // Vrify Code
    $("#verifyCode").click(function (e) {

        e.preventDefault();
        
        current_fs  = $(this).parent();
        next_fs     = $(this).parent().next();
        
        // Show overlay and disable the button
        overlay.css('display', 'block');
        $(this).prop( 'disabled' , true );
        
        let formData = $('form#samform').serializeArray();
        formData.push({ name: 'action', value: 'sam_forms_verify_otp' });

        console.log( formData );
        
        // Remove error class from all inputs
        $('.sam-step-2').find('.sam-input').removeClass("sam-input-error");

        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url,
            data: formData,
            success: function (response) {

                // Handle the response
                if (response.success) {

                    let formStatus  = response.data.status,
                        formErrors  = response.data.errors,
                        urlRedirect = response.data.redirect,
                        needReg     = response.data.need_reg,
                        msg         = response.data.msg;

                    if ( formStatus === 'success' ) {

                        toastr.success( msg , 'Success' );

                        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                        next_fs.show();

                        current_fs.animate(
                            { opacity: 0 },
                            {
                                step: function (now) {
                                    // for making fielset appear animation
                                    opacity = 1 - now;

                                    current_fs.css({
                                        display: "none",
                                        position: "relative"
                                    });
                                    next_fs.css({ opacity: opacity });
                                },
                                duration: 500
                            }
                        );

                        if ( needReg === 'no' ) {

                            window.location.href = urlRedirect;

                        } else {

                            $('.user-is-exist').css('display' , 'none');
                            $('.need-reg').css('display' , 'block');

                        }

                    } else {

                        if ( msg )
                            toastr.error( msg , 'Error' );

                        $.each( formErrors , function ( key, val ) {

                            $('#' + key).addClass("sam-input-error");
                            toastr.error( val , 'Error' );

                        });

                    }

                }
            }
        });

        overlay.css('display', 'none');
        $(this).prop('disabled', false);

    });

    $("#samFinish").click(function (e) {

        e.preventDefault();

        // Show overlay and disable the button
        overlay.css('display', 'block');
        $(this).prop( 'disabled' , true );

        let formData = $('form#samform').serializeArray();
        formData.push({ name: 'action', value: 'sam_forms_add_new_user' });

        console.log( formData );

        // Remove error class from all inputs
        $('.sam-step-2').find('.sam-input').removeClass("sam-input-error");

        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url,
            data: formData,
            success: function (response) {

                // Handle the response
                if (response.success) {

                    let formStatus  = response.data.status,
                        formErrors  = response.data.errors,
                        urlRedirect = response.data.redirect,
                        msg         = response.data.msg;

                    if ( formStatus === 'success' ) {

                        toastr.success( msg , 'Success' );
                        window.location.href = urlRedirect;

                    } else {

                        $.each( formErrors , function ( key, val ) {

                            $('#' + key).addClass("sam-input-error");
                            toastr.error( val , 'Error' );

                        });

                    }

                }
            }
        });

        overlay.css('display', 'none');
        $(this).prop('disabled', false);

    });

    $(".submit").click(function(){
        return false;
    });

})(jQuery);