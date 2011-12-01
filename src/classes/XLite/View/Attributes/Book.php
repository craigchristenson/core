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
 * @since     1.0.14
 */

namespace XLite\View\Attributes;

/**
 * Book 
 *
 * @see   ____class_see____
 * @since 1.0.14
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class Book extends \XLite\View\Dialog
{
    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.14
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'attributes';

        return $result;
    }

    /**
     * Register CSS files
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.14
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
        $list[] = $this->getDir() . '/controller.js';

        return $list;
    }

    /**
     * Return templates directory name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getDir()
    {
        return 'attributes/book';
    }

    /**
     * Return list of attribute group widgets
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.14
     */
    protected function getGroupWidgets()
    {
        $result = array();

        foreach (\XLite\Core\Database::getRepo('\XLite\Model\Attribute\Group')->findAll() as $group) {
            $attributes = array();

            foreach ($group->getAttributes() as $attribute) {
                $attributes[] = $this->getWidget(
                    array(
                        \XLite\View\Attributes\Book\Row\Attribute::PARAM_ATTRIBUTE => $attribute,
                    ),
                    '\XLite\View\Attributes\Book\Row\Attribute'
                );
            }

            $result[] = $this->getWidget(
                array(
                    \XLite\View\Attributes\Book\Row\Group::PARAM_GROUP      => $group,
                    \XLite\View\Attributes\Book\Row\Group::PARAM_ATTRIBUTES => $attributes,
                ),
                '\XLite\View\Attributes\Book\Row\Group'
            );
        }

        return $result;
    }
}
