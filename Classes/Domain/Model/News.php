<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

	/**
	 * Description of the class 'News.php'
	 *
	 * @author Dennis Römmich <dennis@roemmich.eu>
	 * @copyright Copyright belongs to the respective authors
	 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
	 */

/**
 * Class News
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class News extends \GeorgRinger\News\Domain\Model\News {

	use SearchResult;

}
