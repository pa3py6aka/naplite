<?php
/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property \core\components\Settings\SettingsManager $settings
 * @property \core\components\PhotoSaver $photoSaver
 * @property \yii\web\UrlManager $backendUrlManager
 * @property \yii\web\UrlManager $frontendUrlManager
 * @property \core\components\YiiUser $user
 * @property \yii\queue\Queue $queue
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
*/
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 */
class ConsoleApplication extends yii\console\Application
{
}