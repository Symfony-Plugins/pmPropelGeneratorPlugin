<?php

class pmExporterDecoratorObject extends pmExporterDecoratorBase
{
  protected function configure($options = array())
  {
    $this->addRequiredOption('method');
    $this->addOption('method_parameters', array());

    parent::configure($options);
  }

  public function render($value)
  {
    if (is_object($value))
    {
      $method        = $this->getOption('method');
      $method_params = $this->getOption('method_parameters');

      return call_user_func_array(array($value, $method), $this->getOption('method_parameters'));
    }
    return $value;
  }
}
