<?php

class pmExporterDecoratorMany extends pmExporterDecoratorObject
{
  public function configure($options)
  {
    $this->addRequiredOption('item-decorator');
    $this->addOption('item-decorator-options', array());
    $this->addOption('enclosure', '');
    $this->addOption('separator', ', ');
    parent::configure($options);
  }

  public function render($value)
  {
    $value = parent::render($value);

    $string = empty($this->getOption('enclosure'))? '' : $this->options('enclosure');

    $string .= implode($this->getOption('separator'), $this->decorateWhole($value));

    $string .= empty($this->getOption('enclosure'))? '' : $this->getOption('enclosure');

    return $string;
  }

  protected function getItemDecorator()
  {
    $options = array_merge($this->getOption('item-decorator-options'));

    $decorator = pmExporterDecoratorFactory::getInstance($this->getOption('item-decorator'), $options);

    return $decorator;
  }

  protected function decorateWhole($value)
  {
    $dec = $this->getItemDecorator();
    $ret = array();
    foreach ($value as $v)
    {
      $ret[] = $dec->render($v);
    }
    return $ret;
  }
}
