<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-doofinder_feed" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-doofinder_feed" class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
          <div class="col-sm-10">
            <select name="doofinder_feed_status" id="input-status" class="form-control">
                <?php if ($doofinder_feed_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-image_size"><?php echo $entry_image_size ?></label>
          <div class="col-sm-10">
            <select name="doofinder_feed_image_size" id="input-image_size" class="form-control">
              <?php foreach($image_sizes as $size => $label): ?>
              <option value="<?php echo $size ?>" <?php echo $doofinder_feed_image_size == $size ? 'selected': '' ?>>
                <?php echo $label ?>
              </option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-mpn_field"><?php echo $entry_mpn_field ?></label>
          <div class="col-sm-10">
            <select name="doofinder_feed_mpn_field" class="form-control" id="input-mpn_field">
              <?php foreach($mpn_candidates as $mpn_field => $mpn_description): ?>
              <option value="<?php echo $mpn_field?>" <?php echo $doofinder_feed_mpn_field == $mpn_field ? 'selected': '' ?>>
                <?php echo $mpn_description?>
              </option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-display_prices"><?php echo $entry_display_prices ?></label>
          <div class="col-sm-10">
            <select name="doofinder_feed_display_prices" id="input-display_prices" class="form-control">
              <?php if ($doofinder_feed_display_prices) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-prices_with_taxes"><?php echo $entry_prices_with_taxes ?></label>
          <div class="col-sm-10">
            <select name="doofinder_feed_prices_with_taxes" id="input-prices_with_taxes" class="form-control">
              <?php if ($doofinder_feed_prices_with_taxes) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-full_category_path"><?php echo $entry_full_category_path ?></label>
          <div class="col-sm-10">
            <select name="doofinder_feed_full_category_path" id="input-full_category_path" class="form-control">
              <?php if ($doofinder_feed_full_category_path) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </form>

      <?php foreach($data_feeds as $lang => $currency_feed):?>
        <table class="table table-bordered">
          <th><?php echo $entry_data_feed ?> (<?php echo $lang ?>)</th>
          <?php foreach($currency_feed as $currency => $feed):?>
          <tr>
            <td><?php echo $currency ?></td>
            <td><a href="<?php echo $feed?>" target="_new"><?php echo $feed?></a></td>
          </tr>
          <?php endforeach ?>
        </table>
      <?php endforeach ?>

      </div>
    </div>
  </div>
<?php echo $footer; ?>
