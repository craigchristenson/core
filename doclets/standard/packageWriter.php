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

/** This generates the package-summary.html files that list the interfaces and
 * classes for a given package.
 *
 * @package PHPDoctor.Doclets.Standard
 * @version $id$
 */
class packageWriter extends htmlWriter {

	/** Build the package summaries.
	 *
	 * @param doclet doclet
	 */
	function packageWriter(&$doclet) {
	
		parent::htmlWriter($doclet);
		
		$rootDoc =& $this->_doclet->rootDoc();
		$phpdoctor =& $this->_doclet->phpdoctor();
		
		$displayTree = $phpdoctor->getOption('tree');
		
		if ($displayTree) {
			$this->_sections[0] = array('title' => 'Overview', 'url' => 'overview-summary.html');
			$this->_sections[1] = array('title' => 'Package');
			$this->_sections[2] = array('title' => 'Class');
			$this->_sections[3] = array('title' => 'Use');
			$this->_sections[4] = array('title' => 'Tree', 'selected' => TRUE);
			$this->_sections[5] = array('title' => 'Deprecated', 'url' => 'deprecated-list.html');
			$this->_sections[6] = array('title' => 'Index', 'url' => 'index-files/index-1.html');

			$tree = array();
			$classes =& $rootDoc->classes();
			if ($classes) {
				foreach ($classes as $class) {
					$this->_buildTree($tree, $class);
				}
			}

			ob_start();

			echo '<h1>Class Hierarchy</h1>';

			$this->_displayTree($tree);

			$this->_output = ob_get_contents();
			ob_end_clean();

			$this->_write('overview-tree.html', 'Overview', TRUE);
		}

		foreach($rootDoc->packages() as $packageName => $package) {
		
			$this->_depth = $package->depth() + 1;

			$this->_sections[0] = array('title' => 'Overview', 'url' => 'overview-summary.html');
			$this->_sections[1] = array('title' => 'Package', 'selected' => TRUE);
			$this->_sections[2] = array('title' => 'Class');
			$this->_sections[3] = array('title' => 'Use');
			if ($displayTree) $this->_sections[4] = array('title' => 'Tree', 'url' => $package->asPath().'/package-tree.html');
			$this->_sections[5] = array('title' => 'Deprecated', 'url' => 'deprecated-list.html');
			$this->_sections[6] = array('title' => 'Index', 'url' => 'index-files/index-1.html');
			
			ob_start();
			
			echo "<hr />\n\n";
		
			echo '<h1>Package ', $package->name(), "</h1>\n\n";

			$textTag =& $package->tags('@text');
			if ($textTag) {
				echo '<div class="comment">', $this->_processInlineTags($textTag, TRUE), "</div>\n\n";
				echo '<dl><dt>See:</dt><dd><b><a href="#overview_description">Description</a></b></dd></dl>', "\n\n";
			}

			$classes =& $package->ordinaryClasses();
			if ($classes) {
				echo '<table class="title">', "\n";
				echo '<tr><th colspan="2" class="title">Class Summary</th></tr>', "\n";
				foreach($classes as $name => $class) {
					$textTag =& $classes[$name]->tags('@text');
					echo '<tr><td class="name"><a href="', $classes[$name]->name(), '.html">', $classes[$name]->name(), '</a></td>';
					echo '<td class="description">';
					if ($textTag) echo strip_tags($this->_processInlineTags($textTag, TRUE), '<a><b><strong><u><em>');
					echo "</td></tr>\n";
				}
				echo "</table>\n\n";
			}

			$interfaces =& $package->interfaces();
			if ($interfaces) {
				echo '<table class="title">'."\n";
				echo '<tr><th colspan="2" class="title">Interface Summary</th></tr>'."\n";
				foreach($interfaces as $name => $interface) {
					$textTag =& $interfaces[$name]->tags('@text');
					echo '<tr><td class="name"><a href="', $interfaces[$name]->name(), '.html">', $interfaces[$name]->name(), '</a></td>';
					echo '<td class="description">';
					if ($textTag) echo strip_tags($this->_processInlineTags($textTag, TRUE), '<a><b><strong><u><em>');
					echo "</td></tr>\n";
				}
				echo "</table>\n\n";
			}

			$exceptions =& $package->exceptions();
			if ($exceptions) {
				echo '<table class="title">'."\n";
				echo '<tr><th colspan="2" class="title">Exception Summary</th></tr>'."\n";
				foreach($exceptions as $name => $exception) {
					$textTag =& $exceptions[$name]->tags('@text');
					echo '<tr><td class="name"><a href="', $exceptions[$name]->name(), '.html">', $exceptions[$name]->name(), '</a></td>';
					echo '<td class="description">';
					if ($textTag) echo strip_tags($this->_processInlineTags($textTag, TRUE), '<a><b><strong><u><em>');
					echo "</td></tr>\n";
				}
				echo "</table>\n\n";
			}
			
			$functions =& $package->functions();
			if ($functions) {
				echo '<table class="title">', "\n";
				echo '<tr><th colspan="2" class="title">Function Summary</th></tr>', "\n";
				foreach($functions as $name => $function) {
					$textTag =& $functions[$name]->tags('@text');
					echo '<tr><td class="name"><a href="package-functions.html#', $functions[$name]->name(), '">', $functions[$name]->name(), '</a></td>';
					echo '<td class="description">';
					if ($textTag) echo strip_tags($this->_processInlineTags($textTag, TRUE), '<a><b><strong><u><em>');
					echo "</td></tr>\n";
				}
				echo "</table>\n\n";
			}
			
			$globals =& $package->globals();
			if ($globals) {
				echo '<table class="title">', "\n";
				echo '<tr><th colspan="2" class="title">Global Summary</th></tr>', "\n";
				foreach($globals as $name => $global) {
					$textTag =& $globals[$name]->tags('@text');
					echo '<tr><td class="name"><a href="package-globals.html#', $globals[$name]->name(), '">', $globals[$name]->name(), '</a></td>';
					echo '<td class="description">';
					if ($textTag) echo strip_tags($this->_processInlineTags($textTag, TRUE), '<a><b><strong><u><em>');
					echo "</td></tr>\n";
				}
				echo "</table>\n\n";
			}

			$textTag =& $package->tags('@text');
			if ($textTag) {
				echo '<h1>Package ', $package->name(), " Description</h1>\n\n";
				echo '<div class="comment" id="overview_description">'. $this->_processInlineTags($textTag), "</div>\n\n";
			}
			
			echo "<hr />\n\n";

			$this->_output = ob_get_contents();
			ob_end_clean();
			
			$this->_write($package->asPath().'/package-summary.html', $package->name(), TRUE);
			
			if ($displayTree) {
			
				$this->_sections[0] = array('title' => 'Overview', 'url' => 'overview-summary.html');
				$this->_sections[1] = array('title' => 'Package', 'url' => 'package-summary.html', 'relative' => TRUE);
				$this->_sections[2] = array('title' => 'Class');
				$this->_sections[3] = array('title' => 'Use');
				$this->_sections[4] = array('title' => 'Tree', 'url' => 'package-tree.html', 'selected' => TRUE, 'relative' => TRUE);
				$this->_sections[5] = array('title' => 'Deprecated', 'url' => 'deprecated-list.html');
				$this->_sections[6] = array('title' => 'Index', 'url' => 'index-files/index-1.html');

				$tree = array();
				$classes =& $package->ordinaryClasses();
				if ($classes) {
					foreach ($classes as $class) {
						$this->_buildTree($tree, $class);
					}
				}

				ob_start();

				echo '<h1>Class Hierarchy for Package ', $package->name(),'</h1>';

				$this->_displayTree($tree);

				$this->_output = ob_get_contents();
				ob_end_clean();

				$this->_write($package->asPath().'/package-tree.html', $package->name(), TRUE);
			}
			
		}
	
	}
	
	/**
	 * Build the class tree branch for the given element
	 *
	 * @param classDoc[] tree
	 * @param classDoc element
	 */
	function _buildTree(&$tree, &$element) {
		$tree[$element->name()] = $element;
		if ($element->superclass()) {
			$rootDoc =& $this->_doclet->rootDoc();
			$this->_buildTree($tree, $rootDoc->classNamed($element->superclass()));
		}
	}
	
	/**
	 * Build the class tree branch for the given element
	 *
	 * @param classDoc[] tree
	 * @param classDoc parent
	 */
	function _displayTree($tree, $parent = NULL) {
		$outputList = TRUE;
		foreach($tree as $name => $element) {
			if ($element->superclass() == $parent) {
				if ($outputList) echo "<ul>\n";
				echo '<li><a href="', str_repeat('../', $this->_depth), $element->asPath(), '">', $element->qualifiedName(), '</a>';
				$this->_displayTree($tree, $name);
				echo "</li>\n";
				$outputList = FALSE;
			}
		}
		if (!$outputList) echo "</ul>\n";
	}

}

?>