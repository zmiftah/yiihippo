<?php

class AbParseUrlBehavior extends CBehavior 
{
	public function getCacheDuration()
	{
		return $this->owner->cacheDuration;
	}

	public function converShortCode($content)
	{
		ini_set("memory_limit","128M");
		
		// Get Adsense
		$pattern = '/\[ads:(\d{1,2})\]/';
		while(preg_match($pattern, $content, $matches)){
			$id = (int)$matches[1];
			$replace = /*'<p>'.*/Yii::app()->options->get('adsense_'.$id, $matches[0])/*.'</p>'*/;
			$content = str_replace($matches[0], $replace, $content);
		}

		// // Get Keyword
		// $pattern = '/\[kwd\]([\w\-\.\s]+)\[\/kwd\]/';
		// while(preg_match($pattern, $content, $matches)){
		// 	$replace = '<a href="#">'.$matches[1].'</a>';
		// 	$content = str_replace($matches[0], $replace, $content);
		// }

		// Get Video
		$pattern2 = '/\[video:(.*?)\]http:\/\/youtu\.be\/([\w\-]+)\[\/video\]/';
		while(preg_match($pattern2, $content, $matches)){
			list($wi, $he) = explode(',', $matches[1]);
			$replace = '<p><iframe allowfullscreen="" frameborder="0" width="'.$wi.'" height="'.$he.'" src="//www.youtube.com/embed/'.$matches[2].'">';
			$replace .= '</iframe></p>';
			$content = str_replace($matches[0], $replace, $content);
		}
		return $content;
	}

	public function createPermalink($url, $created)
	{
		$option = Yii::app()->options->get('opt_permalink');
		$baseUrl = Yii::app()->baseUrl;
		
		if ($option == 1) {
			$permalink = $url;
		} elseif ($option == 2) {
			$date = date('Y/', strtotime($created));
			$permalink = $date.$url;
		} elseif ($option == 3) {
			$date = date('Y/m/', strtotime($created));
			$permalink = $date.$url;
		}

		return "$baseUrl/$permalink";
	}

	public function postPagination($page, $limit)
	{
		$cacheId = 'paginationArticlesCount';

		$total = Yii::app()->cache->get($cacheId);
		if ($total == false) {
			$total = PostModel::model()->articles()->count();
			Yii::app()->cache->set($cacheId, $total, $this->cacheDuration);
		}
		$pages = new CPagination($total);
		$pages->setPageSize($limit);

		return $pages;
	}

	public function dbGetPosts($page, $limit)
	{
		$cacheId = 'dbGetPostObjects_'.$page.'_'.$limit;

		$offset = ($page-1) * $limit;
		$posts = Yii::app()->cache->get($cacheId);
		if ($posts == false) {
			$posts = PostModel::model()->articles()->findAll(array(
				'limit'=>$limit,
				'offset'=>$offset
			));
			Yii::app()->cache->set($cacheId, serialize($posts), $this->cacheDuration);
		} else {
			$posts = unserialize($posts);
		}

		return $posts;
	}

	public function dbParsePost($link) 
	{
		$cacheId = 'dbParsePostObject_'.$link;

		$link .= '.htm';
		$link = basename($link);

		$post = Yii::app()->cache->get($cacheId);
		if ($post == false) {
			$post = PostModel::model()->find('url=:url AND posttype_id IN (:article, :page)', array(
				':article'=>PostTypeModel::TYPE_ARTICLE,
				':page'=>PostTypeModel::TYPE_PAGE,
				':url'=>$link
			)); 
			Yii::app()->cache->set($cacheId, serialize($post), $this->cacheDuration);
		} else {
			$post = unserialize($post);
		}

		return $post;
	}

	public function dbParseArticle($link) 
	{
		$cacheId = 'dbParseArticleObject_'.$link; var_dump($cacheId);

		$link .= '.htm';
		$link = basename($link);

		$post = Yii::app()->cache->get($cacheId);
		if ($post == false) {
			$post = PostModel::model()->articles()->find('url=:url', array('url'=>$link));
			Yii::app()->cache->set($cacheId, serialize($post), $this->cacheDuration);
		} else {
			$post = unserialize($post);
		}

		return $post;
	}

	public function dbParsePage($link) 
	{
		$cacheId = 'dbParsePageObject_'.$link;

		$link .= '.htm';
		$link = basename($link);

		$post = Yii::app()->cache->get($cacheId);
		if ($post == false) {
			$post = PostModel::model()->pages()->find('url=:url', array('url'=>$link));
			Yii::app()->cache->set($cacheId, serialize($post), $this->cacheDuration);
		} else {
			$post = unserialize($post);
		}

		return $post;
	}

	public function dbParseTaxonomy($taxo, $type, $id)
	{
		$taxonomy = Yii::app()->taxonomy->getTerm($taxo, $type);
		if($taxonomy instanceof TermModel){
			$term_id = $taxonomy->term_id;
		}
		
		$postsID = array();
		if ( $term_id>0 ) {
			$cacheId1 = 'dbParseTaxonomyObjects_'.$id.'_'.$taxo;

			$postTerms = Yii::app()->cache->get($cacheId1);
			if ($postTerms == false) {
				$postTerms = PostTermModel::model()->findAll(array(
					'condition'=>'taxo_id='.$id
				));
				Yii::app()->cache->set($cacheId1, serialize($postTerms), $this->cacheDuration);
			} else {
				$postTerms = unserialize($postTerms);
			}

			if (is_array($postTerms) && $postTerms[0] instanceof PostTermModel) {
				foreach ($postTerms as $model) {
					$terms = $model->terms;
					if(!empty($terms)) {
						$taxos = explode(',', $terms);
						foreach ($taxos as $taxoId) {
							if ($taxoId == $term_id) {
								array_push($postsID, $model->post_id);
							}
						}
					}
				}
			}
		}

		if (count($postsID)>0) {
			$listId = implode(',', $postsID);
			$cacheId2 = 'dbFindAllByPostIDInObjects_'.$listId;

			$posts = Yii::app()->cache->get($cacheId2);
			if ($posts == false) {
				$posts = PostModel::model()->findAll(array(
					'condition'=>"post_id IN ($listId)"
				));
				Yii::app()->cache->set($cacheId2, serialize($posts), $this->cacheDuration);
			} else {
				$posts = unserialize($posts);
			}

			$postsID = $posts;
		}

		return $postsID;
	}

	public function dbParseSearch($keyword)
	{
		$cacheId = 'dbParseSearchObjects_'.$keyword;

		$posts = Yii::app()->cache->get($cacheId);
		if ($posts == false) {
			$posts = PostModel::model()->articles()->findAll(array(
				'condition'=>'title LIKE :title'/* OR desc LIKE :desc OR content LIKE :content'*/,
				'params'=>array(':title'=>"%$keyword%"/*,':desc'=>"%$keyword%",':content'=>"%$keyword%"*/)
			));
			Yii::app()->cache->set($cacheId, serialize($posts), $this->cacheDuration);
		} else {
			$posts = unserialize($posts);
		}

		return $posts;
	}

	public function dbParseArchive($year, $month, $day)
	{
		$cacheId = 'dbParseArchiveObjects_'.implode('_', array($year, $month, $day));

		$condition = 'YEAR(created)=:year';
		$params = array(':year'=>$year);

		$objects = Yii::app()->cache->get($cacheId);
		if ($objects == false) {
			if ($month == null) {
				$posts = PostModel::model()->articles()->findAll(array(
					'condition'=>$condition,
					'params'=>$params
				));
			} elseif ($month>=1 && $month<=12) {
				if ($day>=1 && $month<=31) {
					$condition .= ' AND MONTH(created)=:month AND DAY(created)=:day';
					$params = array_merge($params, array(':month'=>$month,':day'=>$day));
				} else {
					$condition .= ' AND MONTH(created)=:month';
					$params = array_merge($params, array(':month'=>$month));
				}

				$posts = PostModel::model()->articles()->findAll(array(
					'condition'=>$condition,
					'params'=>$params
				));
			} else {
				$posts = array();
			}

			$objects = $posts;
			Yii::app()->cache->set($cacheId, serialize($objects), $this->cacheDuration);
		} else {
			$objects = unserialize($objects);
		}

		return $objects;
	}

	public function dbGenerateSitemap()
	{
		$article  = $this->dbGenerateByArticle();
		$archive  = $this->dbGenerateByArchive();
		$category = $this->dbGenerateByCategory();
		$tag      = $this->dbGenerateByTag();
		$page     = $this->dbGenerateByPage();

		$data = array_merge($article, $page, $archive, $category, $tag);

		foreach($data as $index => $array){
			if ( is_array($array) ) {
				$array = array_reverse($array);
				foreach ($array as $url) {
					if(!empty($url)) $permalink[] = $url;
				}
			} else {
				if(!empty($array)) $permalink[] = $array;
			}
		}

		$sitemaps = '';
		foreach ($permalink as $link) {
			$sitemaps .= $this->siteUrl."/{$link}\n";
		}
		$sitemaps .= $this->siteUrl.'/';

		return $sitemaps;
	}

	public function dbGenerateByArticle()
	{
		$cacheId = 'permalinkGenerateByArticleObjects';

		$data = array();
		$option = Yii::app()->options->get('opt_permalink');
		
		$posts = Yii::app()->cache->get($cacheId);
		if ($posts == false) {
			$posts = PostModel::model()->articles()->findAll(array(
				'order'=>'created DESC'
			));
			Yii::app()->cache->set($cacheId, serialize($posts), $this->cacheDuration);
		} else {
			$posts = unserialize($posts);
		}

		foreach ($posts as $model) {
			$created = $model->created; 
			
			if ($option == 1) {
				$pattern = $model->url;
			} elseif ($option == 2) {
				$date = date('Y/', strtotime($created));
				$pattern = $date.$model->url;
			} elseif ($option == 3) {
				$date = date('Y/m/', strtotime($created));
				$pattern = $date.$model->url;
			}

			$data[$created] = $pattern;
		}

		return $data;
	}

	public function dbGenerateByPage()
	{
		$cacheId = 'permalinkGenerateByPageObjects';

		$data = array();
		
		$posts = Yii::app()->cache->get($cacheId);
		if ($posts == false) {
			$posts = PostModel::model()->pages()->findAll(array(
				'order'=>'created DESC'
			));
			Yii::app()->cache->set($cacheId, serialize($posts), $this->cacheDuration);
		} else {
			$posts = unserialize($posts);
		}

		foreach ($posts as $model) {
			$data[$model->created] = $model->url;
		}

		return $data;
	}

	public function dbGenerateByArchive()
	{
		$cacheId = 'permalinkGenerateByArchiveObjects';

		$data = array();

		$posts = Yii::app()->cache->get($cacheId);
		if ($posts == false) {
			$posts = PostModel::model()->articles()->findAll(array(
				'select'=>'created',
				'order'=>'created ASC'
			));
			Yii::app()->cache->set($cacheId, serialize($posts), $this->cacheDuration);
		} else {
			$posts = unserialize($posts);
		}

		foreach ($posts as $model) {
			$created = strtotime($model->created);
			$year    = date('Y', $created);
			$month   = date('Y/m', $created);
			$day     = date('Y/m/d', $created);

			$data[$year][$month][$day] = $month;
		}

		$result = array();
		foreach ($data as $year => $dt1) {
			foreach ($dt1 as $month => $dt2) {
				foreach ($dt2 as $day => $dt3) {
					$result[$year]["$year"]="archive/$year";
					$result[$year]["$month"]="archive/$month";
					$result[$year]["$day"]="archive/$day";
				}
			}
		}

		return $result;
	}

	public function dbGenerateByCategory()
	{
		$cacheId = 'permalinkGenerateByCategoryObjects';

		$data = array();

		$cats = Yii::app()->cache->get($cacheId);
		if ($cats == false) {
			$cats = TermModel::model()->category()->findAll(array(
				'order'=>'slug ASC'
			));
			Yii::app()->cache->set($cacheId, serialize($cats), $this->cacheDuration);
		} else {
			$cats = unserialize($cats);
		}

		foreach ($cats as $model) {
			$data[$model->slug] = "category/{$model->slug}.htm";
		}

		return $data;
	}

	public function dbGenerateByTag()
	{
		$cacheId = 'permalinkGenerateByTagObjects';

		$data = array();
		
		$tags = Yii::app()->cache->get($cacheId);
		if ($tags == false) {
			$tags = TermModel::model()->tag()->findAll(array(
				'order'=>'slug ASC'
			));
			Yii::app()->cache->set($cacheId, serialize($tags), $this->cacheDuration);
		} else {
			$tags = unserialize($tags);
		}

		foreach ($tags as $model) {
			$data[$model->slug] = "tag/{$model->slug}.htm";
		}

		return $data;
	}

	public function getSiteUrl()
	{
		$host    = Yii::app()->request->hostInfo;
		$siteUrl = Yii::app()->baseUrl;
		return $host.$siteUrl;
	}
}
