<?php
/**
 * The template for displaying search forms in Schechter
 */
?>

    <form role="search" method="get" class="searchform" action="<?php echo home_url( '/' ); ?>">
            <div>
                <input type="hidden" name="post_type" value="page" />
                <label class="screen-reader-text" for="s">Search for:</label>
                <input type="text" value="" name="s" id="s" />
                <input type="submit" id="searchsubmit" value="Search" />
            </div>
    </form>