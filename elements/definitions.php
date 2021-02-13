<?php /* Zmart Floor Plan | definition classes for diffrent objects (sensors, label, ...) | MIT License | By Manuel Feller, 2016 - 2021 */

namespace ZmartFloorPlan\Elements\Item
{
  // Label for different value types
  
  class TextLabel extends \ZmartFloorPlan\Elements\Element
  {
    public $DisplayText;
    public $TextAlign;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'text';
      $this->TextAlign = 'default';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->DisplayText = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }
  
  class TimestampLabel extends \ZmartFloorPlan\Elements\Item\TextLabel
  {
    
    public $Format;

    function __construct()
    {
      $this->Name = '';
      $this->Type = 'text';
      $this->TextAlign = 'default';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->DisplayText = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = true;
      $this->Format = 'H:i:s';
    }
    
    function ApplyValues()
    {
      $this->DisplayText = date($this->Format);
    }
  }

  class TemperatureLabel extends \ZmartFloorPlan\Elements\Item\TextLabel
  {
    public $DecimalPlaces;
    public $MetricFields;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'text';
      $this->TextAlign = 'default';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->DisplayText = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->MetricFields = array('level' => '', 'scaleTitle' => '');
      $this->DecimalPlaces = 1;
      $this->RequiresApplyValues = true;
    }
    
    function ApplyValues()
    {
      $this->DisplayText = number_format($this->MetricFields['level'], $this->DecimalPlaces) . substr($this->MetricFields['scaleTitle'],1);
    }
  }
  
  class PowerLabel extends \ZmartFloorPlan\Elements\Item\TextLabel
  {
    public $DecimalPlaces;
    public $MetricFields;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'text';
      $this->TextAlign = 'default';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->DisplayText = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->MetricFields = array('level' => '', 'scaleTitle' => '');
      $this->DecimalPlaces = 1;
      $this->RequiresApplyValues = true;
    }
    
    function ApplyValues()
    {
      $this->DisplayText = number_format($this->MetricFields['level'], $this->DecimalPlaces) . $this->MetricFields['scaleTitle'];
    }
  }
  
  class BrightnessLabel extends \ZmartFloorPlan\Elements\Item\TextLabel
  {
    public $DecimalPlaces;
    public $MetricFields;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'text';
      $this->TextAlign = 'default';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->DisplayText = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->MetricFields = array('level' => '', 'scaleTitle' => '');
      $this->DecimalPlaces = 0;
      $this->RequiresApplyValues = true;
    }
    
    function ApplyValues()
    {
      $this->DisplayText = number_format($this->MetricFields['level'], $this->DecimalPlaces) . ' ' . $this->MetricFields['scaleTitle'];
    }
  }
  
  class HumidityLabel extends \ZmartFloorPlan\Elements\Item\TextLabel
  {
    public $DecimalPlaces;
    public $SuffixText;
    public $MetricFields;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'text';
      $this->TextAlign = 'default';
      $this->SuffixText = ' rh';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->DisplayText = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->MetricFields = array('level' => '', 'scaleTitle' => '');
      $this->DecimalPlaces = 0;
      $this->RequiresApplyValues = true;
    }
    
    function ApplyValues()
    {
      $this->DisplayText = number_format($this->MetricFields['level'], $this->DecimalPlaces) . $this->MetricFields['scaleTitle'] . $this->SuffixText;
    }
  }
  
  
  // other Elements
  
  class Door extends \ZmartFloorPlan\Elements\Element
  {
    public $OpenDirection;
    public $Width;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'door';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->OpenDirection = 'left';
      $this->MountWall = 'left';
      $this->Width = 50;
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(150, 150, 150);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }

  class Opening extends \ZmartFloorPlan\Elements\Element
  {
    public $WallSize;
    public $Width;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'opening';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->WallSize = 1;
      $this->MountWall = 'left';
      $this->Width = 50;
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(150, 150, 150);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }

  class Window extends \ZmartFloorPlan\Elements\Element
  {
    public $WallSize;
    Public $Height;
    public $OpenDirection;
    
    function __construct()
    {
      $this->Name = '';
      $this->WallSize = 2;
      $this->Type = 'window';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(150, 150, 150);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
      $this->Width = 100;
      $this->OpenDirection = 'left';
    }
  }
  
  class WindowBlinds extends \ZmartFloorPlan\Elements\Element
  {
    public $Width;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'windowblinds';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
      $this->Width = 100;
    }
  }
  
  class Heater extends \ZmartFloorPlan\Elements\Element
  {
    public $Width;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'heater';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->Width = 50;
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }
  
  class WallPlug extends \ZmartFloorPlan\Elements\Element
  {
    public $OnColor;
    public $OffColor;
    public $MetricFields;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'wallplug';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = true;
      $this->MetricFields = array('level' => '');
      $this->OnColor = array(255, 150, 50);
      $this->OffColor = array(150, 200, 255);
    }
    
    function ApplyValues()
    {
      if ($this->MetricFields['level'] == "off") { $this->ActivityColor = $this->OffColor; }
      else { $this->ActivityColor = $this->OnColor; }
    }
  }	
  
  class CeilingLight extends \ZmartFloorPlan\Elements\Element
  {
    public $OnColor;
    public $OffColor;
    public $MetricFields;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'ceilinglight';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = true;
      $this->MetricFields = array('level' => '');
      $this->OnColor = array(255, 150, 50);
      $this->OffColor = array(150, 200, 255);
    }
    
    function ApplyValues()
    {
      if ($this->MetricFields['level'] == "off") { $this->ActivityColor = $this->OffColor; }
      else { $this->ActivityColor = $this->OnColor; }
    }
  }
  
  class Thermostat extends \ZmartFloorPlan\Elements\Element
  {
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'thermostat';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }
  
  class OpenCloseSensor extends \ZmartFloorPlan\Elements\Element
  {
    public $OpenColor;
    public $CloseColor;
    public $MetricFields;
    
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'openclose';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->MetricFields = array('level' => '');
      $this->RequiresApplyValues = true;
      $this->OpenColor = array(255, 100, 100);
      $this->CloseColor = array(100, 200, 100);
    }
    
    function ApplyValues()
    {
      if ($this->MetricFields['level'] == "off") { $this->ActivityColor = $this->CloseColor; }
      else { $this->ActivityColor = $this->OpenColor; }
    }
  }
  
  class FireDetector extends \ZmartFloorPlan\Elements\Element
  {
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'firealarm';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'bottom';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }
  
  class GenericSensor extends \ZmartFloorPlan\Elements\Element
  {
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'sensor';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }
  
  class FloodSensor extends \ZmartFloorPlan\Elements\Element
  {
    function __construct()
    {
      $this->Name = '';
      $this->Type = 'flood';
      $this->HasAutomation = false;
      $this->AutomationName = '';
      $this->MountWall = 'left';
      $this->WallDistance = 1;
      $this->LeftCornerDistance = 1;
      $this->ItemColor = array(0, 0, 0);
      $this->ActivityColor = array(255, 255, 255);
      $this->RequiresApplyValues = false;
    }
  }
  
}