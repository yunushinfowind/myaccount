<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * This is email configuration file.
 *
 * Use it to configure email transports of CakePHP.
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *  Mail - Send using PHP mail function
 *  Smtp - Send using SMTP
 *  Debug - Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {

    public $default = array(
        'transport' => 'Smtp',
        'emailFormat' => 'html',
        'from' => array('contactus@lessonsonthego.com' => 'LessonsOnTheGo'),
        'sender' => array('contactus@lessonsonthego.com'=> 'LessonsOnTheGo'),
        'host' => 'ssl://mail.lessonsonthego.com',
        'port' => 465,
        'timeout' => 30,
        'username' => 'contactus@lessonsonthego.com',
        'password' => 'Reishi.2276',
        'client' => null,
        'log' => true,

        //'charset' => 'utf-8',
        //'headerCharset' => 'utf-8',
    );

    public $local = array(
        'transport' => 'Mail',
        'emailFormat' => 'html',
        'from' => array('contactus@lessonsonthego.com' => 'LessonsOnTheGo'),
        'sender' => array('contactus@lessonsonthego.com'=> 'LessonsOnTheGo'),
        'log' => true,

        //'charset' => 'utf-8',
        //'headerCharset' => 'utf-8',
    );


    public $comcast = array(
		'transport' => 'Smtp',
        'emailFormat' => 'html',
		'from' => array('lessonsonthego@comcast.net' => 'LessonsOnTheGo'),
        'sender' => array('lessonsonthego@comcast.net' => 'LessonsOnTheGo'),
		'host' => 'ssl://smtp.comcast.net',
		'port' => 465,
		'timeout' => 30,
		'username' => 'lessonsonthego',
		'password' => 'Reishi.2276',
		'client' => null,
		'log' => true,

		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
    );
    
    public $gmail = array(
        'from' => array('contactus@lessonsonthego.com' => 'LessonsOnTheGo'),
        //'sender' => array('contactus@lessonsonthego.com'=> 'LessonsOnTheGo'),
        'emailFormat' => 'html',
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'contactus@lessonsonthego.com',
        'password' => '14kfreefalls',
        'transport' => 'Smtp',
        'tls' => true,
        'auth' => true,
        'context' => ['ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]],
    );


/*
	public $fast = array(
		'from' => 'you@localhost',
		'sender' => null,
		'to' => null,
		'cc' => null,
		'bcc' => null,
		'replyTo' => null,
		'readReceipt' => null,
		'returnPath' => null,
		'messageId' => true,
		'subject' => null,
		'message' => null,
		'headers' => null,
		'viewRender' => null,
		'template' => false,
		'layout' => false,
		'viewVars' => null,
		'attachments' => null,
		'emailFormat' => null,
		'transport' => 'Smtp',
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => true,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);
*/
}
