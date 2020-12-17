# select the dotnet image
FROM mcr.microsoft.com/dotnet/sdk:5.0-buster-slim AS builder

# copy over the compiler
COPY ./compiler /compiler

# go to the compiler
WORKDIR /compiler

# restore dotnet
RUN dotnet restore

# run the compiler
RUN mkdir /build && \
    dotnet publish -o /build

# ======================================== without sdk ========================================
FROM mcr.microsoft.com/dotnet/aspnet:5.0-buster-slim

COPY --from=builder /build .

RUN mkdir /build_cms
RUN mkdir /build_cms/sys

# copy over the cms
COPY ./build_cms/app/build_cms /build_cms/sys
COPY ./build_cms/app/.htaccess /build_cms/.htaccess
COPY ./build_cms/app/index.php /build_cms/index.php
COPY ./build_cms/docker/TD_dbExport/data/build-cms.json /build_cms/db.json

# copy the installer
COPY ./build_cms/php_installer/install.php /build_cms/installer/index.php

# remove the plugins from the system
RUN rm -fr /build_cms/sys/plugins && \
    rm -fr /build_cms/sys/build_cms_system/system && \
    rm -f /build_cms/sys/build_cms_system/data/load_system_plugins.json

# copy the plugins
COPY ./build_cms/app/build_cms/plugins /build_cms/plugins

# copy the system plugins
COPY ./build_cms/app/build_cms/build_cms_system/system /build_cms/system-plugins

ENTRYPOINT ["dotnet", "/compiler.dll"]