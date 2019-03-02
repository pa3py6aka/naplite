<?php
return [
    'CKEditorPreset' => [
        'editorOptions' => [
            'preset' => 'basic',
            'height' => 400,
            'contentsCss' => [
                '/css/main.css',
                '/font-awesome-4.7.0/css/font-awesome.min.css',
                '/css/fixes.css',
            ],
            'enterMode' => '3',
            'allowedContent' => true,
            'toolbarGroups' => [
                ['name' => 'clipboard', 'groups' => ['clipboard']],
                ['name' => 'paragraph', 'groups' => ['list']],
                ['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
            ],
            'removeButtons' => 'Table,Cut,Copy,Paste,Anchor,Image,TextColor,BGColor,About,RemoveFormat,Strike,Subscript,Superscript,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe',
            /*'extraPlugins' => [
                'image',
            ],*/
        ]
    ],
];
