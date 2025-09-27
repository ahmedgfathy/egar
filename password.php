<?php
$user_name = 'admin';
$user_password = 'admin';
$salt = substr($user_name, 0, 2);
$encrypted_password = crypt($user_password, salt);
echo $encrypted_password;
?php>