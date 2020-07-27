<?php
$currentOption = get_option('option_attr');
$currentOptionNofollow = $currentOption ? $currentOption['nofollow'] : null;
$currentOptionBlank = $currentOption ? $currentOption['blank'] : null;
//var_dump($currentOptionNofollow);
//var_dump($currentOptionBlank);
//$post_types_arr = getCurrentPostTypes();
//var_dump($post_types_arr);

if($currentOptionNofollow == '1') {
    add_filter('the_content', 'my_nofollow');
    add_filter('the_excerpt', 'my_nofollow');

    function my_nofollow($content) {
        return preg_replace_callback('/<a[^>]+/', 'my_nofollow_callback', $content);
    }

    function my_nofollow_callback($matches) {
        $link = $matches[0];
        $site_link = get_bloginfo('url');

        if (strpos($link, 'rel') === false) {
            $link = preg_replace("%(href=\S(?!$site_link))%i", 'rel="nofollow" $1', $link);
        } elseif (preg_match("%href=\S(?!$site_link)%i", $link)) {
            //var_dump($link);
            $link = preg_replace('/rel=\S(?!nofollow)\S*/i', 'rel="nofollow"', $link);
        }
        return $link;
    }
}

if($currentOptionBlank == '1') {
    add_filter('the_content', 'my_attr_blank');
    add_filter('the_excerpt', 'my_attr_blank');

    function my_attr_blank($content)
    {
        return preg_replace_callback('/<a[^>]+/', 'my_attr_blank_callback', $content);
    }

    function my_attr_blank_callback($matches)
    {
        $link = $matches[0];
        $site_link = get_bloginfo('url');

        if (strpos($link, 'target') === false) {
            $link = preg_replace("%(href=\S(?!$site_link))%i", 'target="_blank" $1', $link);
        } elseif (preg_match("%href=\S(?!$site_link)%i", $link)) {
            $link = preg_replace('/target=\S(?!_blank)\S*/i', 'target="_blank"', $link);
        }
        return $link;
    }
}
