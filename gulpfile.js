const { src, dest, series, parallel, lastRun } = require("gulp");

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

exports.default = series(
  legacyCode,
  parallel(
    copyVendorFiles,
    copyIncludes,
    copyTemplates,
    copyViews,
    copyThemeFiles
  )
);
