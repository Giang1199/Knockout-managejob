<?php
declare(strict_types=1);

namespace Dtn\ManageJob\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Job extends Template implements BlockInterface
{
    protected $_template = "widget/customwidget.phtml";
}
