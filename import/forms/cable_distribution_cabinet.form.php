<form name="input" method="post">
    <label for="lon">longitude</label><input type="text" name="lon" value="<?php echo $lon; ?>"/><br />
    <label for="lat">latidude</label><input type="text" name="lat" value="<?php echo $lat; ?>"/><br />
    <label for="ref">ref</label><input type="text" name="ref" value="<?php echo $ref; ?>"/><br />
    <label for="generatorsource">generator:source</label><input type="text" name="generatorsource" value="<?php echo $generatorsource; ?>"/><br />
    <label for="voltage">voltage</label><input type="text" name="voltage" value="<?php echo $voltage; ?>"/><br />
    <input type="submit" name="send" value="Insert"/>
</form>