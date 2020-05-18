<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
	<input name="s" required type="search" value="<?php echo get_search_query() ?>"
                   placeholder="<?php echo esc_html__('search&hellip;', 'lucille') ?>"
                   class="input-search">

    <button type="submit" class="search-submit" title="<?php echo esc_html__('Search', 'lucille') ?>">
        <i class="fa fa-search"></i>
    </button>
</form>

