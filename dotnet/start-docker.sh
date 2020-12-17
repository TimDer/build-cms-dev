#!/bin/bash

# copy the required files to the docker build context
echo "Copping the required files to the docker build context"
cp ../app ./app -r
cp ../docker/TD_dbExport/data/build-cms.json ./app/db.json
cp ../php_installer ./app/php_installer -r

# build the compiler
echo "Build the docker image"
sudo docker-compose up -d

# remove the required files form the docker build context
echo ""
echo "Deleting the required files from the docker build context"
sudo rm -fr ./app

echo ""
echo "============================================================================="
echo "=                                                                           ="
echo "=                                                                           ="
echo "= ************ The compiler is running on http://localhost:808 ************ ="
echo "=                                                                           ="
echo "=                                                                           ="
echo "============================================================================="
echo ""
