[?php $row_format = $form->getWidgetSchema()->getFormFormatter()->getRowFormat() ?]

[?php $method = "get".sfInflector::camelize($field) ?]

[?php if (method_exists($<?php echo $this->getSingularName() ?>->getRawValue(), $method)): ?]

  [?php echo strtr($row_format, array(
    "%label%" => isset($form[$field]) ? $form[$field]->renderLabel() : __(sfInflector::humanize($field), array(), "messages"),
    "%error%" => "",
    "%field%" => $<?php echo $this->getSingularName() ?>->$method(),
    "%help%" =>  isset($form[$field]) ? $form[$field]->renderHelp() : "",
    "%hidden_fields%" => ""
  )) ?]

[?php else: ?]

  [?php include_partial("<?php echo $this->getModuleName() ?>/".substr($field, 1), array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]

[?php endif ?]