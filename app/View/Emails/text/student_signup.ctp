<?php echo $data['Email_content']['subject']; ?>

Dear <?php echo ucfirst($user['User']['first_name']) . ' ' . ucfirst($user['User']['last_name']); ?>,

Welcome to Lessons On The Go!

To sign in to your account, please visit https://myaccount.lessonsonthego.com/ . You can also access your account by
going to our website, http://lessonsonthego.com/ and clicking "Log In" at the top right-hand corner. Once logged in,
you will be able to purchase lessons, track lesson completion, and chat directly with your teachers. Your log in
information is listed below.

Please note that you can change your temporary password from within your account at any time.

Email : <?php echo $user['User']['email']; ?>
Temporary Password : <?php echo $passwords; ?>

Sincerely,
Lessons On The Go
www.lessonsonthego.com
9595 Six Pines Dr.
Building 8, Level 2, Suite 8210
The Woodlands, TX 77380
Office: (281) 401-9580

