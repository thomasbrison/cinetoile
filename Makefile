all: js

js: uglify-js -o public/js/cinetoile.js public/js/app/*.js -c -m
