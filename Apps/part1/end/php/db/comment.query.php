<?php

namespace db;

use db\DataSource;
use model\CommentModel;
use model\TopicModel;

class CommentQuery
{
    public static function fetchByTopicId($topic)
    {
        // 渡ってきた＄topicIdが正しいか
        if (!$topic->isValidId()) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        select 
            c.*, u.nickname 
        from comments c 
        inner join users u 
            on c.user_id = u.id 
        where c.topic_id = :id
            and c.body != ""
            and c.del_flg != 1
            and u.del_flg != 1
        order by c.id desc
        ';

        $result = $db->select($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, CommentModel::class);

        return $result;
    }

    public static function insert($comment)
    {

        ///値のチェック
        if (!($comment->isValidTopicId()
            * $comment->isValidBody()
            * $comment->isValidAgree())) {
            return false;
        }

        $db = new DataSource;
        $sql = 'insert into comments
            (topic_id, agree, body, user_id) 
        values 
            (:topic_id, :agree, :body, :user_id)';

        return $db->execute($sql, [
            ':topic_id' => $comment->topic_id,
            ':agree' => $comment->agree,
            ':body' => $comment->body,
            ':user_id' => $comment->user_id,
        ]);
    }
    // public static function fetchPublishedTopics() {

    //     $db = new DataSource;
    //     $sql = '
    //     select 
    //         t.*, u.nickname 
    //     from topics t 
    //     inner join users u 
    //         on t.user_id = u.id 
    //     where t.del_flg != 1
    //         and u.del_flg != 1
    //         and t.published = 1
    //     order by t.id desc
    //     ';

    //     $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);

    //     return $result;

    // }

    // public static function fetchById($topic) {

    //     if(!$topic->isValidId()) {
    //         return false;
    //     }

    //     $db = new DataSource;
    //     $sql = '
    //     select 
    //         t.*, u.nickname 
    //     from topics t 
    //     inner join users u 
    //         on t.user_id = u.id 
    //     where t.id = :id
    //         and t.del_flg != 1
    //         and u.del_flg != 1
    //         and t.published = 1
    //     order by t.id desc
    //     ';

    //     $result = $db->selectOne($sql, [
    //         ':id' => $topic->id
    //     ], DataSource::CLS, TopicModel::class);

    //     return $result;

    // }
    // public static function insert($user) {

    //     $db = new DataSource;
    //     $sql = 'insert into users(id, pwd, nickname) values (:id, :pwd, :nickname)';

    //     $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

    //     return $db->execute($sql, [
    //         ':id' => $user->id,
    //         ':pwd' => $user->pwd,
    //         ':nickname' => $user->nickname,
    //     ]);

    // }
}
