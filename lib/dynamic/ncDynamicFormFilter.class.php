<?php

/**
 * ncDynamicFormFilter
 *
 * @author José Nahuel Cuesta Luengo <ncuesta@cespi.unlp.edu.ar>
 */
class ncDynamicFormFilter extends sfFormFilterPropel
{
  /**
   * Configure this dynamic form filter.
   * This method expects a 'form' option which must be the inner form for this
   * form filter - the static one. If no such option is provided, an Invalid
   * Argument Exception will be thrown.
   *
   * @throws InvalidArgumentException If no 'form' option is provided.
   */
  public function configure()
  {
    $this->form = $this->getOption('form');

    if (null === $this->form)
    {
      throw new InvalidArgumentException('Missing required parameter for dynamic form: \'form\'.');
    }

    if (null === $this->getOption('url'))
    {
      throw new InvalidArgumentException('Missing required parameter for dynamic form: \'url\'.');
    }

    $this->disableInnerCSRFProtection();

    $this->mergeWidgets();
    $this->mergeValidators();
    $this->addNewButton();

    $this->getWidgetSchema()->setNameFormat($this->getInnerForm()->getWidgetSchema()->getNameFormat());
  }

  /**
   * Merge any used widget with this form's widgets.
   */
  protected function mergeWidgets()
  {
    foreach ($this->getDefaults() as $name => $value)
    {
      if ($name !== '__new' && !$this->isEmpty($value))
      {
        $this->setWidget($name, $this->getInnerForm()->getWidget($name));
      }
    }
  }

  /**
   * Merge the validator schema of the inner form with the one belonging to this
   * form.
   */
  protected function mergeValidators()
  {
    $this->setValidatorSchema($this->getInnerForm()->getValidatorSchema());
  }

  /**
   * Answers whether $value is an empty value.
   *
   * @param  mixed $value A value to test for emptiness
   *
   * @return bool
   */
  protected function isEmpty($value)
  {
    if (null !== $value)
    {
      if (is_array($value))
      {
        foreach (array('text', 'is_empty', 'value') as $key)
        {
          if (array_key_exists($key, $value) && null !== $value[$key] && '' !== trim($value[$key]))
          {
            return false;
          }
        }
      }
      else if ('' !== trim($value))
      {
        return false;
      }
    }

    return true;
  }

  /**
   * Disable CSRF protection for the inner form.
   */
  private function disableInnerCSRFProtection()
  {
    $this->getInnerForm()->disableLocalCSRFProtection();
    
    unset($this->form['_csrf_token']);
  }

  /**
   * Add the '_new' button (widget and validator) to this form filter.
   */
  protected function addNewButton()
  {
    $this->setWidget('__new', new ncWidgetFormDynamicFieldsChoice(array(
      'label'  => 'Add a new filter',
      'url'    => $this->getOption('url'),
      'fields' => $this->getInnerForm()->getWidgetSchema()->getFields()
    )));
    $this->setValidator('__new', new sfValidatorPass());

    $this->getWidgetSchema()->moveField('__new', 'first');
  }

  /**
   * Get the fields for this form filter.
   *
   * @return array
   */
  public function getFields()
  {
    return $this->getInnerForm()->getFields();
  }

  /**
   * Get the name of the model class for this form filter.
   *
   * @return string
   */
  public function getModelName()
  {
    return $this->getInnerForm()->getModelName();
  }

  /**
   * Get the inner form of this dynamic form - tipically an sfFormFilterPropel
   * subclass.
   * 
   * @return sfFormFilterPropel
   */
  public function getInnerForm()
  {
    return $this->form;
  }

  /**
   * Gets the JavaScript paths associated with the form.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    return array_merge($this->getInnerForm()->getJavaScripts(), array('/pmPropelGeneratorPlugin/js/nc_dynamic_filters.js'));
  }

  /**
   * Builds a Propel Criteria with processed values.
   *
   * Overload this method instead of {@link buildCriteria()} to avoid running
   * {@link processValues()} multiple times.
   *
   * @param  array $values
   *
   * @return Criteria
   */
  protected function doBuildCriteria(array $values)
  {
    return $this->getInnerForm()->buildCriteria($values);
  }
  
}
