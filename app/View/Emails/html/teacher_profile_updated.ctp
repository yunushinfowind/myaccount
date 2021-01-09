<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width"/>
        <title>Profile Updated</title>
    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" leftmargin="0">
        <table style="margin: 0 auto ;" class="cust_table" width="640" cellspacing="0" cellpadding="0" >
            <tr style="border-top:4px solid #28BAA3; float: left;">
                <td>
                    <table width="642" border="0" cellpadding="0" cellspacing="0" style="border:#28BAA3 1px solid; font-family:Arial, Helvetica, sans-serif; ">
                        <tr>
                            <td style="text-align:center; padding:20px 0;">
                                <img src="http://lesson.picnframes.info/developer/img/dashboard_logo.png" width="200" height="60" alt="Header" style="margin:0px; padding:0 0 0 14px; border:none;">
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
                                                <strong>Profile Updated</strong>
                                            </p>

                                            <h3 style="border-bottom: 1px solid #f4f4f4; color:#555; font-weight: lighter; padding-left: 25px ; padding-bottom: 16px;">Dear <?php echo ucfirst($admin['Admin']['username']); ?>, </h3>
                                            <p style="padding:0px 25px 10px 25px; font-size:15px; margin:0px; text-align: justify; color:#555; ">
                                                The teacher named <?php echo ucfirst($teacher_details['User']['first_name']) . ' ' . ucfirst($teacher_details['User']['last_name']); ?> has made some changes in the profile whose Email is <?php echo $teacher_details['User']['email']; ?> <br/><br/>

                                                Please have a look at the Student's Profile Information. <br/><br/>

                                                Sincerely,<br/><br/>
                                                Lessons On The Go®<br/>
                                                www.lessonsonthego.com<br/>
                                                9595 Six Pines Dr. <br/>
                                                Building 8, Level 2, Suite 8210 <br/>
                                                The Woodlands, TX 77380<br/>
                                                Office: (281) 401-9580<br/>
                                            </p>

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