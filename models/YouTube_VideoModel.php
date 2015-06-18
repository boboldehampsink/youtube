<?php

namespace Craft;

/**
 * YouTube Video Model.
 *
 * Contains video data.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   http://buildwithcraft.com/license Craft License Agreement
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTube_VideoModel extends BaseModel
{
    /**
     * YouTube Embed URL prefix.
     */
    const YOUTUBE_EMBED_PREFIX = 'https://www.youtube.com/embed/';

    /**
     * YouTube Watch URL prefix.
     */
    const YOUTUBE_WATCH_PREFIX = 'https://www.youtube.com/watch?v=';

    /**
     * Define model attributes.
     *
     * @return array
     */
    public function defineAttributes()
    {
        return array(
            'id' => AttributeType::String,
        );
    }

    /**
     * Return full YouTube (embed) url.
     *
     * @param bool $embed
     *
     * @return string
     */
    public function getUrl($embed = true)
    {
        if ($embed) {
            return self::YOUTUBE_EMBED_PREFIX.$this->id;
        } else {
            return self::YOUTUBE_WATCH_PREFIX.$this->id;
        }
    }
}
