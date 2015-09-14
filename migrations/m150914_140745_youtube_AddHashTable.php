<?php
namespace Craft;

/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m150914_140745_youtube_AddHashTable extends BaseMigration
{
    /**
     * Any migration code in here is wrapped inside of a transaction.
     *
     * @return bool
     */
    public function safeUp()
    {
        // Create the craft_youtube_hashes table
        craft()->db->createCommand()->createTable('youtube_hashes', array(
            'youtubeId' => array('required' => true),
            'hash'      => array('required' => true),
        ), null, true);

        // Add indexes to craft_youtube_hashes
        craft()->db->createCommand()->createIndex('youtube_hashes', 'hash', true);

        return true;
    }
}
