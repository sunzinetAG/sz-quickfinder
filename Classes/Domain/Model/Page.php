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
class Page extends CustomSearch
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
     * breadcrumb
     *
     * @var string
     */
    protected $breadcrumb;

    /**
     * changeUidToPid
     *
     * @var bool
     */
    public $changeUidToPid = true;

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

    /**
     * Returns the breadcrumb
     *
     * @return string $breadcrumb
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * Sets the breadcrumb
     *
     * @param string $breadcrumb
     * @return Page
     */
    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;

        return $this;
    }

}
