  protected function addSortCriteria($criteria)
  {
    if ($this->configuration->getIsMultipleSort())
    {
      foreach($this->getMultipleSort() as $sort)
      {
        if (!empty($sort))
        {
          $this->addSingleSortCriteria($criteria, $sort);
        }
      }
    }
    else
    {
      if (array(null, null) == ($sort = $this->getSort()))
      {
        return;
      }
      $this->addSingleSortCriteria($criteria, $sort);
    }
  }
  
  protected function addSingleSortCriteria($criteria, $sort)
  {
    $column = $this->configuration->getSortColumnNameForField(strtolower($sort[0]), '<?php echo $this->getModelClass() ?>');
    if ('asc' == $sort[1])
    {
      $criteria->addAscendingOrderByColumn($column);
    }
    else
    {
      $criteria->addDescendingOrderByColumn($column);
    }
  }

  protected function getSort()
  {
    if ($this->configuration->getIsMultipleSort())
    {
      return $this->getMultipleSort();
    }
    if (null !== $sort = $this->getUser()->getAttribute($this->getSortAttribute(), null, 'admin_module'))
    {
      return $sort;
    }

    $this->setSort($this->configuration->getDefaultSort());

    return $this->getUser()->getAttribute($this->getSortAttribute(), null, 'admin_module');
  }

  protected function setSort(array $sort)
  {
    if ($this->configuration->getIsMultipleSort())
    {
      $this->setMultipleSort($sort);
    }
    else
    {
      if (null !== $sort[0] && null === $sort[1])
      {
        $sort[1] = 'asc';
      }

      $this->getUser()->setAttribute($this->getSortAttribute(), $sort, 'admin_module');
    }
  }
  
  protected function getMultipleSort()
  {
    if (null !== $sort = $this->getUser()->getAttribute($this->getSortAttribute(), null, 'admin_module'))
    {
      return $sort;
    }
    $this->getUser()->setAttribute($this->getSortAttribute(), $this->configuration->getDefaultMultipleSort(), 'admin_module');
    
    return $this->getUser()->getAttribute($this->getSortAttribute(), null, 'admin_module');
  }

  protected function setMultipleSort(array $sort)
  {
    if (null !== $sort[0] && null === $sort[1])
    {
      $sort[1] = 'asc';
    }
    $multiple_sort = $this->getUser()->getAttribute($this->getSortAttribute(), null, 'admin_module');
    $multiple_sort = is_null($multiple_sort)?$this->configuration->getDefaultMultipleSort():$multiple_sort;
    if (strcasecmp($sort[1],'clean') == 0)
    {
      unset($multiple_sort [$sort[0]]);
    }
    else
    {
      $multiple_sort [$sort[0]]=$sort;
    }
    $this->getUser()->setAttribute($this->getSortAttribute(), $multiple_sort , 'admin_module');
  }

  protected function isValidSortColumn($column)
  {
    return $this->configuration->isValidSortColumn($column, '<?php echo $this->getModelClass() ?>');
  }
  
  protected function getSortAttribute()
  {
    return '<?php echo $this->getModuleName() ?>.sort';
  }