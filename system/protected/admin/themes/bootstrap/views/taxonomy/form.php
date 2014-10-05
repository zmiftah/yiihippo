<form id="formCategory" method="post" class="form-horizontal">
  <input type="hidden" name="id" value="<?php echo $term_id ?>">
  <input type="hidden" name="action" value="<?php echo $action ?>">

   <div class="control-group">
    <label class="control-label" for="catName">Name</label>
    <div class="controls">
      <?php echo CHtml::activeTextField($model, 'name', array('id'=>'catName','required'=>'required')) ?>
    </div>
  </div>

   <div class="control-group">
    <label class="control-label" for="catSlug">Slug</label>
    <div class="controls">
      <?php echo CHtml::activeTextField($model, 'slug', array('id'=>'catSlug','required'=>'required')) ?>
    </div>
  </div>

   <div class="control-group">
    <label class="control-label" for="catParent">Parent</label>
    <div class="controls">
      <?php $data = array_merge( array(''=>'--- Select ---'), CHtml::listData($parents, 'term_id','name')) ?>
      <?php echo CHtml::activeDropDownList($model, 'term_group', $data, array(
        'id'=>'catParent'
      )) ?>
    </div>
  </div>

   <div class="control-group">
    <label class="control-label" for="catDesc">Description</label>
    <div class="controls">
      <?php echo CHtml::activeTextArea($model, 'desc', array('id'=>'catSlug')) ?>
    </div>
  </div>
  
  <?php if ($action == 'Add') {
    $icon = 'icon-plus';
    $text = 'Tambah';
  } else {
    $icon = 'icon-edit';
    $text = 'Update';
  } ?>
  <div class="control-group">
    <div class="controls">
      <button id="btnSubmit" class="btn">
        <i class="<?php echo $icon ?>"></i> <?php echo $text ?>
      </button>
    </div>
  </div>
</form>