const { src, dest, series, parallel } = require("gulp");
const clean = require("gulp-clean");

// TODO: Linting task, either here or in NPM

function cleanBuild() {
  return src(["build/*"], { read: false }).pipe(clean());
}

function legacyCode() {
  return src(["lucille/**/*"]).pipe(dest("build"));
}

function copyVendorFiles() {
  return src("vendor/**/*").pipe(dest("build/vendor"));
}

function copyIncludes() {
  return src("includes/**/*").pipe(dest("build/includes"));
}

function copyTemplates() {
  return src("templates/**/*").pipe(dest("build"));
}

function copyViews() {
  return src("views/**/*").pipe(dest("build/views"));
}

function copyThemeFiles() {
  return src(["functions.php", "screenshot.png", "readme.txt"]).pipe(
    dest("build")
  );
}

exports.clean = cleanBuild;
exports.build = series(
  cleanBuild,
  legacyCode,
  parallel(
    copyVendorFiles,
    copyIncludes,
    copyTemplates,
    copyViews,
    copyThemeFiles
  )
);
exports.default = exports.build;
