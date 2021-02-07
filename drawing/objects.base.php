<?php /* Zmart Floor Plan | base class for drawing definitions (images / icons) | MIT License | By Manuel Feller, 2016 - 2021 */

namespace ZmartFloorPlan\Drawing
{
  class Drawing
  {
    
    public $Height;
    public $Width;
    public $Pixels;
    
    // pixel codes:
    // 0 = none
    // 1 = item
    // n = possible other colors (depending on object)
    // 255 = activity / highlight
    
    function __construct($width, $height)
    {
      $this->Height = $height;
      $this->Width = $width;
      $this->initPixels();
    }
    
    function GetImagePixel($rotation)
    {
      switch ($rotation)
      {
        case 0:
          return $this->Pixels;
          break;
        case 90:
          return $this->rotateBy90();
          break;
        case 180:
          return $this->rotateBy180();
          break;
        case -90:
          return $this->rotateByMinus90();
          break;
        case 270:
          return $this->rotateByMinus90();
          break;
      }
    }
    
    private function rotateBy90()
    {
      $resultPixel = array();
      for ($line = 0; $line < $this->Width; $line++)
      {
        $tmpLine = array();
        for ($row = 0; $row < $this->Height; $row++)
        {
          $tmpLine[] = $this->Pixels[$this->Height - 1 - $row][$line];
        }
        $resultPixel[] = $tmpLine;
      }
      return $resultPixel;
    }
    
    private function rotateByMinus90()
    {
      $resultPixel = array();
      for ($line = 0; $line < $this->Width; $line++)
      {
        $tmpLine = array();
        for ($row = 0; $row < $this->Height; $row++)
        {
          $tmpLine[] = $this->Pixels[$row][$this->Width - 1 - $line];
        }
        $resultPixel[] = $tmpLine;
      }
      return $resultPixel;
    }

    private function rotateBy180()
    {
      $resultPixel = array();
      for ($line = 0; $line < $this->Height; $line++)
      {
        $tmpLine = array();
        for ($row = 0; $row < $this->Width; $row++)
        {
          $tmpLine[] = $this->Pixels[$this->Height - 1 - $line][$this->Width - 1 - $row];
        }
        $resultPixel[] = $tmpLine;
      }
      return $resultPixel;
    }
    
    protected function initPixels()
    {
      $this->Pixels = array();
      for ($line = 0; $line < $this->Height; $line++)
      {
        $tmpLine = array();
        for ($row = 0; $row <$this->Width; $row++)
        {
          $tmpLine[] = 0;
        }
        $this->Pixels[] = $tmpLine;
      }
    }
    
  }
}