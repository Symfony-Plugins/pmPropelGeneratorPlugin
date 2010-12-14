<?php

class pmPropelGenerator extends sfPropelGenerator
{
  /**
   * This actions is overriden because the confirm parameter is not translated.
   */
  public function getLinkToAction($actionName, $params, $pk_link = false)
  {
    if (isset($params["params"]["confirm"]))
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers(array("I18N"));
      
      $params["params"]["confirm"] = __($params["params"]["confirm"], array(), "messages");
    }
    
    return parent::getLinkToAction($actionName, $params, $pk_link);
  }
}
