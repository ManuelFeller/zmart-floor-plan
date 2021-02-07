# Extension Guide

Here you find information about extending the existing code with new "things"

## Create a new element

### Create the pixel data

file: 'drawing/definitions.php`  
add your new object derived from `\ZmartFloorPlan\Drawing\Drawing`

In this class you define the pixel data that is used to draw the element.


```php
class Opening extends \ZmartFloorPlan\Drawing\Drawing
{
  function __construct($width, $wallsize)
  {
    $this->Height = $wallsize; // set the height (in this case based on a parameter)
    $this->Width = $width; // set the width (in this example also based on a parameter)
    $this->initPixels(); // call teh init function to generate the required array with transparent color (value = 0) as base
    
    // start to define what pixels should have the item color (value = 1) - and if needed the ones that have the activity color (value = 255)
    // as the opening is something that is just drawn over a wall it is basically just a rectangle
    for ($line = 0; $line < $this->Height; $line++) {
      for ($row = 0; $row < $this->Width; $row++)
      {
        $this->Pixels[$line][$row] = 1;
      }
    }
  }
}
```

### Create the element properties

file: `elements/definitions.php`  
add your new object derived from `\ZmartFloorPlan\Elements\Element`

```php
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
```

### Add a switch-case for the processing of the XML configuration object

file: `floorplan.php`  
function: `processElementData`

```php
case 'opening':
  $newElementObject = new \ZmartFloorPlan\Elements\Item\Opening();
  $this->processItemOpeningSpecialFields($element, $newElementObject);
  $validType = true;
  break;
```

### Add a switch-case for the creation of the Object

file: `floorplan.php`  
function: `getPixelElementDrawing`

```php
case 'opening':
  return new \ZmartFloorPlan\Drawing\Elements\Opening($element->Width, $element->WallSize);
  break;
```