# Extension Guide

Here you find information about extending the existing code with new "things"

## Create a new element

An element currently consists out of two classes:

- one class with the pixel data (the "image" data) -> based on `\ZmartFloorPlan\Drawing\Drawing`
- one class with the properties (the data object) -> based on `\ZmartFloorPlan\Elements\Element`

Additionally you need to tell the script about your new objects - as there is currently no reflection or similar auto-discovery ongoing.

Below you find the four steps in a bit more detail...

### Create the element properties

File to edit: `elements/definitions.php`

Add your new object as a class derived from `\ZmartFloorPlan\Elements\Element`.  
In this class you set the default properties as well as the custom ones.

This is referred to as the "element object"...

```php
class Opening extends \ZmartFloorPlan\Elements\Element
{
  // declare the two additional properties that are not part of the base object
  public $WallSize;
  public $Width;
  // set the defaults in the constructor
  function __construct()
  {
    // all the base elements
    $this->Name = '';
    $this->Type = 'opening';
    $this->HasAutomation = false;
    $this->AutomationName = '';
    $this->MountWall = 'left';
    $this->WallDistance = 1;
    $this->LeftCornerDistance = 1;
    $this->ItemColor = array(150, 150, 150);
    $this->ActivityColor = array(255, 255, 255);
    $this->RequiresApplyValues = false;
    // finally the two custom properties
    $this->WallSize = 1;
    $this->Width = 50;
  }
}
```

### Create the pixel data

File to edit: `drawing/definitions.php`  

Add your new object as a class derived from `\ZmartFloorPlan\Drawing\Drawing`.  
In this class you define the pixel data that is used to draw the element.

This is referred to as the "drawing object"...

```php
class Opening extends \ZmartFloorPlan\Drawing\Drawing
{
  // your constructor can have all parameters you need to generate the drawing based parameters
  // this is used to make elements that have variable size or dynamic / customized elements
  function __construct($width, $wallsize)
  {
    $this->Height = $wallsize; // set the height (in this case based on a parameter)
    $this->Width = $width; // set the width (in this example also based on a parameter)
    // call the init function to generate the required array with transparent color (value = 0) as base
    $this->initPixels();
    
    // start to define what pixels should have the item color (value = 1)
    // - and if needed the ones that have the activity color (value = 255)
    // as the Opening is something that is just drawn over a wall (doorless door)
    // it is basically just a rectangle
    for ($line = 0; $line < $this->Height; $line++) {
      for ($row = 0; $row < $this->Width; $row++)
      {
        $this->Pixels[$line][$row] = 1;
      }
    }
  }
}
```

### Add a switch-case for the processing of the XML configuration object

File to edit: `floorplan.php`  
Function to edit: `processElementData`

Here you need to add teh code that is required to read (and maybe validate) the data
that is entered in the XML configuration file. It is basically the "converter" between
the XML node and the internally used object definition.

This exists because teh XML based configuration was an addon that was developed later - you can
still choose to define your drawing object configuration based on other ways...

```php
[...]
switch (strtolower((string)$element['type']))
{
  [...]
  case 'opening':
    // generate the element in the variable that is used for the generated object
    $newElementObject = new \ZmartFloorPlan\Elements\Item\Opening();
    // if needed call the custom data handling (process all the extra fields from the elements XML node)
    // you need to write this function yourself...
    $this->processItemOpeningSpecialFields($element, $newElementObject);
    // mark the element as "found"
    $validType = true;
    // end the processing
    break;
  [...]
}
[...]
```

*Note: as things may change you most likely do not want to re-use any other elements special fields processing...*

### Add a switch-case for the creation of the Object

File to edit: `floorplan.php`  
Function to edit: `getPixelElementDrawing`

Here you will need to generate the actual pixel data object from the element object.
Basically you create an instance if the drawing object and pass any required parameters
from the element object into the constructor.

```php
[...]
switch (strtolower($element->Type))
{
  [...]
  case 'opening':
    return new \ZmartFloorPlan\Drawing\Elements\Opening($element->Width, $element->WallSize);
    break;
  [...]
}
[...]
```

## The future

I am aware that this is not the best way to add new objects. Depending on my available time (or participating contributors?) I may change this at some point, but don't get your hopes too high as long as this is such a niche tool with only myself maintaining it... ;-)
