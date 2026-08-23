<?php
// includes/curriculum.php

// 1. Active Labs List
$activeLabs = [
    [
        'id' => 'measurement',
        'title' => 'Units & Measurement',
        'href' => '/lab/measurement',
        'icon' => '📏',
        'badge' => 'Grade 10 Ch.1',
        'desc' => 'Virtual Vernier calipers and micrometer screw gauge simulation.'
    ],
    [
        'id' => 'kinematics',
        'title' => 'Kinematic Motion',
        'href' => '/lab/kinematics',
        'icon' => '📈',
        'badge' => 'Grade 10 Ch.2',
        'desc' => 'Interactive motion graphs plotting position, velocity, and time.'
    ],
    [
        'id' => 'newtons-second-law',
        'title' => "Newton's Second Law",
        'href' => '/lab/newtons-second-law',
        'icon' => '⚡',
        'badge' => 'Grade 10 Ch.3',
        'desc' => 'Verify the direct relation between net force, mass, and acceleration (F = ma).'
    ],
    [
        'id' => 'friction',
        'title' => 'Friction & Motion',
        'href' => '/lab/friction',
        'icon' => '🛷',
        'badge' => 'Grade 10 Ch.3',
        'desc' => 'Experiment with static and kinetic coefficients of friction.'
    ],
    [
        'id' => 'incline',
        'title' => 'Inclined Plane',
        'href' => '/lab/incline',
        'icon' => '📐',
        'badge' => 'Grade 10 Ch.3',
        'desc' => 'Resolve gravity into normal and parallel force components.'
    ],
    [
        'id' => 'collisions',
        'title' => 'Momentum & Collisions',
        'href' => '/lab/collisions',
        'icon' => '💥',
        'badge' => 'Grade 10 Ch.3',
        'desc' => 'Investigate elastic and inelastic collisions and conservation of momentum.'
    ],
    [
        'id' => 'work-energy',
        'title' => 'Conservation of Energy',
        'href' => '/lab/work-energy',
        'icon' => '🎢',
        'badge' => 'Grade 10 Ch.5',
        'desc' => 'A pendulum simulation tracking kinetic and potential energy conversions.'
    ],
    [
        'id' => 'projectile',
        'title' => 'Projectile Motion',
        'href' => '/lab/projectile',
        'icon' => '🚀',
        'badge' => 'Grade 11 Ch.1',
        'desc' => 'Analyze parabolic trajectories, launch angles, and maximum range.'
    ],
    [
        'id' => 'circular-motion',
        'title' => 'Uniform Circular Motion',
        'href' => '/lab/circular-motion',
        'icon' => '🔄',
        'badge' => 'Grade 11 Ch.1',
        'desc' => 'Visualize velocity vectors, centripetal force, and orbital periods.'
    ],
    [
        'id' => 'torque',
        'title' => 'Torque & Equilibrium',
        'href' => '/lab/torque',
        'icon' => '⚖️',
        'badge' => 'Grade 11 Ch.2',
        'desc' => 'Balance opposing weights on a fulcrum to calculate net rotational torque.'
    ],
    [
        'id' => 'buoyancy',
        'title' => 'Archimedes\' Principle',
        'href' => '/lab/buoyancy',
        'icon' => '⚓',
        'badge' => 'Grade 11 Ch.3',
        'desc' => 'Explore buoyant force, apparent weight, and fluid density.'
    ],
    [
        'id' => 'atwood-incline',
        'title' => 'Atwood Machine on Incline',
        'href' => '/lab/atwood-incline',
        'icon' => '⚙️',
        'badge' => 'Grade 11 Ch.2',
        'desc' => 'Calculate system acceleration with connected masses over pulleys.'
    ],
    [
        'id' => 'double-pulley',
        'title' => 'Double Pulley System',
        'href' => '/lab/double-pulley',
        'icon' => '🏗️',
        'badge' => 'Grade 11 Ch.2',
        'desc' => 'Determine mechanical advantage and tension distribution.'
    ],
    [
    'id' => 'springs',
    'title' => 'Hooke\'s Law & Springs',
    'href' => '/lab/springs',
    'icon' => '〰️',
    'badge' => 'Grade 11 Ch.4',
    'desc' => 'Simulate spring constants, displacement, and elastic potential energy.'
    ],
    [
    'id' => 'banked-curves',
    'title' => 'Banked Curves',
    'href' => '/lab/banked-curves',
    'icon' => '🏎️',
    'badge' => 'Grade 12 Ch.2',
    'desc' => 'Analyze normal and friction forces on a vehicle banking a turn.'
    ],
    [
    'id' => 'fluids',
    'title' => 'Fluid Dynamics',
    'href' => '/lab/fluids',
    'icon' => '💧',
    'badge' => 'Grade 12 Ch.3',
    'desc' => 'Visualize continuity equations and Bernoulli pressure drops.'
    ]
];

// 2. Theory Notes & Core Formulas (Used in theory.php)
$theoryNotes = [
    [
        'grade' => '10',
        'color' => 'Grade 10',
        'topics' => [
            [
                'title' => 'Ch 2: Motion Equations',
                'formulas' => [
                    'v = u + at',
                    's = ut + ½at²',
                    'v² = u² + 2as',
                    's = ½(u + v)t'
                ]
            ],
            [
                'title' => "Ch 3: Forces & Momentum",
                'formulas' => [
                    'F = ma',
                    'W = mg',
                    'f_s ≤ μ_s N',
                    'p = mv',
                    'm₁u₁ + m₂u₂ = m₁v₁ + m₂v₂'
                ]
            ],
            [
                'title' => "Ch 5: Work & Energy",
                'formulas' => [
                    'W = Fs',
                    'E_k = ½mv²',
                    'E_p = mgh'
                ]
            ]
        ]
    ],
    [
        'grade' => '11',
        'color' => 'Grade 11',
        'topics' => [
            [
                'title' => 'Ch 1: Motion in a Plane',
                'formulas' => [
                    'v_x = v₀ cos θ',
                    'v_y = v₀ sin θ - gt',
                    'R = (v₀² sin 2θ) / g',
                    'a_c = v² / r'
                ]
            ],
            [
                'title' => 'Ch 2: Rotational Dynamics',
                'formulas' => [
                    'τ = F r sin θ',
                    'L = I ω',
                    'Στ = 0 (Equilibrium)'
                ]
            ],
            [
                'title' => 'Ch 3: Pressure',
                'formulas' => [
                    'P = ρgh',
                    'F_B = ρ_f V g (Archimedes)'
                ]
            ]
        ]
    ],
    [
        'grade' => '12',
        'color' => 'Grade 12',
        'topics' => [
            [
                'title' => 'Ch 1: Rotational Motion',
                'formulas' => [
                    'ω = ω₀ + αt',
                    'θ = ω₀t + ½αt²',
                    'v = rω',
                    'a_c = rω²'
                ]
            ],
            [
                'title' => 'Ch 3: Fluid Dynamics',
                'formulas' => [
                    'A₁v₁ = A₂v₂ (Continuity)',
                    'P + ½ρv² + ρgh = constant'
                ]
            ]
        ]
    ]
];

// 3. Syllabus Map / Chapter Overview (Used in theory.php)
$curriculum = [
    [
        'label' => 'Grade 10 Mechanics',
        'chapters' => '1 - 5',
        'color' => 'Grade 10',
        'items' => [
            [
                'num' => 1,
                'title' => 'Units and Measurements',
                'desc' => 'Basic and derived units, prefixes, and measurement of length, mass, and time.'
            ],
            [
                'num' => 2,
                'title' => 'Motion',
                'desc' => 'Vectors, describing motion, equations of motion, and motion graphs.'
            ],
            [
                'num' => 3,
                'title' => 'Forces',
                'desc' => 'Newton\'s laws, gravitation, mass, weight, free fall, and conservation of momentum.'
            ],
            [
                'num' => 4,
                'title' => 'Pressure',
                'desc' => 'Density, relative density, and pressure applications.'
            ],
            [
                'num' => 5,
                'title' => 'Work and Energy',
                'desc' => 'Mechanical work, potential energy, kinetic energy, and their conservation.'
            ]
        ]
    ],
    [
        'label' => 'Grade 11 Mechanics',
        'chapters' => '1 - 4',
        'color' => 'Grade 11',
        'items' => [
            [
                'num' => 1,
                'title' => 'Motion in a Plane',
                'desc' => 'Two-dimensional motion, projectile trajectories, and uniform circular motion.'
            ],
            [
                'num' => 2,
                'title' => 'Rotational Dynamics',
                'desc' => 'Scalar/vector products, torque, moment of inertia, and angular momentum.'
            ],
            [
                'num' => 3,
                'title' => 'Pressure (Advanced)',
                'desc' => 'Atmospheric pressure, barometers, manometers, Archimedes\' Principle, and Pascal\'s Law.'
            ],
            [
                'num' => 4,
                'title' => 'Power and Efficiency',
                'desc' => 'Power units, efficiency ratios, and stretching of coiled springs.'
            ]
        ]
    ],
    [
        'label' => 'Grade 12 Mechanics',
        'chapters' => '1 - 3',
        'color' => 'Grade 12',
        'items' => [
            [
                'num' => 1,
                'title' => 'Rotational Motion',
                'desc' => 'Constant angular acceleration, linear vs angular quantities, and centripetal acceleration.'
            ],
            [
                'num' => 2,
                'title' => 'Forces in Circular Motion',
                'desc' => 'Forces causing centripetal acceleration, and centrifugal force frames.'
            ],
            [
                'num' => 3,
                'title' => 'Fluid Dynamics',
                'desc' => 'Laminar/turbulent flow, Bernoulli\'s equation, viscosity, and surface tension.'
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