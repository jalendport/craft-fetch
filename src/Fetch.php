<?php
/**
 * Fetch plugin for Craft CMS 4.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/jalendport
 * @copyright Copyright (c) 2018 Jalen Davenport
 */

namespace jalendport\fetch;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use jalendport\fetch\variables\FetchVariable;
use jalendport\fetch\twigextensions\FetchTwigExtension;
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

	// Public Methods
	// =========================================================================

	/**
	 * @inheritdoc
	 */
	public function init(): void
	{
		parent::init();

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
