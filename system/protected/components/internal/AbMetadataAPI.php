<?php 

/**
 * Inspiration: http://codex.wordpress.org/Custom_Fields
 * 
 */
class AbMetadataAPI extends CApplicationComponent
{
	private $postMeta;
	private $commentMeta;

	public function init()
	{
		$this->postMeta = new AbPostMetadata;
		$this->commentMeta = new AbCommentMetadata;
	}

	public function postMetaAdd($postId, $key, $value)
	{
		$this->postMeta->add($postId, $key, $value);
	}

	public function postMetaUpdate($postId, $key, $newValue)
	{
		$this->postMeta->update($postId, $key, $newValue);
	}

	public function postMetaDelete($postId, $key)
	{
		$this->postMeta->delete($postId, $key);
	}

	public function postMetaGetAll($postId)
	{
		$this->postMeta->getAll($postId);
	}

	public function postMetaGetKeys($postId)
	{
		$this->postMeta->getKeys($postId);
	}

	public function postMetaGet($postId, $key)
	{
		$this->postMeta->get($postId, $key);
	}

	public function commentMetaAdd($commenttId, $key, $value)
	{
		$this->commentMeta->add($commenttId, $key, $value);
	}

	public function commentMetaUpdate($commenttId, $key, $newValue)
	{
		$this->commentMeta->update($commenttId, $key, $newValue);
	}

	public function commentMetaDelete($commenttId, $key)
	{
		$this->commentMeta->delete($commenttId, $key);
	}

	public function commentMetaGet($commenttId, $key)
	{
		$this->commentMeta->get($commenttId, $key);
	}
}