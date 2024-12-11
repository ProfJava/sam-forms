<?php
/**
 * Template for added to cart popup layout 1.
 *
 * @var $args array template args
 * @var $title string email title
 * @since 1.0.0
 */

//$title  = $args['title'] ?? '';
$desc   = isset( $args['desc'] ) ? '<td class="bodycopy" style="color: #153643; font-family: sans-serif;font-size: 16px; line-height: 22px;">'. $args['desc'] .'</td>' : '';

?>
<body yahoo bgcolor="#ffffff">
    <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        img {height: auto;}
        .content {width: 100%; max-width: 600px;}
        .header {padding: 16px 16px 9px;border-top: 8px solid #EF413D;border-bottom: 8px solid #EF413D;}
        .innerpadding {padding: 30px 30px 30px 30px;}
        .bordertop {border-top: 1px solid #f2eeed;}
        .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
        .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
        .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
        .h2 {color: #153643; font-family: sans-serif;padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
        .bodycopy {font-size: 16px; line-height: 22px;}
        .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
        .button a {color: #ffffff; text-decoration: none;}
        .footer {padding: 20px 30px 15px 30px;border-bottom: 8px solid #EF413D;}
        .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
        .footercopy a {color: #ffffff; text-decoration: underline;}
        @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {display: none!important;}
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            body[yahoo] .button {padding: 0px!important;}
            body[yahoo] .button a {background-color: #effb41; padding: 15px 15px 13px!important;}
            body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
        }
        div p {
            font-size: 13px !important;
        }
    </style>
    <table width="100%" bgcolor="#EF413D" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 600px;">
                    <tr>
                        <td bgcolor="#44525f" class="header" style="text-align: center;padding: 16px 16px 9px;border-top: 60px solid #EF413D;border-bottom: 8px solid #EF413D;">
                            <a href="<?php echo home_url() ?>">
                                <img class="logo logo-main" src="https://shahbandr.com/wp-content/uploads/2024/01/1-e1705077821772-1024x357.png" alt="" width="261" height="47">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="innerpadding" style="padding: 30px 30px 30px 30px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="color: #153643; font-family: sans-serif;padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;">
                                        <?php echo $title ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php echo $desc ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer" bgcolor="#44525f" style="padding: 20px 30px 15px 30px;border-bottom: 60px solid #EF413D;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" class="footercopy" style="font-family: sans-serif; font-size: 14px; color: #ffffff;">
                                        <a href="<?php echo home_url() ?>" style="color: #ffffff; text-decoration: underline;">'
                                            All right reserved. <?php echo get_bloginfo( "name" ) .'©'. date("Y") ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
