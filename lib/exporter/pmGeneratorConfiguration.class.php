<?php

class pmGeneratorConfiguration
{
  static public function getExportationFitToPage()
  {
    $opts = self::getExportationConfiguration();
    return isset($opts['fit_to_page'])? $opts['fit_to_page'] : true;
  }

  static public function getExportationCenterHorizontally()
  {
    $opts = self::getExportationConfiguration();
    return isset($opts['center_horizontally'])? $opts['center_horizontally'] : true;
  }

  static public function getExportationCommonTitle()
  {
    $opts = self::getExportationConfiguration();
    return isset($opts['common_title'])? $opts['common_title'] : false; 
  }

  static public function getExportationAppendCommonDate()
  {
    $opts = self::getExportationConfiguration();
    return isset($opts['append_common_date'])? $opts['append_common_date'] : false;
  }

  static public function getExportationDateFormat()
  {
    $opts = self::getExportationConfiguration();
    return isset($opts['date_format'])? $opts['date_format'] : false;
  }

  static public function getExportationConfiguration()
  {
    return sfConfig::get('app_pm_generator_plugin_exportation', array());
  }

  static public function getNumberOfDecimals()
  {
    return sfConfig::get('app_pm_generator_plugin_decimals', false);
  }

  static public function getExportationNumberOfDecimals()
  {
    $opts = self::getExportationConfiguration();
    return isset($opts['decimals'])? $opts['decimals'] : false;
  }

}

?>
