# Use ubuntu as a base image
FROM ubuntu:20.04

# Update base image
RUN apt-get update -y
RUN apt-get upgrade -y

# set time sone
ENV timezone=UTC
RUN echo $timezone > input.txt
RUN apt-get install -y tzdata < input.txt
RUN rm input.txt

# Install PHP
RUN apt-get install php7.4 -y
RUN apt-get install libapache2-mod-php7.4 -y
RUN apt-get install php7.4-mysql -y
RUN apt-get install php7.4-cli -y
RUN apt-get install php7.4-zip -y

# Install apache2
RUN apt-get install -y apache2
RUN a2enmod rewrite
RUN rm /var/www/html/index.html

# build_cms
ENV build_cms_config_override=true
ENV DB_servername=false
ENV DB_username=false
ENV DB_password=false
ENV DB_dbname=false
ENV useHttps=false
ENV domainDir=false
ENV displayUntrustedDomain=false
ENV TrustedDomains=false
ENV call_plugin_definer=true
ENV call_plugin_routes=true
ENV dev_mode_on=false
ENV cms_version=1.0

# run apache in the foreground
CMD apachectl -D FOREGROUND