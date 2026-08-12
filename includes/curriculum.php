<?php
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

function burmalab_grade_colors($grade) {
    switch ($grade) {
        case 'Grade 10':
            return ['badge' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30'];
        case 'Grade 11':
            return ['badge' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/30'];
        case 'Grade 12':
            return ['badge' => 'bg-amber-500/10 text-amber-400 border-amber-500/30'];
        default:
            return ['badge' => 'bg-slate-500/10 text-slate-400 border-slate-500/30'];
    }
}