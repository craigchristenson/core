<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * LiteCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@litecommerce.com so we can send you a copy immediately.
 *
 * PHP version 5.3.0
 *
 * @category  LiteCommerce
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     1.0.16
 */

namespace XLite\View\Attributes\Book\Row\Attribute;

/**
 * AddChoices
 *
 * @see   ____class_see____
 * @since 1.0.16
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class AddChoices extends \XLite\View\Dialog
{
    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.16
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'attribute_add_choices';

        return $result;
    }

    /**
     * Register CSS files
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.16
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/style.css';

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        // For popups
        $list = array_merge(
            $list,
            $this->getWidget(array(), '\XLite\View\Button\Attribute\AddChoices')->getJSFiles(),
            $this->getWidget(array(), '\XLite\View\Button\Attribute\AssignClasses')->getJSFiles()
        );

        return $list;
    }

    /**
     * Return templates directory name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.16
     */
    protected function getDir()
    {
        return 'attributes/book/row/attribute/add_choices';
    }

    /**
     * Alias
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.16
     */
    protected function getAttributeTitle()
    {
        return $this->getAttribute()->getTitle();
    }

    /**
     * Return list of attribute choices
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.16
     */
    protected function getChoices()
    {
        $result = $this->getAttribute()->getChoices();
        $result[] = new \XLite\Model\Attribute\Choice();

        return $result;
    }

    /**
     * Get CSS class for a list row
     *
     * @param \XLite\Model\Attribute\Choice $choice Current object
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.16
     */
    protected function getChoiceRowCSSClass(\XLite\Model\Attribute\Choice $choice)
    {
        return $choice->isPersistent() ? '' : 'hidden';
    }
}