<form name="input" method="post">
    <label for="lon">longitude</label><input type="text" name="lon" value="<?php echo $lon; ?>"/><br />
    <label for="lat">latidude</label><input type="text" name="lat" value="<?php echo $lat; ?>"/><br />
    <label for="lat">power</label><input type="text" name="power" value="<?php echo $power; ?>"/><br />
    <label for="name">name</label><input type="text" name="name" value="<?php echo $name; ?>"/><br />
    <label for="ref">ref</label><input type="text" name="ref" value="<?php echo $ref; ?>"/><br />
    <label for="pole">pole</label><input type="text" name="pole" value="<?php echo $pole; ?>"/><br />
    <label for="gas_insulated">gas_insulated</label><input type="text" name="gas_insulated" value="<?php echo $gas_insulated; ?>"/><br />
    <label for="operator">operator</label><input type="text" name="operator" value="<?php echo $operator; ?>"/><br />
    <label for="substation">substation</label><input type="text" name="substation" value="<?php echo $substation; ?>"/><br />
    <label for="location">location</label><input type="text" name="location" value="<?php echo $location; ?>"/><br />
    <label for="voltage">voltage</label><input type="text" name="voltage" value="<?php echo $voltage; ?>"/><br />
    <label for="transformer">transformer</label><input type="text" name="transformer" value="<?php echo $transformer; ?>"/><br />
    <label for="frequency">frequency</label><input type="text" name="frequency" value="<?php echo $frequency ?>"/><br />
    <label for="phases">phases</label><input type="text" name="phases" value="<?php echo $phases; ?>"/><br />
    <label for="rating">rating</label><input type="text" name="rating" value="<?php echo $rating; ?>"/><br />
    <label for="generatorsource">generator:source</label><input type="text" name="generatorsource" value="<?php echo $generatorsource; ?>"/><br />
    <label for="generatormethod">generator:method</label><input type="text" name="generatormethod" value="<?php echo $generatormethod; ?>"/><br />
    <label for="generatortype">generator:type</label><input type="text" name="generatortype" value="<?php echo $generatortype; ?>"/><br />
    <label for="generatorplant">generator:plant</label><input type="text" name="generatorplant" value="<?php echo $generatorplant; ?>"/><br />
    <input type="submit" name="send" value="Insert"/>
</form>