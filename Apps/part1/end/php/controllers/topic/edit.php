<?php

namespace controller\topic\edit;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get()
{
  //Login必須
  Auth::requireLogin();
  //飛んできたtopicを格納
  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null, false);

  $user = UserModel::getSession();
  Auth::requirePermission($topic->id, $user);

  $fetchedTopic = TopicQuery::fetchById($topic);

  \view\topic\edit\index($fetchedTopic, true);
}

function post()
{
  Auth::requireLogin();

  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null);
  $topic->title = get_param('title', null);
  $topic->published = get_param('published', null);

  $user = UserModel::getSession();
  Auth::requirePermission($topic->id, $user);

  try {
    $is_success =  TopicQuery::update($topic);
  } catch (Throwable $e) {

    Msg::push(Msg::DEBUG, $e->getMessage());

    $is_success = false;
  }

  if ($is_success) {
    Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
    redirect('topic/archive');
  } else {
    Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');
    //GO_REFERERで元の画面
    redirect(GO_REFERER);
  }
}
