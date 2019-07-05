# Kirby Colors

Colors is a field for Kirby 3 that allows the selection of a color using the native color selector. Colors can be viewed and edited in either HEX, RGB or HSL.

Additionally, the field offers the automatic selection of the most contrasty color from a given list. This can be useful, if you'd like to specify per page background colors and would like to adjust the text colors accordingly. The field displays the color contrast ratings AA, AALarge, AAA and AAALarge according to WCAG accessibility guidelines.

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

## Setup

_Additional instructions on how to configure the plugin (e.g. blueprint setup, config options, etc.)_

## Options

_Document the options and APIs that this plugin offers_

## Development

_Add instructions on how to help working on the plugin (e.g. npm setup, Composer dev dependencies, etc.)_

## License

MIT, [see license](https://github.com/hananils/kirby-colors/blob/master/LICENSE)

## Credits

Thanks to [Brian Grinstead](https://briangrinstead.com/) and [Scott Cooper](https://github.com/scttcper) for providing the [TinyColor library](https://github.com/TypeCtrl/tinycolor).
