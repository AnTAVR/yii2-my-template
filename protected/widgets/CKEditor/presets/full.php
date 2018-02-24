<?php
return [
    'height' => 400,
    'toolbarGroups' => [
        ['name' => 'tools', 'groups' => ['mode', 'tools']],
        ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
        ['name' => 'doctools', 'groups' => ['document', 'doctools']],
        ['name' => 'selection', 'groups' => ['find', 'selection']], //, 'spellchecker'
        ['name' => 'paragraph', 'groups' => ['list', 'indent', 'align', 'blocks', 'bidi']],
        ['name' => 'links', 'groups' => ['links', 'insert']],
        ['name' => 'forms'],
        '/',
        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors', 'styles', 'cleanup']],
        ['name' => 'others'],
    ],
    'extraPlugins' => 'ajax,colorbutton,font,bidi,codesnippet',
    'removePlugins' => 'stylescombo',
    'removeButtons' => '',
    'removeDialogTabs' => '',
];
