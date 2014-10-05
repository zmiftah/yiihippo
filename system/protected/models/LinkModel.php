<?php 

class LinkModel extends AbActiveRecord 
{
  public $id;
  public $strictUrl = false;

  const LINK_TYPE_BANNER   = 1;
  const LINK_TYPE_WEBSITE  = 2;
  const LINK_TYPE_MEDIA    = 3; # featured etc
  const LINK_TYPE_FEED     = 4;

  const LINK_STATUS_ACTIVE = 10; # active/inactive

	public static function model($className=__CLASS__) 
  {
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'links';
  }

  public function primaryKey() 
  {
    return 'link_id';
  }

  public function rules()
  {
    $rules = $this->strictUrl? array(
      array('url', 'required'),
      array('url', 'url'),
    ): array();

    return $rules;
  }

  public function scopes()
  {
    $images = $this->imagesType;

    return array(
      'banners' => array(
        'condition' => 'type=1',
      ),
      'websites' => array(
        'condition' => 'type=2',
      ),
      'featured' => array(
        'condition' => 'type=3',
      ),
      'feed' => array(
        'condition' => 'type=4',
      ),
      'images' => array(
        'condition' => "content_type IN (".implode(',',$images).")",
      ),
    ); 
  }

  public function getImagesType()
  {
    return array(
      "'image/gif'", "'image/jpeg'", "'image/pjpeg'", 
      "'image/png'", "'image/svg+xml'", "'image/tiff'"
    );
  }

  public function getIsImage()
  {
    return in_array("'$this->content_type'", $this->imagesType);
  }

  public static function getListPosition()
  {
    return array(
      1 => 'Di Atas Konten',// (Width 655)
      2 => 'Di Atas Sidebar',// (Width 288)
      3 => 'Di Bawah Konten',// (Width 655)
      4 => 'Di Bawah Sidebar',// (Width 288)
      // 5 => 'Di Kanan Situs',
      // 6 => 'Di Kiri Situs',
    );
  }
}