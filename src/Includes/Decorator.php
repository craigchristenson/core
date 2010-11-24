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
 * @subpackage Includes
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

namespace Includes;

/**
 * Decorator - classes cache builder
 * 
 * @package XLite
 * @see     ____class_see____
 * @since   3.0.0
 */
class Decorator extends Decorator\ADecorator
{
    /////////////////////////////// TO REWORK ///////////////////////////////

    /**
     * Pattern to parse PHP files
     */
    const CLASS_PATTERN = '/\s*((?:abstract|final)\s+)?(class|interface)\s+([\w\\\]+)(\s+extends\s+([\w\\\]+))?(\s+implements\s+([\w\\\]+(?:\s*,\s*[\w\\\]+)*))?\s*(\/\*.*\*\/)?\s*{/USsi';

    /**
     * Pattern to get class DOC block
     */
    const CLASS_COMMENT_PATTERN = '/(\s+\*\/\s+)(?:abstract +)?class /USsi';

    /**
     * Suffix for the so called "root" decorator class names
     */
    const ROOT_CLASS_SUFFIX = 'Abstract';


    /**
     * Doctrine class attributes 
     * 
     * @var    array
     * @access protected
     * @see    ____var_see____
     * @since  3.0.0
     */
    protected $doctrineClassAttributes = array(
        'Entity',
        'Table',
        'InheritanceType',
        'DiscriminatorColumn',
        'DiscriminatorMap',
        'ChangeTrackingPolicy',
    );

    /**
     * Classes info
     * 
     * @var    array
     * @access protected
     * @since  3.0
     */
    protected static $classesInfo = array();

    /**
     * Class decorators info
     * 
     * @var    array
     * @access protected
     * @since  3.0
     */
    protected static $classDecorators = array();

    /**
     * List of module dependencies 
     * 
     * @var    array
     * @access protected
     * @since  3.0
     */
    protected $moduleDependencies = null;

    /**
     * List of active modules and their priority values 
     * 
     * @var    array
     * @access protected
     * @since  3.0
     */
    protected $modulePriorities = null;

    /**
     * List of module controllers which names are needed to be normalized
     * 
     * @var    array
     * @access protected
     * @since  3.0
     */
    protected $normalizedControllers = array();


    /**
     * Return file path by class name
     * 
     * @param string $class class name
     *  
     * @return string
     * @access protected
     * @since  3.0
     */
    protected function getFileByClass($class)
    {
        return str_replace('\\', LC_DS, ltrim($class, '\\')) . '.php';
    }

    /**
     * Return text for unresolved dependencies error
     * 
     * @param array $dependencies list of unresolved dependencies
     *  
     * @return string
     * @access protected
     * @since  3.0
     */
    protected function getDependenciesErrorText(array $dependencies)
    {
        $text = 'Class decorator is unable to resolve the following dependencies:<br /><br />' . "\n\n";

        foreach ($dependencies as $module => $dependedModules) {
            $text .= '<strong>' . $module . '</strong>: ' . implode(', ', $dependedModules) . '<br />' . "\n";
        }

        return $text;
    }

    /**
     * Parse class file content 
     * 
     * @param array $info class info
     *  
     * @return string
     * @access protected
     * @since  3.0
     */
    protected function parseClassFile(array $info, $savePath, $class)
    {
        $content = isset($info[self::INFO_FILE]) ? trim(file_get_contents(LC_CLASSES_DIR . $info[self::INFO_FILE])) : '';

        $namespace = explode(LC_DS, $savePath);
        array_pop($namespace);
        $namespace = implode('\\', $namespace);

        if (!empty($info[self::INFO_IS_ROOT_CLASS]) && preg_match(self::CLASS_PATTERN, $content, $matches)) {

            // Top level class in decorator chain has an empty body
            $content = '<?php' . "\n\n"
                . 'namespace ' . $namespace . ';' . "\n\n"
                . trim($info[self::INFO_CLASS_COMMENT]) . "\n"
                . $matches[1] . 'class ' 
                . (isset($info[self::INFO_CLASS]) ? preg_replace('/^.+\\\([^\\\]+)$/Ss', '$1', $info[self::INFO_CLASS]) : $matches[3])
                . (isset($info[self::INFO_EXTENDS]) && $info[self::INFO_EXTENDS] ? ' extends ' . $info[self::INFO_EXTENDS] : '')
                . (isset($matches[6]) ? $matches[6] : '') . "\n" . '{' . "\n" . '}' . "\n";

        } else {

            // Replace class and name of class which extends the current one
            $replace = "\n" 
                . (isset($info[self::INFO_CLASS_TYPE]) ? $info[self::INFO_CLASS_TYPE] . ' ' : '$1') . '$2 ' 
                . (isset($info[self::INFO_CLASS]) ? preg_replace('/^.+\\\([^\\\]+)$/Ss', '$1', $info[self::INFO_CLASS]) : '$3') 
                . (isset($info[self::INFO_EXTENDS]) && $info[self::INFO_EXTENDS] ? ' extends ' . $info[self::INFO_EXTENDS] : '$4') 
                . '$6' . "\n" . '{';
            $content = preg_replace(self::CLASS_PATTERN, $replace, $content);

            $content = preg_replace('/^namespace (.+);/Sm', 'namespace ' . $namespace . ';', $content);

            // Add MappedSuperclass attribute
            if ($this->isDecoratedEntity($info[self::INFO_CLASS_ORIG])) {
                $comment = $this->getClassComment($content);
                if ($comment) {
                    $newComment = $this->modifyParentEntityClassComment($comment);

                    $content = str_replace($comment, $newComment, $content);

                } elseif (preg_match(self::CLASS_PATTERN, $content, $matches)) {
                    $content = str_replace(
                        $matches[0],
                        '/**' . "\n" . ' * @MappedSuperclass' . "\n" . ' */' . "\n" . $matches[0],
                        $content
                    );
                }
            }

            // Prepare static members
            \Includes\Decorator\Utils\StaticRoutines::checkForStaticConstructor($info, $content);
        }

        // Change name of normalized classes in PHP code
        foreach ($this->normalizedControllers as $oldClass => $newClass) {
            $content = preg_replace('/' . preg_quote($oldClass, '/') . '/i', $newClass, $content);
        }

        return $content;
    }

    /**
     * Check - is class decorated entity or not
     * 
     * @param string $class Class name
     *  
     * @return boolean
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected function isDecoratedEntity($class)
    {
        static $cache = null;

        if (!isset($cache)) {
            $cache = array();

            foreach (static::$classDecorators as $root => $list) {
                if (isset(static::$classesInfo[$root]) && static::$classesInfo[$root][self::INFO_ENTITY]) {
                    $cache[] = $root;
                    $cache = array_merge($cache, array_keys($list));
                }
            }
        }

        return in_array($class, $cache);
    }

    /**
     * Modify class comment (insert MappedSuperclass attribute)
     * 
     * @param string $comment Comment
     *  
     * @return string
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected function modifyParentEntityClassComment($comment)
    {
        $comment = preg_replace(
            '/^ \* @(?:' . implode('|', $this->doctrineClassAttributes) . ')(?:\s+\(.+\))?\s*$/UiSm',
            '',
            $comment
        );
        $comment = preg_replace(
            '/ \* @(?:' . implode('|', $this->doctrineClassAttributes) . ')\s+\(.+ \* \)/UiSs',
            '',
            $comment
        );

        $comment = preg_replace('/' . "\n" . '{2,999}/Ss', "\n", $comment);
        $comment = preg_replace('/ \*\//Ssi', ' * @MappedSuperclass' . "\n" . '$0', $comment);

        return $comment;
    }

    /**
     * Check if current class is a controller defined by module 
     * 
     * @param class $class class name
     *  
     * @return bool
     * @access protected
     * @since  3.0
     */
    protected function isModuleController($class)
    {
        return preg_match('/\\\XLite\\\Module\\\[\w]+\\\Controller\\\[\w\\\]*/Ss', $class);
    }
    
    /**
     * Remove the module-related part from module controller class
     * 
     * @param string $class class name
     *  
     * @return string
     * @access protected
     * @since  3.0
     */
    protected function prepareModuleController($class)
    {
        return preg_replace('/\\\XLite\\\(Module\\\[\w]+\\\)Controller(\\\[\w\\\]*)/Ss', '\\\\XLite\\\\Controller$2', $class);
    }

    /**
     * Get class comment 
     * 
     * @param string $data File content
     *  
     * @return string
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected function getClassComment($data)
    {
        $comment = null;

        if (preg_match(self::CLASS_COMMENT_PATTERN, $data, $matches)) {
            $pos = strrpos($matches[1], '*/');
            $tail = str_replace(array("\t", ' '), array('', ''), substr($matches[1], $pos + 2));
            if ("\n" == $tail) {
                $end = strpos($data, $matches[0]);
                $begin = strrpos(substr($data, 0, $end), '/**');
                $comment = substr($data, $begin, $end - $begin + strlen($matches[1]));
            }
        }

        return $comment;
    }

    /**
     * Return list of <module_name> => <dependend_module_1>, <dependend_module_2>, ..., <dependend_module_N>
     * 
     * @return array
     * @access protected
     * @since  3.0
     */
    protected function getModuleDependencies()
    {
        if (!isset($this->moduleDependencies)) {

            $this->moduleDependencies = array();

            if (!class_exists('XLite\Module\AModule', false)) {
                require_once (LC_MODULES_DIR . 'AModule.php');
            }

            foreach (\Includes\Decorator\Utils\ModulesManager::getActiveModules() as $module) {

                $module = $module['name'];

                if (!class_exists('XLite\Module\\' . $module . '\Main', false)) {
                    require_once (LC_MODULES_DIR . $module . LC_DS . 'Main.php');
                }
                
                $mainClassName = \Includes\Decorator\Utils\ModulesManager::getClassNameByModuleName($module);

                $this->moduleDependencies[$module] = $mainClassName::getDependencies();
            }
        }

        return $this->moduleDependencies;
    }

    /**
     * Recursive function to build modules chain base on their dependencies 
     * 
     * @param array $dependencies      dependencies for all modules
     * @param array $levelDependencies available modules for current recursion level
     * @param int   $level             recursion level
     *  
     * @return array
     * @access protected
     * @since  3.0
     */
    protected function calculateModulePriorities(array $dependencies, array $levelDependencies = array(), $level = 0)
    {
        $priorities = array();
        $subLevelDependencies = $levelDependencies;

        // This flag determines if there were any changes on current recursion level
        $isChanged = empty($dependencies);

        foreach ($dependencies as $module => $dependendModules) {

            // Module priority is equals to current level if all module dependencies are already checked
            if (array() === array_diff($dependendModules, $levelDependencies)) {

                // Set priority
                $priorities[$module] = $level;

                // Exclude module from calculation
                unset($dependencies[$module]);

                // Add it to next-level dependencies
                $subLevelDependencies[] = $module;

                // Set flag
                $isChanged = true;
            }
        }

        // There are unresolved dependencies
        if (!$isChanged) {
            echo ($this->getDependenciesErrorText($dependencies));
            die (3);
        }

        $added = empty($dependencies)
            ? array()
            : $this->calculateModulePriorities($dependencies, $subLevelDependencies, $level + 1);

        // Recursive call
        return array_merge($priorities, $added);
    }

    /**
     * Return priority for certain module 
     * 
     * @param string $moduleName module name
     *  
     * @return int
     * @access protected
     * @since  3.0
     */
    protected function getModulePriority($moduleName)
    {
        if (!isset($this->modulePriorities)) {
            $this->modulePriorities = $this->calculateModulePriorities($this->getModuleDependencies());
        }

        return isset($this->modulePriorities[$moduleName])
            ? $this->modulePriorities[$moduleName]
            : 0;
    }

    /**
     * Walk through the PHP files tree and collect classes info 
     * 
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected function createClassTreeFull()
    {
        foreach (static::getClassesTree()->getIndex() as $node) {

            // Save data
            static::$classesInfo[$node->__get(self::N_CLASS)] = array(
                self::INFO_FILE          => $node->__get(self::N_FILE_PATH),
                self::INFO_CLASS_ORIG    => $node->__get(self::N_CLASS),
                self::INFO_EXTENDS       => $node->__get(self::N_PARENT_CLASS),
                self::INFO_EXTENDS_ORIG  => $node->__get(self::N_PARENT_CLASS),
                self::INFO_IS_DECORATOR  => in_array('\XLite\Base\IDecorator', $node->__get(self::N_INTERFACES)),
                self::INFO_ENTITY        => !is_null($node->getTag('Entity')),
                self::INFO_CLASS_COMMENT => ($classComment = $node->__get(self::N_CLASS_COMMENT)),
            );
        }
    }

    /**
     * Module can define their own controllers.
     * To use them we need to place this classes into the Controlle/{Admin|Customer} directory and change class name 
     * 
     * @return void
     * @access protected
     * @since  3.0
     */
    protected function normalizeModuleControllerNames()
    {
        foreach (static::$classesInfo as $class => $info) {

            // Only rename classes which are not decorates controllers
            if (
                !empty($class)
                && $this->isModuleController($class)
                && !$info[self::INFO_IS_DECORATOR]
            ) {

                // Cut module-related part from class name
                $newClass = $this->prepareModuleController($class);

                // Error - such controller is already defined in LC core or in other module
                if (!is_null(static::getClassesTree()->find($newClass))) {
                    echo (
                        sprintf(
                            'Module "%s" has defined controller class "%s" which does not decorate any other one and has an ambigous name',
                            \Includes\Decorator\Utils\ModulesManager::getModuleNameByClassName($class),
                            $class
                        )
                    );
                    die (1);
                }

                // Rename and save data
                static::$classesInfo[$newClass] = array_merge($info, array(self::INFO_CLASS => $newClass));
                unset(static::$classesInfo[$class]);
                $this->normalizedControllers[$class] = $newClass;
            }
        }

        // Rename classes in the "INFO_EXTENDS" field
        foreach (static::$classesInfo as $class => $info) {

            if (isset($this->normalizedControllers[$info[self::INFO_EXTENDS]])) {
                static::$classesInfo[$class][self::INFO_EXTENDS]
                    = $this->normalizedControllers[$info[self::INFO_EXTENDS]];
            }
        }
    }

    /**
     * Find all classes which implement interface "IDecorator" and save them as the tree
     * 
     * @return void
     * @access protected
     * @since  3.0
     */
    protected function createDecoratorTree()
    {
        foreach (static::$classesInfo as $class => $info) {

            if ($info[self::INFO_IS_DECORATOR]) {

                // Create new node
                if (!isset(static::$classDecorators[$info[self::INFO_EXTENDS]])) {
                    static::$classDecorators[$info[self::INFO_EXTENDS]] = array();
                }

                // Save class name and its priority (equals to module priority)
                static::$classDecorators[$info[self::INFO_EXTENDS]][$class] = $this->getModulePriority(
                    \Includes\Decorator\Utils\ModulesManager::getModuleNameByClassName($class)
                );
            }

            // These fields are not needed
            if (empty($info[self::INFO_EXTENDS])) {
                unset(static::$classesInfo[$class][self::INFO_EXTENDS]);
            }
            unset(static::$classesInfo[$class][self::INFO_IS_DECORATOR]);
        }
    }

    /**
     * Modify classes tree according to the decorators tree 
     * 
     * @return void
     * @access protected
     * @since  3.0
     */
    protected function mergeClassAndDecoratorTrees()
    {
        foreach (static::$classDecorators as $class => $decorators) {

            // Sort decorated classes by module priority and invert decorator chain
            arsort($decorators, SORT_NUMERIC);
            $decorators = array_keys($decorators);

            $currentClass = $class;

            // Each decorator class extends a next one in decorator chain
            foreach ($decorators as $decorator) {
                static::$classesInfo[$currentClass][self::INFO_EXTENDS] = $decorator;
                $currentClass = $decorator;
            }

            // So called "root" class - class extended by decorators
            $rootClass = $class . self::ROOT_CLASS_SUFFIX;

            static::$classesInfo[$currentClass][self::INFO_EXTENDS] = $rootClass;
            static::$classesInfo[$class][self::INFO_IS_ROOT_CLASS] = true;

            // Wrong class name
            if (!isset(static::$classesInfo[$class][self::INFO_FILE])) {
                echo (sprintf('Decorator: undefined class - "%s"', $class));
                die (2);
            }

            // Assign new (reserved) name to root class and save other info
            static::$classesInfo[$rootClass] = array(
                self::INFO_FILE         => static::$classesInfo[$class][self::INFO_FILE],
                self::INFO_CLASS        => $rootClass,
                self::INFO_CLASS_ORIG   => $class,
                self::INFO_EXTENDS_ORIG => static::$classesInfo[$class][self::INFO_EXTENDS_ORIG],
                self::INFO_CLASS_TYPE   => 'abstract',
            );
        }
    }

    /**
     * Write PHP file into the cache directory
     * 
     * @param string $class class name (uses to get file name)
     * @param string $info  additional class info
     *  
     * @return void
     * @access protected
     * @since  3.0
     */
    protected function writeClassFile($class, $info)
    {
        $fn = $this->getFileByClass($class);
        $fileName = LC_CLASSES_CACHE_DIR . $fn;
        $dirName  = dirname($fileName);

        if (!file_exists($dirName) || !is_dir($dirName)) {
            \Includes\Utils\FileManager::mkdirRecursive($dirName, 0755);
        }

        file_put_contents($fileName, $this->parseClassFile($info, $fn, $class));
        chmod($fileName, 0644);
    }

    /**
     * Check and (if needed) rebuild cache
     * 
     * @return void
     * @access public
     * @since  3.0
     */
    public function buildCache()
    {
        // Invoke plugins
        \Includes\Decorator\Utils\PluginManager::invokeHook(self::HOOK_INIT);

        // Prepare classes list
        $this->createClassTreeFull();


        $this->normalizeModuleControllerNames();
        $this->createDecoratorTree();
        $this->mergeClassAndDecoratorTrees();

        // Write file to the cache directory
        foreach (static::$classesInfo as $class => $info) {
            $this->writeClassFile($class, $info);
        }

        // Invoke plugins
        \Includes\Decorator\Utils\PluginManager::invokeHook(self::HOOK_PREPROCESS);

        // Invoke plugins
        \Includes\Decorator\Utils\PluginManager::invokeHook(self::HOOK_RUN);
    }



    // TODO - move into plugins and utils

    /**
     * Build multilanguages classes
     * 
     * @param array $nodes list of mulilang classes
     *  
     * @return void
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public static function buildMultilangs(array $nodes)
    {
        foreach ($nodes as $class => $data) {

            $decorated = isset(static::$classDecorators[$class]);
            $fn = LC_CLASSES_CACHE_DIR . static::$classesInfo[$class]['file'];
            if (isset(static::$classDecorators[$class])) {
                $fn = preg_replace('/\.php/S', 'Abstract$0', $fn);
            }

            $tclass = $class . 'Translation';
            if (!isset(static::$classesInfo[$tclass])) {
                // TODO - add error logging
                continue;
            }

            $tfn = LC_CLASSES_CACHE_DIR . static::$classesInfo[$tclass]['file'];
            if (isset(static::$classDecorators[$tclass])) {
                $tfn = preg_replace('/\.php/S', 'Abstract$0', $tfn);
            }

            $tfiles = array($tfn);
            if (isset(static::$classDecorators[$tclass])) {
                foreach (static::$classDecorators[$tclass] as $f) {
                    $tfiles[] = LC_CLASSES_CACHE_DIR . $f['file'];
                }
            }

            $translationFields = array();

            foreach ($tfiles as $f) {
                $translationFields = array_merge(
                    $translationFields,
                    static::collectModelFields($f)
                );
            }

            $data = file_get_contents($fn);
            $id = null;

            if (preg_match('/\s+\*\s@translationkey\s/Ssi', $data, $match)) {
                $pos = strpos($data, $match[0]);
                if (preg_match('/^\s+protected \$([^\s;]+)/Sm', substr($data, $pos), $match)) {
                    $id = $match[1];
                }

            } elseif (preg_match('/\s+\*\s@id\s/Ssi', $data, $match)) {
                $pos = strpos($data, $match[0]);
                if (preg_match('/^\s+protected \$([^\s;]+)/Sm', substr($data, $pos), $match)) {
                    $id = $match[1];
                }
            }

            $tclass = ltrim($tclass, '\\');

            $block = <<<DATA
    /**
     * Translations (relation)
     * AUTOGENERATED
     * 
     * @var    \Doctrine\Common\Collections\ArrayCollection
     * @access protected
     * @OneToMany (targetEntity="$tclass", mappedBy="owner", cascade={"persist","remove"})
     */
    protected \$translations;
DATA;
            static::addPropertyToRepository($fn, $block);

            $data = file_get_contents($fn);

            foreach ($translationFields as $field) {

                $prefix = str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));

                $block = '';

                if (!preg_match('/ function get' . $prefix . '\(/Ss', $data)) {

                    $block .= <<<DATA
    /**
     * Get $field
     * AUTOGENERATED
     * 
     * @return string
     * @access public
     */
    public function get$prefix()
    {
        return \$this->getSoftTranslation()->get$prefix();
    }

DATA;
                }

                if (!preg_match('/ function set' . $prefix . '\(/Ss', $data)) {

                    $block .= <<<DATA
    /**
     * Set $field
     * AUTOGENERATED
     * 
     * @param string \$value Value
     *  
     * @return void
     * @access public
     */
    public function set$prefix(\$value)
    {
        \$this->getTranslation(\$this->editLanguage)->set$prefix(\$value);
    }

DATA;
                }

                if ($block) {
                    static::addMethodToRepository($fn, $block);
                }
            }
            

            $class = ltrim($class, '\\');

            $block = <<<DATA
    /**
     * Translation owner (relation)
     * AUTOGENERATED
     * 
     * @var    $class
     * @access protected
     * @ManyToOne (targetEntity="$class", inversedBy="translations")
     * @JoinColumn (name="id", referencedColumnName="$id")
     */
    protected \$owner;

DATA;
            static::addPropertyToRepository($tfn, $block);
        }
    }

    /**
     * Collect model fields 
     * 
     * @param string $fn Class repository path
     *  
     * @return array
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function collectModelFields($fn)
    {
        $data = file_get_contents($fn);
        $result = array();

        if (preg_match_all('/\s+\*\/\s+protected \$([^;\s]+)/Ss', $data, $match)) {
            foreach ($match[1] as $k => $v) {
                $pos = strpos($data, $match[0][$k]);
                $begin = strrpos(substr($data, 0, $pos), '/**');
                if (preg_match('/\*\s@column/Ssi', substr($data, $begin, $pos - $begin))) {
                    $result[] = $v;
                }
            }
        }

        return $result;
    }

    /**
     * Add class property to class repository 
     * 
     * @param string $fn    Path
     * @param string $block Property block
     *  
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function addPropertyToRepository($fn, $block)
    {
        $data = file_get_contents($fn);

        if (preg_match_all('/^\s+(?:protected|public|private)\s+\$\S+/Sm', $data, $match)) {
            $match = array_pop($match[0]);
            $pos   = strpos($data, $match);
            $pos   = strpos($data, ';', $pos) + 1;
            $data  = substr($data, 0, $pos) . "\n\n" . $block . substr($data, $pos);

        } else {
            $data = preg_replace('/\s+class\s+[^{]+{\s+/Ss', '$0' . $block, $data);
        }

        file_put_contents($fn, $data);
    }

    /**
     * Add class method to class repository 
     * 
     * @param string $fn    Path
     * @param string $block Method block
     *  
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0
     */
    protected static function addMethodToRepository($fn, $block)
    {
        $data = file_get_contents($fn);

        $data = preg_replace('/^\}/Sm', "\n" . $block . "\n" . '$0', $data, 1);

        file_put_contents($fn, $data);
    }

    /**
     * Get final class by class-decorator
     * 
     * @param string $class Class-decorator
     *  
     * @return string
     * @access public
     * @see    ____func_see____
     * @since  3.0.0
     */
    public static function getFinalClass($class)
    {
        if (isset(static::$classDecorators[$class])) {

            // Class already final
            $result = $class;

        } elseif (
            static::$classesInfo[$class][self::INFO_EXTENDS_ORIG] != static::$classesInfo[$class][self::INFO_EXTENDS]
            && isset(static::$classDecorators[static::$classesInfo[$class][self::INFO_EXTENDS_ORIG]])
        ) {

            // Class is decorator
            $result = static::$classesInfo[$class][self::INFO_EXTENDS_ORIG];

        } else {
            $result = $class;
        }

        return $result;
    }
}
