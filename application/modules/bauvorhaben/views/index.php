<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('construction_project'); ?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('bauvorhaben/add'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('bauvorhaben/index'), 'mdl_bauvorhaben'); ?>
    </div>

</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col"><?php _trans("label"); ?></th>
      <th scope="col">Options</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($bauvorhaben as $bv){
        echo "<tr>
        <td>".$bv->id."</td>
        <td>".$bv->bezeichnung."</td>";
        ?>
        <td><div class="options btn-group">
        <a class="btn btn-default btn-sm dropdown-toggle"
            data-toggle="dropdown" href="#">
            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?php echo site_url('bauvorhaben/edit/' . $bv->id); ?>">
                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                </a>
            </li>
            <li>
                <form action="<?php echo site_url('bauvorhaben/delete/' . $bv->id); ?>"
                        method="POST">
                    <?php _csrf_field(); ?>
                    <button type="submit" class="dropdown-button"
                            onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                    </button>
                </form>
            </li>
        </ul>
    </div>
    </td>
    </tr>

    <?php } ?>

</tbody>
</table>
