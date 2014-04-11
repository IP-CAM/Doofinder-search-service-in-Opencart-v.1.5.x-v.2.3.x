<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/feed.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="doofinder_status">
                <?php if ($doofinder_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_image_size ?></td>
            <td><select name="doofinder_image_size">
                <?php foreach($image_sizes as $size => $label): ?>
                <option value="<?php echo $size ?>" <?php echo $doofinder_image_size == $size ? 'selected': '' ?>>
                     <?php echo $label ?>
                </option>
                <?php endforeach ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_mpn_field ?></td>
            <td><select name="doofinder_mpn_field">
                <?php foreach($mpn_candidates as $mpn_field => $mpn_description): ?>
                <option value="<?php echo $mpn_field?>" <?php echo $doofinder_mpn_field == $mpn_field ? 'selected': '' ?>>
                     <?php echo $mpn_description?>
                </option>
                <?php endforeach ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_display_prices?></td>
            <td><select name="doofinder_display_prices">
                <?php if ($doofinder_display_prices) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_prices_with_taxes?></td>
            <td><select name="doofinder_prices_with_taxes">
                <?php if ($doofinder_prices_with_taxes) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_full_category_path?></td>
            <td><select name="doofinder_full_category_path">
                <?php if ($doofinder_full_category_path) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
      </form>
      <?php foreach($data_feeds as $lang => $currency_feed):?>
        <table>
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