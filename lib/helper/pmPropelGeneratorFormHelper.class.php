<?php

class pmPropelGeneratorFormHelper
{
  static public function getRenderizedFields($form, $action)
  {
    $renderized = array();

    $method = "get{$action}Fieldsets";
    if (method_exists($form, $method))
    {
      foreach ($form->$method() as $fieldset)
      {
        if (is_array($fieldset))
        {
          foreach ($fieldset as $field => $name)
          {
            $renderized[] = $name;
          }
        }
      }
      return $renderized;
    }
    return null;
  }

  static public function getUnrenderizedFields($form, $action)
  {
    $fields = self::getFieldNames($form);
    $renderized = self::getRenderizedFields($form, $action);

    if (!is_null($renderized))
    {
      $unrenderized = array();
      foreach (array_diff($fields, $renderized) as $name)
      {
        if (!$form[$name]->isHidden()) $unrenderized[] = $name;
      }
      return $unrenderized;
    }
    return array();
  }

  static public function getFieldNames($form)
  {
    $fieldNames = array();
    foreach ($form as $fieldName => $field)
    {
      $fieldNames[] = $fieldName;
    }
    return $fieldNames;
  }
}
