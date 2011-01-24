[?php use_helper('I18N', 'Date', 'JavascriptBase') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="sf_admin_container">
  <h1>[?php echo __($custom_title, isset($custom_title_params)? $custom_title_params : array()) ?]</h1>

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('dbObject' => $dbObject, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>

  <div id="sf_admin_content">
    [?php include_partial('<?php echo $this->getModuleName() ?>/custom_form', array('dbObject' => $dbObject, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper, 'action' => '', 'custom_form_action' => $custom_form_action)) ?]
  </div>

  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('dbObject' => $dbObject, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>
</div>
