<?php
require_once('./config.php');
define('URI', explode('/', urldecode(trim($_SERVER['REQUEST_URI'], '/'))));
require_once('./routes/router.php');
