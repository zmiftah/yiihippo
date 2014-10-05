<?php 

class MigrateController extends AbBackController
{
	public function actionIndex()
	{
		if ( isset($_FILES) ) {
			$filedb = CUploadedFile::getInstanceByName('filedb');
			if ( $filedb ) {
				$timeA = microtime(true);
				$dirname = dirname(dirname(Yii::app()->basePath)).'/content/upload/';
				$filename = $dirname.$filedb->name;
				if ($filedb->saveAs($filename)) {
					$sequels  = Yii::app()->migration->getDataSQLInsert($filename);
					$totalRow = Yii::app()->migration->processMigation($sequels);
				}
				$timeB = microtime(true);

				Yii::app()->user->setFlash('result', serialize(array(
					'rows' => $totalRow,
					'time' => $timeB-$timeA
				)));
				$this->redirect('migrate.php');
			}
		}
		
		// $filename = dirname(dirname(Yii::app()->basePath)).'/content/upload/suppor78_hippo.sql';
		// $sequels = Yii::app()->migration->getDataSQLInsert($filename);
		
		$result = Yii::app()->user->getFlash('result', false);
		if ($result) $result = unserialize($result);
		
		$this->render('form', $result);
	}
}