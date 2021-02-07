<?php /* Zmart Floor Plan | definition classes for different drawings (images / icons) | MIT License | By Manuel Feller, 2016 - 2021 */
/*
This file contains the "Image" Definitions for the Elements that can be drawn.

Each class is basically just the definition / generation of the pixel representation for an element.
Its not drawn directly an can be requested in four rotations (0, 90 ,-90 / 270, 180)
Since all elements derive from a base class the rotation code is not within the definitions in this file...

*/
namespace ZmartFloorPlan\Drawing\Elements
{
  class Arrow extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 5;
      $this->Width = 5;
      $this->initPixels();
      $this->Pixels[0][0] = 1;
      $this->Pixels[1][1] = 1;
      $this->Pixels[2][2] = 1;
      $this->Pixels[3][3] = 1;
      $this->Pixels[2][4] = 1;
      $this->Pixels[3][4] = 1;
      $this->Pixels[4][2] = 1;
      $this->Pixels[4][3] = 1;
      $this->Pixels[4][4] = 1;
    }
  }

  class CeilingLight extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 11;
      $this->Width = 11;
      $this->initPixels();
      $line = 0;
      //
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][1] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][9] = 255;
      $this->Pixels[$line][10] = 1;
      $line++;
      //
      $this->Pixels[$line][0] = 255;
      $this->Pixels[$line][1] = 1;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][9] = 1;
      $this->Pixels[$line][10] = 255;
      $line++;
      //
      $this->Pixels[$line][1] = 255;
      $this->Pixels[$line][2] = 1;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 1;
      $this->Pixels[$line][9] = 255;
      $line++;
      //
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][8] = 255;
      $line++;
      //
      $this->Pixels[$line][0] = 255;
      $this->Pixels[$line][1] = 255;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 1;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 1;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][9] = 255;
      $this->Pixels[$line][10] = 255;
      $line++;
      //
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][1] = 1;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][3] = 1;
      $this->Pixels[$line][4] = 1;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 1;
      $this->Pixels[$line][7] = 1;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][9] = 1;
      $this->Pixels[$line][10] = 1;
      $line++;
      //
      $this->Pixels[$line][0] = 255;
      $this->Pixels[$line][1] = 255;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 1;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 1;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][9] = 255;
      $this->Pixels[$line][10] = 255;
      $line++;
      
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][8] = 255;
      $line++;
      
      $this->Pixels[$line][1] = 255;
      $this->Pixels[$line][2] = 1;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 1;
      $this->Pixels[$line][9] = 255;
      $line++;
      
      $this->Pixels[$line][0] = 255;
      $this->Pixels[$line][1] = 1;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][9] = 1;
      $this->Pixels[$line][10] = 255;
      $line++;
      
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][1] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][9] = 255;
      $this->Pixels[$line][10] = 1;

    }
  }
  
  class WallPlug extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 6;
      $this->Width = 10;
      $this->initPixels();
      
      $this->Pixels[0][0] = 1;
      $this->Pixels[0][9] = 1;
      
      $this->Pixels[1][0] = 1;
      $this->Pixels[1][1] = 255;
      $this->Pixels[1][8] = 255;
      $this->Pixels[1][9] = 1;
      
      $this->Pixels[2][0] = 1;
      $this->Pixels[2][1] = 255;
      $this->Pixels[2][2] = 255;
      $this->Pixels[2][7] = 255;
      $this->Pixels[2][8] = 255;
      $this->Pixels[2][9] = 1;
      
      $this->Pixels[3][0] = 1;
      $this->Pixels[3][1] = 255;
      $this->Pixels[3][2] = 255;
      $this->Pixels[3][3] = 255;
      $this->Pixels[3][4] = 255;
      $this->Pixels[3][5] = 255;
      $this->Pixels[3][6] = 255;
      $this->Pixels[3][7] = 255;
      $this->Pixels[3][8] = 255;
      $this->Pixels[3][9] = 1;
      
      $this->Pixels[4][0] = 1;
      $this->Pixels[4][1] = 255;
      $this->Pixels[4][2] = 255;
      $this->Pixels[4][3] = 255;
      $this->Pixels[4][4] = 255;
      $this->Pixels[4][5] = 255;
      $this->Pixels[4][6] = 255;
      $this->Pixels[4][7] = 255;
      $this->Pixels[4][8] = 255;
      $this->Pixels[4][9] = 1;
      
      $this->Pixels[5][1] = 1;
      $this->Pixels[5][2] = 1;
      $this->Pixels[5][3] = 1;
      $this->Pixels[5][4] = 1;
      $this->Pixels[5][5] = 1;
      $this->Pixels[5][6] = 1;
      $this->Pixels[5][7] = 1;
      $this->Pixels[5][8] = 1;
      
    }
  }
  
  class OpenCloseSensor extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 5;
      $this->Width = 10;
      $this->initPixels();
      
      $this->Pixels[0][1] = 1;
      $this->Pixels[0][2] = 1;
      $this->Pixels[0][3] = 1;
      $this->Pixels[0][4] = 1;
      $this->Pixels[0][5] = 1;
      $this->Pixels[0][6] = 1;
      $this->Pixels[0][7] = 1;
      $this->Pixels[0][8] = 1;
      
      $this->Pixels[1][0] = 1;
      $this->Pixels[1][1] = 255;
      $this->Pixels[1][2] = 255;
      $this->Pixels[1][3] = 255;
      $this->Pixels[1][4] = 255;
      $this->Pixels[1][5] = 255;
      $this->Pixels[1][6] = 255;
      $this->Pixels[1][7] = 255;
      $this->Pixels[1][8] = 255;
      $this->Pixels[1][9] = 1;
      
      $this->Pixels[2][0] = 1;
      $this->Pixels[2][1] = 255;
      $this->Pixels[2][2] = 255;
      $this->Pixels[2][3] = 255;
      $this->Pixels[2][4] = 255;
      $this->Pixels[2][5] = 255;
      $this->Pixels[2][6] = 255;
      $this->Pixels[2][7] = 255;
      $this->Pixels[2][8] = 255;
      $this->Pixels[2][9] = 1;
      
      $this->Pixels[3][0] = 1;
      $this->Pixels[3][1] = 255;
      $this->Pixels[3][2] = 255;
      $this->Pixels[3][3] = 255;
      $this->Pixels[3][4] = 255;
      $this->Pixels[3][5] = 255;
      $this->Pixels[3][6] = 255;
      $this->Pixels[3][7] = 255;
      $this->Pixels[3][8] = 255;
      $this->Pixels[3][9] = 1;
      
      $this->Pixels[4][1] = 1;
      $this->Pixels[4][2] = 1;
      $this->Pixels[4][3] = 1;
      $this->Pixels[4][4] = 1;
      $this->Pixels[4][5] = 1;
      $this->Pixels[4][6] = 1;
      $this->Pixels[4][7] = 1;
      $this->Pixels[4][8] = 1;
      
    }

  }
  
  class GenericSensor extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 5;
      $this->Width = 5;
      $this->initPixels();
      
      $this->Pixels[0][1] = 1;
      $this->Pixels[0][2] = 1;
      $this->Pixels[0][3] = 1;
      
      $this->Pixels[1][0] = 1;
      $this->Pixels[1][1] = 255;
      $this->Pixels[1][2] = 255;
      $this->Pixels[1][3] = 255;
      $this->Pixels[1][4] = 1;
      
      $this->Pixels[2][0] = 1;
      $this->Pixels[2][1] = 255;
      $this->Pixels[2][2] = 255;
      $this->Pixels[2][3] = 255;
      $this->Pixels[2][4] = 1;
      
      $this->Pixels[3][0] = 1;
      $this->Pixels[3][1] = 255;
      $this->Pixels[3][2] = 255;
      $this->Pixels[3][3] = 255;
      $this->Pixels[3][4] = 1;
      
      $this->Pixels[4][1] = 1;
      $this->Pixels[4][2] = 1;
      $this->Pixels[4][3] = 1;
    }
  }
  
  class Thermostat extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 9;
      $this->Width = 16;
      $this->initPixels();
      
      $this->Pixels[0][1] = 1;
      $this->Pixels[0][2] = 1;
      $this->Pixels[0][3] = 1;
      $this->Pixels[0][4] = 1;
      $this->Pixels[0][5] = 1;
      $this->Pixels[0][6] = 1;
      $this->Pixels[0][7] = 1;
      $this->Pixels[0][8] = 1;
      $this->Pixels[0][9] = 1;
      $this->Pixels[0][10] = 1;
      $this->Pixels[0][11] = 1;
      $this->Pixels[0][12] = 1;
      $this->Pixels[0][13] = 1;
      $this->Pixels[0][14] = 1;
      
      $this->Pixels[1][0] = 1;
      $this->Pixels[1][1] = 255;
      $this->Pixels[1][2] = 255;
      $this->Pixels[1][3] = 255;
      $this->Pixels[1][4] = 255;
      $this->Pixels[1][5] = 255;
      $this->Pixels[1][6] = 255;
      $this->Pixels[1][7] = 255;
      $this->Pixels[1][8] = 255;
      $this->Pixels[1][9] = 255;
      $this->Pixels[1][10] = 255;
      $this->Pixels[1][11] = 255;
      $this->Pixels[1][12] = 255;
      $this->Pixels[1][13] = 255;
      $this->Pixels[1][14] = 255;
      $this->Pixels[1][15] = 1;
      
      $this->Pixels[2][0] = 1;
      $this->Pixels[2][1] = 255;
      $this->Pixels[2][14] = 255;
      $this->Pixels[2][15] = 1;
      
      $this->Pixels[3][0] = 1;
      $this->Pixels[3][1] = 255;
      $this->Pixels[3][3] = 1;
      $this->Pixels[3][7] = 1;
      $this->Pixels[3][10] = 1;
      $this->Pixels[3][14] = 255;
      $this->Pixels[3][15] = 1;
      
      $this->Pixels[4][0] = 1;
      $this->Pixels[4][1] = 255;
      $this->Pixels[4][4] = 1;
      $this->Pixels[4][6] = 1;
      $this->Pixels[4][9] = 1;
      $this->Pixels[4][11] = 1;
      $this->Pixels[4][14] = 255;
      $this->Pixels[4][15] = 1;
      
      $this->Pixels[5][0] = 1;
      $this->Pixels[5][1] = 255;
      $this->Pixels[5][5] = 1;
      $this->Pixels[5][8] = 1;
      $this->Pixels[5][12] = 1;
      $this->Pixels[5][14] = 255;
      $this->Pixels[5][15] = 1;
      
      $this->Pixels[6][0] = 1;
      $this->Pixels[6][1] = 255;
      $this->Pixels[6][14] = 255;
      $this->Pixels[6][15] = 1;
      
      $this->Pixels[7][0] = 1;
      $this->Pixels[7][1] = 255;
      $this->Pixels[7][2] = 255;
      $this->Pixels[7][3] = 255;
      $this->Pixels[7][4] = 255;
      $this->Pixels[7][5] = 255;
      $this->Pixels[7][6] = 255;
      $this->Pixels[7][7] = 255;
      $this->Pixels[7][8] = 255;
      $this->Pixels[7][9] = 255;
      $this->Pixels[7][10] = 255;
      $this->Pixels[7][11] = 255;
      $this->Pixels[7][12] = 255;
      $this->Pixels[7][13] = 255;
      $this->Pixels[7][14] = 255;
      $this->Pixels[7][15] = 1;
      
      $this->Pixels[8][1] = 1;
      $this->Pixels[8][2] = 1;
      $this->Pixels[8][3] = 1;
      $this->Pixels[8][4] = 1;
      $this->Pixels[8][5] = 1;
      $this->Pixels[8][6] = 1;
      $this->Pixels[8][7] = 1;
      $this->Pixels[8][8] = 1;
      $this->Pixels[8][9] = 1;
      $this->Pixels[8][10] = 1;
      $this->Pixels[8][11] = 1;
      $this->Pixels[8][12] = 1;
      $this->Pixels[8][13] = 1;
      $this->Pixels[8][14] = 1;
    }
  }
  
  class WallHeater extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct($width)
    {
      $this->Height = 3;
      $this->Width = $width;
      $this->initPixels();
      for ($line = 0; $line < $this->Height; $line++)
      {
        for ($row = 0; $row < $this->Width; $row++)
        {
          if (!(($line == 0 || $line == 2) && ($row == 0 || $row == $this->Width - 1))) // exclude corner pixel
          {
            if ($line == 1 && ($row > 2 && $row < $this->Width - 3))
            {
              $this->Pixels[$line][$row] = 255;
            }
            else
            {
              $this->Pixels[$line][$row] = 1;
            }
            
          }
        }
      }
    }
  }
  
  class WindowBlinds extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct($width)
    {
      $this->Height = 5;
      $this->Width = $width;
      $this->initPixels();
      for ($row = 0; $row < $this->Width; $row++)
      {
        $this->Pixels[2][$row] = 1;
      }
      
      $this->Pixels[0][1] = 1;
      
      $this->Pixels[1][0] = 1;
      $this->Pixels[1][1] = 1;
      
      $this->Pixels[3][0] = 1;
      $this->Pixels[3][1] = 1;
      
      $this->Pixels[4][1] = 1;
      
      $this->Pixels[0][$this->Width - 8] = 1;
      
      $this->Pixels[1][$this->Width - 7] = 1;
      $this->Pixels[1][$this->Width - 8] = 1;
      
      $this->Pixels[3][$this->Width - 7] = 1;
      $this->Pixels[3][$this->Width - 8] = 1;
      
      $this->Pixels[4][$this->Width - 8] = 1;
      
      for ($row = $this->Width - 5; $row < $this->Width; $row++)
      {
        $this->Pixels[1][$row] = 1;
        $this->Pixels[3][$row] = 1;
      }
      
      
      for ($row = 3; $row < $this->Width - 9; $row++)
      {
        $this->Pixels[0][$row] = 255;
        $this->Pixels[1][$row] = 255;
        $this->Pixels[3][$row] = 255;
        $this->Pixels[4][$row] = 255;
        
      }

      
    }
  }
  
  class Window extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct($width, $wallsize, $opendirection)
    {
      $this->Height = 4 + $wallsize;
      $this->Width = $width;
      $this->initPixels();
      
      $this->Pixels[0][0] = 1;
      $this->Pixels[1][0] = 1;
      $this->Pixels[1][1] = 1;
      
      $this->Pixels[$wallsize + 2][0] = 1;
      $this->Pixels[$wallsize + 2][1] = 1;
      $this->Pixels[$wallsize + 3][0] = 1;
      
      $this->Pixels[0][$this->Width - 1] = 1;
      $this->Pixels[1][$this->Width - 1] = 1;
      $this->Pixels[1][$this->Width - 2] = 1;
      
      $this->Pixels[$wallsize + 2][$this->Width - 1] = 1;
      $this->Pixels[$wallsize + 2][$this->Width - 2] = 1;
      $this->Pixels[$wallsize + 3][$this->Width - 1] = 1;
      
      for ($line = 2; $line < $wallsize + 2; $line++)
      {
        for ($row = 0; $row < $this->Width; $row++)
        {
          $this->Pixels[$line][$row] = 1;
        }
      }
    }
  }
  
  class Door extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct($width, $direction)
    {
      $this->Height = $width;
      $this->Width = $width;
      $this->initPixels();
      //$this->Pixels[0][0] = 1;
      
      for ($row = 0; $row < $this->Width; $row++)
      {
        $this->Pixels[$this->Height - 1][$row] = 1;
      }
      
      if ($direction == 'right') // right
      {
        for ($line = 0; $line < $this->Height; $line++)
        {
          $this->Pixels[$line][0] = 1;
          $this->Pixels[$line][$line] = 1;
        }
      }
      else // left
      {
        for ($line = 0; $line < $this->Height; $line++)
        {
          $this->Pixels[$line][$this->Width - 1] = 1;
          $this->Pixels[$line][$this->Height - 1 - $line] = 1;
        }
      }
      
    }
  }

  class Opening extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct($width, $wallsize)
    {
      $this->Height = $wallsize;
      $this->Width = $width;
      $this->initPixels();
      
      for ($line = 0; $line < $this->Height; $line++) {
        for ($row = 0; $row < $this->Width; $row++)
        {
          $this->Pixels[$line][$row] = 1;
        }
      }
      
    }
  }

  class FireDetector extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 10;
      $this->Width = 8;
      $this->initPixels();
      
      //$this->Pixels[0][0] = 1;
      $this->Pixels[0][1] = 1;
      $this->Pixels[0][2] = 1;
      $this->Pixels[0][3] = 1;
      $this->Pixels[0][4] = 1;
      $this->Pixels[0][5] = 1;
      $this->Pixels[0][6] = 1;
      //$this->Pixels[0][7] = 1;
      
      $this->Pixels[1][0] = 1;
      $this->Pixels[1][1] = 255;
      $this->Pixels[1][2] = 255;
      $this->Pixels[1][3] = 255;
      $this->Pixels[1][4] = 255;
      $this->Pixels[1][5] = 255;
      $this->Pixels[1][6] = 255;
      $this->Pixels[1][7] = 1;
      
      $this->Pixels[2][0] = 1;
      $this->Pixels[2][1] = 255;
      $this->Pixels[2][2] = 1;
      $this->Pixels[2][3] = 1;
      $this->Pixels[2][4] = 1;
      $this->Pixels[2][5] = 1;
      $this->Pixels[2][6] = 255;
      $this->Pixels[2][7] = 1;
      
      $this->Pixels[3][0] = 1;
      $this->Pixels[3][1] = 255;
      $this->Pixels[3][2] = 1;
      $this->Pixels[3][3] = 255;
      $this->Pixels[3][4] = 255;
      $this->Pixels[3][5] = 255;
      $this->Pixels[3][6] = 255;
      $this->Pixels[3][7] = 1;
      
      $this->Pixels[4][0] = 1;
      $this->Pixels[4][1] = 255;
      $this->Pixels[4][2] = 1;
      $this->Pixels[4][3] = 255;
      $this->Pixels[4][4] = 255;
      $this->Pixels[4][5] = 255;
      $this->Pixels[4][6] = 255;
      $this->Pixels[4][7] = 1;
      
      $this->Pixels[5][0] = 1;
      $this->Pixels[5][1] = 255;
      $this->Pixels[5][2] = 1;
      $this->Pixels[5][3] = 1;
      $this->Pixels[5][4] = 1;
      $this->Pixels[5][5] = 255;
      $this->Pixels[5][6] = 255;
      $this->Pixels[5][7] = 1;
      
      $this->Pixels[6][0] = 1;
      $this->Pixels[6][1] = 255;
      $this->Pixels[6][2] = 1;
      $this->Pixels[6][3] = 255;
      $this->Pixels[6][4] = 255;
      $this->Pixels[6][5] = 255;
      $this->Pixels[6][6] = 255;
      $this->Pixels[6][7] = 1;
      
      $this->Pixels[7][0] = 1;
      $this->Pixels[7][1] = 255;
      $this->Pixels[7][2] = 1;
      $this->Pixels[7][3] = 255;
      $this->Pixels[7][4] = 255;
      $this->Pixels[7][5] = 255;
      $this->Pixels[7][6] = 255;
      $this->Pixels[7][7] = 1;
      
      $this->Pixels[8][0] = 1;
      $this->Pixels[8][1] = 255;
      $this->Pixels[8][2] = 255;
      $this->Pixels[8][3] = 255;
      $this->Pixels[8][4] = 255;
      $this->Pixels[8][5] = 255;
      $this->Pixels[8][6] = 255;
      $this->Pixels[8][7] = 1;
      
      //$this->Pixels[9][0] = 1;
      $this->Pixels[9][1] = 1;
      $this->Pixels[9][2] = 1;
      $this->Pixels[9][3] = 1;
      $this->Pixels[9][4] = 1;
      $this->Pixels[9][5] = 1;
      $this->Pixels[9][6] = 1;
      //$this->Pixels[9][7] = 1;
      
      
      
    }
  }
  
  class FloodSensor extends \ZmartFloorPlan\Drawing\Drawing
  {
    function __construct()
    {
      $this->Height = 18;
      $this->Width = 11;
      $this->initPixels();
      $line = 0;
      $this->Pixels[$line][5] = 1;
      $line++;
      
      $this->Pixels[$line][5] = 1;
      $line++;
      
      $this->Pixels[$line][4] = 1;
      $this->Pixels[$line][6] = 1;
      $line++;
      
      $this->Pixels[$line][4] = 1;
      $this->Pixels[$line][6] = 1;
      $line++;
      
      $this->Pixels[$line][4] = 1;
      $this->Pixels[$line][6] = 1;
      $line++;
      
      $this->Pixels[$line][3] = 1;
      $this->Pixels[$line][7] = 1;
      $line++;
      
      $this->Pixels[$line][3] = 1;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][7] = 1;
      $line++;
      
      $this->Pixels[$line][2] = 1;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][8] = 1;
      $line++;
      
      $this->Pixels[$line][1] = 1;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][9] = 1;
      $line++;
      
      $this->Pixels[$line][1] = 1;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][9] = 1;
      $line++;
      
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][10] = 1;
      $line++;
      
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][10] = 1;
      $line++;
      
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][10] = 1;
      $line++;
      
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][2] = 255;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][8] = 255;
      $this->Pixels[$line][10] = 1;
      $line++;
      
      $this->Pixels[$line][0] = 1;
      $this->Pixels[$line][3] = 255;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][7] = 255;
      $this->Pixels[$line][10] = 1;
      $line++;
      
      
      $this->Pixels[$line][1] = 1;
      $this->Pixels[$line][4] = 255;
      $this->Pixels[$line][5] = 255;
      $this->Pixels[$line][6] = 255;
      $this->Pixels[$line][9] = 1;
      $line++;
      
      $this->Pixels[$line][2] = 1;
      $this->Pixels[$line][3] = 1;
      $this->Pixels[$line][7] = 1;
      $this->Pixels[$line][8] = 1;
      $line++;
      
      $this->Pixels[$line][4] = 1;
      $this->Pixels[$line][5] = 1;
      $this->Pixels[$line][6] = 1;
      $line++;
      
      
      
    }
  }
  
  
}