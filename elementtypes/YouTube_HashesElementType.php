<?php

namespace Craft;

/**
 * YouTube Hashes Element Type.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@nerds.company>
 * @copyright Copyright (c) 2016, Bob Olde Hampsink
 * @license   MIT
 *
 * @see      http://github.com/boboldehampsink
 */
class YouTube_HashesElementType extends BaseElementType
{
    /**
     * Return element type name.
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('YouTube Hashes');
    }

    /**
     * Returns whether this element is localized.
     *
     * @return bool
     */
    public function isLocalized()
    {
        return false;
    }

    /**
     * Returns whether this element type has content.
     *
     * @return bool
     */
    public function hasContent()
    {
        return false;
    }

    /**
     * Returns whether this element type has titles.
     *
     * @return bool
     */
    public function hasTitles()
    {
        return false;
    }

    /**
     * No statuses.
     *
     * @return bool
     */
    public function hasStatuses()
    {
        return false;
    }

    /**
     * Define available table column names.
     *
     * @return array
     */
    public function defineAvailableTableAttributes()
    {
        return array(
            'youtubeId' => array('label' => Craft::t('YouTube ID')),
        );
    }

    /**
     * Returns the default table attributes.
     *
     * @param string $source
     *
     * @return array
     */
    public function getDefaultTableAttributes($source = null)
    {
        return array('youtubeId');
    }

    /**
     * Define criteria.
     *
     * @return array
     */
    public function defineCriteriaAttributes()
    {
        return array(
            'youtubeId' => AttributeType::String,
        );
    }

    /**
     * Cancel the elements query.
     *
     * @param DbCommand            $query
     * @param ElementCriteriaModel $criteria
     *
     * @return bool
     */
    public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
    {
        // Default query
        $query
            ->select('id, youtubeId')
            ->from('youtube_hashes elements');

        // Reset default element type query parts
        $query->setJoin('');
        $query->setWhere('1=1');
        $query->setGroup('');
        unset($query->params[':locale']);
        unset($query->params[':elementsid1']);
    }

    /**
     * Create element from row.
     *
     * @param array $row
     *
     * @return TranslateModel
     */
    public function populateElementModel($row)
    {
        return YouTube_HashesModel::populateModel($row);
    }

    /**
     * Define the sources.
     *
     * @param string $context
     *
     * @return array
     */
    public function getSources($context = null)
    {
        return array(
            '*' => array(
                'label' => Craft::t('All video hashes'),
            ),
        );
    }

    /**
     * {@inheritdoc} IElementType::getAvailableActions()
     *
     * @param string|null $source
     *
     * @return array|null
     */
    public function getAvailableActions($source = null)
    {
        $actions = array();

        $deleteAction = craft()->elements->getAction('YouTube_HashesDelete');
        $deleteAction->setParams(array(
            'confirmationMessage' => Craft::t('Are you sure you want to delete the selected video hash(es)?'),
            'successMessage' => Craft::t('Hash(es) deleted'),
        ));
        $actions[] = $deleteAction;

        return $actions;
    }
}
