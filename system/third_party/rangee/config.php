<?php

if ( ! defined('RANGEE_VERSION'))
{
  define('RANGEE_VERSION', '0.3');
  define('RANGEE_NAME', 'Rangee');
  define('RANGEE_DESCRIPTION', 'Output many types of different ranges in your templates. From number ranges to months/days');  
  define('RANGEE_DOCUMENTATION', 'http://support.baseworks.nl/discussions/rangee');
  define('RANGEE_DEBUG', FALSE);
}

$config['name'] = RANGEE_NAME;
$config['version'] = RANGEE_VERSION;
$config['description'] = RANGEE_DESCRIPTION;
$config['nsm_addon_updater']['versions_xml'] = '';