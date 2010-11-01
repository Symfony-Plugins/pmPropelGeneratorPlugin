<?php

class pmExporterDecoratorInteger extends pmExporterDecoratorObject
{
  public function render($value)
  {
    return (int) parent::render($value);
  }
}
