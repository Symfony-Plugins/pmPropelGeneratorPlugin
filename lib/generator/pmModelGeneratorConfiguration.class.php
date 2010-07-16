<?php

abstract class pmModelGeneratorConfiguration extends sfModelGeneratorConfiguration
{
  public function getFilterDisplay()
  {
    return array();
  }

  public function getFormDisplay()
  {
    return array();
  }

  public function getNewDisplay()
  {
    return array();
  }

  public function getEditDisplay()
  {
    return array();
  }

  public function getFieldsFilter()
  {
    return array();
  }

  public function getFieldsForm()
  {
    return array();
  }

  public function getFieldsEdit()
  {
    return array();
  }

  public function getFieldsNew()
  {
    return array();
  }

  public function compile()
  {
    parent::compile();

    $this->configuration['show'] = array(
      'fields'  => array(),
      'title'   => $this->getShowTitle(),
      'actions' => $this->getShowActions() ? $this->getShowActions() : array('_delete' => null, '_list' => null),
    );

    foreach ($this->configuration['show']['actions'] as $action => $parameters)
    {
      $this->configuration['show']['actions'][$action] = $this->fixActionParameters($action, $parameters);
    }

    $this->parseVariables('show', 'title');

    $this->configuration['credentials']['show'] = array();
  }
}
