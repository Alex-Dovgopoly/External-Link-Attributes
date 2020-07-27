<?php
//Get all post types
function getCurrentPostTypes()
{
    $post_types = get_post_types( [ 'publicly_queryable'=>1 ] );
    $post_types['page'] = 'page';       // встроенный тип не имеет publicly_queryable
    unset( $post_types['attachment'] ); // удалим attachment
    return ($post_types);
}