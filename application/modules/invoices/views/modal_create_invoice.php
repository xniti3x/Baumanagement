<script>
    $(function () {
		console.log("modl");
        // Display the create invoice modal
        $('#create-invoice').modal('show');

        // Enable select2 for all selects
        $('.simple-select').select2();
        var clientid=null;

        <?php $this->layout->load_view('clients/script_select2_client_id.js'); ?>

        // Toggle on/off permissive search on clients names



            $('#btn_client_back').click(function () {

            $('#create_invoice_body').removeClass("hidden");
            $('#invoice_create_confirm').removeClass("hidden");
            $('#btn_cancel').removeClass("hidden");

            $('#add_client_body').addClass("hidden");
            $('#btn_client_save').addClass("hidden");
            $('#btn_client_back').addClass("hidden");
            $('#client_add_error').addClass("hidden");


        });

        $('#btn_add_client').click(function () {

            $('#create_invoice_body').addClass("hidden");
            $('#invoice_create_confirm').addClass("hidden");
            $('#btn_cancel').addClass("hidden");

            $('#add_client_body').removeClass("hidden");
            $('#btn_client_save').removeClass("hidden");
            $('#btn_client_back').removeClass("hidden");
            $('#client_add_error').removeClass("hidden");
        });


        $('#btn_client_save').click(function(){

            $.post("<?php echo site_url('clients/ajax/save_client'); ?>", {
                    client_name: $('#client_name').val(),
                    client_surname: $('#client_surname').val(),
                    client_address_1: $('#client_address_1').val(),
                    client_city: $('#client_city').val(),
                    client_zip: $('#client_zip').val(),
                    dataType: 'json'
                },
                function (data) {
                    data = $.parseJSON(data);
                    console.log(data);
                      $('#client_add_error').text(data[0].message);
                      if(data[0].status===200){
                          clientid=data[0].client[0].client_id;
                          $('#invoice_create_confirm').click();
                      }

                });


        });

        // Creates the invoice
        $('#invoice_create_confirm').click(function () {
            // Posts the data to validate and create the invoice;
            if(clientid===null){
                clientid=$('#create_invoice_client_id').val();
            }

            $.post("<?php echo site_url('invoices/ajax/create'); ?>", {
                    client_id: clientid,
                    invoice_date_created: $('#invoice_date_created').val(),
                    invoice_group_id: $('#invoice_group_id').val(),
                    invoice_time_created: '<?php echo date('H:i:s') ?>',
                    invoice_password: $('#invoice_password').val(),
                    user_id: '<?php echo $this->session->userdata('user_id'); ?>',
                    payment_method: $('#payment_method_id').val()
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                        // The validation was successful and invoice was created
                        window.location = "<?php echo site_url('invoices/view'); ?>/" + response.invoice_id;
                    }
                    else {
                        // The validation was not successful
                        $('.control-group').removeClass('has-error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('has-error');
                        }
                    }
                });
        });
    });

</script>

<div id="create-invoice" class="modal modal-lg"
     role="dialog" aria-labelledby="modal_create_invoice" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 class="panel-title"><?php _trans('create_invoice'); ?></h4>
        </div>
        <div class="modal-body">
        <div id="create_invoice_body">
            <input class="hidden" id="payment_method_id"
                   value="<?php echo get_setting('invoice_default_payment_method'); ?>">

            <input class="hidden" id="input_permissive_search_clients"
                   value="<?php echo get_setting('enable_permissive_search_clients'); ?>">

            <div class="form-group has-feedback">
                <a id="btn_add_client" class="btn"><i class="fa fa-plus"></i></a>
                <label for="create_invoice_client_id"><?php _trans('client'); ?></label>
                <div class="input-group">
                    <select name="client_id" id="create_invoice_client_id" class="client-id-select form-control"
                            autofocus="autofocus">
                        <?php if (!empty($client)) : ?>
                            <option value="<?php echo $client->client_id; ?>"><?php _htmlsc(format_client($client)); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label for="invoice_date_created"><?php _trans('invoice_date'); ?></label>

                <div class="input-group">
                    <input name="invoice_date_created" id="invoice_date_created"
                           class="form-control datepicker"
                           value="<?php echo date(date_format_setting()); ?>">
                    <span class="input-group-addon">
                    <i class="fa fa-calendar fa-fw"></i>
                </span>
                </div>
            </div>

            <div class="hidden form-group">
                <label for="invoice_password"><?php _trans('invoice_password'); ?></label>
                <input type="text" name="invoice_password" id="invoice_password" class="form-control"
                       value="<?php echo get_setting('invoice_pre_password') == '' ? '' : get_setting('invoice_pre_password'); ?>"
                       style="margin: 0 auto;" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="invoice_group_id"><?php _trans('invoice_group'); ?></label>
                <select name="invoice_group_id" id="invoice_group_id"
                	class="form-control simple-select" data-minimum-results-for-search="Infinity">
                    <?php foreach ($invoice_groups as $invoice_group) { ?>
                        <option value="<?php echo $invoice_group->invoice_group_id; ?>"
                                <?php if (get_setting('default_invoice_group') == $invoice_group->invoice_group_id) { ?>selected="selected"<?php } ?>>
                            <?php _htmlsc($invoice_group->invoice_group_name); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

        <div id="add_client_body" class="hidden">

            <div class="form-group row">
                <label for="client_name" class="col-sm-2 col-form-label">*Vorname</label>
                <div class="col-sm-6">
                <input type="text" required class="form-control" id="client_name" placeholder="Vorname">
                </div>
            </div>
            <div class="form-group row">
                <label for="client_surname" class="col-sm-2 col-form-label">Nachname</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="client_surname" placeholder="Nachname">
                </div>
            </div>
            <div class="form-group row">
                <label for="street" class="col-sm-2 col-form-label">Straße</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="client_address_1" placeholder="Straße">
                </div>
            </div>
            <div class="form-group row">
                <label for="client_zip" class="col-sm-2 col-form-label">Plz</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="client_zip" placeholder="Plz">
                </div>
            </div>
            <div class="form-group row">
                <label for="city" class="col-sm-2 col-form-label">Ort</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="client_city" placeholder="City">
                </div>
            </div>

        </div>

        </div>
        <div id="client_add_error" class="p-3 mb-2 bg-danger text-dark"></div>
        <div class="modal-footer">
            <div class="btn-group align-items-left">
                <button class="hidden btn btn-success" id="btn_client_save" type="button">
                    <i class="fa fa-save"></i> <?php _trans('save'); ?>
                </button>
            </div>
			<div class="btn-group float-left">
                <button class="hidden btn btn-danger" id="btn_client_back" type="button">
                    <i class="fa fa-repeat"></i> <?php _trans('back'); ?>
                </button>
            </div>
            <div class="btn-group">
                <button class="btn btn-success ajax-loader" id="invoice_create_confirm" type="button">
                    <i class="fa fa-check"></i> <?php _trans('submit'); ?>
                </button>
                <button class="btn btn-danger" id="btn_cancel" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php _trans('cancel'); ?>
                </button>
            </div>
        </div>
    </form>
</div>

