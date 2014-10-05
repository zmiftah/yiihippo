<?php 

class AbLinkPager extends CLinkPager
{
	public $selectedPageCssClass = 'current';

	public $nextPageLabel = '&gt;';
	public $prevPageLabel = '&lt;';
	public $firstPageLabel = '&lt;&lt;';
	public $lastPageLabel = '&gt;&gt;';
	public $maxButtonCount = 7;
	public $prefixUrl = '?page=';

	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo '<div class="wp-pagenavi">';
		echo $this->header;
		echo implode("\n",$buttons);
		echo $this->footer;
		echo '</div>';
	}

	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		
		if(($page=$currentPage-1)<0)
			$page=0;

		// first page
		if($page>0)
			$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);
		// prev page
		if($page>0)
			$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage,false);
		
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;

		// next page
		if($page<$pageCount-1)
			$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);
		// last page
		if($page<$pageCount-1)
			$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	protected function createPageButton($label,$page,$class,$hidden,$selected,$control=true)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);

		if($selected) {
			$widget = '<span class="'.$this->selectedPageCssClass.'">'.($page+1).'</span>';
		} else {
			$isctrl = !$control ? array(
				'class'=>self::CSS_INTERNAL_PAGE,
				'title'=>$label
			) : null;
			$widget = CHtml::link($label, $this->prefixUrl.($page+1), $isctrl);
		}

		return $widget;
	}
}