#!/bin/bash

node_modules/less/bin/lessc webroot/less/admin-lte-custom.less webroot/css/admin-lte-custom/admin-lte-custom.css
node_modules/less/bin/lessc webroot/less/app.less webroot/css/app.css

# Compile all skins
skins=(skin-blue skin-black skin-yellow skin-green skin-red skin-purple skin-blue-light skin-black-light skin-yellow-light skin-green-light skin-red-light skin-purple-light)
for skin in ${skins[@]};
do
  node_modules/less/bin/lessc --clean-css webroot/vendors/bower_components/admin-lte/build/less/skins/${skin}.less webroot/css/admin-lte-custom/skins/${skin}.css
done

bin/cake asset_compress build
