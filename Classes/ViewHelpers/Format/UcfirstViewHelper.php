<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class UcfirstViewHelper
 * @package Sunzinet\SzQuickfinder\ViewHelpers\Format
 */
class UcfirstViewHelper extends AbstractViewHelper
{
    /**
     * Make a string's first character uppercase
     *
     * @return string
     */
    public function render()
    {
        $string = $this->renderChildren();
        if (!is_string($string)) {
            throw new \InvalidArgumentException('Parameter $searchString must be of type string', 1440585046);
        }

        if ($string === '') {
            throw new \InvalidArgumentException('Given String must not be Empty', 1440581637);
        }

        return ucfirst($string);
    }
}
