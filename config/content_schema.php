<?php

/*
| Schema that drives the admin panel. Each section maps to a key in the
| profile content. type "single" = one set of fields; "collection" = a
| repeatable list of items. Field types: text, textarea, checkbox, taglist, image.
*/

return [
    'profile' => [
        'label' => 'Profile & Identity',
        'icon'  => '👤',
        'type'  => 'single',
        'fields' => [
            'name'        => ['label' => 'Full name', 'type' => 'text'],
            'first'       => ['label' => 'First name (hero kicker)', 'type' => 'text'],
            'last'        => ['label' => 'Last name (big hero lines)', 'type' => 'text'],
            'initials'    => ['label' => 'Initials', 'type' => 'text'],
            'role'        => ['label' => 'Role / headline', 'type' => 'text'],
            'tagline'     => ['label' => 'Tagline', 'type' => 'textarea'],
            'about'       => ['label' => 'About paragraph', 'type' => 'textarea'],
            'location'    => ['label' => 'Location', 'type' => 'text'],
            'email'       => ['label' => 'Email', 'type' => 'text'],
            'phone'       => ['label' => 'Phone (display)', 'type' => 'text'],
            'phone_raw'   => ['label' => 'Phone (WhatsApp, digits only)', 'type' => 'text'],
            'website'     => ['label' => 'Website (display)', 'type' => 'text'],
            'website_url' => ['label' => 'Website URL', 'type' => 'text'],
            'socials'     => ['label' => 'Social / profile links for Google (comma-separated URLs)', 'type' => 'taglist'],
            'google_verification' => ['label' => 'Google Search Console verification code (from the "HTML tag" method)', 'type' => 'text'],
            'hero_image'        => ['label' => 'Hero photo', 'type' => 'image'],
            'about_image'       => ['label' => 'About image (shown by default / illustration)', 'type' => 'image'],
            'about_real_image'  => ['label' => 'About image (revealed on hover)', 'type' => 'image'],
            'logo_mark'   => ['label' => 'Logo mark (nav / loader)', 'type' => 'image'],
            'logo_full'   => ['label' => 'Logo full (footer)', 'type' => 'image'],
        ],
    ],

    'stats' => [
        'label' => 'Stats',
        'icon'  => '📊',
        'type'  => 'collection',
        'item_label' => 'value',
        'fields' => [
            'value' => ['label' => 'Value', 'type' => 'text'],
            'label' => ['label' => 'Label', 'type' => 'text'],
        ],
    ],

    'experiences' => [
        'label' => 'Experience',
        'icon'  => '💼',
        'type'  => 'collection',
        'item_label' => 'role',
        'fields' => [
            'role'    => ['label' => 'Role', 'type' => 'text'],
            'company' => ['label' => 'Company', 'type' => 'text'],
            'period'  => ['label' => 'Period (e.g. 2023 - Now)', 'type' => 'text'],
            'summary' => ['label' => 'Summary', 'type' => 'textarea'],
            'current' => ['label' => 'Current role', 'type' => 'checkbox'],
            'tags'    => ['label' => 'Tags (comma-separated)', 'type' => 'taglist'],
        ],
    ],

    'portfolio' => [
        'label' => 'Work / Portfolio',
        'icon'  => '🚀',
        'type'  => 'collection',
        'item_label' => 'name',
        'fields' => [
            'name'     => ['label' => 'Name', 'type' => 'text'],
            'category' => ['label' => 'Category', 'type' => 'text'],
            'desc'     => ['label' => 'Description', 'type' => 'textarea'],
            'url'      => ['label' => 'Link URL', 'type' => 'text'],
            'cta'      => ['label' => 'Button text', 'type' => 'text'],
            'preview'  => ['label' => 'Preview image', 'type' => 'image'],
            'tags'     => ['label' => 'Tags (comma-separated)', 'type' => 'taglist'],
            'badge'    => ['label' => 'Badge (optional)', 'type' => 'text'],
            'note'     => ['label' => 'Note (optional)', 'type' => 'text'],
        ],
    ],

    'skills' => [
        'label' => 'Expertise / Skills',
        'icon'  => '🧠',
        'type'  => 'collection',
        'item_label' => 'name',
        'fields' => [
            'name' => ['label' => 'Skill', 'type' => 'text'],
        ],
    ],

    'education' => [
        'label' => 'Education',
        'icon'  => '🎓',
        'type'  => 'collection',
        'item_label' => 'degree',
        'fields' => [
            'degree' => ['label' => 'Degree', 'type' => 'text'],
            'school' => ['label' => 'School', 'type' => 'text'],
            'period' => ['label' => 'Period', 'type' => 'text'],
        ],
    ],

    'certifications' => [
        'label' => 'Certifications',
        'icon'  => '📜',
        'type'  => 'collection',
        'item_label' => 'name',
        'fields' => [
            'name'   => ['label' => 'Certification', 'type' => 'text'],
            'issuer' => ['label' => 'Issuer (optional)', 'type' => 'text'],
        ],
    ],
];
