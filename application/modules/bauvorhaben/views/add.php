<form method="post" action="<?php echo site_url("bauvorhaben/addPost"); ?>">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('add_construction_project'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
<br>
 <div class="form-group row">
    <label for="bezeichnung" class="col-sm-2 col-form-label"><?php _trans("label"); ?></label>
    <div class="col-sm-4">
      <input type="text" name="bezeichnung" class="form-control" id="bezeichnung" placeholder="Bezeichnung">
    </div>
  </div>
</form>
