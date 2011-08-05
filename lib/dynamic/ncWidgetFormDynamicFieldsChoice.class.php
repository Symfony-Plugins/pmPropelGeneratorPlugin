<?php

/**
 * ncWidgetFormDynamicFieldsChoice
 *
 * @author José Nahuel Cuesta Luengo <ncuesta@cespi.unlp.edu.ar>
 */
class ncWidgetFormDynamicFieldsChoice extends sfWidgetFormChoice
{
  /**
   * Constructor.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  public function __construct($options = array(), $attributes = array())
  {
    $options['choices'] = new sfCallable(array($this, 'getFieldsAsChoices'));
    
    parent::__construct($options, $attributes);
  }
  
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * url:              The url for the ajax callback that gets the fields
   *                        information (required)
   *  * fields:           An array of possible fields (required)
   *  * template:         The HTML template to use. Available placeholders are
   *                        %fields% and %add_button%
   *  * add_text:         The text to use inside the add button (default: '+')
   *  * add_empty:        True if an empty option should be prepended to the
   *                        choices (default: true)
   * 
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormChoice
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    
    $this->addRequiredOption('url');
    $this->addRequiredOption('fields');
    
    $this->addOption('template', '%fields% %add_button%');
    $this->addOption('add_text', 'Add a new filter');
    $this->addOption('add_empty', true);
  }

  /**
   * Get the available fields as an array of choices.
   * 
   * @return array
   */
  public function getFieldsAsChoices()
  {
    $choices = array();

    foreach ($this->getOption('fields') as $name => $field)
    {
      // Choices are translated here on purpose in order to have them correctly sorted...
      $choices[$name] = $this->translate($field->getLabel() ? $field->getLabel() : sfInflector::humanize($name));
    }

    // ...here
    asort($choices, SORT_LOCALE_STRING);

    if ($empty = $this->getOption('add_empty'))
    {
      if (is_bool($empty))
      {
        $empty = '';
      }
      else
      {
        $empty = $this->translate($empty);
      }

      $choices = array('' => $empty) + $choices;
    }

    return $choices;
  }

  /**
   * Get the name of the parent form.
   * 
   * @return string
   */
  protected function getFormName()
  {
    $form_name = '';

    if ('[%s]' == substr($name_format = $this->getParent()->getNameFormat(), -4))
    {
      $form_name = str_replace('[%s]', '', $name_format);
    }

    return $form_name;
  }
  
  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetFormChoice
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $template = $this->getOption('template').<<<HTML
<script type="text/javascript">
//<![CDATA[
DynamicFilters.initialize('#%id%_add_btn', {
  source:      '#%id%_field',
  url:         '%url%',
  name_prefix: '%name%'
});
//]]>
</script>
HTML;

    return strtr($template, array(
      '%fields%'     => parent::render($this->generateId($name.'_field'), $value, $attributes, $errors),
      '%add_button%' => $this->renderTag('input', array('id' => $this->generateId($name.'_add_btn'), 'type' => 'button', 'value' => $this->translate($this->getOption('add_text')))),
      '%id%'         => $this->generateId($name),
      '%url%'        => $this->getOption('url'),
      '%name%'       => $this->getFormName().'_'
    ));
  }
  
}
