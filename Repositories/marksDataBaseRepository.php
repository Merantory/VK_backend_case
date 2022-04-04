<?php

class marksDataBaseRepository {
    static public function isMarkComment(comment $comment, user $user) {
        if(DataBaseRepository::$database->injection("SELECT * FROM `marks` WHERE comment_id=? AND user_id = ?
        LIMIT 1",'ii',$comment->getID(),$user->getID())->fetch_array()) return true;
        else return false;
    }

    static public function removeMark(comment $comment, user $user) {
        DataBaseRepository::$database->injection("DELETE FROM `marks` WHERE comment_id=? AND user_id = ?
        LIMIT 1",'ii',$comment->getID(),$user->getID());
    }

    static public function markCommentUser(comment $comment, user $user) {
        DataBaseRepository::$database->injection("INSERT INTO `marks`(comment_id,user_id)
        VALUES(?,?)",'ii',$comment->getID(),$user->getID());
    }

}