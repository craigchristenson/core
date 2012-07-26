{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * E-mail
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *
 * @ListChild (list="contact-us.send.fields", weight="200")
 *}

<div class="form-item">
  <label for="email">
    {t(#Your e-mail#)}
    <span class="form-required" title="{t(#This field is required.#)}">*</span>
  </label>
  <widget class="XLite\View\FormField\Input\Text\Email" fieldName="email" value="{getValue(#email#)}" fieldOnly="true" required="true" />
</div>
