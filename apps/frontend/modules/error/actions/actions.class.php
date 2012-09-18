<?php

/**
 * altbamensua actions.
 *
 * @package    autoservicio
 * @subpackage error
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class errorActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executePagina404() {
        //$this->forward('default', 'module');
        $this->setLayout('layout_login');
    }


}
