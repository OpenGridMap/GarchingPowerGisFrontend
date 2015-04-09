<form name="input" method="post">
    <span>mandatory:</span><br />
    <label for="lon">longitude</label><input type="text" name="lon" value="<?php echo $lon; ?>"/><br />
    <label for="lat">latidude</label><input type="text" name="lat" value="<?php echo $lat; ?>"/><br />
    <span>recommended:</span><br />
    <label for="location">location</label><input type="text" name="location" value="<?php echo $location; ?>"/><br />
    <label for="voltage">voltage</label><input type="text" name="voltage" value="<?php echo $voltage; ?>"/><br />
    <span>optional:</span><br />
    <label for="transformer">transformer</label><input type="text" name="transformer" value="<?php echo $transformer; ?>"/><br />
    <label for="frequency">frequency</label><input type="text" name="frequency" value="<?php echo $frequency ?>"/><br />
    <label for="phases">phases</label><input type="text" name="phases" value="<?php echo $phases; ?>"/><br />
    <label for="rating">rating</label><input type="text" name="rating" value="<?php echo $rating; ?>"/><br />
    <input type="submit" name="send" value="Insert"/>
</form>