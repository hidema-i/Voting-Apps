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
  public static function insert($id, $pwd, $nickname)
  {

    $db = new DataSource;
    $sql = 'insert into users(id, pwd, nickname) values (:id,:pwd,:nickname)';

    //ハッシュ化 ①どれを②アルゴリズム
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    //isertする
    return $db->execute($sql, [
      ':id' => $id,
      ':pwd' => $pwd,
      ':nickname' => $nickname,
    ]);
  }
}
