  public function getListParams()
  {
    return <?php echo $this->asPhp(isset($this->config['list']['params']) ? $this->config['list']['params'] : '%%'.implode('%% - %%', isset($this->config['list']['display']) ? $this->config['list']['display'] : $this->getAllFieldNames(false)).'%%') ?>;
<?php unset($this->config['list']['params']) ?>
  }

  public function getListLayout()
  {
    return '<?php echo isset($this->config['list']['layout']) ? $this->config['list']['layout'] : 'tabular' ?>';
<?php unset($this->config['list']['layout']) ?>
  }

  public function getListTitle()
  {
    return '<?php echo $this->escapeString(isset($this->config['list']['title']) ? $this->config['list']['title'] : sfInflector::humanize($this->getModuleName()).' List') ?>';
<?php unset($this->config['list']['title']) ?>
  }

  public function getEditTitle()
  {
    return '<?php echo $this->escapeString(isset($this->config['edit']['title']) ? $this->config['edit']['title'] : 'Edit '.sfInflector::humanize($this->getModuleName())) ?>';
<?php unset($this->config['edit']['title']) ?>
  }

  public function getNewTitle()
  {
    return '<?php echo $this->escapeString(isset($this->config['new']['title']) ? $this->config['new']['title'] : 'New '.sfInflector::humanize($this->getModuleName())) ?>';
<?php unset($this->config['new']['title']) ?>
  }

  public function getShowTitle()
  {
    return '<?php echo $this->escapeString(isset($this->config['show']['title']) ? $this->config['show']['title'] : 'Show '.sfInflector::humanize($this->getModuleName())) ?>';
<?php unset($this->config['show']['title']) ?>
  }

  public function getListDisplay()
  {
<?php if (isset($this->config['list']['display'])): ?>
    return <?php echo $this->asPhp($this->config['list']['display']) ?>;
<?php elseif (isset($this->config['list']['hide'])): ?>
    return <?php echo $this->asPhp(array_diff($this->getAllFieldNames(false), $this->config['list']['hide'])) ?>;
<?php else: ?>
    return <?php echo $this->asPhp($this->getAllFieldNames(false)) ?>;
<?php endif; ?>
<?php unset($this->config['list']['display'], $this->config['list']['hide']) ?>
  }

  public function getFieldsDefault()
  {
    return array(
<?php foreach ($this->getDefaultFieldsConfiguration() as $name => $params): ?>
      '<?php echo $name ?>' => <?php echo $this->asPhp($params) ?>,
<?php endforeach; ?>
    );
  }

  public function getFieldsList()
  {
    return array(
<?php foreach ($this->getFieldsConfiguration('list') as $name => $params): ?>
      '<?php echo $name ?>' => <?php echo $this->asPhp($params) ?>,
<?php endforeach ?>
    );
  }
