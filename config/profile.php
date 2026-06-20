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
    'tagline'   => 'Building Indonesia’s digital logistics, AI & IoT future, from blueprint to production.',
    'location'  => 'South Tangerang, Indonesia',
    'website'   => 'www.logilink.id',
    'website_url' => 'https://www.logilink.id',
    'email'     => 'm.luthfirrahman97@gmail.com',
    'phone'     => '(+62) 878-0943-2148',
    'phone_raw' => '6287809432148',

    // SEO (editable in admin)
    'socials'             => [],   // profile URLs (LinkedIn, GitHub, etc.) for search engines
    'google_verification' => '',   // Google Search Console "HTML tag" verification code

    // Images (editable in admin; paths relative to /public)
    'hero_image'       => 'img/hero.jpg',
    'about_image'      => 'img/avatar-toon.jpg',
    'about_real_image' => 'img/photo.jpg',
    'logo_mark'        => 'img/logo-mark.png',
    'logo_full'        => 'img/logo-full.png',

    'about' => 'Technology leader with a decade of experience spanning fullstack development, '
        .'IoT, artificial intelligence and large-scale logistics platforms. I’ve taken products '
        .'from a blank page to nationwide adoption, including Indonesia’s first logistics digital '
        .'platform and the Kartu Prakerja program, and currently lead engineering strategy as CEO '
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
            'period'  => '2023 - Now',
            'current' => true,
            'summary' => 'Define and execute the company’s technology strategy, oversee system '
                .'architecture and software development, and lead engineering teams to deliver secure, '
                .'scalable and reliable platforms that align technology with business objectives, '
                .'regulatory requirements and operational needs while driving continuous innovation.',
            'tags' => ['Leadership', 'System Architecture', 'Strategy'],
        ],
        [
            'role'    => 'Assistant Researcher',
            'company' => 'PwC Republic of Korea',
            'period'  => '2024 - 2025',
            'current' => false,
            'summary' => 'Conducted research on the Electronic Certificate of Origin between ASEAN '
                .'countries and the Republic of Korea, identifying the most effective and efficient '
                .'solutions for cross-border data and document exchange.',
            'tags' => ['Research', 'e-CO', 'ASEAN-Korea'],
        ],
        [
            'role'    => 'Fullstack Web Developer',
            'company' => 'PT GUUD Logistics Indonesia',
            'period'  => '2020 - 2023',
            'current' => false,
            'summary' => 'Developed the first logistics digital platform in Indonesia, covering Container '
                .'Depot Management, Yard Management, Customs Clearance, Port Gatepass and Invoice Financing systems.',
            'tags' => ['Laravel', 'Fullstack', 'Logistics'],
        ],
        [
            'role'    => 'IT Expert, Kartu Prakerja',
            'company' => 'Coordinating Ministry for Economic Affairs, Republic of Indonesia',
            'period'  => '2020',
            'current' => false,
            'summary' => 'Built prototypes for Kartu Prakerja Indonesia, from blueprints, requirement '
                .'gathering and data analytics to fullstack development and project management, taking the '
                .'product all the way to market with no initial blueprint to work from.',
            'tags' => ['GovTech', 'Prototyping', 'Data Analytics'],
        ],
        [
            'role'    => 'IoT Developer',
            'company' => 'PT Total Optima Energi',
            'period'  => '2019',
            'current' => false,
            'summary' => 'Created an OEE system to track industrial machine effectiveness, collecting data '
                .'through a Node-RED middleware and surfacing it in a custom dashboard to support executive '
                .'decision-making.',
            'tags' => ['IoT', 'Node-RED', 'Dashboards'],
        ],
    ],

    'portfolio' => [
        [
            'name'     => 'Logilink',
            'category' => 'Company · Digital Platforms',
            'desc'     => 'The technology company I lead as CEO of PT Logilink Global Utama, building secure, '
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
            'desc'     => 'A modern Port Operating System (POS) that digitizes seaport operations end to end, '
                .'from vessel and berth planning to yard and gate management and real-time cargo visibility, '
                .'lifting throughput, accuracy and transparency across terminals.',
            'tags'     => ['Port Ops', 'Maritime', 'Logistics'],
            'url'      => 'https://bll-sts.com',
            'cta'      => 'Visit bll-sts.com',
            'accent'   => 'b',
            'preview'  => 'img/preview-bll.png',
        ],
        [
            'name'     => 'Logilink Smart Customer Services',
            'category' => 'Live Internal Platform',
            'desc'     => 'The customer-service platform we run live at Logilink. It brings every customer '
                .'WhatsApp conversation into one shared team inbox, automatically routes and assigns each chat to '
                .'the right agent, and handles ticketing, quick replies and per-agent performance tracking, so the '
                .'support team can respond faster and more consistently. Access is restricted to the Logilink support team.',
            'tags'     => ['Customer Service', 'WhatsApp', 'Team Inbox'],
            'url'      => 'https://cs.mluthfirr.id',
            'cta'      => 'Open platform',
            'accent'   => 'c',
            'preview'  => 'img/preview-cs.png',
            'badge'    => 'Live',
            'note'     => 'Staff login required',
        ],
        [
            'name'     => 'AI Medical Assistant',
            'category' => 'Clinical Decision Support',
            'desc'     => 'An AI tool that supports doctors in diagnosing patients — strictly assistive, never the '
                .'final decision. Upload a patient-record PDF for an AI-drafted clinical summary and differential '
                .'diagnosis, or upload a CT scan image to get the scan back with labelled boxes marking regions of '
                .'interest and their findings. Built on OpenAI, with bilingual (Indonesian/English) output.',
            'tags'     => ['AI', 'Healthcare', 'OpenAI'],
            'url'      => 'https://medic.mluthfirr.id',
            'cta'      => 'Open tool',
            'accent'   => 'a',
            'preview'  => 'img/preview-medic.png',
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
            'period' => '2020 - 2023',
        ],
        [
            'degree' => 'Bachelor of Computer Science',
            'school' => 'IPB University',
            'period' => '2015 - 2019',
        ],
    ],

    'certifications' => [
        ['name' => 'Certified System Analyst', 'issuer' => ''],
        ['name' => 'Certified Data Analyst',   'issuer' => ''],
    ],

    'reference' => [
        'name'  => 'Muwasiq M Noor',
        'title' => 'Researcher · PwC Korea · UNESCAP Expert',
        'phone' => '(+62) 878-0943-2148',
        'email' => 'muwasiq@gmail.com',
    ],
];
