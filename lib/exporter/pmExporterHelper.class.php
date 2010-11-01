<?php

class pmExporterHelper
{
  protected 
    $myConfiguration = null,
    $myContext       = null,
    $rowObjects      = null,
    $class           = null,
    $exporterInstance = null,
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
   */
  public function __construct($configuration, $objects, $options = array())
  {
    $this->rowObjects       = $objects;
    $this->myConfiguration  = $configuration;

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
    $this->type        = isset($options['type'])? $options['type'] : pmExporterTypes::EXPORT_TYPE_XLS;
    $this->myContext   = isset($options['context'])? $options['context'] : sfContext::getInstance();
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
   * Returns a sfContext instance
   *
   * @return sfContext
   */
  protected function getContext()
  {
    return $this->myContext;
  }

  /**
   * Returns the generator's configuration instance
   *
   * @return The generator's configuration object (do not recall the class name and I shall not look it up!)
   */
  protected function getConfiguration()
  {
    return $this->myConfiguration;
  }

  /**
   * Return the objects that should be used to fetch data from
   *
   * @return array Object
   */
  protected function getRowObjects()
  {
    return $this->rowObjects;
  }

  /**
   * Return an array of strings that will be used to render headers
   *
   * @return array An array of strings
   */
  protected function getHeaders()
  {
    return $this->getConfiguration()->getExportationHeaders();
  }

  protected function getTitle()
  {
    return $this->getConfiguration()->getExportationTitle();
  }

  /**
   * Use this to get an abstraction of the user's field configuration 
   *
   * @return an array of pmExporterFieldDecorators
   */
  protected function getFieldSelection()
  {
    $fields = array();
    foreach ($this->getConfiguration()->getExportationFieldSelection() as $field)
    {
      $fields[] = pmExporterDecoratorFactory::getInstance($field);
    }
    return $fields;
  }

  /**
   * Formats a row
   *
   * @param Object $object
   *
   * @return array an array with the corresponding object's row information
   */
  protected function decorateRowInformation($object)
  {
    $row = array();
    if (!empty($object))
    {
      foreach ($this->getFieldSelection() as $fieldDecorator)
      {
        $row[] = $fieldDecorator->render($object);
      }
    }
    return $row;
  }


  /**
   * Returns the row information ready to be passed to the exporter subclass
   *
   * @return array
   */
  public function getRowInformation()
  {
    $rowInformation = array();
    foreach ($this->getRowObjects() as $object)
    {
      $rowInformation[] = $this->decorateRowInformation($object);
    }
    return $rowInformation;
  }

  /**
   * This method builds the exporting object with all the data in it!
   */
  public function build($title = null, $headers = null, $rowInformation = null)
  {
    $this->buildSheet($title, $headers, $rowInformation, 0);
    $this->exporterInstance->setActiveSheetIndex(0);
  }

  public function getActiveSheet()
  {
    return is_null($this->exporterInstance)? 0 : $this->exporterInstance->getActiveSheet();
  }

  public function buildSheet($title = null, $headers = null, $rowInformation = null)
  {
    $title          = is_null($title)? $this->getTitle() : $title;
    $headers        = is_null($headers)? $this->getHeaders() : $headers;
    $rowInformation = is_null($rowInformation)? $this->getRowInformation() : $rowInformation;

    $this->exporterInstance = is_null($this->exporterInstance)? $this->getExporterSubclass() : $this->exporterInstance;

    $this->exporterInstance->createSheet(0);
    $this->exporterInstance->setActiveSheetIndex(0);
    $this->exporterInstance->setTitle($title);
    $this->exporterInstance->setHeaders($headers);
    $this->exporterInstance->setRowInformation($rowInformation);
    $this->exporterInstance->setCustomRow($this->getCustomRow());

    $this->exporterInstance->resetRowCount();
    $this->exporterInstance->build();
  }

  protected function getExportationFieldSelectionColumns()
  {
    return array_keys($this->myConfiguration->getExportationFieldSelection());
  }

  public function getCustomRow()
  {
    $customRowData = array();
    $customRow = $this->myConfiguration->getExportationCustomRow();
    $fields    = $this->getExportationFieldSelectionColumns();

    if (is_array($customRow) && isset($customRow[$this->type]) && !empty($customRow[$this->type]))
    {
      $enabled = false;
      foreach ($this->getExportationFieldSelectionColumns() as $order => $col)
      {
        if (isset($customRow[$this->type][$col]))
        {
          $data    = $customRow[$this->type][$col];
          $enabled = true;
        }
        else
        {
          $data = '';
        }
        $customRowData[$order] = $data;
      }
      $customRowData = $enabled? $customRowData : array();
    }

    return $customRowData;
  }

  /**
   * This method saves the file in some location to be rendered afterwards
   *
   * @param $whereTo self explicatory path
   */
  public function saveFile($whereTo)
  {
    $this->exporterInstance->saveFile($whereTo);
    $this->savedFilePath = $whereTo;
  }

  /**
   *
   */
  public function deleteFile($path = null)
  {
    $path= is_null($path)? $this->savedFilePath : $path;
    unlink($path);
    $this->savedFilePath=null;
  }

  /**
   *
   */
  public function getFileContents($fromWhere = null)
  {
    $fromWhere = is_null($fromWhere)? $this->savedFilePath : $fromWhere;
    return file_get_contents($fromWhere);
  }

  /**
   *
   */
  public function freeMem()
  {
    foreach ($this->getRowObjects() as $o)
    {
      if (method_exists($o, 'clearAllReferences')) $o->clearAllReferences();
      unset($o);
    }
    $this->rowObjects = array();
  }
}
