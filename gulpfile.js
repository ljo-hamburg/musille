const { src, dest, parallel, watch } = require("gulp");
const sourcemaps = require("gulp-sourcemaps");
const sass = require("gulp-sass");
const postcss = require("gulp-postcss");
const babel = require("gulp-babel");
const concat = require("gulp-concat");
const gulpWebpack = require("webpack-stream");
const webpack = require("webpack");
const named = require("vinyl-named");
const gulpif = require("gulp-if");
const ejs = require("gulp-ejs");
const rename = require("gulp-rename");

const production = process.env.NODE_ENV === "production";
const data = require("./package.json");
const composer = require("./composer.json");

sass.compiler = require("dart-sass");

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

function compileScripts() {
  return src("scripts/*.js")
    .pipe(sourcemaps.init())
    .pipe(babel())
    .pipe(concat("musille.js"))
    .pipe(sourcemaps.write("."))
    .pipe(dest("build"));
}

function buildBlocks() {
  return src("blocks/*.js")
    .pipe(named())
    .pipe(gulpWebpack(require("./webpack.config"), webpack))
    .pipe(dest("build/blocks"));
}

function buildStyles() {
  return src(["styles/*.scss", "!styles/_*.scss"])
    .pipe(sourcemaps.init())
    .pipe(
      sass({ outputStyle: production ? "compressed" : "expanded" }).on(
        "error",
        sass.logError
      )
    )
    .pipe(postcss([require("autoprefixer")]))
    .pipe(sourcemaps.write("."))
    .pipe(dest("build"));
}

function copyThemeFiles() {
  return src(["theme/*"])
    .pipe(gulpif(/.ejs$/, ejs({ data, composer })))
    .pipe(gulpif(/.ejs$/, rename({ extname: "" })))
    .pipe(dest("build"));
}

function serve() {
  watch("includes/**/*.php", copyIncludes);
  watch("templates/**/*.php", copyTemplates);
  watch("views/**/*.twig", copyViews);
  watch("scripts/**/*.js", compileScripts);
  watch("blocks/**/*.js", buildBlocks);
  watch("styles/**/*.scss", buildStyles);
}

exports.default = parallel(
  copyVendorFiles,
  copyIncludes,
  copyTemplates,
  copyViews,
  compileScripts,
  buildBlocks,
  buildStyles,
  copyThemeFiles
);
exports.watch = serve;
