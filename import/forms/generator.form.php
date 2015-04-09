<form name="input" method="post">
    <input type="hidden" name="power" value="<?php echo $power; ?>"/>
    <label for="lon">longitude</label><input type="text" name="lon" value="<?php echo $lon; ?>"/><br />
    <label for="lat">latidude</label><input type="text" name="lat" value="<?php echo $lat; ?>"/><br />
    <label for="generatorsource">generator:source</label><input type="text" name="generatorsource" value="<?php echo $generatorsource; ?>"/><br />
    <label for="generatormethod">generator:method</label><input type="text" name="generatormethod" value="<?php echo $generatormethod; ?>"/><br />
    <label for="generatortype">generator:type</label><input type="text" name="generatortype" value="<?php echo $generatortype; ?>"/><br />
    <label for="generatorplant">generator:plant</label><input type="text" name="generatorplant" value="<?php echo $generatorplant; ?>"/><br />
    <label for="name">name</label><input type="text" name="name" value="<?php echo $name; ?>"/><br />
    <label for="operator">operator</label><input type="text" name="operator" value="<?php echo $operator; ?>"/><br />
    <input type="submit" name="send" value="Insert"/>
</form>