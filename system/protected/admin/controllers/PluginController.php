<?php

class PluginController extends AbBackController 
{
  public function actionIndex() 
  {
		$plugins = Yii::app()->plugins->pluginList;
		$plugins = $this->validateList( $plugins );
		$data = new CArrayDataProvider( $plugins, array(
			'id'=>'plugins',
			'pagination'=>array(
				'pageSize'=>10
			)
		));

		$this->render('index', array(
			'data' => $data,
		));
	}

	public function actionDetail() {}
	
	public function actionActivate() {}

	public function actionDeactivate() {}

	public function actionUninstall() {}

	public function actionUpdate() {}

	protected function validateList( $list ) 
	{
		foreach ($list as $key => $value) {
			$newList[] = $value;
		}
		return $newList;
	}
}