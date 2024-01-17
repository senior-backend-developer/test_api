<?php

$config = require 'console.php';
$testConfig = require 'test/rewrites.php';

return \yii\helpers\ArrayHelper::merge($config, $testConfig);