<?php

/**
 * altbaevoluc actions.
 *
 * @package    autoservicio
 * @subpackage altbaevoluc
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pdfActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->setLayout('layout_none');        
        $this->imgBase64 = $this->getRequestParameter('img_grafico');  
    }  
}
