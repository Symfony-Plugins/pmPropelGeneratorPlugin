[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }

  public function linkToShow($object, $params)
  {
    return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object).'</li>';
  }

  public function linkToEdit($object, $params)
  {
    $obj = $object instanceOf sfOutputEscaperObjectDecorator ? $object->getRawValue() : $object;
    if (method_exists($obj, 'canEdit'))
    {
      return $obj->canEdit() ? parent::linkToEdit($object, $params) : '';
    }
    else
    {
      return parent::linkToEdit($object, $params);
    }
  }

  public function linkToDelete($object, $params)
  {
    $obj = $object instanceOf sfOutputEscaperObjectDecorator ? $object->getRawValue() : $object;
    if (method_exists($obj, 'canDelete'))
    {
      return $obj->canDelete() ? parent::linkToDelete($object, $params) : '';
    }
    else
    {
      return parent::linkToDelete($object, $params);
    }
  }
}
