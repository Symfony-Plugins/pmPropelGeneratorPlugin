[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorConfiguration extends pmModelGeneratorConfiguration
{
<?php include dirname(__FILE__).'/configuration/actionsConfiguration.php' ?>

<?php include dirname(__FILE__).'/configuration/fieldsConfiguration.php' ?>

<?php if (isset($this->config['exportation']['enabled']) && $this->config['exportation']['enabled']): ?>
  <?php include dirname(__FILE__).'/configuration/exporterConfiguration.php' ?>
  <?php include dirname(__FILE__).'/configuration/exporterPaginationConfiguration.php' ?>
<?php else: ?>
  <?php unset($this->config['exportation']) ?>
<?php endif ?>

  public function isExportationEnabled()
  { $plugins = sfContext::getInstance()->getConfiguration()->getPlugins();
    
    return <?php echo (isset($this->config['exportation']['enabled']) && $this->config['exportation']['enabled']? 'true' : 'false') ?> && in_array('sfPhpExcelPlugin',$plugins);
<?php unset($this->config['exportation']['enabled']) ?> 
  }

  /**
   * Gets the form class name.
   *
   * @return string The form class name
   */
  public function getFormClass()
  {
    return '<?php echo isset($this->config['form']['class']) ? $this->config['form']['class'] : $this->getModelClass().'Form' ?>';
<?php unset($this->config['form']['class']) ?>
  }

  public function hasFilterForm()
  {
    return <?php echo !isset($this->config['filter']['class']) || false !== $this->config['filter']['class'] ? 'true' : 'false' ?>;
  }

  /**
   * Gets the filter form class name
   *
   * @return string The filter form class name associated with this generator
   */
  public function getFilterFormClass()
  {
    return '<?php echo isset($this->config['filter']['class']) && !in_array($this->config['filter']['class'], array(null, true, false), true) ? $this->config['filter']['class'] : $this->getModelClass().'FormFilter' ?>';
<?php unset($this->config['filter']['class']) ?>
  }

<?php include dirname(__FILE__).'/configuration/paginationConfiguration.php' ?>

<?php include dirname(__FILE__).'/configuration/sortingConfiguration.php' ?>

  public function getPeerMethod()
  {
    return '<?php echo isset($this->config['list']['peer_method']) ? $this->config['list']['peer_method'] : 'doSelect' ?>';
<?php unset($this->config['list']['peer_method']) ?>
  }

  public function getPeerCountMethod()
  {
    return '<?php echo isset($this->config['list']['peer_count_method']) ? $this->config['list']['peer_count_method'] : 'doCount' ?>';
<?php unset($this->config['list']['peer_count_method']) ?>
  }
}
