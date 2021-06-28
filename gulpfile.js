/* eslint-disable no-undef */
const { src, dest, series, watch } = require( 'gulp' );
const browserSync = require( 'browser-sync' ).create();
const sass = require( 'gulp-sass' );
const rename = require( 'gulp-rename' );

const postcss = require( 'gulp-postcss' );
const presetEnv = require( 'postcss-preset-env' );

const scss = () => {
	const plugins = [
		presetEnv( {
			autoprefixer: {
				flexbox: 'no-2009',
			},
			stage: 3,
			features: {
				'custom-properties': false,
			},
		} ),
	];

	return src( './sass/style.scss' )
		.pipe( sass() )
		.pipe( postcss( plugins ) )
		.pipe( rename( 'style.css' ) )
		.pipe( dest( './', { overwrite: true } ) );
};

const server = () => {
	return browserSync.init( {
		proxy: 'http://mediahub.test/',
	} );
};

const reload = ( done ) => {
	browserSync.reload();
	done();
};

watch( [ 'sass/**/*.scss' ], series( scss, reload ) );
watch( [ '**/*.js', '**/*.php' ], reload );

exports.scss = scss;
exports.server = server;
exports.default = series( scss, server );
