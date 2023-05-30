<script>
    $(function () {
        // Display the create bauvorhaben modal
        $('#create-bauvorhaben').modal('show');

        // Enable select2 for all selects

        // Creates the bauvorhaben
        $('#bauvorhaben_create_confirm').click(function () {
            $.post("<?php echo site_url('bauvorhaben/ajax/create'); ?>", {
                bezeichnung: $('#bezeichnung').val(),
                },
                function (data) {
                    console.log(data);
                     var response = JSON.parse(data);
                    if(response.status===201){
                        $('#bauvorhaben_add_error').text(response.message);
                    }
                    if(response.status===200){
                        $('#create-bauvorhaben').modal('hide');
                    }


                });
        });
    });

</script>
<div id="create-bauvorhaben" class="modal modal-lg"
     role="dialog" aria-labelledby="modal_create_bauvorhaben" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 class="panel-title"><?php _trans('add_construction_project'); ?></h4>
        </div>
        <div class="modal-body">

        <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">
         <div class="form-group row">
            <label for="bezeichnung" class="col-sm-2 col-form-label"><?php _trans("label"); ?></label>
            <div class="col-sm-4">
            <input type="text" name="bezeichnung" class="form-control" id="bezeichnung" placeholder="Bezeichnung">
            </div>
        </div>

        </div>
        <div id="bauvorhaben_add_error" class="p-3 mb-2 bg-danger text-dark"></div>
        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn btn-success" id="bauvorhaben_create_confirm" type="button">
                    <i class="fa fa-check"></i> <?php _trans('submit'); ?>
                </button>
                <button class="btn btn-danger" id="btn_cancel" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php _trans('cancel'); ?>
                </button>
            </div>
        </div>
    </form>
</div>


