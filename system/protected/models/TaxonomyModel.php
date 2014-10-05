<?php 

class TaxonomyModel extends AbActiveRecord 
{
  const CATEGORY = 1;
  const TAG      = 2;

	public static function model($className=__CLASS__) 
  {
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'taxonomy';
  }

  public function primaryKey() 
  {
    return 'taxo_id';
  }

  public function relations() 
  {
    return array(
      'term'  => array( self::HAS_MANY, 'TermModel', 'taxo_id' ),
      // Stat
      'termCount' => array( self::STAT, 'TermModel', 'taxo_id' ),
   	);
  }

  public static function getTaxonomyId($taxonomy)
  {
    $taxonomies = array(
      'category' => self::CATEGORY,
      'tag'      => self::TAG,
    );
    
    $Id = array_key_exists($taxonomy, $taxonomies) ? $taxonomies[$taxonomy] : 0;
    return $Id;
  }
}