<?php

declare(strict_types=1);

use SimpleSAML\Auth\Simple;
use SimpleSAML\Configuration;
use SimpleSAML\XHTML\Template;

$baseDir = dirname(__DIR__, 3);

// Add library autoloader.
require_once($baseDir . '/lib/_autoload.php');


const CONFIG_FILE_NAME = 'config_attribute_check.php';

$as = new Simple('default-sp');

$config = Configuration::getInstance();
$conf = Configuration::getConfig(CONFIG_FILE_NAME);

$attributesGroupConfiguration = $conf->getArray('attribute_groups');

$t = new Template($config, 'attribute_check:attribute_check-tpl.php');
$t->data['attributes_group_config'] = $attributesGroupConfiguration;
$t->data['as'] = $as;
$t->show();
