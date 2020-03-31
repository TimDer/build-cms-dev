<?php

// set the base url
config_url::displayUntrustedDomain();

// connect to the database
database::connect();

// call plugin definer and routes
plugins::call_plugins();