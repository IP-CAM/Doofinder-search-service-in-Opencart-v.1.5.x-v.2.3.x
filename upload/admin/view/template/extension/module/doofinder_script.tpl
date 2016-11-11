<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-doofinder_script" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $text_edit; ?></h3>
      </div>

      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-doofinder_script" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-12">
              <?php echo $entry_code;?>
            </div>
          </div>
          <?php foreach($doofinder_codes as $lang_code => $doofinder_currency_codes):?>
          <div class="form-group required">
            <div class="col-sm-12">Language code: <?php echo strtoupper($lang_code) ?></div>

            <?php foreach($doofinder_currency_codes as $cur_code => $code):?>

            <div class="col-sm-2">
              <label class="control-label" for="input-doofinder_script_<?php echo $lang_code ?>_<?php echo $cur_code ?>"><?php echo strtoupper($cur_code) ?></label>
              <textarea rows="10" name="doofinder_script_<?php echo $lang_code ?>_<?php echo $cur_code ?>" id="input-doofinder_script_<?php echo $lang_code ?>_<?php echo $cur_code ?>" class="form-control">
                <?php echo $code; ?>
              </textarea>
              <?php if ($error_code) { ?>
              <div class="text-danger"><?php echo $error_code; ?></div>
              <?php } ?>
            </div>
            <?php endforeach ?>
          </div>
          <?php endforeach ?>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="doofinder_script_status" id="input-status" class="form-control">
                <?php if ($google_script_status) { ?>
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
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
