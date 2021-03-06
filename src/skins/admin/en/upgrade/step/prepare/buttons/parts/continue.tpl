{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * The "Continue" button
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *
 * @ListChild (list="upgrade.step.prepare.buttons.sections", weight="200")
 *}

<widget IF="isNextStepAvailable()" class="\XLite\View\Button\Submit" style="main-button" label="{t(#Continue#)}" />
