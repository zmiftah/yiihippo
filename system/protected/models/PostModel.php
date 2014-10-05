<?php 

class PostModel extends AbActiveRecord 
{
  public $id;

  public static function model($className=__CLASS__) 
  {
    return parent::model( $className );
  }

  public function attributeLabels() 
  {
    return array(
      'title'   => '<strong>Title</strong>',
      'content' => '<strong>Konten</strong>',
      'keyword' => '<strong>Keyword</strong>',
      'desc'    => '<strong>Deskripsi</strong>',
      'url'     => '<strong>Permalink</strong>',
    );
  }

  public function rules() 
  {
    // menghilangkan `author` dari rules untuk menghindari bugs masa depan
    return array(
      array('posttype_id, created, title, desc, content, excerpt, url, keyword', 'required'), //keyword,
      array('url', 'unique', 'className'=>'PostModel', 'attributeName'=>'url', 'message'=>'Url sudah ada'),
    );
  }

  public function _tableName() 
  {
    return 'posts';
  }

  public function primaryKey() 
  {
    return 'post_id';
  }

  public function relations() 
  {
    return array(
      'comment'     => array( self::HAS_MANY, 'CommentModel', 'post_id', 'condition'=>'status='.CommentModel::STATUS_APPROVE),
      'postStatus'  => array( self::BELONGS_TO, 'PostStatusModel', 'status' ),
      'type'        => array( self::BELONGS_TO, 'ClientPostType', 'posttype_id' ),
      'postKeyword' => array( self::BELONGS_TO, 'KeywordModel', 'keyword' ),
      'featured'    => array( self::BELONGS_TO, 'LinkModel', 'image'),
      'categories'  => array( self::HAS_MANY, 'PostTermModel', 'post_id', 'condition'=>'taxo_id='.TaxonomyModel::CATEGORY),
      'tags'        => array( self::HAS_MANY, 'PostTermModel', 'post_id', 'condition'=>'taxo_id='.TaxonomyModel::TAG),
      
      // Statistic
      'commentCount' => array(self::STAT, 'CommentModel', 'post_id', 'condition'=>'t.status='.CommentModel::STATUS_APPROVE.' OR t.status='.CommentModel::STATUS_REPLY),
    );
  }

  public function scopes()
  {
    return array(
      'pages'=>array(
        'condition'=>'posttype_id='.PostTypeModel::TYPE_PAGE,
      ),
      'articles'=>array(
        'condition'=>'posttype_id='.PostTypeModel::TYPE_ARTICLE,
      ),
      'revisions'=>array(
        'condition'=>'posttype_id='.PostTypeModel::TYPE_REVISION,
      ),
      'privates'=>array(
        'condition'=>'posttype_id='.PostTypeModel::TYPE_PRIVATE,
      ),
      'trashes'=>array(
        'condition'=>'posttype_id='.PostTypeModel::TYPE_TRASH,
      ),
      'drafts'=>array(
        'condition'=>'status='.PostStatusModel::STATUS_DRAFT,
      ),
      'published'=>array(
        'condition'=>'status='.PostStatusModel::STATUS_PUBLISH,
      ),
    );
  }

  public function viewArticle()
  {
    $this->viewed++;
    $this->save();
  }

  public function getRelatedArticle()
  {
    $sql = "SELECT GROUP_CONCAT(post_id) as id FROM posts WHERE posttype_id=".PostTypeModel::TYPE_ARTICLE;
    $listID = Yii::app()->db->createCommand($sql)->queryRow();
    $lists = explode(',', $listID['id']);

    for ($i=0; $i<count($lists); $i++) { 
      if ($this->post_id == $lists[$i]) {
        $prevId = $lists[($i-1)];
        $nextId = $lists[($i+1)];
      }
    }

    $prevArticle = $this->findByPk($prevId);
    if ($prevArticle instanceof PostModel) {
      $permalink = Yii::app()->controller->createPermalink($prevArticle->url, $prevArticle->created);
      $prevArticle = array(
        'url'=>/*Yii::app()->baseUrl.*/$permalink,
        'title'=>$prevArticle->title
      );
    }

    $nextArticle = $this->findByPk($nextId);
    if ($nextArticle instanceof PostModel) {
      $permalink = Yii::app()->controller->createPermalink($nextArticle->url, $nextArticle->created);
      $nextArticle = array(
        'url'=>/*Yii::app()->baseUrl.*/$permalink,
        'title'=>$nextArticle->title
      );
    }

    return array(
      'prev'=>$prevArticle,
      'next'=>$nextArticle
    );
  }

  public function fetchMetadata($meta)
  {
    $metadata = MetadataModel::model()->find(array(
      'condition'=>'`mtable`=:table AND `table_id`=:id AND `mkey`=:key',
      'params'=>array(':table'=>'posts',':id'=>$this->post_id, 'key'=>$meta)
    ));
    return $metadata;
  }

  public function isUniqueUrl($url)
  {
    $posts = $this->findAll(array(
      'condition'=>'url=:url',
      'params'=>array(':url'=>$url)
    ));

    return (count($posts)==0);
  }
}
