[?php

require_once(dirname(__FILE__).'/../lib/Base<?php echo ucfirst($this->moduleName) ?>GeneratorConfiguration.class.php');
require_once(dirname(__FILE__).'/../lib/Base<?php echo ucfirst($this->moduleName) ?>GeneratorHelper.class.php');
require_once(dirname(__FILE__).'/../lib/exporterHelper.php');
require_once(dirname(__FILE__).'/../lib/exporterHelperUser.php');
require_once(dirname(__FILE__).'/../lib/exporterXls.php');
require_once(dirname(__FILE__).'/../lib/exporterCsv.php');
require_once(dirname(__FILE__).'/../lib/exporterForm.php');

/**
 * <?php echo $this->getModuleName() ?> actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 */
abstract class <?php echo $this->getGeneratedModuleName() ?>Actions extends <?php echo $this->getActionsBaseClass()."\n" ?>
{
  public function preExecute()
  {
    $this->configuration = new <?php echo $this->getModuleName() ?>GeneratorConfiguration();

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($this->getActionName())))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.pre_execute', array('configuration' => $this->configuration)));

    $this->helper = new <?php echo $this->getModuleName() ?>GeneratorHelper();

    $route_options = $this->getRoute()->getOptions();
    $skip = array('new', 'create', 'update');
    if (isset($route_options['type']) && $route_options['type'] == 'object' && !in_array($this->getActionName(), $skip))
    {
      $method = sfInflector::camelize('can_'.$this->getActionName());
      if (method_exists($this->getRoute()->getObject(), $method) && !call_user_func(array($this->getRoute()->getObject(), $method), $this->getUser()))
      {
        $verb = strtolower(sfInflector::humanize($this->getActionName()));
        $verb .= (substr($verb, -1) == 'e') ? 'd' : 'ed';
        $this->getUser()->setFlash('error', "The item cannot be $verb.");
        $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
      }
    }
  }

<?php include dirname(__FILE__).'/../../parts/actions/indexAction.php' ?>

<?php if ($this->configuration->hasFilterForm()): ?>
<?php include dirname(__FILE__).'/../../parts/actions/filterAction.php' ?>
<?php endif; ?>

<?php include dirname(__FILE__).'/../../parts/actions/newAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/actions/createAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/actions/editAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/actions/updateAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/actions/deleteAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/actions/showAction.php' ?>

<?php if ($this->configuration->getValue('list.batch_actions')): ?>
<?php include dirname(__FILE__).'/../../parts/actions/batchAction.php' ?>
<?php endif; ?>

<?php include dirname(__FILE__).'/../../parts/actions/processFormAction.php' ?>

<?php if ($this->configuration->hasFilterForm()): ?>
<?php include dirname(__FILE__).'/../../parts/actions/filtersAction.php' ?>
<?php endif; ?>

<?php include dirname(__FILE__).'/../../parts/actions/paginationAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/actions/sortingAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/actions/customAction.php' ?>
<?php include dirname(__FILE__).'/../../parts/actions/dynamicFieldAction.php' ?>

<?php if ($this->configuration->isExportationEnabled()): ?>
<?php include dirname(__FILE__).'/../../parts/actions/exporterAction.php' ?>
<?php include dirname(__FILE__).'/../../parts/actions/exporterPaginationAction.php' ?>
<?php endif ?>

}
