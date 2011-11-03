  protected function getPager()
  {
    $pager = $this->configuration->getPager('<?php echo $this->getModelClass() ?>');
    $pager->setCriteria($this->buildCriteria());
    $pager->setPage($this->getPage());
    $pager->setPeerMethod($this->configuration->getPeerMethod());
    $pager->setPeerCountMethod($this->configuration->getPeerCountMethod());
    $pager->init();

    return $pager;
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute($this->getPageAttribute(), $page, 'admin_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute($this->getPageAttribute(), 1, 'admin_module');
  }
  
  protected function getPageAttribute()
  {
    return '<?php echo $this->getModuleName() ?>.page';
  }

  protected function buildCriteria()
  {
<?php if ($this->configuration->hasFilterForm()): ?>
    if (null === $this->filters)
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $criteria = $this->filters->buildCriteria($this->getFilters());
<?php else: ?>
    $criteria = new Criteria();
<?php endif; ?>

    $this->addSortCriteria($criteria);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
    $criteria = $event->getReturnValue();

    return $criteria;
  }
