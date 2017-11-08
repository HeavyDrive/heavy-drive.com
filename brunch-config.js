// See http://brunch.io for documentation.
exports.config = {
    paths: {
        watched: ["app/Resources/frontend/", "app/Resources/backend/", "bower_components"],
        public: "web"
    },
    files: {
        javascripts: {
            joinTo: {
                "javascripts/front.js": /frontend/,
                "javascripts/back.js": [
                    /backend/
                ],
                "javascripts/vendor.js": [
                    /^bower/,
                    "bower_components/jquery/dist/jquery.min.js",
                    "bower_components/bootstrap-sass/assets/javascripts/bootstrap/*",
                    "bower_components/bootstrap-sass/assets/javascripts/bootstrap.js",
                    "bower_components/bootstrap/js/*",
                    "bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js",
                    "bower_components/moment/min/moment.min.js",
                    "bower_components/datetimepicker/build/jquery.datetimepicker.min.js",

                ]
            }
        },
        stylesheets: {
            joinTo: {
                "styles/front.css": /frontend/,
                "styles/back.css" : [
                    /backend/,
                ],
                "styles/vendor.css": [
                    "bower_components/bootstrap-sass/assets/stylesheets/bootstrap",
                    "bower_components/bootstrap/dist/css/bootstrap.min.css",
                    "bower_components/components-font-awesome/font-awesome.min.css",
                    "bower_components/bootstrap-social/bootstrap-social.css",
                    "bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"
                ]
            }
        }
    },
    modules: {
        nameCleaner: function(path) {
            return path
                .replace('app/Resources/', '')
                .replace('/scripts/', '/');
        }
    },
    plugins: {
        sass: {
            mode: 'ruby',
        },
        cleancss: {
            keepSpecialComments: 0,
            removeEmpty: true,
            removeWhitespace: true
        },
        uglify: {
            mangle: false,
            compress: {
                global_defs: {
                    DEBUG: false
                }
            }
        }
    },
    overrides: {
        production: {
            optimize: true,
            sourceMaps: false
        }
    }
};