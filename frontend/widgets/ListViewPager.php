<?
namespace frontend\widgets;

use yii\helpers\Html;
use yii\widgets\ListView;
use frontend\widgets\APager;
use yii\helpers\ArrayHelper;

class ListViewPager extends ListView
{
    /**
     * Renders the pager.
     * @return string the rendering result
     */
    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class APager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', APager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();

        return $class::widget($pager);
    }	
}