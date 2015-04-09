<form name="input" method="post">
    <label for="lon">longitude</label><input type="text" name="lon" value="<?php echo $lon; ?>"/><br />
    <label for="lat">latidude</label><input type="text" name="lat" value="<?php echo $lat; ?>"/><br />
    <label for="ref">ref</label><input type="text" name="ref" value="<?php echo $ref; ?>"/><br />
    <label for="pole">pole</label><input type="text" name="pole" value="<?php echo $pole; ?>"/><br />
    <input type="submit" name="send" value="Insert"/>
</form>