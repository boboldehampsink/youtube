<?php

namespace Craft;

/**
 * YouTube Duplicate Record.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTube_HashesRecord extends BaseRecord
{
    /**
     * Return table name
     * @return string
     */
    public function getTableName()
    {
        return 'youtube_hashes';
    }

    /**
     * Define attributes
     * @return array
     */
    protected function defineAttributes()
    {
        return array(
            'hash' => AttributeType::String
        );
    }

    /**
     * Define relations
     * @return array
     */
    public function defineRelations()
    {
        return array(
            'asset' => array(static::BELONGS_TO, 'AssetFileRecord')
        );
    }
}
