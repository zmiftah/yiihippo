<?php 

class AbBannerWidget extends CWidget 
{
	public $posititon = 1;
	public $width = '100%';
	private $_banners = null;
 
	public function run() 
	{
		$this->_banners = $this->bannerByPosition;
		$this->createBanner();
	}

	public function createBanner() 
	{
		$begin = array(
			1=>'<div class="banner-content">',
			2=>'<aside class="wsb widget-mas">',
			3=>'<div class="banner-content">',
			4=>'<aside class="wsb widget-mas">'
		);

		$end = array(
			1=>'</div><!-- #Banner Di atas konten -->',
			2=>'</aside><!-- #Banner Di atas sidebar -->',
			3=>'</div><!-- #Banner Di bawah konten -->',
			4=>'</aside><!-- #Banner Di bawah sidebar -->'
		);

		$pos = $this->posititon;
		$base = Yii::app()->baseUrl;

		$html = $begin[$pos];
		foreach ($this->_banners as $banner) {
			$title = $this->getText($banner->desc);

			if (in_array($pos, array(2,4))) $html .= '<div class="div-content">';
			$html .= '<a href="'.$banner->image_url.'" class="thumbnail">';
			$width = ($banner->width > $this->width)? ' width="'.$this->width.'"': '';
	    $html .= '	<img src="'.$base.$banner->url.'" title="'.$title.'" alt="'.$title.'"'.$width.'>';
	    $html .= '</a>';
	    if (in_array($pos, array(2,4))) $html .= '</div';
	    $html .= '<div class="clear"></div>';
		}
		$html .= $end[$pos];

		echo $html;
	}

	public function getBannerByPosition()
	{
		$banners = LinkModel::model()->banners()->findAll(array(
			'condition'=>'target=:target AND status<>0',
			'params'=>array(':target'=>$this->posititon)
		));

		return $banners;
	}

	public function getText($serial)
	{
		$array = @unserialize($serial);
		if ( is_array($array) ) {
			$result = $array["text"];
		}
		return $result;
	}
}