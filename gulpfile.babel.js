/* eslint-disable no-undef */
import { src, dest, series, watch } from 'gulp';
import sass from 'gulp-sass';
import rename from 'gulp-rename';
import postcss from 'gulp-postcss';
import presetEnv from 'postcss-preset-env';

// added packages
import browserSync from 'browser-sync';
import util from 'util';
import fs from 'fs-extra';
import path from 'path';
import child_process from 'child_process';
import del from 'del';

let exec = util.promisify(child_process.exec);

const scss = () => {
  const plugins = [
    presetEnv({
      autoprefixer: {
        flexbox: 'no-2009',
      },
      stage: 3,
      features: {
        'custom-properties': false,
      },
    }),
  ];

  return src('./sass/style.scss')
    .pipe(sass())
    .pipe(postcss(plugins))
    .pipe(rename('style.css'))
    .pipe(dest('./', { overwrite: true }));
};

export const compress = async () => {
  // let date = new Date().toISOString().replace('T', ' ').substr(0, 10);
  let themeName = `mediahub`;
  let tempName = `mediahub_temp`

  // copy the babezine folder outside babezine (can't copy inside)
  await fs.copy(path.resolve(__dirname, './'), `../${tempName}`, {
    overwrite: true,
    filter: (path) => {
      return ![
        '/node_modules',
        '.gitignore',
        '.babelrc',
        'gulpfile.babel.js',
        'package.json',
        'package-lock.json',
        '/sass',
      ].some((excluded) => path.includes(excluded));
    },
  });

  await fs.move(`../${tempName}`, `./dist/${themeName}`, {
    overwrite: true,
  });

  await exec(`cd dist && zip -r ${themeName}.zip ${themeName}`);

  await fs.remove(`./dist/${themeName}`);
};

const server = (done) => {
  browserSync.init({
    proxy: 'http://mediahub.test/',
    open: false,
  });
  done();
};

const reload = (done) => {
  browserSync.reload();
  done();
};

const cleanDir = () => del(['dist']);

export const watchChanges = () => {
  watch(['sass/**/*.scss'], series(scss, reload));
  watch(['js/**/*.js', '**/*.php'], reload);
};

export const start = series(scss, reload, server, watchChanges);
export const build = series(scss, cleanDir, compress);
