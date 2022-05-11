<?php
require_once 'config.php';

//library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';

//Model
require_once SOURCE_BASE . 'models/user.model.php';
//DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/user.query.php';
//セッション開始

session_start();
require_once SOURCE_BASE . 'partials/header.php';

$rpath = str_replace(BASE_CONTEXT_PATH, '', CURRENT_URI);

$method = strtolower($_SERVER['REQUEST_METHOD']);

route($rpath, $method);


function route($rpath, $method)
{
  if ($rpath === '') {
    $rpath = 'home';
  }

  $targetfile = SOURCE_BASE . "controllers/{$rpath}.php";

  if (!file_exists($targetfile)) {
    require_once SOURCE_BASE .  "views/404.php";
    return;
  }

  require_once $targetfile;

  $fn = "\\controller\\{$rpath}\\{$method}";
  $fn();
}




// if ($_SERVER['REQUEST_URI'] === 'login') {
//   require_once SOURCE_BASE . 'controllers/login.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/voting/part1/end/register') {
//   require_once SOURCE_BASE . 'controllers/register.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/voting/part1/end/') {
//   require_once SOURCE_BASE . 'controllers/home.php';
// }

require_once SOURCE_BASE . 'partials/footer.php';
