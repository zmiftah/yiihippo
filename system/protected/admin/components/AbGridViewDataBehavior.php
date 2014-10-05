<?php 

class AbGridViewDataBehavior extends CBehavior 
{
	public function filterField($field)
	{
		$value = str_replace('NOT_IN', '', $field);
		return trim($value);
	}

	/**
	 * Generate Data for GridView
	 *
	 * Return Data rows, Pages count, Offset and Total rows
	 * 
	 * @param  CActiveRecord  $modelObj
	 * @param  int  $page    
	 * @param  int  $limit   
	 * @param  CDbCriteria  $criteria
	 * @param  boolean $sorting 
	 * @return array           
	 */
	public function generateData($modelObj, $page, $limit, $criteria, $activeRecord=true)
	{
		if( !isset($page) ) $page=1;
		$offset = ($page-1) * $limit;

		$provider = $activeRecord ? 'CActiveDataProvider' : 'CArrayDataProvider';
    $data = new $provider($modelObj, array(
      'pagination'=>array(
        'pageSize'=>$limit,
      )
    ));

    if ( $activeRecord ) {
    	$data->setCriteria($criteria);
    }

    $config = array(
    	'type' => 'striped bordered condensed hover',
	    'dataProvider' => $data,
	    'template' => "{items}{pager}",
	    'pager' => array(
	    	'class'=>'bootstrap.widgets.TbPager',
	    	'prevPageLabel' => '<i class="icon-double-angle-left"></i>',
	    	'nextPageLabel' => '<i class="icon-double-angle-right"></i>',
	    )
    );

    return array(
			'config' => $config,
			'offset' => $offset,
			'total'  => $data->itemCount,
		);
	}
}