  public function getPagerClass()
  {
    return '<?php echo isset($this->config['list']['pager_class']) ? $this->config['list']['pager_class'] : 'sfPropelPager' ?>';
<?php unset($this->config['list']['pager_class']) ?>
  }
  
  public function getPagerMaxPerPageArray()
  {
<?php if (isset($this->config['list']['max_per_page']) && is_array($this->config['list']['max_per_page'])): ?>
    return <?php echo $this->asPhp($this->config['list']['max_per_page']) ?>;
<?php else: ?>
    return false;
<?php endif ?>
  }
  
  public function getPagerMaxPerPage()
  {
<?php if (isset($this->config['list']['max_per_page'])): ?>
    return <?php echo is_array($this->config['list']['max_per_page']) ? (integer) array_shift($this->config['list']['max_per_page']) : (integer) $this->config['list']['max_per_page'] ?>;
<?php else: ?>
    return 20;
<?php endif ?>
<?php unset($this->config['list']['max_per_page']) ?>
  }

  public function getListUseTopPagination()
  {
    return <?php echo isset($this->config['list']['use_top_pagination']) ? $this->config['list']['use_top_pagination'] : false ?>;
<?php unset($this->config['list']['use_top_pagination']) ?>
  }
