<?php

namespace Craft;

/**
 * YouTube Upload Task.
 *
 * Upload video assets to YouTube.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   http://buildwithcraft.com/license Craft License Agreement
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTube_UploadTask extends BaseTask
{
    /**
     * Define settings.
     *
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'element'   => AttributeType::Mixed,
            'model'     => AttributeType::Mixed,
            'assets'    => AttributeType::Mixed,
        );
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function getDescription()
    {
        return Craft::t('YouTube Upload');
    }

    /**
     * Return total steps.
     *
     * @return int
     */
    public function getTotalSteps()
    {
        // Get settings
        $settings = $this->getSettings();

        // Take a step for every asset
        return count($settings->assets);
    }

    /**
     * Run step.
     *
     * @param int $step
     *
     * @return string|bool
     */
    public function runStep($step)
    {
        // Get settings
        $settings = $this->getSettings();

        // Get asset
        $asset = craft()->assets->getFileById($settings->assets[$step]);

        // Return process status
        return craft()->youTube->process($settings->element, $asset, $settings->model->handle, $step);
    }
}
