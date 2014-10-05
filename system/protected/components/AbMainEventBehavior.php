<?php

class AbMainEventBehavior extends CBehavior
{
	public function onSetupTheme( $event ) 		{ $this->raiseEvent('onSetupTheme', $event); 	}
	public function onSetupPlugin( $event ) 	{ $this->raiseEvent('onSetupPlugin', $event); 	}
	public function onSetupHead( $event ) 		{ $this->raiseEvent('onSetupHead', $event); 	}
	public function onLoadHeader( $event ) 		{ $this->raiseEvent('onLoadHeader', $event); 	}
	public function onBeforeContent( $event ) { $this->raiseEvent('onBeforeContent', $event); }
	public function onLoadContent( $event ) 	{ $this->raiseEvent('onLoadContent', $event); 	}
	public function onAfterContent( $event ) 	{ $this->raiseEvent('onAfterContent', $event); 	}
	public function onLoadSidebar( $event ) 	{ $this->raiseEvent('onLoadSidebar', $event); 	}
	public function onLoadFooter( $event ) 		{ $this->raiseEvent('onLoadFooter', $event); 	}
	public function onSetupBottom( $event ) 	{ $this->raiseEvent('onSetupBottom', $event); 	}

	public function getViewPath()
	{
		$name = Yii::app()->theme->name;
		$path = dirname( Yii::app()->theme->basePath ) . "/{$name}/views/partial/";
		return $path;
	}

	public function doSetupHead($event)
	{

		$viewFile = $this->viewPath . '_head.php';
		$this->owner->renderFile( $viewFile );
	}

	public function doLoadHeader($event)
	{
		$viewFile = $this->viewPath . '_header.php';
		$this->owner->renderFile( $viewFile );
	}

	public function doBeforeContent($event)
	{
		$viewFile = $this->viewPath . '_before.php';
		$this->owner->renderFile( $viewFile );
	}

	public function doLoadSidebar($event)
	{
		$viewFile = $this->viewPath . '_sidebar.php';
		$this->owner->renderFile( $viewFile );
	}

	public function doLoadFooter($event)
	{
		$viewFile = $this->viewPath . '_footer.php';
		$this->owner->renderFile( $viewFile );
	}

	public function doSetupBottom($event)
	{
		$viewFile = $this->viewPath . '_bottom.php';
		$this->owner->renderFile( $viewFile );
	}
}