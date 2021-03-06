<?php

namespace Behat\Gherkin\Filter;

use Behat\Gherkin\Node\AbstractNode,
    Behat\Gherkin\Node\FeatureNode,
    Behat\Gherkin\Node\ScenarioNode;

/*
 * This file is part of the Behat Gherkin.
 * (c) 2011 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Filters scenarios by feature/scenario tag.
 *
 * @author     Konstantin Kudryashov <ever.zet@gmail.com>
 */
class TagFilter implements FilterInterface
{
    protected $filterString;

    /**
     * Initializes filter.
     *
     * @param   string  $filterStringString name filter string
     */
    public function __construct($filterString)
    {
        $this->filterString = trim($filterString);
    }

    /**
     * {@inheritdoc}
     */
    public function isFeatureMatch(FeatureNode $feature)
    {
        return $this->matchesCondition($feature);
    }

    /**
     * {@inheritdoc}
     */
    public function isScenarioMatch(ScenarioNode $scenario)
    {
        return $this->matchesCondition($scenario);
    }

    /**
     * Checks that node matches condition.
     *
     * @param   Behat\Gherkin\Node\Node\AbstractNode $node  node to check
     */
    protected function matchesCondition(AbstractNode $node)
    {
        $satisfies = true;

        foreach (explode('&&', $this->filterString) as $andTags) {
            $satisfiesComma = false;

            foreach (explode(',', $andTags) as $tag) {
                $tag = str_replace('@', '', trim($tag));

                if ('~' === $tag[0]) {
                    $tag = mb_substr($tag, 1);
                    $satisfiesComma = !$node->hasTag($tag) || $satisfiesComma;
                } else {
                    $satisfiesComma = $node->hasTag($tag) || $satisfiesComma;
                }
            }

            $satisfies = (false !== $satisfiesComma && $satisfies && $satisfiesComma) || false;
        }

        return $satisfies;
    }
}
