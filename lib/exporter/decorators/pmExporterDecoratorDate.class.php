<?php

class pmExporterDecoratorDate extends pmExporterDecoratorObject
{
  protected function configure($options = array())
  {
    $this->addOption('date-format', null);

    parent::configure($options);
  }

  public function render($value)
  {
    $value = parent::render($value);
    if (!empty($value) && !is_null($this->getOption('date-format')))
    {
      $value = date($this->getOption('date-format'), strtotime($value));
    }
    return $value;
  }
}

