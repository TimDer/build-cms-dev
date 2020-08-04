#!/bin/bash


DEV_DIR="/build_cms/dev"


if [ "$1" != "" ]
then
    DEV_ARGUMENT="$DEV_DIR";
    for ARGUMENTS in "$@" 
    do
        DEV_ARGUMENT="$DEV_ARGUMENT $ARGUMENTS";
    done
    php $DEV_ARGUMENT
else
    php $DEV_DIR
fi
