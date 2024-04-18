module.exports = function( grunt ) {

	'use strict';
	var banner = '/**\n * <%= pkg.homepage %>\n * Copyright (c) <%= grunt.template.today("yyyy") %>\n * This file is generated automatically. Do not edit.\n */\n';
	// Project configuration
	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		addtextdomain: {
			options: {
				textdomain: 'bsf-changelog',
			},
			update_all_domains: {
				options: {
					updateDomains: true
				},
				src: [ '*.php', '**/*.php', '!node_modules/**', '!php-tests/**', '!bin/**' ]
			}
		},

		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},

		copy: {
			main: {
				options: {
					mode: true,
				},
				src: [
					'**',
					'!node_modules/**',
					'!.vscode/**',
					'!build/**',
					'!css/sourcemap/**',
					'!.git/**',
					'!bin/**',
					'!.gitlab-ci.yml',
					'!bin/**',
					'!tests/**',
					'!phpunit.xml.dist',
					'!*.sh',
					'!*.map',
					'!*.zip',
					'!Gruntfile.js',
					'!package.json',
					'!.gitignore',
					'!phpunit.xml',
					'!README.md',
					'!sass/**',
					'!codesniffer.ruleset.xml',
					'!vendor/**',
					'!composer.json',
					'!composer.lock',
					'!package-lock.json',
					'!phpcs.xml.dist',
				],
				dest: 'bsf-changelog/',
			},
		},
		compress: {
			main: {
				options: {
					archive: 'bsf-changelog-<%= pkg.version %>.zip',
					mode: 'zip',
				},
				files: [
					{
						src: [ './bsf-changelog/**' ],
					},
				],
			},
		},
		clean: {
			main: [ 'bsf-changelog' ],
			zip: [ '*.zip' ],
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					mainFile: 'bsf-changelog.php',
					potFilename: 'bsf-changelog.pot',
					potHeaders: {
						poedit: true,
						'x-poedit-keywordslist': true
					},
					type: 'wp-plugin',
					updateTimestamp: true
				}
			}
		},
	} );

	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.registerTask( 'i18n', ['addtextdomain', 'makepot'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );
	grunt.registerTask( 'release', [
		'clean:zip',
		'copy',
		'compress',
		'clean:main',
	] );

	grunt.util.linefeed = '\n';

};
