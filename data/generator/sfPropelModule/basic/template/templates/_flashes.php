[?php if ($sf_user->hasFlash('notice')): ?]
  <div class="notice flash_message">
    [?php if ($sf_user->hasFlash('notice_detail')): ?]
      <span class="expander">[?php echo link_to_function("[".__('show', array(), '<?php echo $this->getI18nCatalogue() ?>')."]", "jQuery('#notice_detail_msgs').show(); jQuery(this).hide(); jQuery(this).hide();") ?]</span>
    [?php endif ?]
    [?php $params = $sf_user->getFlash('notice_params', array()) ?]
    [?php echo __($sf_user->getFlash('notice'), $params instanceOf sfOutputEscaper? $params->getRawValue() : $params, '<?php echo $this->getI18nCatalogue() ?>') ?]
  </div>
[?php endif; ?]

[?php if ($sf_user->hasFlash('notice_detail')): ?]
  <div class="notice_detail flash_message" style="display: none" id="notice_detail_msgs">
    <ul>
      [?php $params = $sf_user->getFlash('notice_detail_params', array()) ?]
      [?php foreach ($sf_user->getFlash("notice_detail") as $value): ?]
        <li>[?php echo __(strval($value), $params instanceOf sfOutputEscaper? $params->getRawValue() : $params, '<?php echo $this->getI18nCatalogue() ?>') ?]</li>
      [?php endforeach ?]
    </ul>
  </div>
[?php endif ?]

[?php if ($sf_user->hasFlash('error')): ?]
  <div class="error flash_message">
    [?php if ($sf_user->hasFlash('error_detail')): ?]
      <span class="expander">[?php echo link_to_function("[".__('show', array(), '<?php echo $this->getI18nCatalogue() ?>')."]", "jQuery('#error_detail_msgs').show(); jQuery(this).hide(); jQuery(this).hide();") ?]</span>
    [?php endif ?]
    [?php $params = $sf_user->getFlash('error_params', array()) ?]
    [?php echo __($sf_user->getFlash('error'), $params instanceOf sfOutputEscaper? $params->getRawValue() : $params, '<?php echo $this->getI18nCatalogue() ?>') ?]
  </div>
[?php endif; ?]

[?php if ($sf_user->hasFlash('error_detail')): ?]
  <div class="error_detail flash_message" style="display: none" id="error_detail_msgs">
    <ul>
      [?php $params = $sf_user->getFlash('error_detail_params', array()) ?]
      [?php foreach ($sf_user->getFlash("error_detail") as $value): ?]
        <li>[?php echo __(strval($value), $params instanceOf sfOutputEscaper? $params->getRawValue() : $params, '<?php echo $this->getI18nCatalogue() ?>') ?]</li>
      [?php endforeach ?]
    </ul>
  </div>
[?php endif ?]

[?php if ($sf_user->hasFlash('warning')): ?]


  <div class="warning flash_message">
    [?php if ($sf_user->hasFlash('warning_detail')): ?]
      <span class="expander">[?php echo link_to_function("[".__('show', array(), '<?php echo $this->getI18nCatalogue() ?>')."]", "jQuery('#warning_detail_msgs').show(); jQuery(this).hide(); jQuery(this).hide();") ?]</span>
    [?php endif ?]
    [?php $params = $sf_user->getFlash('warning_params', array()) ?]
    [?php echo __($sf_user->getFlash('warning'), $params instanceOf sfOutputEscaper? $params->getRawValue() : $params, '<?php echo $this->getI18nCatalogue() ?>') ?]
  </div>

  [?php if ($sf_user->hasFlash('warning_detail')): ?]
    <div class="warning_detail flash_message" style="display: none" id="warning_detail_msgs">
      <ul>
        [?php $params = $sf_user->getFlash('warning_detail_params', array()) ?]
        [?php foreach ($sf_user->getFlash("warning_detail") as $value): ?]
        <li>[?php echo __(strval($value), $params instanceOf sfOutputEscaper? $params->getRawValue() : $params, '<?php echo $this->getI18nCatalogue() ?>') ?]</li>
        [?php endforeach ?]
      </ul>
    </div>
  [?php endif ?]
[?php endif; ?]
