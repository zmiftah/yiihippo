<?php 

class AbMigrationComponent extends CApplicationComponent
{
	public $parser;

	public function init()
	{
		parent::init();
		$this->parser = new SqlParser;
		$this->parser->init();
	}

	public function getDataSQLInsert($filedb)
	{
		$insert = file_get_contents($filedb);

		$insert = str_replace(array('!--','/--'), array('GA_STRIP1','GA_STRIP2'), $insert);
		$parsed = explode('--', $insert);
		foreach ($parsed as $forcheck) {
			if (strpos($forcheck, 'INSERT INTO')>=1) {
				$forcheck = str_replace(array('GA_STRIP1','GA_STRIP2'), array('!--','/--'), $forcheck);
				$sql = trim($forcheck);
				$data[]  = $this->parser->parse($sql);
			}
		}
		return $data;
	}

	public function processMigation($data)
	{
		if (count($data)<=0) return;

		foreach ($data as $key => $table) {
			// echo "<h4>$key => {$table[INSERT][0][table]}</h4>";

			$columns = $table['INSERT'][0];
			$rows    = $table['VALUES'];
			$columns = $this->escapeColumns($columns['columns']);

			$values = array();
			foreach ($rows as $id => $value) {
				$values[] = $this->escapeValues($value['data']);
			}

			if (count($columns)==0 || count($values)==0) {
				continue;
			}

			switch ($table['INSERT'][0]['table']) {
				case '`adsense`':
					$jml['Adsense'] = $this->processAdsense($columns, $values);
					break;
				case '`article`':
					$jml['Article'] = $this->processArticle($columns, $values);
					break;
				case '`banner`':
					$jml['Banner'] = $this->processBanner($columns, $values);
					break;
				case '`comment`':
					$jml['Comment'] = $this->processComment($columns, $values);
					break;
				case '`project_keyword`':
					/* $jml['Keyword'] = $this->processKeyword($columns, $values); */
					break;
				case '`setting`':
					$jml['Setting'] = $this->processSetting($columns, $values);
					break;
			}
		}

		return $jml;
	}

	protected function escapeColumns($array)
	{
		foreach ($array as $arr) {
			$data[] = str_replace('`', '', $arr['base_expr']);
		}
		return $data;
	}

	protected function escapeValues($array)
	{
		foreach ($array as $arr) {
			$data[] = $arr['base_expr'];
		}
		return $data;
	}

	protected function processAdsense($colums, $rows) 
	{
		// Convert adsense to options
		$colums = array_flip($colums);
	  foreach ($rows as $id => $value) {
	  	$option = 'adsense_'.($id+1);+
	  	$script = substr($value[1], 1, strlen($value[1])-2);
	  	$script = str_replace(array('\r','\n'), array('',''), $script);
	  	Yii::app()->options->add($option, $script);
	  }
	  return count($rows);
	}

	protected function processArticle($colums, $rows) 
	{
		// Convert adsense to posts
		$colums = array_flip($colums);
		foreach ($rows as $id => $value) {
			$post_id = $value[$colums['article_id']]; 
			$keyword = str_replace("'", '', $value[$colums['article_main_keyword']]);
			$created = str_replace("'", '', $value[$colums['post_date']]);
			$title   = str_replace("'", '', $value[$colums['article_metatitle']]);
			$desc    = str_replace("'", '', $value[$colums['article_desc']]);
			$url     = str_replace("'", '', $value[$colums['article_link']]);

			$content_index = $colums['article_content'];
			$total_index   = count($value)-4;
			$pieces        = array();
			for ($i=$content_index; $i<$total_index; $i++) {
				$pieces[] = $value[$i];
			}
			$content = implode('', $pieces);
			$content = substr($content, 1, strlen($content)-2);
			$content = $this->convertShortCode($content);
			// Keyword
			$kwdObj = KeywordModel::model()->find(array(
				'condition'=>'name=:name',
				'params'=>array(':name'=>$keyword)
			));
			if (!($kwdObj instanceof KeywordModel)) {
				$kwdObj = new KeywordModel;
				$kwdObj->name   = $keyword;
				$kwdObj->status = 1;
				$kwdObj->save();
			}
			// Article
			$model = PostModel::model()->find(array(
				'condition'=>'title=:title AND posttype_id='.PostTypeModel::TYPE_ARTICLE,
				'params'=>array(':title'=>$title)
			));
			if (!($model instanceof PostModel)) $model = new PostModel; 
			$model->post_id     = (int)$post_id;
			$model->posttype_id = PostTypeModel::TYPE_ARTICLE;
			$model->created     = $created;
			$model->title       = $title;
			$model->keyword 		= $kwdObj->id;
			$model->desc        = $desc;
			$model->content     = $content;
			$model->author      = Yii::app()->user->adminId;
			$model->excerpt     = substr(strip_tags($content), 0, 100) . '..';
			$model->url         = $url;
			$model->status      = PostStatusModel::STATUS_PUBLISH;
			try {
				$jml += $model->save();
			} catch (Exception $e) {}
			
		}
		return $jml;
	}

	protected function processBanner($colums, $rows)
	{
		// Convert banner to links
		$colums = array_flip($colums);
		foreach ($rows as $id => $value) {
			$link_id  = $value[$colums['id']];
			$name     = str_replace("'", '', $value[$colums['name']]);
			$position = str_replace("'", '', $value[$colums['position']]);
			$img_url  = str_replace("'", '', $value[$colums['link']]);
			$text     = str_replace("'", '', $value[$colums['alt']]);

			$model = new LinkModel;
			$model->url = '/content/upload/banner/'.$name;
			$model->name = $name;
			$model->type = LinkModel::LINK_TYPE_BANNER;
			$model->content_type = FileHelper::getContentType($name);
			$model->image_url = $img_url;
			$model->target = $position;
			$model->status = 0;
			$model->desc = serialize(array('text'=>$text));
			$model->created = new CDbExpression('NOW()'); 
			$jml += $model->save();
		}
		return $jml;
	}

	protected function processComment($colums, $rows) 
	{
		// Convert comment to comments
		$colums = array_flip($colums);
		foreach ($rows as $id => $value) {
			$comment_id   = str_replace("'", '', $value[$colums['comment_id']]);
			$post_id 			= $value[$colums['article_id']];
			$author 			= str_replace("'", '', $value[$colums['comment_name']]);
			$email 				= str_replace("'", '', $value[$colums['comment_email']]);
			$content 			= str_replace("'", '', $value[$colums['comment_content']]);
			$date_insert 	= str_replace("'", '', $value[$colums['post_date']]);
			$status 			= str_replace("'", '', $value[$colums['comment_stat']]);
			$admin_reply	= str_replace("'", '', $value[$colums['comment_reply']]);

			$comment = CommentModel::model()->findByPK($comment_id);
			if(!$comment) $comment = new CommentModel;
			$comment->comment_id  = $comment_id;
      $comment->post_id     = $post_id;
      $comment->author      = $author;
      $comment->email       = $email;
      $comment->content     = $content;
      $comment->date_insert = $date_insert;
      $comment->status      = CommentModel::STATUS_APPROVE;
      $jml += $comment->save(); 

      if ($admin_reply != 'NULL') {
      	$reply = new CommentModel;
				$reply->post_id  = $post_id;
				$reply->author   = 'Admin';
				$reply->email 	 = '';
				$reply->content  = $admin_reply;
				$reply->status   = CommentModel::STATUS_REPLY;
				$reply->reply_to = $comment->comment_id;
				$reply->save();
      }
		}
		return $jml;
	}

	protected function processKeyword($colums, $rows) 
	{
		// Convert project_keyword to keywords
		$colums = array_flip($colums);
		foreach ($rows as $id => $value) {
			$kwdId     = $value[$colums['project_id']];
			$kwdName   = str_replace("'", '', $value[$colums['keyword']]);
			$kwdStatus = $value[$colums['project_status']];

			$model = new KeywordModel;
			$model->id     = $kwdId;
			$model->name   = $kwdName;
			$model->status = $kwdStatus;
			$jml += $model->save();
		}
		return $jml;
	}

	protected function processSetting($colums, $rows) 
	{
		// Convert settiing to options
		foreach ($rows[0] as $id => $value) {
			$value = str_replace("'", '', $value);
			$value = str_replace(array('\r','\n'), array('',''), $value);

			if ($colums[$id] == 'domain') {
				$options['site_address'] = 'http://'.str_replace('http://', '', $value);
			} elseif ($colums[$id] == 'title') {
				$options['site_title'] = $value;
			} elseif ($colums[$id] == 'meta_keyword') {
				$options['meta_keyword'] = $value;
			} elseif ($colums[$id] == 'meta_desc') {
				$options['meta_desc'] = $value;
			} elseif ($colums[$id] == 'contact') {
				$keyword = KeywordModel::model()->find(array(
					'condition'=>'name=:name',
					'params'=>array(':name'=>'contact us')
				));
				if (!($keyword instanceof KeywordModel)) {
					$keyword = new KeywordModel;
					$keyword->name   = 'contact us';
					$keyword->status = 1;
					$keyword->save();
				}

				// Insert Page: Contact
				$model = PostModel::model()->find(array(
					'condition'=>'title=:title AND posttype_id='.PostTypeModel::TYPE_PAGE,
					'params'=>array(':title'=>'Contact Us')
				));
				if (!$model instanceof PostModel) $model = new PostModel;
				$model->posttype_id = PostTypeModel::TYPE_PAGE;
				$model->created     = new CDbExpression('NOW()');
				$model->title 			= 'Contact Us';
				$model->desc 				= '-'; //Get First Paragraph
				$model->keyword 		= $keyword->id;
				$model->content 		= $value;
				$model->author      = Yii::app()->user->adminId;
				$model->excerpt     = substr(strip_tags($value), 0, 100) . '..';
				$model->url         = StringHelper::urlize( 'contact-us' );
				$model->status 			= PostStatusModel::STATUS_PUBLISH;
				try {
					$jml += $model->save();
				} catch (Exception $e) {}
			} elseif ($colums[$id] == 'about_us') {
				$keyword = KeywordModel::model()->find(array(
					'condition'=>'name=:name',
					'params'=>array(':name'=>'about us')
				));
				if (!($keyword instanceof KeywordModel)) {
					$keyword = new KeywordModel;
					$keyword->name   = 'about us';
					$keyword->status = 1;
					$keyword->save();
				}

				// Insert Page: About Us
				$model = PostModel::model()->find(array(
					'condition'=>'title=:title AND posttype_id='.PostTypeModel::TYPE_PAGE,
					'params'=>array(':title'=>'About Us')
				));
				if (!$model instanceof PostModel) $model = new PostModel;
				$model->posttype_id = PostTypeModel::TYPE_PAGE;
				$model->created     = new CDbExpression('NOW()');
				$model->title 			= 'About Us';
				$model->desc 				= '-'; //Get First Paragraph
				$model->keyword 		= $keyword->id;
				$model->content 		= $value;
				$model->author      = Yii::app()->user->adminId;
				$model->excerpt     = substr(strip_tags($value), 0, 100) . '..';
				$model->url         = StringHelper::urlize( 'about-us' );
				$model->status 			= PostStatusModel::STATUS_PUBLISH;
				try {
					$jml += $model->save();
				} catch (Exception $e) {}
			}
		}
		if(count($options)<=0) return 0;

		foreach ($options as $key => $value) {
			Yii::app()->options->add($key, $value);
		}
		$jml += count($options);

		return $jml;
	}

	protected function convertShortCode($content)
	{
		$content = str_replace('\r\n', '<br>', $content);

		// Get Youtube ID
		$pattern = '/\[video:http:\/\/youtu\.be\/([\w\-\.]+)\]/';
		while(preg_match($pattern, $content, $matches)){
			$replace = '<p><iframe allowfullscreen="" frameborder="0" width="572" height="480" src="//www.youtube.com/embed/'.$matches[1].'">';
			$replace .= '</iframe></p>';
			$content = str_replace($matches[0], $replace, $content);
		}
		// $pattern2 = '/\[video:(\d{1,3}),(\d{1,3})\]http:\/\/youtu\.be\/([\w\-]+)\[\/video\]/';
		// while(preg_match($pattern2, $content, $matches)){
		// 	$replace = '<p><iframe allowfullscreen="" frameborder="0" width="'.$matches[0].'" height="'.$matches[1].'" src="//www.youtube.com/embed/'.$matches[2].'">';
		// 	$replace .= '</iframe></p>';
		// 	$content = str_replace($matches[0], $replace, $content);
		// }

		// Get Image
		$pattern = '/\[img:(left|right|kiri|kanan)\]([\w\-\.\s]+)\[\/img\]/';
		while(preg_match($pattern, $content, $matches)){
			$replace = '<p><img alt="" src="/content/upload/'.$matches[2].'" style="width: 300px; height: 300px;" /></p>';
			$content = str_replace($matches[0], $replace, $content);
		}

		// Get Link
		$pattern = '/\[link:\d{1,2}\]([\w\-\.\s]+)\[\/link\]/';
		while(preg_match($pattern, $content, $matches)){
			$replace = '<a href="'.StringHelper::urlize($matches[1]).'">'.$matches[1].'</a>';
			$content = str_replace($matches[0], $replace, $content);
		}

		// Get Keyword
		$pattern = '/\[kwd\]([\w\-\.\s]+)\[\/kwd\]/';
		while(preg_match($pattern, $content, $matches)){
			$replace = '<a href="#">'.$matches[1].'</a>';
			$content = str_replace($matches[0], $replace, $content);
		}

		return $content;
	}
}
