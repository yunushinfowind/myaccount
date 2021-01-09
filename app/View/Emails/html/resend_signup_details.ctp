<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width"/>
        <title><?php echo ucfirst($data['Email_content']['subject']); ?></title>
    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" leftmargin="0">
        <table style="margin: 0 auto ;" class="cust_table" width="640" cellspacing="0" cellpadding="0" >
            <tr style="border-top:4px solid #28BAA3; float: left;">
                <td>
                    <table width="642" border="0" cellpadding="0" cellspacing="0" style="border:#28BAA3 1px solid; font-family:Arial, Helvetica, sans-serif; ">
                        <tr>
                            <td style="text-align:center; padding:20px 0;">
                                <?php 
                                $base_url = BASE_URL;
                                ?>
                                <img src="<?php echo $base_url;?>img/dashboard_logo.png" width="200" height="60" alt="Header" style="margin:0px; padding:0 0 0 14px; border:none;">
                                <span style="float:right; color:#fff; padding-right: 28px; padding-top: 13px;">
                                    <br/></span>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" bgcolor="#f4f4f4" style="width:100%;">
                                    <tr>
                                        <td colspan="2">
                                            <p style="padding:10px 25px 10px 25px; font-size:14px; margin:0px; background: #F4F4F4; border-bottom: 1px solid #d4d4d4;">
                                                <strong><?php echo ucfirst($data['Email_content']['subject']); ?></strong>
                                            </p>
                                            <?php
                                            $search = array('{name}', '{link}', '{email}', '{temporary_password}');
                                            $replace = array(ucfirst($find_user['User']['first_name']) . ' ' . ucfirst($find_user['User']['last_name']), $base_url.'frontend/login', $find_user['User']['email'], $new_password);
                                            echo str_replace($search, $replace, $data['Email_content']['content']);
                                            ?>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="margin-top:20px;">
                            <td style="text-align:center; padding:20px 0 ; margin-top: 20px;">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>