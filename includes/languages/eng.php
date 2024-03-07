<?php
function lang($phrase){
    static $results=array(
        // navbar link
        "BRAND"         => 'Home',
        'CATEGORIES'    => 'Categories',
        'ITEMS'         => 'items',
        "COMMENTS"      => 'Comments',
        'STATISTICS'    => 'Statistics',
        "MEMBERS"       => 'Members',
        'LOGS'          => 'Logs',
        'EDIT_PROFILE'  => 'Edit Profile',
        "SETTING"       => 'Setting',
        "LOG_OUT"       => 'Logout'
    );
    return $results[$phrase];
}
?>