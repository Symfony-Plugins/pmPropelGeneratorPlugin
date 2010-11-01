<?php

class pmExporterDecoratorBoolean extends pmExporterDecoratorObject
{
  protected function configure($options = array())
  {
    $this->addOption('true-representation', 'Yes');
    $this->addOption('false-representation', 'No');

    parent::configure($options);
  }

  public function render($value)
  {
    $value = parent::render($value);

    return $value? $this->getOption('true-representation') : $this->getOption('false-representation');
  }
}
