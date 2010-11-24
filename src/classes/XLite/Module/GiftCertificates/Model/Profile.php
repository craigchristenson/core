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
 * @category   LiteCommerce
 * @package    XLite
 * @subpackage Model
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

namespace XLite\Module\GiftCertificates\Model;

/**
 * User profile
 * 
 * @package XLite
 * @see     ____class_see____
 * @since   3.0.0
 */
class Profile extends \XLite\Model\Profile implements \XLite\Base\IDecorator
{
    /**
     * Active gift certificates
     * 
     * @var    array
     * @access protected
     * @see    ____var_see____
     * @since  3.0.0
     */
    protected $_active_gift_certs = null;

    /**
     * Get active gift certificates 
     * 
     * @return array(\XLite\Module\GiftCertificates\Model\GiftCertificate)
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public function getActiveGiftCertificates()
    {
        if (is_null($this->_active_gift_certs)) {
            $profileId = $this->get('profile_id');
            $gc = new \XLite\Module\GiftCertificates\Model\GiftCertificate();
            $this->_active_gift_certs = $gc->findAll('profile_id = \'' . $profileId . '\' AND status = \'A\'');
        }

        return $this->_active_gift_certs;
    }
}
