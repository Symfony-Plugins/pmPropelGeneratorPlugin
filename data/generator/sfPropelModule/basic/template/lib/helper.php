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
  
  public function linkToNew($params)
  {
    $sf_user = sfContext::getInstance()->getUser();
    
    if (isset($params['show_when']))
    {
      $show_when = $params['show_when'];
    }
    
    if (method_exists('<?php echo $this->getModelClass() ?>Peer', 'canNew') && !<?php echo $this->getModelClass() ?>Peer::canNew($sf_user))
    {
      return '<li class="sf_admin_action_new_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
    }
    
    if (isset($show_when))
    {
      return (call_user_func(array('<?php echo $this->getModelClass() ?>Peer', $show_when))) ? parent::linkToNew($params) : '';
    }
    else
    {
      return parent::linkToNew($params);
    }
  }
  
  public function linkToEdit($object, $params)
  {
    $sf_user = sfContext::getInstance()->getUser();
    
    $obj = $object instanceOf sfOutputEscaperObjectDecorator ? $object->getRawValue() : $object;
    if (isset($params['show_when']))
    {
      $show_when = $params['show_when'];
    }

    if (method_exists($obj, 'canEdit') && !$obj->canEdit($sf_user))
    {
      return '<li class="sf_admin_action_edit_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
    }

    if (isset($show_when))
    {
      return (call_user_func(array($obj, $show_when))) ? parent::linkToEdit($object, $params) : '';
    }
    else
    {
      return parent::linkToEdit($object, $params);
    }
  }

  public function linkToDelete($object, $params)
  {
    $sf_user = sfContext::getInstance()->getUser();
    
    $obj = $object instanceOf sfOutputEscaperObjectDecorator ? $object->getRawValue() : $object;
    if (isset($params['show_when']))
    {
      $show_when = $params['show_when'];
    }

    if (method_exists($obj, 'canDelete') && !$obj->canDelete($sf_user))
    {
      return '<li class="sf_admin_action_delete_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
    }

    if (isset($show_when))
    {
      return (call_user_func(array($obj, $show_when))) ? parent::linkToDelete($object, $params) : '';
    }
    else
    {
      return parent::linkToDelete($object, $params);
    }
  }

  public function linkToShow($object, $params)
  {
    $sf_user = sfContext::getInstance()->getUser();
    
    $obj = $object instanceOf sfOutputEscaperObjectDecorator ? $object->getRawValue() : $object;
    if (isset($params['show_when']))
    {
      $show_when = $params['show_when'];
    }

    if (method_exists($obj, 'canShow') && !$obj->canShow($sf_user))
    {
      return '<li class="sf_admin_action_show_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
    }

    if (isset($show_when))
    {
      return (call_user_func(array($obj, $show_when))) ? '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object).'</li>' : '';
    }
    else
    {
      return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object).'</li>';
    }
  }
  
  public function linkToSaveAndList($object, $params)
  {
    return '<li class="sf_admin_action_save_and_list"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').'" name="_save_and_list" /></li>';
  }
}
