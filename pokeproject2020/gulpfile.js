"use strict";

var gulp = require("gulp");
var sass = require("gulp-sass");
var browserify = require("browserify");
var source = require("vinyl-source-stream");
var uglify = require("gulp-uglify");
var buffer = require("vinyl-buffer");
var minify = require("gulp-minify");
var cleanCSS = require("gulp-clean-css");

gulp.task("sass", function () {
    return (
        gulp
            .src("./assets/sass/**/*.scss")
            .pipe(
                sass({
                    includePaths: ["node_modules"],
                }).on("error", sass.logError)
            )
            // .pipe(cleanCSS())
            .pipe(gulp.dest("./webroot/css"))
    );
});

gulp.task("sass:watch", function () {
    gulp.watch("./assets/sass/*.scss", gulp.series("sass"));
});

gulp.task("browserify", function () {
    return browserify()
        .require(["jquery", "bootstrap"])
        .bundle()
        .pipe(source("vendor.js"))
        .pipe(buffer())
        .pipe(uglify())
        .pipe(minify())
        .pipe(gulp.dest("./webroot/js/"));
});

gulp.task("dev:watch", function () {
    gulp.watch("./assets/sass/**/*.scss", gulp.series("sass"));
});

gulp.task("build", gulp.series("sass", "browserify"));
