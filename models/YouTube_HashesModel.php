<?php

namespace Craft;

/**
 * YouTube Hashes Model.
 *
 * Contains hash data.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @see      http://github.com/boboldehampsink
 */
class YouTube_HashesModel extends BaseElementModel
{
    /**
     * Element Type.
     *
     * @var string
     */
    protected $elementType = 'YouTube_Hashes';

    /**
     * Define model attributes.
     *
     * @return array
     */
    public function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'youtubeId' => AttributeType::String,
            'hash' => AttributeType::String,
        ));
    }

    /**
     * Return YouTube ID as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->youtubeId;
    }
}
