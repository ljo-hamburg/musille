#!/usr/bin/env node

/**
 * This script synchronizes data from package.json to composer.json.
 */

const fs = require("fs");

const pkg = require("./package.json");

// Update composer.json
const composer = require("./composer.json");
composer.name = "ljo-hamburg/" + pkg.name;
composer.version = pkg.version;
composer.description = pkg.description;
composer.license = pkg.license;
const author = pkg.author.match(
  /^(?<name>.+?)\s*(<(?<email>.+?)>)?\s*(\((?<homepage>.+?)\))?$/
).groups;
composer.authors = [author];
fs.writeFileSync("composer.json", JSON.stringify(composer, null, 2));
