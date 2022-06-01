<?php

namespace controller\topic\detail;

use db\CommentQuery;
use db\TopicQuery;
use lib\Msg;
use lib\Auth;
use model\TopicModel;

function get()
{
  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null, false);

  TopicQuery::incrementViewCount($topic);

  $fetchedTopic = TopicQuery::fetchById($topic);
  $comments = CommentQuery::fetchByTopicId($topic);

  if (empty($fetchedTopic) || !$fetchedTopic->published) {
    Msg::push(Msg::ERROR, 'トピックが見つかりません');
    redirect('404');
  }
  \view\topic\detail\index($fetchedTopic, $comments);

  function post()
  {
    Auth::requireLogin();
  }
}
