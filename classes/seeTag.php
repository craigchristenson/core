<?php
/*
PHPDoctor: The PHP Documentation Creator
Copyright (C) 2004 Paul James <paul@peej.co.uk>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/** Represents a see tag.
 *
 * @package PHPDoctor.Tags
 * @version $id$
 */
class seeTag extends tag {

	/** The link.
	 *
	 * @var str
	 */
	var $_link = NULL;

	/**
	 * Constructor
	 *
	 * @param str text The contents of the tag
	 * @param str[] data Reference to doc comment data array
	 * @param rootDoc root The root object
	 */
	function seeTag($text, &$data, &$root) {
		if (preg_match('/^<a href="(.+)">(.+)<\/a>$/', $text, $matches)) {
			$this->_link = $matches[1];
			$text = $matches[2];
		} elseif (preg_match('/^([^ ]+)([ \t](.*))?$/', $text, $matches)) {
			$this->_link = $matches[1];
			if (isset($matches[3])) {
				$text = $matches[3];
			}
		} else {
			$this->_link = NULL;
		}
		parent::tag('@see', $text, $root);
	}
	
	/** Get display name of this tag.
	 *
	 * @return str
	 */
	function displayName() {
		return 'See Also';
	}
	
	/** Get value of this tag.
	 *
	 * @return str
	 */
	function text() {
		if ($this->_text && $this->_text != "\n") {
			$link = $this->_text;
		} else {
			$link = $this->_link;
		}
		$element =& $this->_resolveLink();
		if ($element) {
			$package =& $this->_parent->containingPackage();
			$path = str_repeat('../', $package->depth() + 1).$element->asPath();
			return '<a href="'.$path.'">'.$link.'</a>';
		} else {
			return $link;
		}
	}
	
	/**
	 * Turn the objects link text into a link to the element it refers to.
	 *
	 * @return programElementDoc
	 */
	function &_resolveLink() {
		$labelRegex = '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*';
		if (preg_match('/^(([a-zA-Z0-9_\x7f-\xff .-]+)\.)?(('.$labelRegex.')#)?('.$labelRegex.')$/', $this->_link, $matches)) {
			$packageName = $matches[2];
			$className = $matches[4];
			$elementName = $matches[5];
			if ($packageName) { // get package
				$package =& $this->_root->packageNamed($packageName);
			}
			if ($className) { // get class
				if (isset($package)) {
					$classes =& $package->allClasses();
				} else {
					$classes =& $this->_root->classes();
				}
				foreach ($classes as $key => $class) {
					if ($class->name() == $className) {
						break;
					}
				}
				$class =& $classes[$key];
			}
			if ($elementName) { // get element
				if (isset($class)) { // from class
					$constructors =& $class->constructor();
					foreach($constructors as $key => $constructor) {
						if ($constructor->name() == $elementName) {
							$element =& $constructors[$key];
							break;
						}
					}
					if (!isset($element)) {
						$methods =& $class->methods();
						foreach($methods as $key => $method) {
							if ($method->name() == $elementName) {
								$element =& $methods[$key];
								break;
							}
						}
						if (!isset($element)) {
							$fields =& $class->fields();
							foreach($fields as $key => $field) {
								if ($field->name() == $elementName) {
									$element =& $fields[$key];
									break;
								}
							}
						}
					}
				} elseif (isset($package)) { // from package
					$classes =& $package->allClasses();
					foreach($classes as $key => $class) {
						if ($class->name() == $elementName) {
							$element =& $classes[$key];
							break;
						}
						$constructors =& $class->constructor();
						foreach($constructors as $key => $constructor) {
							if ($constructor->name() == $elementName) {
								$element =& $constructors[$key];
								break 2;
							}
						}
						if (!isset($element)) {
							$methods =& $class->methods();
							foreach($methods as $key => $method) {
								if ($method->name() == $elementName) {
									$element =& $methods[$key];
									break 2;
								}
							}
							if (!isset($element)) {
								$fields =& $class->fields();
								foreach($fields as $key => $field) {
									if ($field->name() == $elementName) {
										$element =& $fields[$key];
										break 2;
									}
								}
							}
						}
					}
					if (!isset($element)) {
						$functions =& $package->functions();
						foreach($functions as $key => $function) {
							if ($function->name() == $elementName) {
								$element =& $functions[$key];
								break;
							}
						}
						if (!isset($element)) {
							$globals =& $package->globals();
							foreach($globals as $key => $global) {
								if ($global->name() == $elementName) {
									$element =& $globals[$key];
									break;
								}
							}
						}
					}
				} else { // from anywhere
					$classes =& $this->_root->classes();
					foreach($classes as $key => $class) {
						if ($class->name() == $elementName) {
							$element =& $classes[$key];
							break;
						}
						$constructors =& $class->constructor();
						foreach($constructors as $key => $constructor) {
							if ($constructor->name() == $elementName) {
								$element =& $constructors[$key];
								break 2;
							}
						}
						if (!isset($element)) {
							$methods =& $class->methods();
							foreach($methods as $key => $method) {
								if ($method->name() == $elementName) {
									$element =& $methods[$key];
									break 2;
								}
							}
							if (!isset($element)) {
								$fields =& $class->fields();
								foreach($fields as $key => $field) {
									if ($field->name() == $elementName) {
										$element =& $fields[$key];
										break 2;
									}
								}
							}
						}
					}
					if (!isset($element)) {
						$functions =& $this->_root->functions();
						foreach($functions as $key => $function) {
							if ($function->name() == $elementName) {
								$element =& $functions[$key];
								break;
							}
						}
						if (!isset($element)) {
							$globals =& $this->_root->globals();
							foreach($globals as $key => $global) {
								if ($global->name() == $elementName) {
									$element =& $globals[$key];
									break;
								}
							}
						}
					}
				}
			}
			return $element;
		} else {
			return NULL;
		}
	}
	
	/** Return true if this Taglet is used in constructor documentation. */
	function inConstructor() {
		return TRUE;
	}

	/** Return true if this Taglet is used in field documentation. */
	function inField() {
		return TRUE;
	}

	/** Return true if this Taglet is used in method documentation. */          
	function inMethod() {
		return TRUE;
	}

	/** Return true if this Taglet is used in overview documentation. */
	function inOverview() {
		return TRUE;
	}

	/** Return true if this Taglet is used in package documentation. */
	function inPackage() {
		return TRUE;
	}

	/** Return true if this Taglet is used in class or interface documentation. */
	function inType() {
		return TRUE;
	}

	/** Return true if this Taglet is an inline tag. */
	function isInlineTag() {
		return FALSE;
	}

}

?>