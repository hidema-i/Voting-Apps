<?php

namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery
{
  public static function fetchById($id)
  {
    $db = new DataSource;
    $sql = 'select * from votingapp.users where id = :id;';
    $result =  $db->selectOne($sql, [
      ':id' => $id
    ], DataSource::CLS, UserModel::class);

    return $result;
  }

  //registerのdb
  public static function insert($user)
  {

    $db = new DataSource;
    $sql = 'insert into users(id, pwd, nickname) values (:id,:pwd,:nickname)';

    //ハッシュ化 ①どれを②アルゴリズム
    $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);
    //isertする
    return $db->execute($sql, [
      ':id' => $user->id,
      ':pwd' => $user->pwd,
      ':nickname' => $user->nickname,
    ]);
  }
}
