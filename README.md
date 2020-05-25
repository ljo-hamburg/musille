# Musille

Musille is a WordPress theme used by the [LJO Hamburg](https://ljo-hamburg.de).

## Installation

### Installation via GitHub Updater

The easiest way to install this theme is to use [GitHub Updater](https://github.com/afragen/github-updater). Using the plugin you can go to Settings → GitHub Updater and select “Install Theme” from there. Enter the following data:

```
Theme URI: https://github.com/ljo-hamburg/musille
Repository-Branch: release
Remote Repository Host: GitHub
GitHub Access Token: <Your Access Token> (optional)
```

Note that you **must not** use the `master` branch for installation. The master branch contains the development files which must be compiled in order to yield an installable theme. Instead you can choose between the following branches for installation:

- `release`: The latest stable release.
- `pre-release`: The latest pre-release.
- `testing`: The latest build corresponding to the `master` branch. Note that while you should be able to use this version of the theme it is not considered stable and may contain severe bugs. Use this only for testing purposes, never in production.

### Manual Installation

Go to [Releases](https://github.com/ljo-hamburg/musille/releases) and downlaod the theme from the latest release. Install it in WordPress by going to the administration console and selecting Design →. Themes. There you can upload and install the theme.

## User Guide

The rest of this document is primarily concerned with information that is relevant for developers. See the WordPress [`readme.txt`](https://github.com/ljo-hamburg/musille/blob/master/theme/readme.txt.ejs) for more information about using the theme.

