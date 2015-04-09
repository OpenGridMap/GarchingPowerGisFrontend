<form name="input" method="post">
    <span>mandatory:</span><br />
    <label for="lon">longitude</label><input type="text" name="lon" value="<?php echo $lon; ?>"/><br />
    <label for="lat">latidude</label><input type="text" name="lat" value="<?php echo $lat; ?>"/><br />
    <span>recommended:</span><br />
    <label for="substation">substation</label><input type="text" name="substation" value="<?php echo $substation; ?>"/><br />
    <label for="location">location</label><input type="text" name="location" value="<?php echo $location; ?>"/><br />
    <label for="voltage">voltage</label><input type="text" name="voltage" value="<?php echo $voltage; ?>"/><br />
    <label for="name">name</label><input type="text" name="name"  value="<?php echo $name; ?>"/><br />
    <span>optional:</span><br />
    <label for="gas_insulated">gas_insulated</label><input type="text" name="gas_insulated" value="<?php echo $gas_insulated; ?>"/><br />
    <label for="operator">operator</label><input type="text" name="operator" value="<?php echo $operator; ?>"/><br />
    <label for="ref">ref</label><input type="text" name="ref" value="<?php echo $ref; ?>"/><br />
    <input type="submit" name="send" value="Insert"/>
</form>