<?php

/**
 * altbaevoluc actions.
 *
 * @package    autoservicio
 * @subpackage altbaevoluc
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pdfpoblacionActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //$this->forward('default', 'module');
        //$this->setTemplate('layout.php');
        $this->setLayout('layout_none');
        
    }

    

}