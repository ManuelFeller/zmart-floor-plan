<?php /* Zmart Floor Plan | usage demo | MIT License | By Manuel Feller, 2016 - 2021 */

// load Zmart Floor Plan class(es)
// -----------------------
// The file 'floorplan.php' (or how ever you might name it) contains everything you need to load.
// On the first creation of a new ImageGenerator class (contained in the file) it will load all required subscripts,
// so there is nothing more you have to do before you can start using it.
require_once 'floorplan.php';
//
// instanciate a new ImageGenerator, passing the directory names for the different subscripts
// (element definition and drawing functions)
// You can use the parameters to have "non-default" installation (may become helpfull in case I have missed some security things.
// Since the files that will be loaded are not located in a sub-directory everybody knows it may help to make automated attacks against those scripts much more effort.
$generator = new \ZmartFloorPlan\ImageGenerator('elements', 'drawing');
//
// Configure the image generator
//
// the API URL's for the Z-Wave data - uncomment (and - if needed - adjust) them if you have a running z-way server
//$generator->ZWayDeviceListUrl = 'http://127.0.0.1:8083/ZAutomation/api/v1/devices';
//$generator->ZWayLocationListUrl = 'http://127.0.0.1:8083/ZAutomation/api/v1/locations';
// the User and Password that should be used for the API calls
$generator->ZWayUserName = '!!!YourZWayUserName!!!';
$generator->ZWayUserPassword = '!!!YourZWayUserPassword!!!';
// activate Z-Wave data processing
$generator->ZWayActive = true;
// set simulator to have the virtual devices from the demo.xml
$generator->ZWaySimulation = true;
// the ttf font file that should be used for text
$generator->FontFile = 'fonts/Play-Regular.ttf'; // https://www.google.com/fonts/specimen/Play
// font size that should be used
$generator->FontSize = 9;
// size for the generated image
$generator->ImageWidth = 500;
$generator->ImageHeight = 470;
// offset for drawing
$generator->ImageTopOffset = 3;
$generator->ImageLeftOffset = 3;
//
// Load drawing (definition of rooms and elements) from xml file
$generator->LoadDefinitionFromXmlFile('demo.xml');
//
// Generate image and return it to the browser
$generator->GenerateImage();