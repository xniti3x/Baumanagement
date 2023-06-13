<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('invoice'); ?></title>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/templates.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom-pdf.css">
</head>
<body>
<header class="clearfix">
  <div style="font-size:8pt; text-decoration:underline;"><?php echo $invoice->user_name." | ".$invoice->user_address_1." | ".$invoice->user_zip." ".$invoice->user_city; ?></div>
    <div id="client">
        <div>
            <b><?php _htmlsc(format_client($invoice)); ?></b>
        </div>
        <?php if ($invoice->client_vat_id) {
            echo '<div>' . trans('vat_id_short') . ': ' . $invoice->client_vat_id . '</div>';
        }
        if ($invoice->client_tax_code) {
            echo '<div>' . trans('tax_code_short') . ': ' . $invoice->client_tax_code . '</div>';
        }
        if ($invoice->client_address_1) {
            echo '<div>' . htmlsc($invoice->client_address_1) . '</div>';
        }
        if ($invoice->client_address_2) {
            echo '<div>' . htmlsc($invoice->client_address_2) . '</div>';
        }
        if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
            echo '<div>';
            if ($invoice->client_zip) {
                echo htmlsc($invoice->client_zip). ' ';
            }
            if ($invoice->client_city) {
                echo htmlsc($invoice->client_city);
            }
            if ($invoice->client_state) {
                echo htmlsc($invoice->client_state);
            }
            echo '</div>';
        }
        if ($invoice->client_country) {
            echo '<div>' . get_country_name(trans('cldr'), $invoice->client_country) . '</div>';
        }
 ?>
    </div>
    <div id="company">
		<div id="logo" style="margin-top:-70px; padding:0;">
        	<?php echo invoice_logo_pdf(); ?>
    	</div>
		<?php echo trans('invoice_date') . ':'; ?><?php echo date_from_mysql($invoice->invoice_date_created, true); ?>
	</div>
</header>
	
<main>
    <h2 class="title"><?php echo trans('invoice')." ".$invoice->invoice_number; ?></h2>
	
  <p><?php if(!empty($custom_fields['invoice']['invoice-intro'])){echo $custom_fields['invoice']['invoice-intro']; }else{echo "Sehr geehrte Damen und Herren,<br>für die erbrachte Leistung erlauben wir uns Ihnen folgende Rechnung zu stellen:";} ?></p>
    
  <table  width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td style="font-size:9pt"><b> <?php echo trans(' Rechnungsart') . ':</b> '.($custom_fields['invoice']['Rechnungsart']); ?></b>
                <?php echo ""; ?>
                </td>
                <td style="font-size:9pt"><b><?php echo trans('Ausführung') . ':</b> '.($custom_fields['invoice']['Ausführung']); ?></b>
                <?php echo ""; ?>
                </td>
                <td style="font-size:9pt"><b> <?php echo trans(' Bauvorhaben') . ': '; ?></b>
                <?php if($bauvorhaben){echo $bauvorhaben[0]->bezeichnung; }?>
                </td>
             </tr>
          </table>
  <hr>
  <table class="item-table">
        <thead>
        <tr>
            <th class="item-name"><?php _trans('item'); ?></th>
            <th class="item-desc"><?php _trans('description'); ?></th>
            <th class="item-amount text-right"><?php _trans('qty'); ?></th>
            <th class="item-price text-right">E-<?php _trans('price'); ?></th>
			<th><?php _trans('tax'); ?></th>
            <th class="item-total text-right"><?php _trans('total'); ?></th>
        </tr>
        </thead>
        <tbody>

        <?php 
			$showLine=true;
			$zsume=0;
        foreach ($items as $item) {
			$isAZ=$item->product_sku == "AZ";
			if(!$isAZ){$zsume=$zsume+$item->item_subtotal;}
			if($showLine && $isAZ){ ?>
			<tr>
				<td colspan="5" class="text-right" style="text-decoration:underline;border-bottom:1px solid #000;">
					<?php _trans('subtotal'); ?>
				</td>
				<td class="text-right" style="border-bottom:1px solid #000;"><?php echo format_currency($zsume); ?></td>
        	</tr>
			<?php $showLine=false; } ?>
            <tr>
                <td><?php _htmlsc($item->item_name); ?></td>
				<?php if(!$isAZ){ ?>
                <td><?php echo nl2br(htmlsc($item->item_description)); ?></td>
                <td class="text-right">
                    <?php echo format_amount($item->item_quantity); ?>
                    <?php if ($item->item_product_unit) : ?>
                        <small><?php _htmlsc($item->item_product_unit); ?></small>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($item->item_price); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($item->item_tax_total); ?>
                </td>
				<?php } ?>
				
                <td <?php echo ($isAZ)? 'colspan="5"':""; ?> class="text-right">
                    <?php echo format_currency($item->item_subtotal); ?>
                </td>
				
            </tr>
        <?php } ?>

        </tbody>
        <tbody class="invoice-sums">
		
			<?php
			if($invoice->invoice_item_subtotal!=$invoice->invoice_total){
			?>
        <tr>
            <td colspan="5" class="text-right" style="text-decoration:underline;">
                <?php _trans('subtotal'); ?>
            </td>
            <td class="text-right">
				<?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
        </tr>
		<?php } ?>
        <?php if ($invoice->invoice_item_tax_total > 0) { ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php _trans('MwSt.'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_item_tax_total); ?>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php echo "MWST. ".htmlsc($invoice_tax_rate->invoice_tax_rate_name); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                </td>
            </tr>
        <?php endforeach ?>

        <tr>
            <td colspan="5" class="text-right">
                <b><?php _trans('Rechnungsbetrag'); ?></b>
            </td>
            <td class="text-right">
                <b><?php echo format_currency($invoice->invoice_total); ?></b>
            </td>
        </tr>

        </tbody>

</table>

</main>
<?php if($invoice->invoice_item_tax_total == 0){echo "<small>Die Umsatzsteuer für den Rechnungsbetrag schuldet der Auftraggeber nach §13b UStG </small>";}?>
<footer>
  <?php if ($invoice->invoice_terms) : ?>
        <div class="notes">
            <b><?php _trans('terms'); ?></b><br/>
            <?php echo nl2br(htmlsc($invoice->invoice_terms)); ?>
        </div>
    <?php endif; ?>
</footer>
	
</body>
</html>
