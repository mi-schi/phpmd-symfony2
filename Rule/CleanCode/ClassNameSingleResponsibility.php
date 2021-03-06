<?php

namespace MS\PHPMD\Rule\CleanCode;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Node\ClassNode;
use PHPMD\Rule\ClassAware;

/**
 * Class ClassNameSingleResponsibility
 *
 * Try to avoid general suffixes like Manager. It might violate the single responsibility principle.
 *
 * @package MS\PHPMD\Rule\CleanCode
 */
class ClassNameSingleResponsibility extends AbstractRule implements ClassAware
{
    /**
     * @param AbstractNode|ClassNode $node
     */
    public function apply(AbstractNode $node)
    {
        $suffixes = $this->getStringProperty('suffixes');
        $generalSuffixes = explode($this->getStringProperty('delimiter'), $suffixes);

        foreach ($generalSuffixes as $generalSuffix) {
            if ($generalSuffix === substr($node->getImage(), strlen($generalSuffix) * -1)) {
                $this->addViolation($node, [$suffixes, $generalSuffix]);
                break;
            }
        }
    }
}
