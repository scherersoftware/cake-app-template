#!/bin/bash

lessc webroot/less/admin-lte-custom.less webroot/css/admin-lte-custom/admin-lte-custom.css
lessc webroot/less/app.less webroot/css/app.css

sass webroot/vendors/bower_components/source-sans-pro/scss/source-sans-pro.scss webroot/vendors/bower_components/source-sans-pro/css/source-sans-pro.css
sass webroot/vendors/bower_components/font-awesome/scss/font-awesome.scss webroot/vendors/bower_components/font-awesome/css/font-awesome.css

# Compile all skins. The are based on a symlink to bootstrap's less folder in webroot/vendors/AdminLTE
skins=(skin-blue skin-black skin-yellow skin-green skin-red skin-purple skin-blue-light skin-black-light skin-yellow-light skin-green-light skin-red-light skin-purple-light)
for skin in ${skins[@]};
do
    lessc --clean-css webroot/vendors/AdminLTE/less/skins/${skin}.less webroot/css/admin-lte-custom/skins/${skin}.css
done

bin/cake asset_compress build
