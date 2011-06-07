
### Examples
    // Output a range from 1 to 31
    <select name="bday_d" id="bday_d">
      <option value="">Day</option>
    {exp:rangee:numbers start='1' end='31'}
      <option>{value}</option>
    {/exp:rangee:numbers}
    </select>
    
    // Output months
    <select name="bday_m" id="bday_m">
      <option value="">Month</option>
    {exp:rangee:months}
      <option value='{month:num}'>{month}</option>
    {/exp:rangee:months}
    </select>
    
    // Output a range of years with a simple expression in the parameter.
    // "{current_time format='%Y'} - 18" gives: 2011 - 18 = 1993
    // "{current_time format='%Y'} - 90" gives: 2011 - 18 = 1921
    // reverse='yes' reverses the order of the returned range
    <select name="bday_y" id="bday_y">
      <option value="">Year</option>
    {exp:rangee:numbers start='{current_time format="%Y"} - 90' end='{current_time format="%Y"} - 18' reverse='yes'}
      <option>{value}</option>
    {/exp:rangee:numbers}
    </select>