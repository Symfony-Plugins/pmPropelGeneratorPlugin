<?php

abstract class pmExporterDecoratorBase
{
  protected
    $requiredOptions = array(),
    $context         = null,
    $id              = null,
    $options         = array();

  public function setId($id)
  {
    $this->id = $id;
  }

  public function __construct($options = array())
  {
    $this->configure($options);

    $currentOptionKeys = array_keys($this->options);
    $optionKeys = array_keys($options);

    // check option names
    if ($diff = array_diff($optionKeys, array_merge($currentOptionKeys, $this->requiredOptions)))
    {
      throw new InvalidArgumentException(sprintf('%s does not support the following options: \'%s\'.', get_class($this), implode('\', \'', $diff)));
    }

    // check required options
    if ($diff = array_diff($this->requiredOptions, array_merge($currentOptionKeys, $optionKeys)))
    {
      throw new RuntimeException(sprintf('%s requires the following options: \'%s\'.', get_class($this), implode('\', \'', $diff)));
    }

    $this->options = array_merge($this->options, $options);
  }

  protected function configure($options = array())
  {
    $this->addRequiredOption('label');
    $this->addOption('context', sfContext::getInstance());
    $this->addOption('translate', true);
  }

  public function addRequiredOption($name)
  {
    $this->requiredOptions[] = $name;

    return $this;
  }

  public function getRequiredOptions()
  {
    return $this->requiredOptions;
  }

  public function addOption($name, $value = null)
  {
    $this->options[$name] = $value;

    return $this;
  }

  public function setOption($name, $value)
  {
    if (!in_array($name, array_merge(array_keys($this->options), $this->requiredOptions)))
    {
      throw new InvalidArgumentException(sprintf('%s does not support the following option: \'%s\'.', get_class($this), $name));
    }

    $this->options[$name] = $value;

    return $this;
  }

  public function getOption($name)
  {
    return isset($this->options[$name]) ? $this->options[$name] : null;
  }

  public function hasOption($name)
  {
    return array_key_exists($name, $this->options);
  }

  public function getOptions()
  {
    return $this->options;
  }

  public function setOptions($options)
  {
    $this->options = $options;

    return $this;
  }

  public function getLabel()
  {
    return $this->getOption('label');
  }

  public function getId()
  {
    return is_null($this->id)
      ? strtolower(str_replace(array('á', 'é', 'í', 'ó', 'ú', 'ñ'),
                               array('a', 'e', 'i', 'o', 'u', 'n'),
                               sfInflector::underscore($this->options['label'])))
      : $this->id;
  }

  protected function getContext()
  {
    return $this->getOption('context');
  }

  protected function translate($text)
  {
    if ($this->getOption('translate'))
    {
      $this->getContext()->getConfiguration()->loadHelpers('I18N');
      return __($text);
    }
    return $text;
  }

  abstract public function render($value);
}
