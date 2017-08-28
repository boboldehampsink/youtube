<?php

namespace Craft;

/**
 * YouTube Variable.
 *
 * Upload video assets to YouTube.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @see      http://github.com/boboldehampsink
 */
class YouTubeVariable
{
    /**
     * YouTube's upload limit for a day.
     *
     * @var int
     */
    const YOUTUBE_MAX_UPLOADS = 400;

    /**
     * Detect if max uploads are reached for today (400).
     *
     * @return bool
     */
    public function maxUploadsReached()
    {
        return craft()->db->createCommand()
            ->select('COUNT(*)')
            ->from('youtube_hashes')
            ->where('DATE(dateCreated) = DATE(NOW())')
            ->queryScalar() >= self::YOUTUBE_MAX_UPLOADS;
    }
}
