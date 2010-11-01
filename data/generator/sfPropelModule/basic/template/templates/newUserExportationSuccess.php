<?php if ($this->configuration->isExportationEnabled()): ?>
[?php use_helper('JavascriptBase') ?]
<fieldset>
  <h1>[?php echo __('Exportation Form', array(), 'sf_admin') ?]</h1>
  <div id="sf_admin_exportation_resizable_area">

    <form id="sf_admin_exportation_form_tag" action="" method="post" onsubmit="jQuery.ajax({
          async:true,
          url: '[?php echo url_for("<?php echo $this->getModuleName() ?>/createUserExportation")?]',
          beforeSend: function (request)
          {
            jQuery('#sf_admin_exportation').show();
            jQuery('#sf_admin_exportation_ajax_indicator').show();
            jQuery('#sf_admin_exportation_form').hide();
            jQuery('#sf_admin_exportation').centerHorizontally();
            jQuery('#sf_admin_exportation_resizable_area').ensureVisibleHeight();
          },
          success: function(html){
            jQuery('#sf_admin_exportation').show();
            jQuery('#sf_admin_exportation_ajax_indicator').hide();
            jQuery('#sf_admin_exportation_form').show();
            jQuery('#sf_admin_exportation').centerHorizontally();
            jQuery('#sf_admin_exportation_resizable_area').ensureVisibleHeight();
            jQuery('#sf_admin_exportation_form').html(html);
          },
          data: jQuery.param(jQuery(this).serializeArray()),
          dataType: 'script'
          }); return false;">


      [?php echo $form->renderHiddenFields() ?]
      [?php if ($form->hasGlobalErrors()): ?]
        [?php echo $form->renderGlobalErrors() ?]
      [?php endif; ?]
      [?php foreach ($form as $name => $field): ?]
        [?php if (!$form[$name]->isHidden()): ?]
          [?php include_partial('exportation_form_field', array('form' => $form, 'name' => $name, 'help' => null, 'class' => 'sf_admin_form_row sf_admin_exportation_form_row')) ?]
        [?php endif ?]
      [?php endforeach ?]
      <input type="submit" value="Submit" style="display: none" id="sf_admin_exportation_form_submit" />
    </form>
  </div>
  <div class="actions">
    <ul class="sf_admin_exportation_actions">
      <li>[?php echo link_to_function(__('Cancel', array(), 'sf_admin'), "jQuery('#sf_admin_exportation').hide()") ?]</li>
      <li>
        [?php echo button_to_function(__('Export', array(), 'sf_admin'), "jQuery('#sf_admin_exportation_form_submit').click()") ?]
      </li>
    </ul>
  </div>
</fieldset>
<?php endif ?>
