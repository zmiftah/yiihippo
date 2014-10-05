<?php

class AbArticleHandlerBehavior extends CBehavior
{
	private $terms;

	private function getPostTerms($postId)
	{
		$this->terms = array();
		$terms = PostTermModel::model()->findAll(array(
			'condition'=>'post_id=:post',
			'params'=>array(':post'=>$postId)
		));

		if ( count($terms) ) {
			foreach ($terms as $postTerm) {
				$taxonomy = $postTerm->taxo_id;
				$termList = explode(',', $postTerm->terms);
				$termList = "'".implode("','", $termList)."'";
				$this->terms[$taxonomy] = $termList;
			}
		}
	}

	private function handleTagTerm($tags)
	{
		// var_dump($tags); exit;
		if ( is_array($tags) && count($tags)>0 ) {
			foreach ($tags as $tag) {
				$exist = $this->taxonomy->getTerm($tag, 'tag'); 
				if ( $exist == null ) {
					$tag = strtolower($tag);
					$tag = str_replace(' ', '-', $tag);
					$result = $this->taxonomy->createTerm('tag', $tag, $tag);
				}
			}
		}
	}

	public function getTaxonomy()
	{
		return Yii::app()->taxonomy;
	}

	public function handleCategory($postCat, $postId)
	{
		$categories = is_array($postCat)? implode(',', $postCat): 1; //fix issue #31

		$postTerm = PostTermModel::model()->find(array(
			'condition'=>'post_id=:post AND taxo_id=:taxo',
			'params'=>array(':post'=>$postId,':taxo'=>TaxonomyModel::CATEGORY)
		));

		if ( !($postTerm instanceof PostTermModel) ) {
			$postTerm = new PostTermModel;
			$postTerm->post_id = $postId;
			$postTerm->taxo_id = TaxonomyModel::CATEGORY;
		}
		$postTerm->terms = $categories;
		$retVal = $postTerm->save();

		return $retVal;
	}

	public function handleTags($postTag, $postId)
	{
		$parsed = StringHelper::parseTag($postTag);

		$this->handleTagTerm($parsed);
		$Ids = is_array($parsed)? $this->getTagsId($parsed): '';

		$postTerm = PostTermModel::model()->find(array(
			'condition'=>'post_id=:post AND taxo_id=:taxo',
			'params'=>array(':post'=>$postId,':taxo'=>TaxonomyModel::TAG)
		)); 

		if ( !($postTerm instanceof PostTermModel) ) {
			$postTerm = new PostTermModel;
			$postTerm->post_id = $postId;
			$postTerm->taxo_id = TaxonomyModel::TAG;
		}
		$postTerm->terms = $Ids;
		$retVal = $postTerm->save();

		return $retVal;
	}

	public function handleKeyword($action, $keywordId, $postId)
	{
		if ( $action=='ADD' ) {

			return Yii::app()->db->createCommand()->update('keywords', array(
			  'status'=>KeywordModel::STATUS_SUBMITED,
			  'post_id'=>$postId,
			), 'id=:id', array(':id'=>$keywordId));

		} elseif ( $action=='DELETE' ) {

			return Yii::app()->db->createCommand()->update('keywords', array(
			  'status'=>KeywordModel::STATUS_ADDED,
			  'post_id'=>null
			), 'id=:id', array(':id'=>$keywordId));

		}
	}

	public function handlePostMeta($title, $keyword, $postId)
	{
		$metadata = MetadataModel::model()->find(array(
			'condition'=>'`mtable`=:table AND `table_id`=:id AND `mkey`=:key',
			'params'=>array(':table'=>'posts',':id'=>$postId, ':key'=>'post_meta')
		));

		if ( !($metadata instanceof MetadataModel) ) {
			$metadata = new MetadataModel;
			$metadata->mkey = 'post_meta';
			$metadata->mtable = 'posts';
			$metadata->table_id = $postId;
		}
		$metadata->value = serialize(array(
			'title' => $title,
			'keyword' => $keyword
		));
		$retVal = $metadata->save();

		return $retVal;
	}

	public function parsePostMeta($postModel)
	{
		$metadata = $postModel->fetchMetadata('post_meta');
		if ($metadata instanceof MetadataModel) {
			$value = unserialize($metadata->value);
		} else {
			$value = array();
		}
		return $value;
	}

	public function getTagsId($tags)
	{
		$Id = array();

		if (is_array($tags) && count($tags)>0) {
			foreach ($tags as $tagName) {
				$term = $this->taxonomy->getTerm($tagName,'tag');
				if ($term instanceof TermModel) {
					$Id[]=$term->term_id;
				}
			}
		}

		$ids = implode(',', $Id);
		return $ids;
	}
}