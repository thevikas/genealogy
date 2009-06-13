<p></p><div class="searchbox">
<table width="100%" border="0">
<form action="search_person.php" target="_new">
<? #200508020724:vikas:added name INPUT tag also ?>
<tr><td align="right">Name:</td><td><input type="text" name="name"></td></tr>
<tr><td align="right">First Name:</td><td><input type="text" name="firstname"></td></tr>
<tr><td align="right">Last Name:</td><td><input type="text" name="lastname"></td></tr>
<tr><td align="right">City:</td><td><input type="text" name="city"></td></tr>

<tr><td align="right">Travel Agent:</td><td><input type="text" name="travel_agent"></td></tr>

<input type="hidden" value="0" name="stype">
<tr><td></td><td colspan="2">
<input type="submit" value="Search">
<input type="submit" value="Rush Hour" onclick="this.form.stype.value=1;">
[<a href="searchmore.php">Advanced</a>]
</td></tr>
</form>
</table>
</div>