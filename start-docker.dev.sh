#!/bin/bash

# build the compiler
echo "Build the docker image"
sudo docker-compose -f docker-compose.dev.yml up

# stop all docker containers
sudo docker-compose -f docker-compose.dev.yml down
