<?php

/*
|--------------------------------------------------------------------------
| Profile / CV Data
|--------------------------------------------------------------------------
| Single source of truth for the CV website content. Edit values here and
| the front page updates automatically.
*/

return [
    'name'      => 'Muhammad Luthfir Rahman',
    'first'     => 'Muhammad',
    'last'      => 'Luthfir Rahman',
    'initials'  => 'MLR',
    'role'      => 'Programmer, Project Manager & Researcher',
    'tagline'   => 'Building Indonesia’s digital logistics, AI & IoT future — from blueprint to production.',
    'location'  => 'South Tangerang, Indonesia',
    'website'   => 'www.logilink.id',
    'website_url' => 'https://www.logilink.id',
    'email'     => 'm.luthfirrahman97@gmail.com',
    'phone'     => '(+62) 878-0943-2148',
    'phone_raw' => '6287809432148',

    'about' => 'Technology leader with a decade of experience spanning fullstack development, '
        .'IoT, artificial intelligence and large-scale logistics platforms. I’ve taken products '
        .'from a blank page to nationwide adoption — including Indonesia’s first logistics digital '
        .'platform and the Kartu Prakerja program — and currently lead engineering strategy as CEO '
        .'of PT Logilink Global Utama.',

    'stats' => [
        ['value' => '10+',  'label' => 'Years in Tech'],
        ['value' => '5+',   'label' => 'Platforms Shipped'],
        ['value' => '2',    'label' => 'Degrees in CS'],
        ['value' => '3',    'label' => 'Countries Worked With'],
    ],

    'experiences' => [
        [
            'role'    => 'Chief Executive Officer',
            'company' => 'PT Logilink Global Utama',
            'period'  => '2023 — Now',
            'current' => true,
            'summary' => 'Define and execute the company’s technology strategy, oversee system '
                .'architecture and software development, and lead engineering teams to deliver secure, '
                .'scalable and reliable platforms — aligning technology with business objectives, '
                .'regulatory requirements and operational needs while driving continuous innovation.',
            'tags' => ['Leadership', 'System Architecture', 'Strategy'],
        ],
        [
            'role'    => 'Assistant Researcher',
            'company' => 'PwC Republic of Korea',
            'period'  => '2024 — 2025',
            'current' => false,
            'summary' => 'Conducted research on the Electronic Certificate of Origin between ASEAN '
                .'countries and the Republic of Korea, identifying the most effective and efficient '
                .'solutions for cross-border data and document exchange.',
            'tags' => ['Research', 'e-CO', 'ASEAN–Korea'],
        ],
        [
            'role'    => 'Fullstack Web Developer',
            'company' => 'PT GUUD Logistics Indonesia',
            'period'  => '2020 — 2023',
            'current' => false,
            'summary' => 'Developed the first logistics digital platform in Indonesia — Container Depot '
                .'Management, Yard Management, Customs Clearance, Port Gatepass and Invoice Financing systems.',
            'tags' => ['Laravel', 'Fullstack', 'Logistics'],
        ],
        [
            'role'    => 'IT Expert — Kartu Prakerja',
            'company' => 'Coordinating Ministry for Economic Affairs, Republic of Indonesia',
            'period'  => '2020',
            'current' => false,
            'summary' => 'Built prototypes for Kartu Prakerja Indonesia — from blueprints, requirement '
                .'gathering and data analytics to fullstack development and project management — taking the '
                .'product all the way to market with no initial blueprint to work from.',
            'tags' => ['GovTech', 'Prototyping', 'Data Analytics'],
        ],
        [
            'role'    => 'IoT Developer',
            'company' => 'PT Total Optima Energi',
            'period'  => '2019',
            'current' => false,
            'summary' => 'Created an OEE system to track industrial machine effectiveness — collecting data '
                .'through a Node-RED middleware and surfacing it in a custom dashboard to support executive '
                .'decision-making.',
            'tags' => ['IoT', 'Node-RED', 'Dashboards'],
        ],
    ],

    'portfolio' => [
        [
            'name'     => 'Logilink',
            'category' => 'Company · Digital Platforms',
            'desc'     => 'The technology company I lead as CEO of PT Logilink Global Utama — building secure, '
                .'scalable digital platforms across logistics, AI and IoT, and helping enterprises digitize complex '
                .'supply-chain and operational workflows end to end.',
            'tags'     => ['Logistics', 'AI', 'IoT'],
            'url'      => 'https://logilink.id',
            'cta'      => 'Visit logilink.id',
            'accent'   => 'a',
            'preview'  => 'img/preview-logilink.png',
        ],
        [
            'name'     => 'Benua Laut Lepas',
            'category' => 'Port Operating System',
            'desc'     => 'A modern Port Operating System (POS) that digitizes end-to-end seaport operations — '
                .'vessel & berth planning, yard and gate management, and real-time cargo visibility — to lift '
                .'throughput, accuracy and transparency across terminals.',
            'tags'     => ['Port Ops', 'Maritime', 'Logistics'],
            'url'      => 'https://bll-sts.com',
            'cta'      => 'Visit bll-sts.com',
            'accent'   => 'b',
            'preview'  => 'img/preview-bll.png',
        ],
        [
            'name'     => 'Logilink Smart Customer Services',
            'category' => 'Live Internal Platform',
            'desc'     => 'A production multi-agent WhatsApp customer-service platform running live at Logilink — '
                .'a Laravel dashboard paired with a Node/Baileys gateway, with a real-time inbox, auto-assignment & '
                .'smart routing, ticketing, message templates and per-agent performance analytics. Access is '
                .'restricted to the Logilink support team.',
            'tags'     => ['Laravel', 'Node / Baileys', 'Real-time'],
            'url'      => 'https://cs.mluthfirr.id',
            'cta'      => 'Open platform',
            'accent'   => 'c',
            'preview'  => 'img/preview-cs.png',
            'badge'    => 'Live',
            'note'     => 'Staff login required',
        ],
    ],

    'skills' => [
        ['name' => 'Project Management',      'icon' => 'clipboard'],
        ['name' => 'Artificial Intelligence', 'icon' => 'sparkles'],
        ['name' => 'Programming',             'icon' => 'code'],
        ['name' => 'Robotics',                'icon' => 'cpu'],
        ['name' => 'Internet of Things',      'icon' => 'broadcast'],
        ['name' => 'Logistics',              'icon' => 'truck'],
    ],

    'education' => [
        [
            'degree' => 'Master of Computer Science',
            'school' => 'Universitas Indonesia',
            'period' => '2020 — 2023',
        ],
        [
            'degree' => 'Bachelor of Computer Science',
            'school' => 'IPB University',
            'period' => '2015 — 2019',
        ],
    ],

    'reference' => [
        'name'  => 'Muwasiq M Noor',
        'title' => 'Researcher · PwC Korea · UNESCAP Expert',
        'phone' => '(+62) 878-0943-2148',
        'email' => 'muwasiq@gmail.com',
    ],
];
