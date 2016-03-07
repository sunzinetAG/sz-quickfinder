module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				compress: {
					drop_console: true
				},
				banner: '/*! \n' +
				'* <%= pkg.name %> - v<%= pkg.version %> (<%= pkg.repository.url %>)\n' +
				'* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %> (<%= pkg.company %>) <%= pkg.author.mail %>\n' +
				'* Licensed under the <%= pkg.license %> license\n' +
				'*/\n'
			},
			szFlyout: {
				files: {
					'Resources/Public/Js/SzIndexedSearch.min.js': ['Resources/Public/Js/SzIndexedSearch.js']
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('default', ['uglify']);

};