<?php
// includes/curriculum.php

// 1. Active Labs List
$activeLabs = [
    [
        'id' => 'projectile',
        'title' => 'Projectile Motion',
        'href' => '/lab/projectile',
        'icon' => '🚀',
        'badge' => 'Grade 11',
        'desc' => 'Analyze parabolic trajectories, launch angles, and maximum range.'
    ],
    [
        'id' => 'incline',
        'title' => 'Inclined Plane',
        'href' => '/lab/incline',
        'icon' => '📐',
        'badge' => 'Grade 10',
        'desc' => 'Resolve gravity into normal and parallel force components.'
    ],
    [
        'id' => 'friction',
        'title' => 'Friction & Motion',
        'href' => '/lab/friction',
        'icon' => '🛷',
        'badge' => 'Grade 10',
        'desc' => 'Experiment with static and kinetic coefficients of friction.'
    ],
    [
        'id' => 'newtons-second-law',
        'title' => "Newton's Second Law",
        'href' => '/lab/newtons-second-law',
        'icon' => '⚡',
        'badge' => 'Grade 10',
        'desc' => 'Verify the direct relation between net force, mass, and acceleration (F = ma).'
    ],
    [
        'id' => 'atwood-incline',
        'title' => 'Atwood Machine on Incline',
        'href' => '/lab/atwood-incline',
        'icon' => '⚙️',
        'badge' => 'Grade 11',
        'desc' => 'Calculate system acceleration with connected masses over pulleys.'
    ],
    [
        'id' => 'double-pulley',
        'title' => 'Double Pulley System',
        'href' => '/lab/double-pulley',
        'icon' => '🏗️',
        'badge' => 'Grade 11',
        'desc' => 'Determine mechanical advantage and tension distribution.'
    ],
    [
        'id' => 'collisions',
        'title' => 'Momentum & Collisions',
        'href' => '/lab/collisions',
        'icon' => '💥',
        'badge' => 'Grade 12',
        'desc' => 'Investigate elastic and inelastic collisions in 1D space.'
    ]
];

// 2. Theory Notes & Core Formulas (Used in theory.php)
$theoryNotes = [
    [
        'grade' => '10',
        'color' => 'Grade 10',
        'topics' => [
            [
                'title' => 'Kinematics & Motion',
                'formulas' => [
                    'v = u + at',
                    's = ut + ½at²',
                    'v² = u² + 2as',
                    's = ½(u + v)t'
                ]
            ],
            [
                'title' => "Newton's Laws & Friction",
                'formulas' => [
                    'F_net = ma',
                    'W = mg',
                    'f_s ≤ μ_s N',
                    'f_k = μ_k N'
                ]
            ]
        ]
    ],
    [
        'grade' => '11',
        'color' => 'Grade 11',
        'topics' => [
            [
                'title' => 'Projectile Motion',
                'formulas' => [
                    'x = (v₀ cos θ)t',
                    'y = (v₀ sin θ)t - ½gt²',
                    'R = (v₀² sin 2θ) / g',
                    'H = (v₀² sin² θ) / (2g)'
                ]
            ],
            [
                'title' => 'Work, Energy & Pulleys',
                'formulas' => [
                    'W = F d cos θ',
                    'K = ½mv²',
                    'U = mgh',
                    'a = (m₂ - m₁)g / (m₁ + m₂)'
                ]
            ]
        ]
    ],
    [
        'grade' => '12',
        'color' => 'Grade 12',
        'topics' => [
            [
                'title' => 'Momentum & Collisions',
                'formulas' => [
                    'p = mv',
                    'J = F Δt = Δp',
                    'm₁u₁ + m₂u₂ = m₁v₁ + m₂v₂',
                    'e = (v₂ - v₁) / (u₁ - u₂)'
                ]
            ]
        ]
    ]
];

// 3. Syllabus Map / Chapter Overview (Used in theory.php)
$curriculum = [
    [
        'label' => 'Grade 10 Mechanics',
        'chapters' => '1 - 3',
        'color' => 'Grade 10',
        'items' => [
            [
                'num' => 1,
                'title' => 'Introduction to Motion',
                'desc' => 'Understanding displacement, velocity, and acceleration vectors.'
            ],
            [
                'num' => 2,
                'title' => 'Forces and Newton’s Laws',
                'desc' => 'Analyzing forces, inertia, mass, and acceleration relationships.'
            ],
            [
                'num' => 3,
                'title' => 'Friction & Inclined Planes',
                'desc' => 'Static and kinetic friction force components on inclined surfaces.'
            ]
        ]
    ],
    [
        'label' => 'Grade 11 Advanced Mechanics',
        'chapters' => '4 - 6',
        'color' => 'Grade 11',
        'items' => [
            [
                'num' => 4,
                'title' => '2D Kinematics & Projectiles',
                'desc' => 'Decomposing 2D motion vectors into horizontal and vertical components.'
            ],
            [
                'num' => 5,
                'title' => 'Connected Systems & Tension',
                'desc' => 'Pulleys, Atwood machines, and tension distribution across masses.'
            ],
            [
                'num' => 6,
                'title' => 'Work, Power & Energy',
                'desc' => 'Conservation of energy, mechanical work, and power output.'
            ]
        ]
    ],
    [
        'label' => 'Grade 12 Impulse & Dynamics',
        'chapters' => '7 - 8',
        'color' => 'Grade 12',
        'items' => [
            [
                'num' => 7,
                'title' => 'Momentum & Impulse',
                'desc' => 'Linear momentum conservation laws and force-time impulse curves.'
            ],
            [
                'num' => 8,
                'title' => 'Elastic & Inelastic Collisions',
                'desc' => 'Calculating post-impact velocities using coefficients of restitution.'
            ]
        ]
    ]
];

// 4. Helper Function for Dynamic Badges/Colors
function burmalab_grade_colors($grade) {
    switch ($grade) {
        case 'Grade 10':
            return [
                'badge' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
                'border' => 'border-emerald-100',
                'chip' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
            ];
        case 'Grade 11':
            return [
                'badge' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/30',
                'border' => 'border-indigo-100',
                'chip' => 'bg-indigo-50 text-indigo-700 border-indigo-200'
            ];
        case 'Grade 12':
            return [
                'badge' => 'bg-amber-500/10 text-amber-400 border-amber-500/30',
                'border' => 'border-amber-100',
                'chip' => 'bg-amber-50 text-amber-700 border-amber-200'
            ];
        default:
            return [
                'badge' => 'bg-slate-500/10 text-slate-400 border-slate-500/30',
                'border' => 'border-slate-100',
                'chip' => 'bg-slate-50 text-slate-700 border-slate-200'
            ];
    }
}