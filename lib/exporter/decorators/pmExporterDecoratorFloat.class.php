<?php

class pmExporterDecoratorFloat extends pmExporterDecoratorObject
{
  protected function configure($options = array())
  {
    $this->addOption('decimals', pmGeneratorConfiguration::getExportationNumberOfDecimals());

    parent::configure($options);
  }

  public function render($value)
  {
    $value = parent::render($value);

    if ($this->getOption('decimals'))
    {
      $value = pmGeneratorRounder::round($value, $this->getOption('decimals'));
    }
    return (float) parent::render($value);
  }
}
