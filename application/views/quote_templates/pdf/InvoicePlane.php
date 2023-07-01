<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('quote'); ?></title>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'quoteplane'); ?>/css/templates.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom-pdf.css">
</head>
<body>
<header class="clearfix">
  <div style="font-size:8pt; text-decoration:underline;"><?php echo $quote->user_name." | ".$quote->user_address_1." | ".$quote->user_zip." ".$quote->user_city; ?></div>
    <div id="client">
        <div>
            <b><?php _htmlsc(format_client($quote)); ?></b>
        </div>
        <?php if ($quote->client_vat_id) {
            echo '<div>' . trans('vat_id_short') . ': ' . $quote->client_vat_id . '</div>';
        }
        if ($quote->client_tax_code) {
            echo '<div>' . trans('tax_code_short') . ': ' . $quote->client_tax_code . '</div>';
        }
        if ($quote->client_address_1) {
            echo '<div>' . htmlsc($quote->client_address_1) . '</div>';
        }
        if ($quote->client_address_2) {
            echo '<div>' . htmlsc($quote->client_address_2) . '</div>';
        }
        if ($quote->client_city || $quote->client_state || $quote->client_zip) {
            echo '<div>';
            if ($quote->client_zip) {
                echo htmlsc($quote->client_zip). ' ';
            }
            if ($quote->client_city) {
                echo htmlsc($quote->client_city);
            }
            if ($quote->client_state) {
                echo htmlsc($quote->client_state);
            }
            echo '</div>';
        }
        if ($quote->client_country) {
            echo '<div>' . get_country_name(trans('cldr'), $quote->client_country) . '</div>';
        }
 ?>
    </div>
    <div id="company">
		<div id="logo" style="margin-top:-70px; padding:0;">
        	<?php echo invoice_logo_pdf(); ?>
    	</div>
		<?php echo trans('quote_date') . ':'; ?><?php echo date_from_mysql($quote->quote_date_created, true); ?>
	</div>
</header>
	
<main>
    <h2 class="title"><?php echo trans('quote'); ?></h2>
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
        <tbody class="quote-sums">
		
			<?php
			if($quote->quote_item_subtotal!=$quote->quote_total){
			?>
        <tr>
            <td colspan="5" class="text-right" style="text-decoration:underline;">
                <?php _trans('subtotal'); ?>
            </td>
            <td class="text-right">
				<?php echo format_currency($quote->quote_item_subtotal); ?></td>
        </tr>
		<?php } ?>
        <?php if ($quote->quote_item_tax_total > 0) { ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php _trans('MwSt.'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($quote->quote_item_tax_total); ?>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($quote_tax_rates as $quote_tax_rate) : ?>
            <tr>
                <td colspan="5" class="text-right">
                    <?php echo "MWST. ".htmlsc($quote_tax_rate->quote_tax_rate_name); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($quote_tax_rate->quote_tax_rate_amount); ?>
                </td>
            </tr>
        <?php endforeach ?>

        <tr>
            <td colspan="5" class="text-right">
                <b><?php _trans('Betrag'); ?></b>
            </td>
            <td class="text-right">
                <b><?php echo format_currency($quote->quote_total); ?></b>
            </td>
        </tr>

        </tbody>

</table>

</main>
<footer>
  <?php if ($quote->notes) : ?>
        <div class="notes">
            <b><?php _trans('terms'); ?></b><br/>
            <?php echo nl2br(htmlsc($quote->quote_terms)); ?>
        </div>
    <?php endif; ?>
</footer>
</body>
</html>
