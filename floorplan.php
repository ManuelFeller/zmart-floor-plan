<?php /* Zmart Floor Plan | main class | MIT License | By Manuel Feller, 2016 - 2021 */

namespace ZmartFloorPlan
{	
  /**
   * This is the the class that helps you to generate a floor plan with your Z-Way devices
   * 
   * The ImageGenerator class is workhorse of the floor plan image generator.
   * 
   * For users that do not want to enhance anything this is the only contact point; you basically configure it via it's properties and then run the image generation.
   * This will then generate a PNG image that is sent back to the browser (or whoever is calling the script).
   */
  class ImageGenerator
  {		
    /**
     * Should the Z-Way integration be activated or not
     * 
     * When setting this to `true` the `ImageGenerator` will call the configured Z-Way device list endpoint and integrate the results into the output.
     * 
     * default: `false` (not active)
     *
     * @var boolean
     */
    public $ZWayActive;

    /**
     * Shall an internally generated Z-Way data simulation be used
     * 
     * When setting this to `true` the `ImageGenerator` will use internally generated example device data instead of doing a real Z-Way API call.
     * 
     * default: `false` (not active)
     *
     * @var boolean
     */
    public $ZWaySimulation;

    /**
     * The URL to call to get the Z-Way device data
     * 
     * This URL is used to query the Z-Way to get the data for all devices
     * 
     * default: `'http://127.0.0.1:8083/ZAutomation/api/v1/devices'`
     *
     * @var string
     */
    public $ZWayDeviceListUrl;

    /**
     * The URL to call to get the Z-Way location configuration
     * 
     * Currently unused
     *
     * default: `'http://127.0.0.1:8083/ZAutomation/api/v1/locations'`
     * 
     * @var string
     */
    public $ZWayLocationListUrl;

    /**
     * The user that should be used for authentication against the Z-Way API
     * 
     * default: empty `string`
     *
     * @var string
     */
    public $ZWayUserName;

    /**
     * The password that should be used for authentication against the Z-Way API
     *
     * default: empty `string`
     * 
     * @var string
     */
    public $ZWayUserPassword;

    /**
     * The (internal) array with the room definition objects
     *
     * This contains the object structure that is generated from the configuration XML.
     * You can dump it to learn about the internal structure that is used to generate - or use it to "inject" data generated somewhere else...
     * 
     * default: empty `array`
     * 
     * @var array
     */
    public $RoomDefinition;

    /**
     * Path to the file with the font to use for drawing text
     * 
     * This should be a `.ttf` file
     * 
     * default: empty `string`
     *
     * @var string
     */
    public $FontFile;

    /**
     * The of the font when text is drawn in the image
     *
     * default: `9`
     * 
     * @var int
     */
    public $FontSize;

    /**
     * The height of the generated image (in pixel)
     * 
     * default: `10`
     *
     * @var int
     */
    public $ImageHeight;

    /**
     * The width of the generated image (in pixel)
     * 
     * default: `10`
     *
     * @var int
     */
    public $ImageWidth;

    /**
     * The top offset from the image border (in pixel)
     * 
     * default: `1`
     *
     * @var int
     */
    public $ImageTopOffset;

    /**
     * The left offset from the image border (in pixel)
     * 
     * default: `1`
     *
     * @var int
     */
    public $ImageLeftOffset;

    private $elementCodeDirectory;
    private $drawingCodeDirectory;

    /**
     * Constructor for a new instance of the `ImageGenerator`
     *
     * Initializes the internal objects and loads the "sub-modules"
     * 
     * @param  string $elementCodeDir The name / path of the folder that contains the element definitions
     * @param  string $drawingCodeDir The name / path of the folder that contains the drawing definitions
     * @return void
     */
    function __construct($elementCodeDir = 'elements', $drawingCodeDir = 'drawing')
    {
      $this->ZWayActive = false;
      $this->ZWaySimulation = false;
      $this->ZWayDeviceListUrl = 'http://127.0.0.1:8083/ZAutomation/api/v1/devices';
      $this->ZWayLocationListUrl = 'http://127.0.0.1:8083/ZAutomation/api/v1/locations';
      $this->ZWayUserName = '';
      $this->ZWayUserPassword = '';
      $this->RoomDefinition = array();
      $this->FontFile = '';
      $this->FontSize = 9;
      $this->elementCodeDirectory = $elementCodeDir;
      $this->drawingCodeDirectory = $drawingCodeDir;
      $this->ImageHeight = 10;
      $this->ImageWidth = 10;
      $this->ImageTopOffset = 1;
      $this->ImageLeftOffset = 1;
      // load files with required code elements (realizing "lazy loading" on first usage of class by require_once)
      require_once $this->elementCodeDirectory . '/objects.base.php';
      require_once $this->elementCodeDirectory . '/definitions.php';
      require_once $this->drawingCodeDirectory . '/objects.base.php';
      require_once $this->drawingCodeDirectory . '/definitions.php';
      
    }

    /**
     * GenerateImage
     *
     * @return void
     */
    function GenerateImage()
    {
      // create image to draw on
      $canvas = imagecreatetruecolor($this->ImageWidth, $this->ImageHeight);
      // ensure alpha is saved / processed
      imagesavealpha($canvas, true);
      // allocate transaprent color
      $background = imagecolortransparent($canvas);
      // fill background with transparent color
      imagefill($canvas, 0, 0, $background);
      // if ZWay data fill is active
      if ($this->ZWayActive)
      {
        // request required data from Z-Wave System
        $devices = $this->getZWaveDeviceData();
        // check for fields that need to be filled with values from z-wave network
        for ($room = 0; $room < count($this->RoomDefinition); $room++)
        {
          for ($element = 0; $element < count($this->RoomDefinition[$room]->Elements); $element++)
          {
            if ($this->RoomDefinition[$room]->Elements[$element]->HasAutomation)
            {
              // check the data source where the value should be loaded from
              if ($this->RoomDefinition[$room]->Elements[$element]->AutomationDataSource == 'zmart') {
                // this is an element that gets its data internally
                if ($this->RoomDefinition[$room]->Elements[$element]->RequiresApplyValues)
                {
                  $this->RoomDefinition[$room]->Elements[$element]->ApplyValues();
                }
              } else {
                // ToDo: this is the Z-Way method, this may need some adjustment when we open this up to more data sources
                // we have an element that is configured to be filled by Z-Wave data,
                // so lets check the received list of Z-Wave devices
                foreach ($devices as &$device)
                {
                  // if ID of device and ID in element match
                  if ($device->id == $this->RoomDefinition[$room]->Elements[$element]->AutomationName)
                  {
                    // check for known field(s) and (if found) save them in the metrics array of the element to draw
                    if (isset($this->RoomDefinition[$room]->Elements[$element]->MetricFields['level'])) // value of sensor
                    {
                      $this->RoomDefinition[$room]->Elements[$element]->MetricFields['level'] = $device->metrics->level;
                    }
                    if (isset($this->RoomDefinition[$room]->Elements[$element]->MetricFields['scaleTitle'])) // unit name provided by device
                    {
                      $this->RoomDefinition[$room]->Elements[$element]->MetricFields['scaleTitle'] = $device->metrics->scaleTitle;
                    }
                    // in case element to draw indicates it provides an ApplyValues procedure: call it
                    // ToDo: fix this, assign is always successful but this should check the property !!!
                    if ($device->id == $this->RoomDefinition[$room]->Elements[$element]->RequiresApplyValues)
                    {
                      $this->RoomDefinition[$room]->Elements[$element]->ApplyValues();
                    }
                  }
                }
              }
            }
          }
        }
      }
      
      // run image creation by drawing rooms and their elements
      foreach ($this->RoomDefinition as &$room)
      {
        // apply offset to room
        $room->LocationLeft += $this->ImageLeftOffset;
        $room->LocationTop += $this->ImageTopOffset;
        // draw room
        $this->drawRoom($canvas, $room);
        // remove offset again
        $room->LocationLeft -= $this->ImageLeftOffset;
        $room->LocationTop -= $this->ImageTopOffset;
      }
      
      /* --- starting test code for new items --- */
      $this->executeTestCode($canvas);
      /* --- end test code for new items --- */
      
      // send result to client
      header('Content-Disposition: inline; filename="floorplan.png"'); // set name for the generated file (as nicer browser title and in case user wants to save the image
      header('Content-Type: image/png'); // set content type header to png image
      imagepng($canvas); // create and output png image
      imagedestroy($canvas); // destroy object to free memory
    }
    
    // to get the id's of new devices		
    /**
     * GetZWaveDeviceDataList
     *
     * @return void
     */
    function GetZWaveDeviceDataList()
    {
      if (!$this->ZWayActive) { return false; }
      return $this->getZWaveDeviceData();
    }
        
    /**
     * LoadDefinitionFromXmlFile
     *
     * @param  string $fileName
     * @return void
     */
    function LoadDefinitionFromXmlFile($fileName)
    {
      $xml = $this->loadXmlFile($fileName);
      if ($xml !== false)
      {
        $this->loadDefinitionFromXml($xml);
      }
    }
        
    /**
     * LoadDefinitionFromXmlString
     *
     * @param  string $xmlString
     * @return void
     */
    function LoadDefinitionFromXmlString($xmlString)
    {
      $xml = simplexml_load_string($xmlString);
      $this->loadDefinitionFromXml($xml);
    }
    
    private function executeTestCode($canvas)
    {
      //$img = new \ZmartFloorPlan\Drawing\Elements\WallPlug();
      //$img = new \ZmartFloorPlan\Drawing\Elements\OpenCloseSensor();
      //$img = new \ZmartFloorPlan\Drawing\Elements\GenericSensor();
      //$img = new \ZmartFloorPlan\Drawing\Elements\Thermostat();
      //$img = new \ZmartFloorPlan\Drawing\Elements\Door(50, 'left');
      //$img = new \ZmartFloorPlan\Drawing\Elements\WallHeater(200);
      //$img = new \ZmartFloorPlan\Drawing\Elements\FireDetector();
      //$img = new \ZmartFloorPlan\Drawing\Elements\FloodSensor();
      //$img = new \ZmartFloorPlan\Drawing\Elements\Window(200);
      //$img = new \ZmartFloorPlan\Drawing\Elements\CeilingLight();
      //$img = new \ZmartFloorPlan\Drawing\Elements\WindowBlinds(200);
      //$img = new \ZmartFloorPlan\Drawing\Elements\Arrow();
      //$img = new \ZmartFloorPlan\Drawing\Elements\Opening(50, 5);

      if (isset($img)) { // drawer debugging
        $finalPixel = $img->GetImagePixel(0);
        $colorItem = imagecolorallocate($canvas, 0, 0, 0);
        //$colorActivity = imagecolorallocate($canvas, 255, 125, 125);
        $colorActivity = imagecolorallocate($canvas, 255, 175, 50);
        //$colorActivity = imagecolorallocate($canvas, 255, 125, 125);
        for ($line = 0; $line < count($finalPixel); $line++)
        {
          for ($row = 0; $row < count($finalPixel[$line]); $row++)
          {
            if ($finalPixel[$line][$row] === 1)
            {
              imagesetpixel ($canvas, $row + 10, $line + 10, $colorItem);
            }
            else if ($finalPixel[$line][$row] === 255)
            {
              imagesetpixel ($canvas, $row + 10, $line + 10, $colorActivity);
            }
          }
        }
      }
    }
    
    private function getZWaveDeviceData()
    {
      if ($this->ZWaySimulation) // simulation for demo
      {
        $result = array();
        
        // temperature
        $object = new \stdClass();
        $object->id = 'temp_indoor_1';
        $innerObject = new \stdClass();
        $innerObject->level = 18.3;
        $innerObject->scaleTitle = '°C';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'temp_indoor_2';
        $innerObject = new \stdClass();
        $innerObject->level = 21.0;
        $innerObject->scaleTitle = '°C';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'temp_indoor_3';
        $innerObject = new \stdClass();
        $innerObject->level = 20.5;
        $innerObject->scaleTitle = '°C';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'temp_indoor_4';
        $innerObject = new \stdClass();
        $innerObject->level = 21.2;
        $innerObject->scaleTitle = '°C';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'temp_outdoor';
        $innerObject = new \stdClass();
        $innerObject->level = 15.7;
        $innerObject->scaleTitle = '°C';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        // power consumption
        
        $object = new \stdClass();
        $object->id = 'indoor_power_1';
        $innerObject = new \stdClass();
        $innerObject->level = 0.5;
        $innerObject->scaleTitle = 'W';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_power_2';
        $innerObject = new \stdClass();
        $innerObject->level = 10.7;
        $innerObject->scaleTitle = 'W';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_power_3';
        $innerObject = new \stdClass();
        $innerObject->level = 132.4;
        $innerObject->scaleTitle = 'W';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        // brightness
        
        $object = new \stdClass();
        $object->id = 'indoor_brightness_1';
        $innerObject = new \stdClass();
        $innerObject->level = 250;
        $innerObject->scaleTitle = 'Lux';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_brightness_2';
        $innerObject = new \stdClass();
        $innerObject->level = 44;
        $innerObject->scaleTitle = 'Lux';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_brightness_3';
        $innerObject = new \stdClass();
        $innerObject->level = 63;
        $innerObject->scaleTitle = 'Lux';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_brightness_4';
        $innerObject = new \stdClass();
        $innerObject->level = 0;
        $innerObject->scaleTitle = 'Lux';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'outdoor_brightness';
        $innerObject = new \stdClass();
        $innerObject->level = 519;
        $innerObject->scaleTitle = 'Lux';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        // humidity
        
        $object = new \stdClass();
        $object->id = 'indoor_humidity_1';
        $innerObject = new \stdClass();
        $innerObject->level = 44;
        $innerObject->scaleTitle = '%';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_humidity_2';
        $innerObject = new \stdClass();
        $innerObject->level = 44;
        $innerObject->scaleTitle = '%';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_humidity_3';
        $innerObject = new \stdClass();
        $innerObject->level = 41;
        $innerObject->scaleTitle = '%';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'indoor_humidity_4';
        $innerObject = new \stdClass();
        $innerObject->level = 44;
        $innerObject->scaleTitle = '%';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'outdoor_humidity';
        $innerObject = new \stdClass();
        $innerObject->level = 42;
        $innerObject->scaleTitle = '%';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        // door and window sensors
        
        $object = new \stdClass();
        $object->id = 'window_open';
        $innerObject = new \stdClass();
        $innerObject->level = 'on';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'window_closed';
        $innerObject = new \stdClass();
        $innerObject->level = 'off';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'door_open';
        $innerObject = new \stdClass();
        $innerObject->level = 'on';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'door_closed';
        $innerObject = new \stdClass();
        $innerObject->level = 'off';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        // light
        
        $object = new \stdClass();
        $object->id = 'light_on';
        $innerObject = new \stdClass();
        $innerObject->level = 'on';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'light_off';
        $innerObject = new \stdClass();
        $innerObject->level = 'off';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        // wall plug
        
        $object = new \stdClass();
        $object->id = 'wallplug_on';
        $innerObject = new \stdClass();
        $innerObject->level = 'on';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        $object = new \stdClass();
        $object->id = 'wallplug_off';
        $innerObject = new \stdClass();
        $innerObject->level = 'off';
        $object->metrics = $innerObject;
        $result[] = $object;
        
        /*
        $object = new \stdClass();
        $object->id = 'demosensor';
        $innerObject = new \stdClass();
        $innerObject->level = 18.3;
        $innerObject->scaleTitle = '°C';
        $object->metrics = $innerObject;
        $result[] = $object;
        */
        return $result;
      }
      else // real data
      {
        // data request from Z-Wave System
        $aHTTP['http']['method'] = 'GET';
        $aHTTP['http']['header'] = "User-Agent: Zmart Floor Plan API Call\r\nConnection: close\r\n";
        $aHTTP['http']['header'] .= "Authorization: Basic " . base64_encode($this->ZWayUserName . ":" . $this->ZWayUserPassword);
        $aHTTP['http']['timeout'] = 1.0;
        $context = stream_context_create($aHTTP);
        $content = file_get_contents($this->ZWayDeviceListUrl, false, $context); // Send the Request
        // can https://stackoverflow.com/questions/18187419/get-file-contents-when-connection-is-keep-alive help with the fixed keep-alive in z-way?
        //$ResponseHeaders = $http_response_header;
        $decoded = json_decode($content);
        return $decoded->data->devices;
      }
    }
    
    
    private function getPixelElementDrawing(\ZmartFloorPlan\Elements\Element $element)
    {
      switch (strtolower($element->Type))
      {
        case 'wallplug':
          return new \ZmartFloorPlan\Drawing\Elements\WallPlug();
          break;
        case 'thermostat':
          return new \ZmartFloorPlan\Drawing\Elements\Thermostat();
          break;
        case 'openclose':
          return new \ZmartFloorPlan\Drawing\Elements\OpenCloseSensor();
          break;
        case 'heater':
          return new \ZmartFloorPlan\Drawing\Elements\WallHeater($element->Width);
          break;
        case 'door':
          return new \ZmartFloorPlan\Drawing\Elements\Door($element->Width, $element->OpenDirection);
          break;
        case 'opening':
          return new \ZmartFloorPlan\Drawing\Elements\Opening($element->Width, $element->WallSize);
          break;
        case 'firealarm':
          return new \ZmartFloorPlan\Drawing\Elements\FireDetector();
          break;
        case 'flood':
          return new \ZmartFloorPlan\Drawing\Elements\FloodSensor();
          break;
        case 'sensor':
          return new \ZmartFloorPlan\Drawing\Elements\GenericSensor();
          break;
        case 'window':
          return new \ZmartFloorPlan\Drawing\Elements\Window($element->Width, $element->WallSize, $element->OpenDirection);
          break;
        case 'ceilinglight':
          return new \ZmartFloorPlan\Drawing\Elements\CeilingLight();
          break;
        case 'windowblinds':
          return new \ZmartFloorPlan\Drawing\Elements\WindowBlinds($element->Width);
          break;
      }
    }
    
    private function drawRoom($canvas, \ZmartFloorPlan\Elements\Room $room)
    {
      // base / walls
      imagefilledrectangle($canvas
                  ,$room->LocationLeft
                  ,$room->LocationTop
                  ,$room->LocationLeft + $room->RoomWidth
                  ,$room->LocationTop + $room->RoomHeight
                  ,imagecolorallocate($canvas, $room->ColorWall[0], $room->ColorWall[1], $room->ColorWall[2])
                );
      //floor in room
      imagefilledrectangle($canvas
                  ,$room->LocationLeft + $room->WallThicknessLeft
                  ,$room->LocationTop + $room->WallThicknessTop
                  ,$room->LocationLeft + $room->RoomWidth - $room->WallThicknessRight
                  ,$room->LocationTop + $room->RoomHeight - $room->WallThicknessBottom
                  ,imagecolorallocate($canvas, $room->ColorFloor[0], $room->ColorFloor[1], $room->ColorFloor[2])
                );
      foreach ($room->Elements as &$element)
      {
        $this->drawElement($canvas, $room, $element);
      }
    }
    
    private function getElementSize(\ZmartFloorPlan\Elements\Element $element)
    {
      $elementHeight = -1;
      $elementWidth = -1;
      if ($element->Type == 'text')
      {
        $bbox = imagettfbbox($this->FontSize, 0, $this->FontFile, $element->DisplayText);
        $elementWidth = $bbox[3] - $bbox[7];
        $elementHeight = $bbox[2] - $bbox[6];
      }
      else
      {
        $tmpElement = $this->getPixelElementDrawing($element);
        if ($tmpElement != null)
        {
          $elementHeight = $tmpElement->Height;
          $elementWidth = $tmpElement->Width;
        }
      }
      return array('width' => $elementWidth, 'height' => $elementHeight);
    }
    
    private function getLabelTextAlign(\ZmartFloorPlan\Elements\Element $element)
    {
      $mountWall = strtolower($element->MountWall);
      if ($element->TextAlign != 'default')
      {
        $textAlign = $element->TextAlign;
      }
      else
      {
        if ($mountWall == 'top' || $mountWall == 'left')
        {
          $textAlign = 'left';
        }
        else
        {
          $textAlign = 'right';
        }
      }
      return $textAlign;
    }
    
    private function drawElement($canvas, \ZmartFloorPlan\Elements\Room $room, \ZmartFloorPlan\Elements\Element $element)
    {
      // get element type (for height + width)
      $mountWall = strtolower($element->MountWall);
      $elementSize = $this->getElementSize($element);
      // ToDo: cancel somehow on invalid size
      
      if ($element->Type == 'text') // special calculation / assigning for text objects
      {
        $elementRealHeight = $elementSize['width'];
        $elementRealWidth = $elementSize['height'] - 1;
        $textAlign = $this->getLabelTextAlign($element);
      }
      else // regular calculation / assigning for pixel objects
      {
        // calculate real dimensions by orientation
        if ($mountWall == 'left' || $mountWall == 'right')
        {
          $elementRealHeight = $elementSize['width'];
          $elementRealWidth = $elementSize['height'];
        }
        else
        {
          $elementRealHeight = $elementSize['height'];
          $elementRealWidth = $elementSize['width'];
        }
      }
      
      // calculate room boundaries
      $boxLeft = $room->LocationLeft + $room->WallThicknessLeft;
      $boxTop = $room->LocationTop + $room->WallThicknessTop;
      $boxRight = $room->LocationLeft + $room->RoomWidth - $room->WallThicknessRight;
      $boxBottom = $room->LocationTop + $room->RoomHeight - $room->WallThicknessBottom;
      // init draw location for element
      $elementTopLocation = $boxTop;
      $elementLeftLocation = $boxLeft;
      
      // calculation varies by mount wall
      switch ($mountWall)
      {
        case 'top':
          $elementLeftLocation = $boxLeft + $element->LeftCornerDistance;
          $elementTopLocation = $boxTop + $element->WallDistance;
          break;
        case 'left':
          $elementLeftLocation = $boxLeft + $element->WallDistance;
          $elementTopLocation = $boxBottom - $element->LeftCornerDistance - ($elementRealHeight - 1) ;
          break;
        case 'right':
          $elementLeftLocation = $boxRight - $element->WallDistance - ($elementRealWidth - 1);
          $elementTopLocation = $boxTop + $element->LeftCornerDistance;
          break;
        case 'bottom':
          $elementLeftLocation = $boxRight - $element->LeftCornerDistance - ($elementRealWidth - 1) ;
          $elementTopLocation = $boxBottom - $element->WallDistance - ($elementRealHeight - 1) ;
          break;
      }
      // draw the element
      if (strtolower($element->Type) != 'text')
      {
        $this->drawPixelElement($canvas, $elementTopLocation, $elementLeftLocation, $element);
      }
      else
      {
        $this->drawText($canvas, $elementTopLocation, $elementLeftLocation, $element->DisplayText, $element->ItemColor, $textAlign);
      }
    }
    
    private function drawPixelElement($canvas, $top, $left, \ZmartFloorPlan\Elements\Element $element)
    {
      $mountWall = strtolower($element->MountWall);
      $colorItem = imagecolorallocate($canvas, $element->ItemColor[0], $element->ItemColor[1], $element->ItemColor[2]);
      $colorActivity = imagecolorallocate($canvas, $element->ActivityColor[0], $element->ActivityColor[1], $element->ActivityColor[2]);
      $img = $this->getPixelElementDrawing($element);

      if ($mountWall == 'top')
      {
        $finalPixel = $img->GetImagePixel(180);
      }
      else if ($mountWall == 'left')
      {
        $finalPixel = $img->GetImagePixel(90);
      }
      else if ($mountWall == 'right')
      {
        $finalPixel = $img->GetImagePixel(-90);
      }
      else if ($mountWall == 'bottom')
      {
        $finalPixel = $img->GetImagePixel(0);
      }
      else // invalid mount location
      {
        return;
      }
      
      for ($line = 0; $line < count($finalPixel); $line++)
      {
        for ($row = 0; $row < count($finalPixel[$line]); $row++)
        {
          if ($finalPixel[$line][$row] === 1)
          {
            imagesetpixel ($canvas, $row + $left, $line + $top, $colorItem);
          }
          else if ($finalPixel[$line][$row] === 255)
          {
            imagesetpixel ($canvas, $row + $left, $line + $top, $colorActivity);
          }
        }
      }
      
    }
    
    private function drawText($canvas, $top, $left, $text, $color, $align)
    {
      
      $bbox = imagettfbbox($this->FontSize, 0, $this->FontFile, $text);
      
      $elementWidth = $bbox[2] - $bbox[6];
      $elementHeight = $bbox[3] - $bbox[7];
      
      $colorItem = imagecolorallocate($canvas, $color[0], $color[1], $color[2]);
      if ($text != '')
      {
        switch ($align)
        {
          case 'left':
            imagettftext($canvas, $this->FontSize, 0, $left, $top + $elementHeight, $colorItem, $this->FontFile, $text);
            break;
          case 'center':
            imagettftext($canvas, $this->FontSize, 0, $left - ($elementWidth / 2), $top + $elementHeight, $colorItem, $this->FontFile, $text);
            break;
          case 'right':
            imagettftext($canvas, $this->FontSize, 0, $left , $top + $elementHeight, $colorItem, $this->FontFile, $text);
            break;
        }
      }
    }
  
    private function loadXmlFile($fileName)
    {
      if (file_exists($fileName)) {
        return simplexml_load_file($fileName);
      }
      return false;
    }
    
    private function loadDefinitionFromXml($xml)
    {
      $roomDefinition = array();
      foreach ($xml->room as $room)
      {
        //$tmpName
        $basicsIncomplete = false;
        if (!isset($room['name'])) // not defined
        {
          //echo 'missing room name';
          $basicsIncomplete = true;
        }
        // name found, can continue
        // location is required
        if (!isset($room->location)) // not defined
        {
          //echo 'missing location data<br />';
          $basicsIncomplete = true;
        }
        else // check for attributes
        {
          if (!isset($room->location['left']) || !isset($room->location['top']))
          {
            //echo 'missing location attribute<br />';
            $basicsIncomplete = true;
          }
        }
        // size is required
        if (!isset($room->size)) // not defined
        {
          //echo 'missing size data<br />';
          $basicsIncomplete = true;
        }
        else // check for attributes
        {
          if (!isset($room->size['width']) || !isset($room->size['height']))
          {
            //echo 'missing location attribute<br />';
            $basicsIncomplete = true;
          }
        }
        
        // required items checked
        if (!$basicsIncomplete)
        {
          $tmpRoom = new \ZmartFloorPlan\Elements\Room();
          // defaults
          $tmpRoom->Name = (string)$room['name'];
          $tmpRoom->LocationLeft = (int)$room->location['left'];
          $tmpRoom->LocationTop = (int)$room->location['top'];
          $tmpRoom->RoomHeight = (int)$room->size['height'];
          $tmpRoom->RoomWidth = (int)$room->size['width'];
          // colors
          if (isset($room->colors))
          {
            if (isset($room->colors['floor']))
            {
              $colFloor = $this->processColor($room->colors['floor']);
              if (count($colFloor) == 3)
              {
                //echo 'has valid floor color data<br />';
                $tmpRoom->ColorFloor = $colFloor;
              }
            }
            if (isset($room->colors['wall']))
            {
              $colWall = $this->processColor($room->colors['wall']);
              if (count($colWall) == 3)
              {
                //echo 'has valid wall color data<br />';
                $tmpRoom->ColorWall = $colWall;
              }
            }
              
            //echo 'has color data<br />';
          }
          // wall size
          if (isset($room->wallsize))
          {
            if (isset($room->wallsize['top']))
            {
              //echo 'has top wall size data<br />';
              $tmpRoom->WallThicknessTop = (int)$room->wallsize['top'];
            }
            if (isset($room->wallsize['left']))
            {
              $tmpRoom->WallThicknessLeft = (int)$room->wallsize['left'];
              //echo 'has left wall size data<br />';
            }
            if (isset($room->wallsize['right']))
            {
              $tmpRoom->WallThicknessRight = (int)$room->wallsize['right'];
              //echo 'has right wall size data<br />';
            }
            if (isset($room->wallsize['bottom']))
            {
              //echo 'has bottom wall size data<br />';
              $tmpRoom->WallThicknessBottom = (int)$room->wallsize['bottom'];
            }
          }
          // elements in room
          if (isset($room->elements))
          {
            // contains element items ?
            if (isset($room->elements->element))
            {
              foreach ($room->elements->element as $element)
              {
                $this->processElementData($element, $tmpRoom);
              }
            }
          }
          $roomDefinition[] = $tmpRoom;
        }
        
        
        //print_r($room);
        //echo '<br /> ------------------------ <br />';
      }
      $this->RoomDefinition = $roomDefinition;
    }
    
    
    
    private function processElementData($element, \ZmartFloorPlan\Elements\Room $elementParent)
    {
      //echo '+++++<br />';
      if (!isset($element['type']))
      {
        //echo 'missing element type';
      }
      else
      {
        $newElementObject = false;
        $validType = false;
        switch (strtolower((string)$element['type']))
        {
          case 'textlabel':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\TextLabel();
            $this->processItemTextLabelSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'timestamplabel':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\TimestampLabel();
            $this->processItemTextLabelSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'temperaturelabel':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\TemperatureLabel();
            $this->processItemTextLabelSpecialFields($element, $newElementObject);
            $this->processItemNumericLabelSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'powerlabel':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\PowerLabel();
            $this->processItemTextLabelSpecialFields($element, $newElementObject);
            $this->processItemNumericLabelSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'brightnesslabel':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\BrightnessLabel();
            $this->processItemTextLabelSpecialFields($element, $newElementObject);
            $this->processItemNumericLabelSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'humiditylabel':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\HumidityLabel();
            $this->processItemTextLabelSpecialFields($element, $newElementObject);
            $this->processItemNumericLabelSpecialFields($element, $newElementObject);
            $this->processItemHumidityLabelSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'door':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\Door();
            $this->processItemDoorSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'opening':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\Opening();
            $this->processItemOpeningSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'window':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\Window();
            $this->processItemWindowSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'windowblinds':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\WindowBlinds();
            $this->processItemWindowBlindsSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'heater':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\Heater();
            $this->processItemHeaterSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'wallplug':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\WallPlug();
            $this->processItemOnOffStateSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'ceilinglight':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\CeilingLight();
            $this->processItemOnOffStateSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'thermostat':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\Thermostat();
            $validType = true;
            break;
          case 'openclosesensor':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\OpenCloseSensor();
            $this->processItemOpenCloseStateSpecialFields($element, $newElementObject);
            $validType = true;
            break;
          case 'firedetector':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\FireDetector();
            $validType = true;
            break;
          case 'genericsensor':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\GenericSensor();
            $validType = true;
            break;
          case 'floodsensor':
            $newElementObject = new \ZmartFloorPlan\Elements\Item\FloodSensor();
            $validType = true;
            break;
        }
        if ($validType)
        {
          $base = $this->processElementBaseProperties($element, $newElementObject);
          if ($base)
          {
            //echo (string)$element['type'] . '<br />';
            $elementParent->Elements[] = $newElementObject;
          }
        }
      }
      //echo '+---+<br />';
      //echo '<br />+---+<br />';
      //
    }
    
    private function processElementBaseProperties($element, $object)
    {
      if (!isset($element['name']))
      {
        //echo 'missing element name';
        return false;
      }
      $validWall = false;
      switch (strtolower($element['wall']))
      {
        case 'top':
          $validWall = true;
          break;
        case 'left':
          $validWall = true;
          break;
        case 'right':
          $validWall = true;
          break;
        case 'bottom':
          $validWall = true;
          break;
      }
      if (!$validWall)
      {
        //echo 'invalid mount wall';
        return false;
      }
      // required fields available
      $object->Name = (string)$element['name'];
      $object->MountWall = (string)$element['wall'];
      if (isset($element->position))
      {
        if (isset($element->position['fromleft']))
        {
          //echo $element->position['fromleft'] . '<br />';
          $object->LeftCornerDistance = (int)$element->position['fromleft'];
        }
        if (isset($element->position['distance']))
        {
          //echo $element->position['distance'] . '<br />';
          $object->WallDistance = (int)$element->position['distance'];
        }
      }
      if (isset($element->colors))
      {
        if (isset($element->colors['item']))
        {
          $colItem = $this->processColor($element->colors['item']);
          if (count($colItem) == 3)
          {
            //echo 'has valid item color data<br />';
            $object->ItemColor = $colItem;
          }
        }
        if (isset($element->colors['highlight']))
        {
          $colHighlight = $this->processColor($element->colors['highlight']);
          if (count($colHighlight) == 3)
          {
            //echo 'has valid highlight color data<br />';
            $object->ActivityColor = $colHighlight;
          }
        }
        
      }
      if (isset($element->automation))
      {
        $dataSource = 'zway';
        if (isset($element->automation['source'])) {
          // ToDo: make this filtered to possible valid sources only ?
          $dataSource = $element->automation['source'];
        }
        $object->AutomationDataSource = $dataSource;
        if (isset($element->automation['active']))
        {
          if ((string)$element->automation['active'] == '1' || strtolower((string)$element->automation['active']) == 'true')
          {
            // not all automation elements need a device name (e.g. internal ones), so save that setting already
            $object->HasAutomation = true;
            if (isset($element->automation['devicename']))
            {
              $object->AutomationName = (string)$element->automation['devicename'];
            }
          }
        }
      }
      
      return true;
    }
    
    private function processItemDoorSpecialFields($element, $object)
    {
      if (isset($element->door))
      {
        if (isset($element->door['width']))
        {
          $object->Width = (int)$element->door['width'];
        }
        if (isset($element->door['opendirection']))
        {
          $object->OpenDirection = (string)$element->door['opendirection'];
        }
      }
    }
    
    private function processItemOpeningSpecialFields($element, $object) {
      if (isset($element->opening))
      {
        if (isset($element->opening['width']))
        {
          $object->Width = (int)$element->opening['width'];
        }
        if (isset($element->opening['wallsize']))
        {
          $object->WallSize = (int)$element->opening['wallsize'];
        }
      }

    }

    private function processItemWindowSpecialFields($element, $object)
    {
      if (isset($element->window))
      {
        if (isset($element->window['width']))
        {
          $object->Width = (int)$element->window['width'];
        }
        if (isset($element->window['opendirection']))
        {
          $object->OpenDirection = (string)$element->window['opendirection'];
        }
        if (isset($element->window['wallsize']))
        {
          $object->WallSize = (int)$element->window['wallsize'];
        }
      }
    }
    
    private function processItemTextLabelSpecialFields($element, $object)
    {
      if (isset($element->text))
      {
        if (isset($element->text['align']))
        {
          $object->TextAlign = (string)$element->text['align'];
        }
        if (isset($element->text['value']))
        {
          $object->DisplayText = (string)$element->text['value'];
        }
      }
    }

    private function processItemNumericLabelSpecialFields($element, $object)
    {
      if (isset($element->text))
      {
        if (isset($element->text['decimal']))
        {
          $object->DecimalPlaces = (string)$element->text['decimal'];
        }
      }
    }
    
    private function processItemHumidityLabelSpecialFields($element, $object)
    {
      if (isset($element->text))
      {
        if (isset($element->text['suffix']))
        {
          $object->SuffixText = (string)$element->text['suffix'];
        }
      }
    }
    
    private function processItemWindowBlindsSpecialFields($element, $object)
    {
      if (isset($element->blinds))
      {
        if (isset($element->blinds['width']))
        {
          $object->Width = (int)$element->blinds['width'];
        }
      }
    }
    
    private function processItemHeaterSpecialFields($element, $object)
    {
      if (isset($element->heater))
      {
        if (isset($element->heater['width']))
        {
          $object->Width = (int)$element->heater['width'];
        }
      }
    }
    
    private function processItemOnOffStateSpecialFields($element, $object)
    {
      if (isset($element->colors))
      {
        if (isset($element->colors['on']))
        {
          $colItem = $this->processColor($element->colors['on']);
          if (count($colItem) == 3)
          {
            $object->OnColor = $colItem;
          }
        }
        if (isset($element->colors['off']))
        {
          $colHighlight = $this->processColor($element->colors['off']);
          if (count($colHighlight) == 3)
          {
            $object->OffColor = $colHighlight;
          }
        }
      }
    }
    
    private function processItemOpenCloseStateSpecialFields($element, $object)
    {
      if (isset($element->colors))
      {
        if (isset($element->colors['open']))
        {
          $colItem = $this->processColor($element->colors['open']);
          if (count($colItem) == 3)
          {
            $object->OpenColor = $colItem;
          }
        }
        if (isset($element->colors['closed']))
        {
          $colHighlight = $this->processColor($element->colors['closed']);
          if (count($colHighlight) == 3)
          {
            $object->CloseColor = $colHighlight;
          }
        }
      }
    }
    
    
    /*
    
    private function processItemXxxxxxxSpecialFields($element, $object)
    {
      if (isset($element->yyy))
      {
        if (isset($element->yyy['xxx']))
        {
          $object->xxx = (int)$element->yyy['xxx'];
        }
      }
    }
    
    */
    
    private function processColor($data)
    {
      $result = array();
      $pos = strpos($data, ',');
      $splitChar = '';
      if ($pos === false)
      {
        $pos = strpos($data, ';');
        if ($pos === false)
        {
          $pos = strpos($data, '#');
          if ($pos === 0 && strlen($data) == 7) // found at start and 7 chars long
          {
            $splitChar = '#'; // assuming html color
          }
        }
        else // ; detected
        {
          $splitChar = ';';
        }
      }
      else // , detected
      {
        $splitChar = ',';
      }
      // if valid split char was detected start processing
      if ($splitChar != '')
      {
        if ($splitChar == '#') // html color
        {
          $r = substr($data, 1, 2);
          $g = substr($data, 3, 2);
          $b = substr($data, 5, 2);
          $result = array(hexdec($r), hexdec($g), hexdec($b));
        }
        else // array of 3 color values assumed
        {
          $tmpSplit = explode($splitChar, $data);
          if (count($tmpSplit) == 3)
          {
            if (($tmpSplit[0] >= 0 && $tmpSplit[0] <= 255) && ($tmpSplit[1] >= 0 && $tmpSplit[1] <= 255) && ($tmpSplit[2] >= 0 && $tmpSplit[2] <= 255))
            {
              $result = $tmpSplit;
            }
          }
        }
      }
      
      return $result;
    }

  }
}