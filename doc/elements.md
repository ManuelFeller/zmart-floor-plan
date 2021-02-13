# Available Elements

This document lists all elements that can be drawn by the script.

## Room

The room is the basic element to have. I is currently the only allowed child for the `<roomplan>` tag in the XML that describes the floor plan.
It basically defines a rectangle and the borders that should be drawn around it.

It was originally thought to be "just" a room, but you can also draw pathways, property-boundaries and everything lese that you can create out of rectangles.

It is the element that holds all child elements (passive elements, labels, sensors, actors) that should be part of it, and all sub-elements move relative to it when you change the position in the image.

### Example XML

```xml
<room name="NAME FOR THE ELEMENT">
  <location left="0" top="0" />
  <size width="100" height="100" />
  <colors floor="255,255,255" wall="0,0,0" />
  <wallsize top="2" left="2" right="2" bottom="2" />
  <elements>
    ...
  </elements>
</room>
```

### (Sub-)Tag Description

| Tag | Attribute | Value / Type | Description |
|-----|-----------|--------------|-------------|
| `<room>` | `name` | string | Just a field that you can use to note down what this element represents |
| `<location />` | `left` | integer | How many pixels from the left side of the generated image should the drawing of the rectangle start |
| `<location />` | `top` | integer | How many pixels from the top side of the generated image should the drawing of the rectangle start |
| `<size />` | `width` | integer | How many pixels wide should the rectangle be in the generated image |
| `<size />` | `height` | integer | How many pixels high should the rectangle be in the generated image |
| `<colors />` | `floor` | rgb string | What color should the rectangle be filled with |
| `<colors />` | `wall` | rgb string | What color should the borders of the rectangle have |
| `<wallsize />` | `top` | integer | The thickness of the wall (rectangle border) on the top side in pixels |
| `<wallsize />` | `left` | integer | The thickness of the wall (rectangle border) on the left side in pixels |
| `<wallsize />` | `right` | integer | The thickness of the wall (rectangle border) on the right side in pixels |
| `<wallsize />` | `bottom` | integer | The thickness of the wall (rectangle border) on the bottom side in pixels |
| `<elements>` | - | - | This element contains the child elements that are part of the room |










## Copy Template for more content

### Example XML

```xml
...
```

### (Sub-)Tag Description

| Tag | Attribute | Value / Type | Description |
|-----|-----------|--------------|-------------|
| x | x | x | x |