<?php 

class CommentModel extends AbActiveRecord 
{
  const STATUS_PENDING = 0;
  const STATUS_APPROVE = 1;
  const STATUS_SPAM    = 2;
  const STATUS_TRASH   = 3;
  const STATUS_REPLY   = 4;

  public $id;

  public function attributeLabels() 
  {
    return array(
      'author'  => 'Nama'
    );
  }

  public static function model($className=__CLASS__) 
  {
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'comments';
  }

  public function primaryKey() 
  {
    return 'comment_id';
  }

  public function rules()
  {
    return array(
      array('author, email', 'required'),
      array('email', 'email'),
      // array('website', 'url'),
    );
  }

  public function relations() 
  {
    return array(
      'post' => array( self::BELONGS_TO, 'PostModel', 'post_id' ),
      'reply' => array( self::HAS_MANY, 'CommentModel', 'reply_to' ),
      'replyCount' => array(self::STAT, 'CommentModel', 'reply_to'),
    );
  }

  public function scopes()
  {
    return array(
      'comments' => array(
        'condition'=>"reply_to IS NULL AND status!=".self::STATUS_TRASH,
      ),
      'pending' => array(
        'condition'=>"reply_to IS NULL AND status=".self::STATUS_PENDING,
      ), 
      'approve' => array(
        'condition'=>"reply_to IS NULL AND status=".self::STATUS_APPROVE,
      ), 
      'spam' => array(
        'condition'=>"reply_to IS NULL AND status=".self::STATUS_SPAM,
      ), 
      'trash' => array(
        'condition'=>"reply_to IS NULL AND status=".self::STATUS_TRASH,
      ),
      'replies' => array(
        'condition'=>"reply_to IS NOT NULL",
      )
    );
  }
}