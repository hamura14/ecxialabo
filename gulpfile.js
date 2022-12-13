// gulpプラグインの読み込み
var { src, dest, watch } = require("gulp");
var sass = require('gulp-sass')(require('sass'));
var postcss = require("gulp-postcss");
var autoprefixer = require("autoprefixer");
var mqpacker = require("css-mqpacker");
var cssdeclsort = require("css-declaration-sorter");
var pug = require("gulp-pug");

// Sassをコンパイルする
const compileSass = () =>
  src("sass/*.scss")
    // Sassのコンパイルを実行
    .pipe(
      sass({
        outputStyle: "compressed",
      })
        // Sassのコンパイルエラーを表示
        // (これがないと自動的に止まってしまう)
        .on("error", sass.logError)
    )
    // sassの後に指定
    .pipe(postcss([cssdeclsort({ order: "smacss" })]))
    .pipe(postcss([autoprefixer()]))
    .pipe(postcss([mqpacker()]))
    // cssフォルダー以下に保存
    .pipe(dest("css"))

// Sassファイルを監視
const watchSassFiles = () =>
  watch("sass/*.scss", compileSass);

// pugをコンパイルする
const compilePug = () =>
  src("pug/*.pug")
    .pipe(
      pug({
        pretty: true
      })
    )
    .pipe(dest("./"));

// pugファイルを監視
const watchPugFiles = () =>
  watch("pug/*.pug", compilePug);

// npx gulpで実行される関数
exports.default = () =>
watchPugFiles();
watchSassFiles();
