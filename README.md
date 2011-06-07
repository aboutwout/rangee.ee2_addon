
### Examples

**Days**

Aside the {number} tag, you also get a {number:padded} tag to output the padded value if the 'pad' parameter has been specified. (Zero's are prefixed)

    // Output a range from 01 to 31
    <select name="bday_d" id="bday_d">
      <option value="">Day</option>
    {exp:rangee:numbers start='1' end='31' pad='2'}
      <option value="{number}">{number:padded}</option>
    {/exp:rangee:numbers}
    </select>


**Months**

Output a list of the months. The month names are always localized in the language the current user has set.

    // Output months
    <select name="bday_m" id="bday_m">
      <option value="">Month</option>
    {exp:rangee:months}
      <option value='{month:num}'>{month}</option>
    {/exp:rangee:months}
    </select>


**Years**

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