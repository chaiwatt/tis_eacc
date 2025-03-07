<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'font_path'             => base_path('resources/fonts/'),
	'font_data'             => [
        'thsarabunnew' => [
            'R'  => 'thsarabunnew-webfont.ttf',             // regular font
            'B'  => 'thsarabunnew_bold-webfont.ttf',        // optional: bold font
            'I'  => 'thsarabunnew_italic-webfont.ttf',      // optional: italic font
            'BI' => 'thsarabunnew_bolditalic-webfont.ttf'   // optional: bold-italic font
        ]
    ]
];
