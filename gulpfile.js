const { src, dest, series, parallel, lastRun, watch } = require("gulp");
const sourcemaps = require("gulp-sourcemaps");
const sass = require("gulp-sass");
const postcss = require("gulp-postcss");
const babel = require("gulp-babel");

sass.compiler = require("dart-sass");

function legacyCode() {
  return src(["lucille/**/*"], { since: lastRun(legacyCode) }).pipe(
    dest("build")
  );
}

function copyVendorFiles() {
  return src("vendor/**/*", { since: lastRun(copyVendorFiles) }).pipe(
    dest("build/vendor")
  );
}

function copyIncludes() {
  return src("includes/**/*", { since: lastRun(copyIncludes) }).pipe(
    dest("build/includes")
  );
}

function copyTemplates() {
  return src("templates/**/*", { since: lastRun(copyTemplates) }).pipe(
    dest("build")
  );
}

function copyViews() {
  return src("views/**/*", { since: lastRun(copyViews) }).pipe(
    dest("build/views")
  );
}

function copyThemeFiles() {
  return src(["functions.php", "screenshot.png", "readme.txt"], {
    since: lastRun(copyThemeFiles),
  }).pipe(dest("build"));
}

function compileScripts() {
  return src(["scripts/*.js"], { since: lastRun(compileScripts) })
    .pipe(babel({ presets: ["@babel/env"] }))
    .pipe(dest("build"));
}

function buildStyles() {
  // We don't minify styles as it makes for a bad user experience when
  // opening the theme editor. A wordpress plugin may be used to minify
  // css and JS resources.
  return src(["styles/*.scss", "!styles/_*.scss"])
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: "expanded" }).on("error", sass.logError))
    .pipe(postcss([require("autoprefixer")]))
    .pipe(sourcemaps.write("."))
    .pipe(dest("build"));
}

function serve() {
  watch("includes/**/*", copyIncludes);
  watch("templates/**/*", copyTemplates);
  watch("views/**/*", copyViews);
  watch("scripts/**/*", compileScripts);
  watch("styles/**/*.scss", buildStyles);
}

exports.default = series(
  legacyCode,
  parallel(
    copyVendorFiles,
    copyIncludes,
    copyTemplates,
    copyViews,
    compileScripts,
    copyThemeFiles,
    buildStyles
  )
);
exports.watch = serve;
