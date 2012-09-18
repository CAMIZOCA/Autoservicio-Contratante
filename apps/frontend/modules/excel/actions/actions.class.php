<?php

/**
 * pdf2 actions.
 *
 * @package    autoservicio
 * @subpackage pdf2
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class excelActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->setLayout(false);
        $this->getResponse()->setContentType('application/msexcel');
        $this->getResponse()->addHttpMeta('content-disposition: ', 'attachment; filename="excel.xls"', true);
    }

}
