<?php

class pmExporterHelperCustom extends pmExporterHelper
{
  protected 
    $myContext       = null,
    $rowObjects      = null,
    $class           = null,
    $headers         = array(),
    $title           = null,
    $fieldSelection  = array(),
    $type            = null;

  /**
   * 
   *
   * @param $configuration        generator's configuration
   * @param $objects              a set of objects to fetch information from
   * @param $options              an array of options to configure the exportation. The available options are:
   *                                + type:       see pmExporterTypes
   *                                + class:      an exporter class to use instead of the defaults defined in pmExporterTypes
   *                                + context:    an sfContext instance
   *                                + decorators: an array of sfPropelRevistedExporterFieldDecorator instances to format the data.
   *                                + headers:    an array of header's label
   *                                + title:      the title of the document
   *                                + mime_type:  the mime type
   */
  public function __construct($objects, $options = array())
  {
    $this->rowObjects = $objects;
    $this->parseOptions($options);
  }

  /*
   * parseOptions
   *
   * Parses the options of the exporter helper.
   *
   * @param array $options
   */
  protected function parseOptions($options)
  {
    parent::parseOptions($options);
    $this->fieldSelection = isset($options['decorators'])? $options['decorators'] : array();
    $this->headers        = isset($options['headers'])? $options['headers'] : array();
    $this->title          = isset($options['title'])? $options['title'] : array();
    $this->mime_type      = isset($options['mime_type'])? $options['mime_type'] : null;
  }

  protected function getExporterSubclassPrefix()
  {
    return 'pm';
  }

  /**
   * Returns the exporter subclass name
   *
   * @return string exporter subclass name
   */
  protected function getExporterSubclassName()
  {
    return pmExporterTypes::getClassForType($this->type, $this->getExporterSubclassPrefix());
  }

  /**
   * Returns the exporter subclass instance
   *
   * @return pmExporter subclass
   */
  protected function getExporterSubclass()
  {
    $klass = $this->getExporterSubclassName();
    return new $klass();
  }

  /**
   * Returns the generator's configuration instance
   *
   * @return The generator's configuration object (do not recall the class name and I shall not look it up!)
   */
  protected function getConfiguration()
  {
    return null;
  }

  /**
   * Return an array of strings that will be used to render headers
   *
   * @return array An array of strings
   */
  protected function getHeaders()
  {
    return $this->headers;
  }

  protected function getTitle($pageNumber = null)
  {
    return $this->title;
  }

  /**
   * Use this to get an abstraction of the user's field configuration 
   *
   * @return an array of pmExporterFieldDecorators
   */
  protected function getFieldSelection()
  {
    return $this->fieldSelection;
  }

  public function getMimeType()
  {
    return $this->mime_type;
  }

  public function prepareResponseForExportation($response, $filename)
  {
    sfConfig::set('sf_web_debug', false);
    $mimeType = $this->getMimeType();
    $response->setHttpHeader('Content-type', "$mimeType; charset=UTF-8");
    $response->setHttpHeader('Content-Disposition', ' attachment; filename="'.$filename.'"');
    $response->setHttpHeader('Cache-Control', ' maxage=3600');
    $response->setHttpHeader('Prapma', 'public');
  }

  public function prepareActionForExportation($action, $filename)
  {
    $action->setLayout(false);
    $this->prepareResponseForExportation($action->getResponse(), $filename);
  }
}
