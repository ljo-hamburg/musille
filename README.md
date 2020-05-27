# Musille

![Build](https://github.com/ljo-hamburg/musille/workflows/Build/badge.svg)
![Lint](https://github.com/ljo-hamburg/musille/workflows/Lint/badge.svg)

Musille is a WordPress theme used by the [LJO Hamburg](https://ljo-hamburg.de).

## Installation

Go to [Releases](https://github.com/ljo-hamburg/musille/releases) and downlaod the latest version of the theme. Install it via the WordPress admin. If you are usure how to install the theme see [this help page](https://wordpress.org/support/article/using-themes/#adding-new-themes) for more information.

The theme supports auto update functionality via [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker). This functionality is enabled by default.

## Comments

The Musille theme **does not support comments**. Although it does nothing to prevent wordpress from using comment functionality, neither comments nor a comment form are included in the theme at the moment.

It is recommended that you use a plugin such as [Disable Comments](https://wordpress.org/plugins/disable-comments/) to completely hide the comments functionality from your site.

## Development

### Installing the Dependencies

In order to develop the theme you need [Node.js](https://nodejs.org/en/) and [Composer](https://getcomposer.org). You also need [Gnu `gettext`](https://www.gnu.org/software/gettext/) to compile translations. To get startet run the following commands:

```shell
npm install
composer install
```

This will install all dependencies required to build the theme.

### Building the Theme

The theme provides several npm scripts that can be used to accomplish common tasks. Building the theme is as easy as

```shell
npm run build
```

This will simply execute `gulp` which is used as a build system. Gulp will then compile the theme into a `build` folder.

The command above will compile a production version of the theme. In development you likely want additional features (such as the development autoloader). To compile the theme for development run

```shell
npm run build-dev
```

The theme will be built into the `build` folder. The `build` folder can then be mounted inside a docker container or VM or be symlinked to a WordPress installation in the `themes` folder.

In development you can automatically recompile if you change a file. To do so run

```shell
npm run watch
```

This will watch most of the development files and recompile them if any changes are detected. Note that the dependencies in `composer.json` and `package.json` are not watched. If you change any of those you need to manually trigger a rebuild using `npm run build-dev`.

The `build` directory is not automatically cleaned. Existing files are overridden but orphaned files are not deleted. If you want to clean the `build` directory just run `npm run clean`.

### Creating Translations

The Theme is completely translation-ready. Translations are compiled from the `languages` folder automatically. If you want to add a new translatable strings be sure to run

```shell
npm run gettext
```

afterwards to update the translation files to reflect the updated code. Note that the gettext utility needs to be installed separately.

### Linting the Code

To check the code for style violations run

```shell
npm run lint
```

Alternatively you can lint only a part of the code using one of the following:

```shell
npm run lint:php
npm run lint:js
npm run lint:scss
```

