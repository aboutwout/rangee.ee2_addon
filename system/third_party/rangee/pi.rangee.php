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
	     'month:short:lowercase' => strtolower($this->EE->lang->line($month[0])),
	     'month:short:uppercase' => strtoupper($this->EE->lang->line($month[0])),
	     'month:short:capitalize' => ucfirst($this->EE->lang->line($month[0])),
	     'month:long' => $this->EE->lang->line($month[1]),
	     'month:long:lowercase' => strtolower($this->EE->lang->line($month[1])),
	     'month:long:uppercase' => strtoupper($this->EE->lang->line($month[1])),
	     'month:long:capitalize' => ucfirst($this->EE->lang->line($month[1])),
	     'month' => $this->EE->lang->line($month[1]),
	     'month:lowercase' => strtolower($this->EE->lang->line($month[1])),
	     'month:uppercase' => strtoupper($this->EE->lang->line($month[1])),
	     'month:capitalize' => ucfirst($this->EE->lang->line($month[1]))
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
		$this->pad = $this->_fetch_param('pad', $this->pad);
		$this->reverse = $this->_fetch_bool_param('reverse', $this->reverse);

	  $data = array();
 
	  foreach ($this->days as $num => $day)
	  {
	    $data[] = array(
 	     'day:num' => $num,
	     'day:num:padded' => $this->_pad_value($num, 2),
	     'day:short' => $this->EE->lang->line($day[0]),
	     'day:short:lowercase' => strtolower($this->EE->lang->line($day[0])),
	     'day:short:uppercase' => strtoupper($this->EE->lang->line($day[0])),
	     'day:short:capitalize' => ucfirst($this->EE->lang->line($day[0])),
	     'day:medium' => $this->EE->lang->line($day[1]),
	     'day:medium:lowercase' => strtolower($this->EE->lang->line($day[1])),
	     'day:medium:uppercase' => strtoupper($this->EE->lang->line($day[1])),
	     'day:medium:capitalize' => ucfirst($this->EE->lang->line($day[1])),
	     'day:long' => $this->EE->lang->line($day[2]),
	     'day:long:lowercase' => strtolower($this->EE->lang->line($day[2])),
	     'day:long:uppercase' => strtoupper($this->EE->lang->line($day[2])),
	     'day:long:capitalize' => ucfirst($this->EE->lang->line($day[2])),
	     'day' => $this->EE->lang->line($day[2]),
	     'day:lowercase' => strtolower($this->EE->lang->line($day[2])),
	     'day:uppercase' => strtoupper($this->EE->lang->line($day[2])),
	     'day:capitalize' => ucfirst($this->EE->lang->line($day[2]))
	    );
	  }
	  
		if ($this->reverse)
		{
		  $data = array_reverse($data);
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
  
  Rangee aims to ease the use of ranges in your EE templates.

  No more will you hardcode those pesky month dropdowns or year selects!
  No more will you resort to PHP in your templates!
  No more.. !

  Define a start and end value and Rangee will do the rest. You can even use basic equations in the parameter to have a truly dynamic range (handy for year selects).

  Need to put output a padded value? No problem, Rangee can pad your numbers for you... so if you need a number like 007, just specify the pad='3'.

  Rangee comes with the following tags:

  <h4>{exp:rangee:numbers}</h4>
  Like it suggests, this outputs a range of numbers.

  <strong>Parameters</strong>
  start = Start range (default = 1)
  end = End range
  limit = If the end parameter hasn't been specified, limit is added to the start value (default = 25)
  step = The increment for each step (default = 1)
  pad = Pad the number to a certain length
  reverse = Reverse the order of the returned range (default = no)

  <strong>Variables</strong>
  {number} = output the value  (ex: 7)
  {number:padded} = outputs the padded value (ex. 007)
  {start} = The start value
  {end} = The end value
  {step} = The step value

  <strong>Examples</strong>
  <pre><code>// Output a range from 01 to 31
  <select name="bday_d" id="bday_d">
    <option value="">Day</option>
    {exp:rangee:numbers start='1' end='31' pad='2'}
      <option value="{number}">{number:padded}</option>
    {/exp:rangee:numbers}
  </select></code></pre>

  <pre><code>// Output a list of years from 1993 to 1921
  <select name="bday_y" id="bday_y">
    <option value="">Year</option>
  {exp:rangee:numbers start='{current_time format="%Y"} - 90' end='{current_time format="%Y"} - 18' reverse='yes'}
    <option>{number}</option>
  {/exp:rangee:numbers}
  </select></code></pre>


  <h4>{exp:rangee:months}</h4>
  Output a list of the months. The returned values are always localized to the current users' language.

  <strong>Variables</strong>
  pad = Pad the month numbers
  reverse = Reverse the returned months

  <strong>Variables</strong>
  {month} = The full name of the month (ex. 'January').
  {month:long} = Same as {month} variable.
  {month:short} = The abbreviated version of the month (ex. 'Jan').
  {month:num} = The month number (ex. '1')
  {month:num:padded} = The padded version of the month number (ex. 01)

  <strong>Examples</strong>
  <pre><code>// Output months
  <select name="bday_m" id="bday_m">
    <option value="">Month</option>
    {exp:rangee:months}
      <option value='{month:num}'>{month}</option>
    {/exp:rangee:months}
  </select>
  </code></pre>


  <h4>{exp:rangee:weekdays}</h4>
  Output a list of days in the week.

  <strong>Parameters</strong>
  pad = Pad the weekday numbers
  reverse = Reverse the returned weekdays

  <strong>Variables</strong>
  {day} = The full weekday name (ex. 'Friday')
  {day:long} = Same as {day} variable
  {day:medium} = The shortened name of the weekday (ex. 'Fri')
  {day:short} = The minimal version of the weekday name (ex. 'Fr')
  {day:num} = Number of the weekday (Sunday = 1, Saturday = 7)
  {day:num:padded} = Padded number of the weekday

  <strong>Examples</strong>
  <pre><code>// Simple list of weekdays
  <ul>
    {exp:rangee:weekdays pad='2'}
      <li>{day:num:padded}. {day:long}</li>
    {/exp:rangee:weekdays}
  </ul></code></pre>

  Right now Rangee comes with these 3 tags, but that's just because I ran out of inspiration and things that should be in it. If you have any suggestions, drop me a line!







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