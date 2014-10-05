<?php 

class AbCalenderWidget extends CWidget 
{
	public $title = '';
	public $year  = null;
	public $month = null;

	private $_date     = null;
	private $_lastDay  = null;
	private $_firstDay = null;
	private $_queries  = null;

	public function run() 
	{
		if ($this->year == null || $this->month == null){
			$this->year  = date('Y');
			$this->month = date('m');
		}
			
		$this->_date = mktime(0, 0, 0, $this->month, 1, $this->year);
		$this->_lastDay = date('t', $this->_date); 
		$this->_firstDay = date('N',$this->_date)-1; //0 to 6

		$this->_queries = $this->getPostByDay();
		$this->calenderWidget();
	}

	public function calenderWidget()
	{
		$header  = date('F Y', $this->_date);
		$baseUrl = Yii::app()->baseUrl.'/archive/';
		$prev    = mktime(0,0,0, ($this->month-1), 1, $this->year);
		$prevUrl = $baseUrl.date('Y/m/', $prev);
		$next    = mktime(0,0,0, ($this->month+1), 1, $this->year);
		$nextUrl = $baseUrl.date('Y/m/', $next);
		?>
		<aside id="calendar-2" class="widget widget_calendar">
			<p class="widget-title">&nbsp;<?php echo $this->title ?></p>
			<div id="calendar_wrap">
				<table id="wp-calendar">
			  	<caption><?php echo $header ?></caption>
					<thead>
						<tr>
							<th scope="col" title="Monday">M</th>
							<th scope="col" title="Tuesday">T</th>
							<th scope="col" title="Wednesday">W</th>
							<th scope="col" title="Thursday">T</th>
							<th scope="col" title="Friday">F</th>
							<th scope="col" title="Saturday">S</th>
							<th scope="col" title="Sunday">S</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td colspan="3" id="prev" style="text-align:left">
								<a href="<?php echo $prevUrl ?>" title="View posts for <?php echo date('F Y', $prev) ?>">
									« <?php echo date('M', $prev) ?>
								</a>
							</td>	
							<td class="pad">&nbsp;</td>
							<td colspan="3" id="next" style="text-align:right">
								<a href="<?php echo $nextUrl ?>" title="View posts for <?php echo date('F Y', $next) ?>">
									<?php echo date('M', $next) ?> »
								</a>
							</td>
						</tr>
					</tfoot>
					<tbody>
						<tr>
						<?php if ($this->_firstDay>0): ?>
							<td colspan="<?php echo $this->_firstDay ?>" class="pad">&nbsp;</td>
						<?php endif ?>
						<?php for ($day=1; $day<=$this->_lastDay; $day++): ?>
							<?php $index = ($this->_firstDay+$day) % 7 ?>
							<?php if ($index == 1): ?>
						</tr>
						<tr>
							<?php endif ?>
							<td>
								<?php $day = $day<10? "0$day": $day ?>
								<?php if ($this->_queries[$day]>=1): ?>
								<a style="font-weight:bold" href="<?php echo $baseUrl.date('Y/m/', $this->_date).$day ?>/" title="<?php echo $this->_queries[$day] ?> post(s)">
									<?php echo $day ?>
								</a>	
								<?php else: ?>
								<?php echo $day ?>
								<?php endif ?>
							</td>
							<?php if ($index == 0): ?>
						</tr>
							<?php endif ?>
						<?php endfor ?>
						</tr>
					</tbody>
				</table>
			</div>
		</aside>
		<?php
	}

	public function getPostByDay()
	{
		$posts = PostModel::model()->articles()->findAll(array(
			'condition' => 'YEAR(created)=:year AND MONTH(created)=:month',
			'params' => array(':year'=>$this->year, ':month'=>$this->month)
		));

		$data = array();
		foreach ($posts as $post) {
			$day = date('d', strtotime($post->created));
			$data[$day]++;
		}

		return $data;
	}
}