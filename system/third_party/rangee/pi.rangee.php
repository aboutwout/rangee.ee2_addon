<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @package ExpressionEngine
* @author Wouter Vervloet
* @copyright Copyright (c) 2011, Baseworks
* @license http://creativecommons.org/licenses/by-sa/3.0/
* 
* This work is licensed under the Creative Commons Attribution-Share Alike 3.0 Unported.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/
* or send a letter to Creative Commons, 171 Second Street, Suite 300,
* San Francisco, California, 94105, USA.
*/

require PATH_THIRD."rangee/config.php";

$plugin_info = array(
  'pi_name' => RANGEE_NAME,
  'pi_version' => RANGEE_VERSION,
  'pi_author' => 'Wouter Vervloet',
  'pi_author_url' => 'http://www.baseworks.nl/',
  'pi_description' => RANGEE_DESCRIPTION,
  'pi_usage' => Rangee::usage()
);


class Rangee {

	var $return_data = '';

  var $step = 1;
  var $start = 1;
  var $end = FALSE;
  var $limit = 25;
  var $pad = FALSE;
  var $reverse = FALSE;
  
  var $months = array(
    1 => array('Jan', 'January'),
    2 => array('Feb', 'February'),
    3 => array('Mar', 'March'),
    4 => array('Apr', 'April'),
    5 => array('May', 'May'),
    6 => array('Jun', 'June'),
    7 => array('Jul', 'July'),
    8 => array('Aug', 'August'),
    9 => array('Sep', 'September'),
    10 => array('Oct', 'October'),
    11 => array('Nov', 'November'),
    12 => array('Dec', 'December'),
  );

  var $days = array(
    1 => array('Su', 'Sun', 'Sunday'),
    2 => array('Mo', 'Mon', 'Monday'),
    3 => array('Tu', 'Tue', 'Tuesday'),
    4 => array('We', 'Wed', 'Wednesday'),
    5 => array('Th', 'Thu', 'Thursday'),
    6 => array('Fr', 'Fri', 'Friday'),
    7 => array('Sa', 'Sat', 'Saturday')
  );

	function Rangee()
	{
		$this->EE =& get_instance(); 
	}
	
	function numbers()
	{
		$this->step = $this->_fetch_param('step', $this->step);
		$this->start = $this->_fetch_param('start', $this->start);
		$this->end = $this->_fetch_param('end', $this->end);
		$this->limit = $this->_fetch_param('limit', $this->limit);
		$this->pad = $this->_fetch_param('pad', $this->pad);
		$this->reverse = $this->_fetch_bool_param('reverse', $this->reverse);
		
		// If the start or end value is an equation this part will parse it
		eval('$this->end = ' . $this->end . ';');
		eval('$this->start = ' . $this->start . ';');

		if ($this->end === FALSE)
		{
		  $this->end = $this->start + $this->limit;
		}
		
		$range = range($this->start, $this->end, $this->step);
		
		if ($this->reverse)
		{
		  $range = array_reverse($range);
		}
		
		$data = array();
		
		foreach ($range as $number)
		{
		  $data[] = array(
		    'start' => $this->start,
		    'end' => $this->end,
		    'step' => $this->step,
		    'number' => $number,
		    'number:padded' => $this->_pad_value($number, $this->pad)
		  );
		}
		
		$this->return_data = $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $data);
		
		return $this->return_data;
		
	}
	
	function months()
	{
	  
		$this->pad = $this->_fetch_param('pad', $this->pad);
		$this->reverse = $this->_fetch_bool_param('reverse', $this->reverse);
	  
	  $data = array();
	  
	  foreach ($this->months as $num => $month)
	  {
	    $data[] = array(
 	     'month:num' => $num,
	     'month:num:padded' => $this->_pad_value($num, $this->pad),
	     'month:short' => $this->EE->lang->line($month[0]),
	     'month:long' => $this->EE->lang->line($month[1]),
	     'month' => $this->EE->lang->line($month[1])
	    );
	  }
	  
		if ($this->reverse)
		{
		  $data = array_reverse($data);
		}	  
	  
	  $this->return_data = $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $data);
	  
	  return $this->return_data;
	}
	
	function weekdays()
	{
	  $data = array();
	  
	  foreach ($this->days as $num => $day)
	  {
	    $data[] = array(
 	     'day:num' => $num,
	     'day:num:padded' => $this->_pad_value($num, 2),
	     'day:short' => $this->EE->lang->line($day[0]),
	     'day:medium' => $this->EE->lang->line($day[1]),
	     'day:long' => $this->EE->lang->line($day[2]),
	     'day' => $this->EE->lang->line($day[2])
	    );
	  }
	  
	  $this->return_data = $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $data);
	  
	  return $this->return_data;
	}	
	
	function _pad_value($val=FALSE, $len=0)
	{
	  if ( is_numeric($len) && $len > 0)
	  {
	    return str_pad($val, (int) $len, '0', STR_PAD_LEFT);
	  }
	  
	  return $val;
	}
	
  /**
  * Helper function for getting a parameter
  */		 
  function _fetch_param($key='', $default_value = FALSE)
  {
    $val = $this->EE->TMPL->fetch_param($key);

    if ($val === '' OR $val === FALSE)
    {
      return $default_value;
    }
    
    return $val;
  }	
  
  function _fetch_bool_param($key='', $default_value = FALSE)
  {
    $val = $this->_fetch_param($key, $default_value);
    
    return in_array($val, array('y', 'yes', '1', 'true')) ? TRUE : FALSE;
  }

  function usage()
  {
	  ob_start(); 
  ?>
		Description:

		{exp:rangee step='1' start='1' end='10'}
		  Start: {start}<br />
		  Number: {number}<br />
		  End: {end}
    {/exp:rangee}
		------------------------------------------------------
		
		Parameters:

		step='1'
		start='1'
		end='25'
		limit='25'

  <?php
	  $buffer = ob_get_contents();

	  ob_end_clean(); 

	  return $buffer;
	  }
	  // END

	}


if( ! function_exists('debug') )
{
  function debug($val, $exit=true)
  {
    echo "<pre>".print_r($val, true)."</pre>";
    if($exit) exit; 
  }  
}

/* End of file pi.rangee.php */ 
/* Location: ./system/expressionengine/third_party/plugin_name/pi.rangee.php */