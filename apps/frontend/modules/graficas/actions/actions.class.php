<?php

/**
 * graficas actions.
 *
 * @package    aulavirtual
 * @subpackage graficas
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class graficasActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    $this->grafica='<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn("string", "Year");
        data.addColumn("number", "Sales");
        data.addColumn("number", "Expenses");
        data.addRows([
          ["2004", 1000, 400],
          ["2005", 1170, 460],
          ["2006", 660, 1120],
          ["2007", 1030, 540]
        ]);

        var options = {
          width: 400, height: 240,
          title: "Company Performance",
          vAxis: {title: "Year",  titleTextStyle: {color: "red"}}
        };

        var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
        chart.draw(data, options);
      }
    </script>';
  }
}
