<?php

return [

    'preferences' => [
        'main'        => 'User Preferences',
        'change'      => 'Change password',
        'permissions' => 'Device / Port permissions',
        'adminaccess' => 'Global Administrative Access',
        'viewaccess'  => 'Global Viewing Access',
        'devices'     => 'Devices',
        'showdevices' => 'Show devices',
        'ports'       => 'Ports',
        'showports'   => 'Show ports',
        'noaccess'    => 'No access!',
    ],
    'manage'      => [
        'adddevice'         => 'Add Device',
        'devicepermissions' => 'Device permissions',
        'alldeviceaccess'   => 'User has access to all devices',
        'addport'           => 'Add Port',
        'portpermissions'   => 'Port permissions',
        'portexplanation'   => 'Includes access to all ports on devices',
        'allportaccess'     => 'User has access to all ports',
        'edituser'          => 'Edit User',
        'userinfo'          => 'User Info',
        'password'          => 'Password',
        'create'            => 'Create New User',
        'deletefailed'      => 'Failed to delete user.',
        'deleteconfirm'     => [
            'title'   => 'Delete User?',
            'message' => 'Are you sure you want to delete this user?',
        ],
    ],
    'text'        => [
        'manage'        => 'Manage',
        'users'         => 'Users',
        'username'      => 'Username',
        'realname'      => 'Real Name',
        'descr'         => 'Description',
        'level'         => 'Level',
        'actions'       => 'Actions',
        'pwdupdated'    => 'Password has been updated',
        'updated'       => 'User <i>:username</i> updated.',
        'deleted'       => 'User <i>:username</i> deleted.',
        'created'       => 'User <i>:username</i> created.',
        'devicesadded'  => 'Device(s) added.',
        'deviceremoved' => 'Device <i>:hostname</i> removed.',
        'portsadded'    => 'Port(s) added.',
        'portremoved'   => 'Port <i>:label</i> removed.',
    ],

    'level' => [
        1  => 'Normal User',
        5  => 'Global Read-Only',
        10 => 'Global Admin',
        11 => 'Demo User',
    ],
    'login' => [
        'username' => 'Username',
        'password' => 'Password',
        'remember' => 'Remember me',
    ],

];
