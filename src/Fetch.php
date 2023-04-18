<?php
/**
 * Fetch plugin for Craft 4
 *
 * Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/jalendport
 * @copyright Copyright (c) 2018 Jalen Davenport
 */

namespace jalendport\fetch;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use jalendport\fetch\twigextensions\FetchTwigExtension;
use jalendport\fetch\variables\FetchVariable;
use yii\base\Event;

/**
 * Class Fetch
 *
 * @author    Jalen Davenport
 * @package   Fetch
 * @since     1.0.0
 *
 */
class Fetch extends Plugin
{
    // Properties
    // =========================================================================

    public static mixed $plugin;

    public bool $hasCpSection = false;

    public bool $hasCpSettings = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        if (!$this->isInstalled) {
            return;
        }

        Craft::$app->view->registerTwigExtension(new FetchTwigExtension());

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('fetch', FetchVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'fetch',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
}
