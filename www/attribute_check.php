<?php

declare(strict_types=1);

use SimpleSAML\Auth\Simple;
use SimpleSAML\Configuration;
use SimpleSAML\XHTML\Template;

require_once(__DIR__ . '/../../../vendor/autoload.php');


const CONFIG_FILE_NAME = 'config_attribute_check.php';

$as = new Simple('default-sp');
$as->requireAuth();
$attributes = $as->getAttributes();

$config = Configuration::getInstance();
$conf = Configuration::getConfig(CONFIG_FILE_NAME);

$attributesGroupConfiguration = $conf->getArray('attribute_groups');

$t = new Template($config, 'attribute_check:attribute_check-tpl.php');
$t->data['attributes_group_config'] = $attributesGroupConfiguration;
$t->data['attributes'] = $attributes;
$t->show();
