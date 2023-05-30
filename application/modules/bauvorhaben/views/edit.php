
<form method="POST" action="<?php echo site_url('bauvorhaben/editPost'); ?>">

<input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

<input type="hidden" name="bauvorhaben_id"
           value="<?php echo $bauvorhaben_id; ?>">


    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('Bauvorhaben Hinzufügen'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
    <br>
     <div id="content">
    <div class="row">
    <div class="col-xs-12 col-md-6 col-md-offset-2">

    <div class="form-group row">
    <label for="bezeichnung" class="col-sm-2 col-form-label">Bezeichnung</label>
    <div class="col-sm-6">
      <input type="text" class="form-control"
       value="<?php echo $bauvorhaben[0]->bezeichnung; ?>" placeholder="Bezeichnung" name="bezeichnung">

    </div>
  </div>
</div>
</div>

</div>
</form>

