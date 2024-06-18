<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_model extends CI_Model
{

    public $title;
    public $content;
    public $date;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $sql = 'CREATE TABLE IF NOT EXISTS "users" ( "userid" TEXT UNIQUE, "username" TEXT, "level" TEXT DEFAULT "user", "pass" TEXT NOT NULL, "date" DATETIME DEFAULT (datetime()), PRIMARY KEY("userid") )';
        $this->db->query($sql);

    }

    public function get_user($userid)
    {
        if ($userid == 'admin' and $pass = 'admin') {
            return ['userid' => 'admin', 'username' => 'Admin', 'level' => 'admin', 'pass' => md5('admin')];
        } else {
            $query = $this->db->get_where('users', array('userid' => $userid), 1);
            if ($query->num_rows() == 1) {
                return $query->row_array();
            } else {
                return false;
            }
        }
    }

    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function insert_user($userid, $username, $pass)
    {
        $user = $this->get_user($userid);
        if (!$user) {
            $sql = "INSERT INTO users ( userid, username, pass ) VALUES ( ?, ?, ? )";
            $this->db->query($sql, array($userid, $username, md5($pass)));
            return true;
        } else {
            return false;
        }
    }

// ... do uzupełnienia dalsza częśc metod modelu danych  !!!
    public function get_topics()
    {
        $query = $this->db->get('topic');
        return $query->result_array();
    }

    public function get_topic($topicid)
    {
        $query = $this->db->get_where('topic', array('topicid' => $topicid), 1);
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function add_topic($topic, $topic_body, $date, $userid, $topicid)
    {
        $isTopicExist = $this->get_topic($topicid);
        if ($isTopicExist) {
            $this->db->where('topicid', $topicid);
            $this->db->update('topic', array('topic' => $topic, 'topic_body' => $topic_body));
        } else {
            $this->db->insert('topic', array('topic' => $topic, 'topic_body' => $topic_body, 'date' => $date, 'userid' => $userid));
        }
    }

    public function count_posts($topicid)
    {
        $query = $this->db->get_where('post', array('topicid' => $topicid));
        return $query->num_rows();
    }

    public function delete_topic($topicid)
    {
        $this->db->delete('topic', array('topicid' => $topicid));
        $this->db->delete('post', array('topicid' => $topicid));
    }

    public function get_last_post_date()
    {
        $query = $this->db->query('SELECT date FROM post ORDER BY date DESC LIMIT 1');
        return $query->row_array();
    }

    public function get_posts($topicid)
    {
        $query = $this->db->get_where('post', array('topicid' => $topicid));
        return $query->result_array();
    }

    public function get_post($postid)
    {
        $query = $this->db->get_where('post', array('postid' => $postid), 1);
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function get_image($imgid)
    {
        $query = $this->db->get_where('image', array('id' => $imgid), 1);
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function add_post($post, $userid, $topicid, $date, $postid)
    {
        $isPostExist = $this->get_post($postid);
        if ($isPostExist) {
            $this->db->where('postid', $postid);
            $this->db->update('post', array('post' => $post, 'userid' => $userid, 'topicid' => $topicid));
        } else {
            $this->db->insert('post', array('post' => $post, 'userid' => $userid, 'topicid' => $topicid, 'date' => $date));
        }
    }

    public function delete_post($postid)
    {
        $this->db->delete('post', array('postid' => $postid));
        $this->db->delete('image', array('postid' => $postid));
    }

    public function get_images($topicid = null)
    {
        if ($topicid) {
            $query = $this->db->get_where('image', array('topicid' => $topicid));
        } else {
            $query = $this->db->get('image');
        }
        return $query->result_array();
    }

    public function upload_image($userid, $postid, $topicid, $name, $sufix, $title)
    {
        $this->db->where('postid', $postid);
        $this->db->where('name', $name);
        $query = $this->db->get('image');
        $data = [
            'userid' => $userid,
            'postid' => $postid,
            'topicid' => $topicid,
            'name' => $name,
            'sufix' => $sufix,
            'title' => $title,
            'date' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('image', $data);
    }

    public function getNextImageId()
    {
        $query = $this->db->query('SELECT MAX(id) as maxid FROM image');
        $row = $query->row_array();
        return $row['maxid'] + 1;
    }

    public function delete_image($imageid)
    {

        $this->db->where('id', $imageid);
        $query = $this->db->get('image');
        $image = $query->row_array();

        if ($image) {

            $file_path = './files/' . $image['id'] . '.' . $image['sufix'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Remove the image record from the database
            $this->db->where('id', $imageid);
            $this->db->delete('image');
        } else {
            return false;
        }

        return true;
    }
    public function edit_image($imgid, $title)
    {
        $this->db->where('id', $imgid);
        $this->db->update('image', ['title' => $title]);
    }
    public function change_user_level($userid){
        $user = $this->get_user($userid);
        if ($user['level'] == 'admin'){
            $this->db->where('userid', $userid);
            $this->db->update('users', ['level' => 'user']);
        } else {
            $this->db->where('userid', $userid);
            $this->db->update('users', ['level' => 'admin']);
        }
    }
    public function delete_user($userid){
        $this->db->delete('users', ['userid' => $userid]);
        $this->del_user_activity($userid);
    }
    public function del_user_activity($userid){
        $this->db->delete('topic', ['userid' => $userid]);
        $this->db->delete('post', ['userid' => $userid]);
        $this->db->delete('image', ['userid' => $userid]);
    }


}// end of Form_model model