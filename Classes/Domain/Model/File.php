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
 * Class File
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class File extends CustomSearch
{

    /**
     * fileCollectionRepository
     *
     * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
     * @inject
     */
    protected $fileCollectionRepository;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * uidForeign
     *
     * @var int
     */
    protected $uidForeign;

    /**
     * breadcrumb
     *
     * @var string
     */
    protected $breadcrumb;

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
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the uidForeign
     *
     * @return int $uidForeign
     */
    public function getUidForeign()
    {
        return $this->uidForeign;
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
     * @return File
     */
    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;

        return $this;
    }

    /**
     * @return array <\TYPO3\CMS\Core\Resource\File>
     */
    public function getItem()
    {
        $uid = $this->getUidLocal();
        $obj = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileObject($uid);
        $item = $obj->toArray();

        $itemAdds = array(
            'breadcrumb' => $this->getBreadcrumb(),
            'description' => $this->getDescription(),
            'title' => $this->getTitle(),
            'uid' => $this->getUid(),
            'uidLocal' => $this->getUidLocal(),
            'uidForeign' => $this->getUidForeign(),
        );

        $item = array_merge($item, $itemAdds);
        return $item;
    }
}
