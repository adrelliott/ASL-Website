<?php if(!defined('ABSPATH')) { die('You are not allowed to call this page directly.'); } ?>

<?php $prli_blogurl = esc_html($prli_blogurl); ?>

<div class="prli-page" id="custom-bookmarklet">
  <div class="prli-page-title"><?php esc_html_e('Custom Bookmarklet:', 'pretty-link'); ?></div>
  <strong><span id="prlipro-custom-bookmarklet-link"><a class="button button-primary" href="<?php echo esc_url(PrliLink::bookmarklet_link()); ?>" style="vertical-align:middle;"><?php esc_html_e('Get Pretty Link', 'pretty-link'); ?></a></span></strong>&nbsp;&nbsp;
  <?php PrliAppHelper::info_tooltip( 'prli-custom-bookmarklet-instructions',
                                      esc_html__('Customize Pretty Link Bookmarklet', 'pretty-link'),
                                      esc_html__('Alter the options below to customize this Bookmarklet. As you modify the label, redirect type, tracking and category, you will see this bookmarklet update -- when the settings are how you want them, drag the bookmarklet into your toolbar. You can create as many bookmarklets as you want each with different settings.', 'pretty-link'));
  ?>
  <div>&nbsp;</div>
  <p><strong><?php esc_html_e('Pretty Link Options', 'pretty-link'); ?></strong></p>
  <form id="prlipro-custom-bookmarklet-form">
    <p>
      <label for="prlipro-bookmarklet-label" class="plp-bookmarklet-col-1"><?php esc_html_e('Label:', 'pretty-link'); ?></label>
      <input id="prlipro-bookmarklet-label" type="text" size="25" value="<?php esc_attr_e('Get Pretty Link', 'pretty-link'); ?>" />
    </p>
    <p>
      <label for="prlipro-bookmarklet-redirect-type" class="plp-bookmarklet-col-1"><?php esc_html_e('Redirection:', 'pretty-link'); ?></label>
      <?php PrliLinksHelper::redirect_type_dropdown('prlipro-bookmarklet-redirect-type','',array(__('Default', 'pretty-link') => -1)); ?>
    </p>
    <p>
      <label for="prlipro-bookmarklet-track" class="plp-bookmarklet-col-1"><?php esc_html_e('Tracking:', 'pretty-link'); ?></label>
      <select id="prlipro-bookmarklet-track" name="prlipro-bookmarklet-track?>">
        <option value="-1"><?php esc_html_e('Default', 'pretty-link'); ?>&nbsp;</option>
        <option value="1"><?php esc_html_e('Yes', 'pretty-link'); ?>&nbsp;</option>
        <option value="0"><?php esc_html_e('No', 'pretty-link'); ?>&nbsp;</option>
      </select>
    </p>
    <p>
      <label for="prlipro-bookmarklet-category" class="plp-bookmarklet-col-1"><?php esc_html_e('Category:', 'pretty-link'); ?></label>
      <?php
        wp_dropdown_categories(array(
          'id' => 'prlipro-bookmarklet-category',
          'name' => 'prlipro-bookmarklet-category',
          'show_option_none' => esc_html__('None', 'pretty-link'),
          'taxonomy' => PlpLinkCategoriesController::$ctax,
          'hide_empty' => false
        ));
      ?>
    </p>
  </form>
</div>
