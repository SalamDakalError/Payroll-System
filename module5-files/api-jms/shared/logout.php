<?php
// simple logout placeholder: clear session and redirect to login
session_start();
session_unset();
session_destroy();
header('Location: ../index.html');
exit;