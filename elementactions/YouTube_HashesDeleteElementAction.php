<?php

namespace Craft;

/**
 * YouTube Hashes Delete Element Action.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Bob Olde Hampsink
 * @license   MIT
 *
 * @see      http://github.com/boboldehampsink
 */
class YouTube_HashesDeleteElementAction extends BaseElementAction
{
    /**
     * Get element action name.
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('Delete video hash(es)');
    }

    /**
     * Delete given task.
     *
     * @param ElementCriteriaModel $criteria
     *
     * @return bool
     */
    public function performAction(ElementCriteriaModel $criteria)
    {
        foreach ($criteria->id as $hashId) {
            YouTube_HashesRecord::model()->deleteAll(array(
                'condition' => 'id = :id',
                'params' => array(':id' => $hashId),
            ));
        }

        $this->setMessage(Craft::t('Hash(es) deleted.'));

        return true;
    }
}
