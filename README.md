# Content Elements

A collection of Content Elements used by Joomla! X (Pythagoras)
based on the proposed [Joomla! specification for Content Elements][content-elements] v0.2.1.

[content-elements]: https://github.com/nibra/joomla-standards/blob/master/proposed/content-elements.md

## Usage

To use the Content Elements in your project, enter

    $ composer require nibra/content-elements
    
in the console.

## Documentation

The documentation in the `docs` directory is generated from the sources.

[Read the documentation](docs/index.md)

## Build environment

Some Composer scripts are provided to make life a bit easier.

- `composer docs` - Generate the documentation for the Content Elements
- `composer icons` - Generate the icons for the Content Elements from SVG files
- `composer pull` - Pull the latest version of `joomla-standards-contenttypes`

## Tests

To run the tests, just enter

    $ phpunit

## License

[MIT License](LICENSE)
