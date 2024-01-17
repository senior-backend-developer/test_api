<?php

/**
 * Params env get settings
 * @param string $eName
 * @param string $default
 * @return string
 */
if (!function_exists('env')) {
    function env(string $eName, string $default = ''): string
    {
        return (string)(getenv($eName) ? getenv($eName) : $default);
    }
}

if (!class_exists('ConfigGenerator')) {
    class ConfigGenerator
    {
        const FOLDER_LOCAL = 'local';
        const FOLDER_SECTIONS = 'sections';

        private function baseConfig()
        {
            return [
                'id' => 'test_api',
                'name' => 'Test API',
                'timeZone' => 'Europe/Moscow',
                'language' => 'en',
                'sourceLanguage' => '',
                'basePath' => dirname(__DIR__),
                'bootstrap' => [],
                'aliases' => [
                    '@bower' => '@vendor/bower-asset',
                    '@webroot' => dirname(__FILE__, 2).'/web',
                ],
                'components' => [
                    'urlManager' => null,
                    'db' => null,
                ],
                'params' => null,
            ];
        }

        private $fullConfig;
        private $directoryPrefix = null;

        public function __construct($config, $directoryPrefix = null)
        {
            $this->fullConfig = $this->baseConfig();
            $this->directoryPrefix = $directoryPrefix;

            $this->fullConfig = yii\helpers\ArrayHelper::merge($this->fullConfig, $config);
        }

        public function getFullConfig()
        {
            foreach (array_keys($this->fullConfig) as $section) {
                $this->mergeSection($section);
            }
            foreach (array_keys($this->fullConfig['components']) as $component) {
                $this->mergeComponent($component);
            }
            foreach (array_keys($this->fullConfig) as $section) {
                $this->mergeSection($section, self::FOLDER_LOCAL);
            }
            foreach (array_keys($this->fullConfig['components']) as $component) {
                $this->mergeComponent($component, self::FOLDER_LOCAL);
            }
            if (!empty($this->directoryPrefix)) {
                foreach (array_keys($this->fullConfig) as $section) {
                    $this->mergeSection($section, $this->directoryPrefix.DIRECTORY_SEPARATOR.self::FOLDER_LOCAL);
                }
                foreach (array_keys($this->fullConfig['components']) as $component) {
                    $this->mergeComponent($component, $this->directoryPrefix.DIRECTORY_SEPARATOR.self::FOLDER_LOCAL);
                }
            }

            return $this->fullConfig;
        }

        private function mergeComponent($component, $folder = self::FOLDER_SECTIONS)
        {
            $data = $this->getSectionSettings($component, $folder);
            if (!empty($data)) {
                $this->fullConfig['components'][$component] = yii\helpers\ArrayHelper::merge($this->fullConfig['components'][$component], $data);
            }
        }

        private function mergeSection($section, $folder = self::FOLDER_SECTIONS)
        {
            $data = $this->getSectionSettings($section, $folder);
            if (!empty($data)) {
                $this->fullConfig[$section] = yii\helpers\ArrayHelper::merge($this->fullConfig[$section], $data);
            }
        }

        private function getSectionSettings($section, $folder = self::FOLDER_SECTIONS)
        {
            $path = __DIR__.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$section.'.php';
            if (file_exists($path)) {
                return require $path;
            }
            return [];
        }
    }
}
