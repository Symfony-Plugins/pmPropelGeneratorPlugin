<?php

class pmExporterXls extends pmExporter
{
  const
    FILE_EXTENSION    = 'xls',
    MIME_TYPE         = 'application/x-excel';

  protected
    $rowInformation   = array(),
    $myContext        = null,
    $excelWriter      = null,
    $excelObject      = null;

  public function __construct()
  {
    parent::__construct();
    $this->buildExcelObject();
  }

  public function resetRowCount()
  {
    $this->firstHeaderRow = 1;
    $this->lastHeaderRow  = 1;
    $this->rowCount       = 0;
  }

  public function setRowInformation($rows)
  {
    $this->rowInformation = $rows;
  }

  static public function getFileExtension()
  {
    return self::FILE_EXTENSION;
  }

  static public function getMimeType()
  {
    return self::MIME_TYPE;
  }

  public function getRowInformation()
  {
    return $this->rowInformation;
  }

  public function build()
  {
    ini_set("max_execution_time",0); 

    $this->buildTitle();
    $this->buildHeaders($this->getHeaders());
    $this->buildRows($this->getRowInformation());
    $this->buildCustomRow();
    $this->setAutosizeColumnDimensions();
  }

  public function getTitleLastRowNumber()
  {
    return $this->lastTitleRow;
  }

  public function getActiveSheet()
  {
    return $this->excelObject->getActiveSheetIndex();
  }

  public function setAutosizeColumnDimensions()
  {
    if (sfConfig::get('app_xls_autosize_columns', true))
    {
      if ($this->getTitleLastRowNumber() > 0)
      {
        foreach (range(1, $this->getTitleLastRowNumber()) as $row)
        {
          $this->excelObject->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
        }
      }

      for ($i=0;$i<$this->getHeaderCount();$i++)
      {
        $column = chr(ord('A') + $i);
        $this->excelObject->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
      }
    }
  }

  public function saveFile($whereTo)
  {
    ini_set("max_execution_time",0);
    $this->excelWriter = new PHPExcel_Writer_Excel5($this->getExcelObject());
    $this->excelWriter->save($whereTo);
  }

  public function createSheet($i)
  {
    return $this->applyDefaultSheetStyle($this->excelObject->createSheet($i));
  }

  public function setSheetTitle($number, $title)
  {
    if (!is_null($sheet = $this->excelObject->getSheet($number)))
    {
      $sheet->setTitle($title);
    }
  }

  public function getSheetCount()
  {
    return $this->excelObject->getSheetCount();
  }

  public function setActiveSheetIndex($i)
  {
    $this->excelObject->setActiveSheetIndex($i);
  }

  protected function applyDefaultSheetStyle($sheet)
  {
    $sheet->getDefaultStyle()->getFont()->setSize(sfConfig::get('app_xls_font_size', 9));
    $sheet->getDefaultStyle()->getFont()->setName(sfConfig::get('app_xls_font_name', 'Arial'));
    $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
    $sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
    $sheet->getPageSetup()->setOrientation(sfConfig::get('app_xls_orientation_landscape')? PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE : PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    //$sheet->getPageSetup()->setFitToPage(true);
    $sheet->getPageMargins()->setTop(sfConfig::get('app_xls_top_margin'));
    $sheet->getPageMargins()->setRight(sfConfig::get('app_xls_right_margin'));
    $sheet->getPageMargins()->setBottom(sfConfig::get('app_xls_bottom_margin'));
    $sheet->getPageMargins()->setLeft(sfConfig::get('app_xls_left_margin'));

    return $sheet;
  }

  protected function buildExcelObject()
  {
    $this->excelObject = new sfPhpExcel();
    $this->applyDefaultSheetStyle($this->excelObject->getActiveSheet());
    $this->excelObject->setActiveSheetIndex(0);
  }

  public function setExcelObject($excelObject)
  {
    $this->excelObject = $object;
  }

  public function getExcelObject()
  {
    return $this->excelObject;
  }

  protected function buildTitleFormat($order = 1)
  {
    $ret = array(
      'font'      => array(
        'bold'    => $order == 1,
        'size'    => $order < 4? 15 - $order : 11,
      ),
      'alignment'  => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true),
      'borders' => array(
        'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => 'ffffff')),
        'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => 'ffffff')),
        'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => 'ffffff')),
        'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => 'ffffff')),
      ),
    );
    return $ret;
  }

  protected function buildGeneralFormat()
  {
    $ret = array(
      'borders' => array(
        'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      ),
      'alignment'  => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
    );
    return $ret;
  }

  protected function buildHeaderFormat()
  {
    $ret = array(
      'font'      => array(
          'bold'       => true,
      ),
      'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
      'borders' => array(
        'top'     => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'    => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'   => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
      ),
    );
    return array_merge($ret, $this->buildGeneralFormat());
  }

  protected function getTitles()
  {
    return is_array($this->getTitle())? $this->getTitle() : array($this->getTitle());
  }

  protected function buildTitle()
  {
    $titles = $this->getTitles();
    $order  = 1;

    $this->firstHeaderRow = $this->rowCount + 1;
    foreach ($titles as $title)
    {
      ++$this->rowCount;
      $this->lastHeaderRow = $this->rowCount;

      $text   = is_array($title)? $title['text'] : $title;
      $format = is_array($title) && isset($title['format'])? $title['format'] : array();

      $this->excelObject->getActiveSheet()->setCellValueByColumnAndRow(0, $this->rowCount, $this->translate($text));
      $this->excelObject->getActiveSheet()->getStyleByColumnAndRow(0, $this->rowCount)->applyFromArray(array_merge($this->buildTitleFormat($order), $format));
      $this->excelObject->getActiveSheet()->mergeCellsByColumnAndRow(0, $this->rowCount, $this->getHeaderCount()-1, ++$this->rowCount);

      ++$order;
    }
  }

  protected function buildHeaders($headers)
  {
    $column  = 0;
    $headers = $this->getHeaders();
    if (!empty($headers))
    {
      ++$this->rowCount;
      $this->lastHeaderRow = $this->firstHeaderRow = $this->rowCount;
      foreach ($this->getHeaders() as $field)
      {
        $this->excelObject->getActiveSheet()->setCellValueByColumnAndRow($column, $this->rowCount, $this->translate($field));
        $this->excelObject->getActiveSheet()->getStyleByColumnAndRow($column, $this->rowCount)->applyFromArray($this->buildHeaderFormat());

        $column++;
      }
    }
  }

  protected function buildRows($rows)
  {
    $this->firstDataRow = $this->rowCount+1;
    foreach ($rows as $line)
    {
      ++$this->rowCount;
      $this->buildRow($line, $this->rowCount);
      $this->lastDataRow = $this->rowCount;
    }
  }

  protected function buildRow($row, $rowNumber)
  {
    $column = 0;
    foreach ($row as $key => $field)
    {
      $this->excelObject->getActiveSheet()->setCellValueByColumnAndRow($column, $rowNumber, $field);
      $this->excelObject->getActiveSheet()->getStyleByColumnAndRow($column, $rowNumber)->applyFromArray($this->buildGeneralFormat());
      $column++;
    }
  }

  protected function buildCustomRow()
  {
    $row = $this->getCustomRow();
    if (!empty($row))
    {
      $oldCount = $this->rowCount++;
      $column = 0;
      foreach ($row as $position => $field)
      {
        $content = str_replace(array(
          '%first-data-row%',
          '%last-data-row%',
          '%first-header-row%',
          '%last-header-row%',
          '%row-count%',
          '%first-title-row%',
          '%last-title-row%',
          '%column-position%',
        ),
        array(
          $this->firstDataRow,
          $this->lastDataRow,
          $this->firstHeaderRow,
          $this->lastHeaderRow,
          $oldCount,
          $this->firstTitleRow,
          $this->lastTitleRow,
          $this->getAlpha($position),
        ),
        $field);

        $this->excelObject->getActiveSheet()->setCellValueByColumnAndRow($column, $this->rowCount, $content);
        $this->excelObject->getActiveSheet()->getStyleByColumnAndRow($column, $this->rowCount)->applyFromArray($this->buildGeneralFormat());
        $column++;
      }
    }
  }

  protected function getAlpha($number)
  {
    return chr(ord('A')+$number);
  }
}
