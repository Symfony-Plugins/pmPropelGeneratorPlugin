<?php /** MUESTRA UN WARNING SI SE OLVIDÓ DE PONER UN FIELD EN EL 'getFieldsets' **/ ?>
<?php if (sfProjectConfiguration::getActive()->isDebug()): ?>
[?php if (count($unrenderized = pmPropelGeneratorFormHelper::getUnrenderizedFields($form, $action)) > 0): ?]
  <div class="warning">
    <span class="expander">
      [?php echo link_to_function("[".__('show', array(), 'sf_admin')."]", "jQuery('#warning_unrenderized').show(); jQuery(this).hide(); jQuery('#unrenderized_hider').show();", array('id' => 'unrenderized_shower')) ?]
      [?php echo link_to_function("[".__('hide', array(), 'sf_admin')."]", "jQuery('#warning_unrenderized').hide(); jQuery(this).hide(); jQuery('#unrenderized_shower').show();", array('id' => 'unrenderized_hider', 'style' => 'display: none')) ?]
    </span>
    [?php echo __("Some fields that haven't been unsetted in the form are not being rendered. This message is only shown in development environment as a warning.", array(), 'sf_admin') ?]
  </div>
  <div class="warning_detail" id="warning_unrenderized" style="display: none">
    <ul>
      [?php foreach ($unrenderized as $name): ?]
        <li>[?php echo __($form[$name]->renderLabelName()).' ('.$name.')' ?]</li>
      [?php endforeach ?]
    </ul>
  </div>
[?php endif ?]
<?php endif ?>
