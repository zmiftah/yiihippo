<?php

/**
 * Inspiration: http://codex.wordpress.org/Taxonomies
 * in Activation/Deactivation/Uninstall Functions
 */
class AbTaxonomyAPI extends CApplicationComponent
{
	/* Taxonomy, not yet implemented */

	public function register($name, $label, $postType, $hierarchical=null)
	{
		throw new 
			CException("Not Yet Implemented. Class: " . __CLASS__ . ", function: register", 100);
	}

	public function unregister($name)
	{
		throw new 
			CException("Not Yet Implemented. Class: " . __CLASS__ . ", function: unregister", 100);
	}

	/* Term */

	public function createTerm($taxo, $name, $slug, $termGroup=null)
	{
		$taxoId = TaxonomyModel::getTaxonomyId($taxo);
		if ( $taxoId <= 0 ) {
			throw new CException('Taxonomi tidak ditemukan', 101);
		}

		$term = new TermModel;
		$term->taxo_id = $taxoId;
		$term->name = $name;
		$term->slug = $slug;
		$term->term_group = $termGroup;

		return $term->save();
	}

	public function updateTerm($name, $taxo, $newName, $slug, $termGroup=null)
	{
		$taxoId = TaxonomyModel::getTaxonomyId($taxo);
		if ( $taxoId <= 0 ) {
			throw new CException('Taxonomi tidak ditemukan', 101);
		}

		$term = TermModel::model()->find(array(
	    'condition'=>'LOWER(name)=:name',
	    'params'=>array(':name'=>$name),
		));
		if ( !$term instanceof TermModel ) return false;

		$term->name = $newName;
		$term->taxo_id = $taxoId;
		$term->slug = $slug;
		$term->term_group = $termGroup;

		return $term->save();
	}

	public function getTerm($name, $taxo)
	{
		if ( TaxonomyModel::getTaxonomyId($taxo) <= 0 ) {
			throw new CException('Taxonomi tidak ditemukan', 101);
		}

		$term = TermModel::model()->find(array(
	    'condition'=>'LOWER(name)=LOWER(:name)',
	    'params'=>array(':name'=>$name),
		));

		return $term;
	}

	public function removeTerm($name)
	{
		$term = TermModel::model()->find(array(
	    'condition'=>'LOWER(name)=LOWER(:name)',
	    'params'=>array(':name'=>$name),
		));

		if ( !$term instanceof TermModel ) {
			return false;
		} elseif ( $term->delete() ) {
			return true;
		} else {
			return false;
		}
	}
}
