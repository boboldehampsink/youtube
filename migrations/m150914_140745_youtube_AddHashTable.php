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
            'assetId' => array('column' => 'integer', 'required' => false),
            'hash'    => array(),
        ), null, true);

        // Add foreign keys to craft_youtube_hashes
        craft()->db->createCommand()->addForeignKey('youtube_hashes', 'assetId', 'assetfiles', 'id', 'SET NULL', null);

        return true;
    }
}
