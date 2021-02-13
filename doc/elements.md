# Available Elements

This document lists all elements that can be drawn by the script.

## Room

The room is the basic element to use for all "areas" in your smarthome. I is currently the only allowed child for the `<roomplan>` tag in the XML that describes the floor plan.
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

---

## Architecture Elements

Architecture elements are the ones that are fully passive (for now). They are used to represent certain things that every home and are commonly found on floor plan drawings (e.g. doors, windows, ...).

All these elements need to be a child of a `<elements>` tag that is within a `<room>` tag!

---
### Door

This element represents a door. It always opens into the room it is assigned to, but you can choose if it opens to the left side or the right side.

If you need the door to open to the outside of a room you need to assign the door to the room (or area) it opens into...

#### Example XML

```xml
<element name="Door" type="door" wall="left">
  <position fromleft="50" distance="-1" />
  <colors item="100,100,100"/>
  <door width="40" opendirection="right" />
</element>
```

#### (Sub-)Tag Description

| Tag | Attribute | Value / Type | Description |
|-----|-----------|--------------|-------------|
| `<element>` | `name` | string | Just a field that you can use to note down what this element represents |
| `<element>` | `type` | `door` | This defines that the element represents a door |
| `<element>` | `wall` | `left`, `right`, `top` or `bottom` | This defines to which wall of the containing room the item should be "attached" to |
| `<position />` | `fromleft` | integer | How many pixels from the start of the assigned wall should this item be located. (Its called `fromleft` because the drawing algorithm always considers you watching from the center of the room, facing the respective wall - I know, that may not have been the perfect choice...) |
| `<position />` | `distance` | integer | How many pixels from the away from the assigned wall should the element be drawn. You can use negative numbers to place the door in the wall, but make sure that the drawing order does not paint over it... |
| `<colors />` | `item` | rgb string | The color that should be used for drawing the door element |
| `<door />` | `width` | integer | The width (and also height) of the door in pixels |
| `<door />` | `opendirection` | `left` or `right` | The direction the door opens to (always seen from the center of the room that it is part of) |

---

### Window

This element represents a window. It is an element that is intended to be placed on (or in) a wall.

Unlike the door it does not show in which direction it will be opened as there are too many variations (open to inside or outside, swing open, slide open, tilt, ...) for now.  
Maybe - if I am bored - I add a visualization for the way a window opens one day in the future, there is already one (currently unused) parameter for that... ;-)

#### Example XML

```xml
<element name="Window" type="window" wall="top">
  <position fromleft="50" distance="-1" />
  <colors item="100,100,100"/>
  <door width="40" opendirection="right" />
</element>
```

#### (Sub-)Tag Description

| Tag | Attribute | Value / Type | Description |
|-----|-----------|--------------|-------------|
| `<element>` | `name` | string | Just a field that you can use to note down what this element represents |
| `<element>` | `type` | `window` | This defines that the element represents a window |
| `<element>` | `wall` | `left`, `right`, `top` or `bottom` | This defines to which wall of the containing room the item should be "attached" to |
| `<position />` | `fromleft` | integer | How many pixels from the start of the assigned wall should this item be located. (Its called `fromleft` because the drawing algorithm always considers you watching from the center of the room, facing the respective wall - I know, that may not have been the perfect choice...) |
| `<position />` | `distance` | integer | How many pixels from the away from the assigned wall should the element be drawn. You can use negative numbers to place the window in the wall, but make sure that the drawing order does not paint over it... |
| `<colors />` | `item` | rgb string | The color that should be used for drawing the window element |
| `<window />` | `width` | integer | The width of the window in pixels |
| `<window />` | `wallsize` | integer | Is used to define the height of the element (actual height is slightly bigger, but this way the element makes sure it is fully painting over the wall) |
| `<window />` | `opendirection` | `left` or `right` | **CURRENTLY UNUSED** - The direction the door opens to (always seen from the center of the room that it is part of) |

---

... more elements are planned ...

---

## Smarthome elements

Smarthome elements are the ones that have the possibility to change their state depending on the available smarthome data. This are labels (for things like temperature or humidity), sensors (open / close state, ...) or actors (switches, ...).

All these these elements need to be a child of a `<elements>` tag that is within a `<room>` tag!

---

... more details coming soon ...

---

## Copy Template for more content

#### Example XML

```xml
...
```

#### (Sub-)Tag Description

| Tag | Attribute | Value / Type | Description |
|-----|-----------|--------------|-------------|
| x | x | x | x |
