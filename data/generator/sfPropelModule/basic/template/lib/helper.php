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
    
    if (isset($show_when))
    {
      if (call_user_func(array($obj, $show_when), $sf_user))
      {
        if (method_exists('<?php echo $this->getModelClass() ?>Peer', 'canNew') && !<?php echo $this->getModelClass() ?>Peer::canNew($sf_user))
        {
          return parent::linkToNew($params);
        }
      }
    }
    else
    {
      if (method_exists('<?php echo $this->getModelClass() ?>Peer', 'canNew'))
      {
        if (<?php echo $this->getModelClass() ?>Peer::canNew($sf_user))
        {
          return parent::linkToNew($params);
        }
        else
        {
          return '<li class="sf_admin_action_new_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
        }
      }
      else
      {
        return parent::linkToNew($params);
      }
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

    if (isset($show_when))
    {
      if (call_user_func(array($obj, $show_when), $sf_user))
      {
        if (method_exists($obj, 'canEdit') && $obj->canEdit($sf_user))
        {
          return parent::linkToEdit($object, $params);
        }
      }
    }
    else
    {
      if (method_exists($obj, 'canEdit'))
      {
        
        return $obj->canEdit($sf_user) ? parent::linkToEdit($object, $params) : '<li class="sf_admin_action_edit_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
      }
      else
      {
        return parent::linkToEdit($object, $params);
      }
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

    if (isset($show_when))
    {
      if (call_user_func(array($obj, $show_when), $sf_user))
      {
        if (method_exists($obj, 'canDelete') && $obj->canDelete($sf_user))
        {
          return parent::linkToDelete($object, $params);
        }
      }
    }
    else
    {
      if (method_exists($obj, 'canDelete'))
      {
        return $obj->canDelete($sf_user) ? parent::linkToDelete($object, $params) : '<li class="sf_admin_action_delete_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
      }
      else
      {
        return parent::linkToDelete($object, $params);
      }
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

    if (isset($show_when))
    {
      if (call_user_func(array($obj, $show_when), $sf_user))
      {
        if (method_exists($obj, 'canShow') && $obj->canShow($sf_user))
        {
          return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object).'</li>';
        }
      }
    }
    else
    {
      if (method_exists($obj, 'canShow'))
      {
        if ($obj->canShow($sf_user))
        {
          return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object).'</li>';
        }
        else
        {
          return '<li class="sf_admin_action_show_disabled">'.__($params['label'], array(), 'sf_admin').'</li>';
        }
      }
      else
      {
        return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object).'</li>';
      }
    }
  }

  public function linkToSaveAndList($object, $params)
  {
    return '<li class="sf_admin_action_save_and_list"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').'" name="_save_and_list" /></li>';
  }

public function linkToExport($params)
  {
    $params['action'] = isset($params['action'])? $params['action'] : 'doExportationPages';
    $params['label'] = 'Export';

    return '<li class="sf_admin_action_export">'.link_to_function(__('Export', array(), 'sf_admin'),
"
jQuery('#sf_admin_exportation').show();
jQuery('#sf_admin_exportation_ajax_indicator').show();
jQuery('#sf_admin_exportation_form').hide();
jQuery('#sf_admin_exportation').centerHorizontally();

jQuery('#sf_admin_exportation_form').load('".url_for(sfContext::getInstance()->getModuleName().'/'.$params['action'])."',

  function (response, status, xhr) {
    if (status != 'error')
    {
      jQuery('#sf_admin_exportation').show();
      jQuery('#sf_admin_exportation_ajax_indicator').hide();
      jQuery('#sf_admin_exportation_form').show();
      jQuery('#sf_admin_exportation').centerHorizontally();
      jQuery('#sf_admin_exportation_resizable_area').ensureVisibleHeight();
      jQuery(document).scrollTop(jQuery('#sf_admin_exportation').offset().top);
    }
  }
)").'</li>';
  }

  public function linkToUserExport($params)
  {
    $params['action'] = isset($params['action'])? $params['action'] : 'newUserExportation';
    $params['label'] = 'Custom export';

    return '<li class="sf_admin_action_user_export">'.link_to_function(__('Custom export', array(), 'sf_admin'),
"
jQuery('#sf_admin_exportation').show();
jQuery('#sf_admin_exportation_ajax_indicator').show();
jQuery('#sf_admin_exportation_form').hide();
jQuery('#sf_admin_exportation').centerHorizontally();

jQuery('#sf_admin_exportation_form').load('".url_for(sfContext::getInstance()->getModuleName().'/'.$params['action'])."',

  function (response, status, xhr) {
    if (status != 'error')
    {
      jQuery('#sf_admin_exportation').show();
      jQuery('#sf_admin_exportation_ajax_indicator').hide();
      jQuery('#sf_admin_exportation_form').show();
      jQuery('#sf_admin_exportation').centerHorizontally();
      jQuery('#sf_admin_exportation_resizable_area').ensureVisibleHeight();
      jQuery(document).scrollTop(jQuery('#sf_admin_exportation').offset().top);
    }
  }
)").'</li>';
  }
}
