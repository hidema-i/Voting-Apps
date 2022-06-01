<?php

namespace lib;

use Throwable;
use Error;

function route($rpath, $method)
{
  try {

    if ($rpath === '') {
      $rpath = 'home';
    }

    $targetfile = SOURCE_BASE . "controllers/{$rpath}.php";

    if (!file_exists($targetfile)) {
      require_once SOURCE_BASE .  "views/404.php";
      return;
    }


    require_once $targetfile;
    // echo $rpath;
    $rpath = str_replace('/', '\\', $rpath);
    $fn = "\\controller\\{$rpath}\\{$method}";

    $fn();
  } catch (Throwable $e) {
    Msg::push(Msg::DEBUG, $e->getMessage());
    Msg::push(Msg::ERROR, '何かがおかしいようです。。');
    redirect('404');
  }
}
