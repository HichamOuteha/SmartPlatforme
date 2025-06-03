#!/bin/bash

# Create necessary directories
mkdir -p public/assets/css
mkdir -p public/assets/js
mkdir -p public/assets/images
mkdir -p public/assets/fonts

# Copy CSS files
cp resources/template/assets/css/style-starter.css public/assets/css/

# Copy JavaScript files
cp resources/template/assets/js/jquery-3.3.1.min.js public/assets/js/
cp resources/template/assets/js/jquery.waypoints.min.js public/assets/js/
cp resources/template/assets/js/jquery.countup.js public/assets/js/
cp resources/template/assets/js/theme-change.js public/assets/js/
cp resources/template/assets/js/owl.carousel.js public/assets/js/
cp resources/template/assets/js/bootstrap.min.js public/assets/js/

# Copy images
cp -r resources/template/assets/images/* public/assets/images/

echo "Assets copied successfully!" 