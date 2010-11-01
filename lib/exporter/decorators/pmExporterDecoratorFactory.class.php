<?php

class pmExporterDecoratorFactory
{
  static public function getInstance($options = array())
  {
    $decorator = isset($options['decorator'])? $options['decorator'] : 'text';

    unset($options['decorator']);

    $klassName = 'pmExporterDecorator'.ucfirst(strtolower($decorator));

    return new $klassName($options);
  }
}
