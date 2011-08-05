  public function executeDynamicField(sfWebRequest $request)
  {
    $this->getResponse()->setContentType('text/json');

    try
    {
      if ($this->configuration->areFiltersDynamic() && $request->hasParameter('f'))
      {
        $class = $this->configuration->getStaticFilterFormClass();
        $form  = new $class();

        $form_field = $form[$request->getParameter('f')];

        $field = array(
          'label' => $form_field->renderLabel(),
          'field' => $form_field->render()
        );

        return $this->renderText(json_encode($field));
      }
    }
    catch (Exception $e)
    {
    }

    return sfView::NONE;
  }
