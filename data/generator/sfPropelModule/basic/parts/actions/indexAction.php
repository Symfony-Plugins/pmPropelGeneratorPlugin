  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }
    if ($request->getParameter('max_per_page'))
    {
      $this->setMaxPerPage($request->getParameter('max_per_page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
  }
