#!/bin/bash

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
