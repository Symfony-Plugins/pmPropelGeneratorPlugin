
  protected function simpleProcessForm($request, sfForm $form, $action, $successFlash = "The item was updated successfully.", $failureFlash = "The item has not been saved due to some errors.", $redirect = null, $redirect_method = null)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $<?php echo $this->getSingularName() ?> = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $<?php echo $this->getSingularName() ?>)));
      $this->getUser()->setFlash('notice', $successFlash);

      if (!is_null($redirect_method))
      {
        $redirect = $this->$redirect_method($form);
      }
      else
      {
        $redirect = is_null($redirect)? $action."?id=".$<?php echo $this->getSingularName() ?>->getId() : $redirect;
      }
      $this->redirect($redirect);
    }
    else
    {
      $this->getUser()->setFlash('error', $failureFlash, false);
    }
  }

  protected function getObjectFromRequest($form_name, $idField = 'id')
  {
    $request  = $this->getRequest()->getParameter($form_name);
    $this->forward404If(!is_array($request) || !isset($request[$idField]));

    if (is_array($idField))
    {
      $pk = array();
      foreach ($idField as $f)
      {
        $pk[$f] = $request[$f];
      }
    }
    else
    {
      $pk = $request[$idField];
    }

    return <?php echo constant($this->getModelClass().'::PEER') ?>::retrieveByPk($pk);
  }
