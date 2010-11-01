<?php

class pmExporterDecoratorText extends pmExporterDecoratorObject
{
  protected function configure($options = array())
  {
    $this->addOption('truncate-to', -1);
    $this->addOption('lowercase', false);
    $this->addOption('uppercase', false);
    $this->addOption('capitalize', false);
    $this->addOption('truncate-append', false);

    parent::configure($options);
  }

  public function render($value)
  {
    $value = strval(parent::render($value));

    if ($this->getOption('truncate-to') > 0 && strlen($value) > $this->getOption('truncate-to'))
    {
      $value = substr($value, 0, $this->getOption('truncate-to'));
      if ($this->getOption('truncate-append'))
      {
        $value .= $this->getOption('truncate-append');
      }
    }

    if ($this->getOption('capitalize'))
    {
      $value = ucfirst(strtolower($value));
    }

    if ($this->getOption('uppercase'))
    {
      $value = strtoupper($value);
    }

    if ($this->getOption('lowercase'))
    {
      $value = strtolower($value);
    }

    return $value;
  }

}
