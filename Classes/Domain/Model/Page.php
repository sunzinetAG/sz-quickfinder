<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

    /**
     * Description of the phpfile 'Pages.php'
     *
     * @author Dennis Römmich <dennis@roemmich.eu>
     * @copyright Copyright belongs to the respective authors
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     */

/**
 * Class Page
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class Page extends AbstractSearch
{

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * url
     *
     * @var string
     */
    protected $url;

    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle;

    /**
     * keywords
     *
     * @var string
     */
    protected $keywords;

    /**
     * author
     *
     * @var string
     */
    protected $author;

    /**
     * getPageId Must return the uid in this case
     *
     * @return int
     */
    public function getPid()
    {
        return (int)$this->uid;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Returns the keywords
     *
     * @return string $keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Returns the author
     *
     * @return string $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

}
