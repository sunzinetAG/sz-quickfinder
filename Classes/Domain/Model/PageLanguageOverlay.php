<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

    /**
     * Description of the phpfile 'Pages.php'
     *
     * @author Dennis Römmich <dennis@roemmich.eu>
     * @copyright Copyright belongs to the respective authors
     * @license http://www.gnu.org/licenses/gpl.html
     * GNU General Public License, version 3 or later
     */

/**
 * Class PageLanguageOverlay
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class PageLanguageOverlay extends Page
{
    /**
     * getPageId
     *
     * @return int
     */
    public function getPid()
    {
        return (int)$this->pid;
    }
}
