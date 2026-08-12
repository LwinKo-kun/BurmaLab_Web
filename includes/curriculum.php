<?php

$activeLabs = [
    ['href' => 'newtons-second-law.html', 'title' => "Newton's Second Law", 'desc' => 'Test the relationship between force, mass, and acceleration (F = ma).', 'badge' => 'Grade 10 Ch.3', 'icon' => '⚡'],
    ['href' => 'collisions.html', 'title' => 'Momentum & Collisions', 'desc' => 'Observe momentum conservation and energy transfer in 2D collision events.', 'badge' => 'Grade 10 Ch.3', 'icon' => '💥'],
    ['href' => 'friction.html', 'title' => 'Friction Dynamics', 'desc' => 'Analyze surface resistance and motion coefficients on sliding masses.', 'badge' => 'Grade 10 Ch.3', 'icon' => '🪵'],
    ['href' => 'projectile.html', 'title' => 'Projectile Motion', 'desc' => 'Explore 2D trajectories, launch angles, and gravitational components.', 'badge' => 'Grade 11 Ch.1', 'icon' => '🎯'],
    ['href' => 'atwood-incline.html', 'title' => 'Atwood Machine', 'desc' => 'Examine string tension and system acceleration with connected masses.', 'badge' => 'Grade 11 Ch.2', 'icon' => '⚖️'],
    ['href' => 'double-pulley.html', 'title' => 'Double Pulley System', 'desc' => 'Investigate mechanical advantage and torque using multi-pulley rigs.', 'badge' => 'Grade 11 Ch.2', 'icon' => '⚙️'],
    ['href' => 'incline.html', 'title' => 'Incline Plane Forces', 'desc' => 'Study force breakdowns, normal force, and slope dynamics.', 'badge' => 'Grade 12 Ch.1–2', 'icon' => '📐'],
];

$curriculum = [
    [
        'grade' => '10',
        'label' => 'Grade 10',
        'color' => 'indigo',
        'chapters' => '1–4',
        'items' => [
            ['num' => 1, 'title' => 'Units and Measurements', 'desc' => 'Basic and Derived Units, System of Units, Prefixes, Standards and Units, Measurement of Length, Mass, and Time.'],
            ['num' => 2, 'title' => 'Motion', 'desc' => 'Vectors, Describing Motion, Equations of Motion, and Motion Graphs.'],
            ['num' => 3, 'title' => 'Forces', 'desc' => "Newton's Laws of Motion, Gravitational Force & Law of Gravitation, Different Kinds of Forces, Mass and Weight, Freely Falling Bodies, Momentum, and Law of Conservation of Momentum."],
            ['num' => 4, 'title' => 'Pressure', 'desc' => 'Pressure, Density, Relative Density (or Specific Gravity), and Hydrometer.'],
        ],
    ],
    [
        'grade' => '11',
        'label' => 'Grade 11',
        'color' => 'violet',
        'chapters' => '1–3',
        'items' => [
            ['num' => 1, 'title' => 'Motion in a Plane', 'desc' => 'Two-Dimensional Motion, Projectile Motion, and Circular Motion.'],
            ['num' => 2, 'title' => 'Rotational Dynamics', 'desc' => 'Scalar Product and Vector Product, Turning Effect of Force, Relation Between Torque and Moment of Inertia, Equilibrium, Angular Momentum and Law of Conservation of Angular Momentum.'],
            ['num' => 3, 'title' => 'Pressure', 'desc' => "Atmospheric Pressure, Barometer, Pressure in a Liquid, Manometer, Archimedes' Principle, and Pascal's Law."],
        ],
    ],
    [
        'grade' => '12',
        'label' => 'Grade 12',
        'color' => 'purple',
        'chapters' => '1–3',
        'items' => [
            ['num' => 1, 'title' => 'Rotational Motion', 'desc' => 'Rotational Motion Under Constant Angular Acceleration, Relations Between Linear and Angular Quantities, and Centripetal Acceleration.'],
            ['num' => 2, 'title' => 'Forces in Circular Motion', 'desc' => 'Forces Causing Centripetal Acceleration, Centripetal and Centrifugal Forces.'],
            ['num' => 3, 'title' => 'Fluid Dynamics', 'desc' => "Laminar and Turbulent Flow, Equation of Continuity for Fluids, Bernoulli's Equation, Manifestations of Bernoulli's Theorem, Viscosity (Fluid Friction), Surface Tension and Capillarity."],
        ],
    ],
];

$theoryNotes = [
    ['grade' => '10', 'color' => 'indigo', 'topics' => [
        ['title' => 'Motion Equations (constant acceleration)', 'formulas' => ['v = u + at', 's = ut + ½at²', 'v² = u² + 2as']],
        ['title' => "Newton's Laws", 'formulas' => ['F = ma', 'F₁₂ = −F₂₁ (action–reaction)']],
        ['title' => 'Momentum', 'formulas' => ['p = mv', 'Σp_before = Σp_after (isolated system)']],
        ['title' => 'Pressure & Density', 'formulas' => ['P = F/A', 'ρ = m/V', 'RD = ρ_substance / ρ_water']],
    ]],
    ['grade' => '11', 'color' => 'violet', 'topics' => [
        ['title' => 'Projectile Motion', 'formulas' => ['x = v₀ cos θ · t', 'y = v₀ sin θ · t − ½gt²', 'R = v₀² sin 2θ / g']],
        ['title' => 'Circular Motion', 'formulas' => ['v = ωr', 'a_c = v²/r = ω²r']],
        ['title' => 'Torque & Angular Momentum', 'formulas' => ['τ = r × F', 'L = Iω', 'τ = Iα']],
        ['title' => "Archimedes' Principle", 'formulas' => ['F_b = ρ_fluid · V_displaced · g']],
    ]],
    ['grade' => '12', 'color' => 'purple', 'topics' => [
        ['title' => 'Rotational Kinematics', 'formulas' => ['ω = ω₀ + αt', 'θ = ω₀t + ½αt²', 'v = ωr']],
        ['title' => 'Centripetal Force', 'formulas' => ['F_c = mv²/r']],
        ['title' => 'Fluid Continuity', 'formulas' => ['A₁v₁ = A₂v₂']],
        ['title' => "Bernoulli's Equation", 'formulas' => ['P + ½ρv² + ρgh = constant (ideal fluid)']],
    ]],
];

function burmalab_grade_colors(string $color): array {
    return match ($color) {
        'violet' => ['badge' => 'bg-violet-600', 'chip' => 'text-violet-600 bg-violet-50 border-violet-100', 'border' => 'border-violet-100'],
        'purple' => ['badge' => 'bg-purple-600', 'chip' => 'text-purple-600 bg-purple-50 border-purple-100', 'border' => 'border-purple-100'],
        default  => ['badge' => 'bg-indigo-600', 'chip' => 'text-indigo-600 bg-indigo-50 border-indigo-100', 'border' => 'border-indigo-100'],
    };
}
