<?php /* Zmart Floor Plan | base class for object definitions (sensors, label, ...) | MIT License | By Manuel Feller, 2016 - 2021 */

namespace ZmartFloorPlan\Elements
{
  class Room
  {
    public $Name;
    
    public $ColorFloor;
    public $ColorWall;
    
    public $LocationLeft;
    public $LocationTop;
    public $RoomWidth;
    public $RoomHeight;
    
    public $WallThicknessLeft;
    public $WallThicknessTop;
    public $WallThicknessRight;
    public $WallThicknessBottom;
    
    public $Elements;
    
    function __construct()
    {
      $this->Name = '';
      $this->ColorFloor = array(222, 222, 222);
      $this->ColorWall = array(0, 0, 0);
      $this->LocationLeft = 0;
      $this->LocationTop = 0;
      $this->RoomWidth = 50;
      $this->RoomHeight = 50;
      $this->WallThicknessLeft = 1;
      $this->WallThicknessTop = 1;
      $this->WallThicknessRight = 1;
      $this->WallThicknessBottom = 1;
      $this->Elements = array();
    }
  }

  class Element
  {
    // common
    public $Name;
    public $Type;
    public $MountWall;
    public $WallDistance;
    public $LeftCornerDistance;
    public $ItemColor;
    public $ActivityColor;
    // common automation parameters
    public $HasAutomation;
    public $AutomationName;
    public $RequiresApplyValues;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'unknown';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(100, 100, 100);
      $this->RequiresApplyValues = false;
    }
  }
}