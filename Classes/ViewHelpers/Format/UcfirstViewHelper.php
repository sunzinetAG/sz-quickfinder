<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\ViewHelpers\Format;

use Closure;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * @deprecated
 */
final class UcfirstViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('string', 'string', 'String which first char should be uppercase.');
    }

    /**
     * @param array $arguments
     * @param Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @deprecated
     */
    public static function renderStatic(
        array $arguments,
        Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        trigger_error(
            'ViewHelper "Ucfirst" from EXT:sz_quickfinder is deprecated since version 6.0.0-dev, will be removed in version 6.0.0. Use f:format.case() instead.',
            E_USER_DEPRECATED
        );
        return ucfirst($renderChildrenClosure());
    }
}
