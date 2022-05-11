<?php

namespace lib;

use db\UserQuery;

class Auth
{
  //login
  public static function login($id, $pwd)
  {
    $is_success = false;

    $user =  UserQuery::fetchById($id);

    if (!empty($user) && $user->del_flg !== 1) {


      if (password_verify($pwd, $user->pwd)) {
        //$is_successが取れたらtrue
        $is_success = true;
        //セッションにuserを保持
        $_SESSION['user'] = $user;
      } else {
        echo 'パスワードが一致しません';
      }
    } else {
      echo 'ユーザーが見つかりません';
    }
    return $is_success;
  }
  //register
  public static function regist($id, $pwd, $nickname)
  {
    $is_success = false;

    $exist_user =  UserQuery::fetchById($id);

    if (!empty($exist_user)) {
      echo 'ユーザーがすでに存在します';
      return false;
    }

    $is_success =  UserQuery::insert($id, $pwd, $nickname);

    return $is_success;
  }
}
