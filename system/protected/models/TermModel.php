<?php 

class TermModel extends AbActiveRecord 
{
	public static function model($className=__CLASS__) 
  {
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'terms';
  }

  public function primaryKey() 
  {
    return 'term_id';
  }

  public function relations() 
  {
    return array(
      'taxonomy'  => array( self::BELONGS_TO, 'TaxonomyModel', 'taxo_id' ),
      'posts'     => array( self::HAS_MANY, 'PostModel', 'post_id'),
      'postCount' => array( self::STAT, 'PostModel', 'post_id'),
   	);
  }

  public function scopes()
  {
    return array(
      'category'=>array(
        'condition'=>'taxo_id='.TaxonomyModel::CATEGORY,
      ),
      'tag'=>array(
        'condition'=>'taxo_id='.TaxonomyModel::TAG,
      ),
    );
  }

  public static function getCategory($useId=true)
  {
      $categories = self::model()->findAll(array(
        'select'=>'term_id,name,term_group',
        'condition'=>'taxo_id=:taxo',
        'params'=>array(':taxo'=>TaxonomyModel::CATEGORY),
      ));

    foreach ($categories as $cat) {
      $index = $useId ? $cat->term_id : $cat->name;
      $data[$index] = $cat->name;
    }

    return $data;
  }

  public static function filterBy($idCategory, $array)
  {
    if (count($array)>0) {
      foreach ($array as $termModel) {
        if ($termModel->taxo_id == $idCategory) {
          $data[] = $termModel;
        }
      }
    }
    return $data;
  }
}