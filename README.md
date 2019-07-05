# Kirby Colors

Colors is a field for Kirby 3 that allows the selection of a color using the native color selector. Colors can be viewed and edited in either HEX, RGB or HSL. Additionally, the field automatically calculates the most readable contrast color. This can be useful, if you'd like to specify background colors and would like to adjust the text colors accordingly. The field displays the color contrast ratings AA, AALarge, AAA and AAALarge according to WCAG accessibility guidelines.

## Installation

### Download

Download and copy this repository to `/site/plugins/colors`.

### Git submodule

```
git submodule add https://github.com/hananils/kirby-colors.git site/plugins/colors
```

### Composer

```
composer require hananils/kirby-colors
```

## Blueprint

This field is provided under the type `colors`:

-   `alpha`: allows you to enable or disable the opacity widget, either `true` or `false`.
-   `contrast`: allows you to enable or disable the contrast widget that calculated the most readable contrast color, either `true` or `false` or an array of colors the plugin should choose from.
-   `default`: the color to be used as default, either in hex3, hex6, hex8, rgb, rgba, hsl or hsla.

### Examples

```yml
colors:
    type: colors
    label: Colors
```

```yml
colors:
    type: colors
    label: Colors (alpha)
    alpha: true
```

```yml
colors:
    type: colors
    label: Colors (alpha + readable)
    alpha: true
    contrast: true
```

```yml
colors:
    type: colors
    label: Colors (readable)
    contrast:
        - '#112233'
        - '#778899'
```

## Field Methods

-   `$field->isHex()`: wheather the color is stored as hexadecimal value, return `true` or `false`.
-   `$field->isRgb()`: wheather the color is stored as RGB value, return `true` or `false`.
-   `$field->isHsl()`: wheather the color is stored as HSL value, return `true` or `false`.
-   `$field->toColors()`: returns the chosen color and the readable color.
-   `$field->toColor()`: returns the chosen color.
-   `$field->toReadableColor()`: returns the readable color.

## Development

This plugin is based on the official [Kirby plugin kit](https://github.com/getkirby/pluginkit/tree/4-panel).

## Alternatives

Please note that there is another color field for Kirby 3 developed by Tim Ötting called Kirby Color, see <https://github.com/TimOetting/kirby-color>. There is also an extended fork of the same plugin maintained by Sylvain Julé at <https://github.com/sylvainjule/kirby-color>.

## License

MIT, [see license](https://github.com/hananils/kirby-colors/blob/master/LICENSE)

## Credits

Thanks to [Brian Grinstead](https://briangrinstead.com/) and [Scott Cooper](https://github.com/scttcper) for providing the [TinyColor library](https://github.com/TypeCtrl/tinycolor).
