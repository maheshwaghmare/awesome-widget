module.exports = function (grunt) {
	'use strict';
	// Project configuration
	var autoprefixer = require('autoprefixer');
	var flexibility = require('postcss-flexibility');

	grunt.initConfig({
			pkg: grunt.file.readJSON('package.json'),

			rtlcss: {
				options: {
					// rtlcss options
					config: {
						preserveComments: true,
						greedy: true
					},
					// generate source maps
					map: false
				},
				dist: {
					files: [
						{
							expand: true,
							cwd: "assets/css/",
							src: [
									'*.css',
									'!*-rtl.css',
								],
							dest: "assets/css/",
							ext: '-rtl.css'
						},
					]
				}
			},

			sass: {
				options: {
					sourcemap: 'none',
					outputStyle: 'expanded'
				},
				dist: {
					files: [
						{
							expand: true,
							cwd: "assets/scss",
							src: ["*.scss"],
							dest: "assets/css",
							ext: ".css",
							/*rename: function (dest, src) {
								return dest + src.replace('scss', 'css'); // The target file is written to folder "css" instead of "scss" by renaming the folder
							}*/
						},
					]
				}
			},

			postcss: {
				options: {
					map: false,
					processors: [
						flexibility,
						autoprefixer({
							browsers: [
								'Android >= 2.1',
								'Chrome >= 21',
								'Edge >= 12',
								'Explorer >= 7',
								'Firefox >= 17',
								'Opera >= 12.1',
								'Safari >= 6.0'
							],
							cascade: false
						})
					]
				},
				style: {
					expand: true,
					src: [
						"assets/css/*",
					]
				}
			},

			uglify: {
				js: {
					files: [
						{
							expand: true,
							cwd: "assets/js/",
							src: ["*.js"],
							dest: "assets/js/",
							ext: '.min.js'
						},
					]
				}
			},

			cssmin: {
				options: {
					keepSpecialComments: 0
				},
				css: {
					files: [
						{ //.css to min.css
							expand: true,
							cwd: "addons/css",
							src: ["**.css"],
							dest: "addons/css",
							ext: ".min.css",
						},
					]
				}
			},

			copy: {
				main: {
					options: {
						mode: true
					},
					src: [
						'**',
						'!node_modules/**',
						'!build/**',
						'!.git/**',
						'!bin/**',
						'!.gitlab-ci.yml',
						'!bin/**',
						'!tests/**',
						'!phpunit.xml.dist',
						'!*.sh',
						'!*.map',
						'!Gruntfile.js',
						'!package.json',
						'!.gitignore',
						'!phpunit.xml',
						'!README.md',
						'!codesniffer.ruleset.xml',
					],
					dest: 'awesome-widget/'
				}
			},

			compress: {
				main: {
					options: {
						archive: 'awesome-widget.zip',
						mode: 'zip'
					},
					files: [
						{
							src: [
								'./awesome-widget/**'
							]

						}
					]
				}
			},

			clean: {
				main: ["awesome-widget"],
				zip: ["awesome-widget.zip"]

			},

			makepot: {
				target: {
					options: {
						domainPath: '/',
						potFilename: 'languages/awesome-widget.pot',
						potHeaders: {
							poedit: true,
							'x-poedit-keywordslist': true
						},
						type: 'wp-plugin',
						updateTimestamp: true
					}
				}
			},

			addtextdomain: {
				options: {
					textdomain: 'astra',
				},
				target: {
					files: {
						src: [
							'*.php',
							'**/*.php',
							'!node_modules/**',
							'!php-tests/**',
							'!bin/**',
						]
					}
				}
			}

		}
	);

	// Load grunt tasks
	grunt.loadNpmTasks('grunt-rtlcss');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-wp-i18n');

	// rtlcss, you will still need to install ruby and sass on your system manually to run this
	grunt.registerTask('rtl', ['rtlcss']);

	// SASS compile
	grunt.registerTask('scss', ['sass']);

	// Style
	grunt.registerTask('style', ['scss', 'postcss:style', 'rtl']);

	// min all
	grunt.registerTask('minify', ['style', 'uglify:js', 'cssmin:css']);

	// Grunt release - Create installable package of the local files
	grunt.registerTask('release', ['clean:zip', 'copy', 'compress', 'clean:main']);

	// i18n
	grunt.registerTask('i18n', ['addtextdomain', 'makepot']);

	grunt.util.linefeed = '\n';
};
