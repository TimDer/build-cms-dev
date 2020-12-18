#!/bin/bash

# stop all docker containers to recompiler
./stop-docker.sh

# build the compiler
echo "Build the docker image"
sudo docker-compose up -d

# Run done the message
echo ""
echo "============================================================================="
echo "=                                                                           ="
echo "=                                                                           ="
echo "= ************ The compiler is running on http://localhost:808 ************ ="
echo "=                                                                           ="
echo "=                                                                           ="
echo "============================================================================="
echo ""
