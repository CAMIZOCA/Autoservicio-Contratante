<?php

/**
 * temp actions.
 *
 * @package    autoservicio
 * @subpackage temp
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tempActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  $this->setLayout('layout_none');        
    //$this->forward('default', 'module');
  }
}
