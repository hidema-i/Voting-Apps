<?php

namespace controller\login;

use lib\Auth;

function get()
{
  require_once SOURCE_BASE . 'views/login.php';
}



function post()
{
  $id = get_param('id', '');
  $pwd = get_param('pwd', '');



  if (Auth::login($id, $pwd)) {
    echo '認証成功';
  } else {
    echo '認証失敗';
  }
}
