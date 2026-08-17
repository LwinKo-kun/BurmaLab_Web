<?php
/**
 * BurmaLab - Front Controller & Router
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/curriculum.php';
require_once __DIR__ . '/includes/progress.php';

$url = isset($_GET['url']) ? trim(filter_var($_GET['url'], FILTER_SANITIZE_URL), '/') : '';
$is_logged_in = isset($_SESSION['user_id']);
// Remove optional .php extension and any trailing slash for clean routing
$url = rtrim($url, '/');
$url = preg_replace('/\.php$/', '', $url);

$publicRoutes = ['', 'index', 'login', 'signup', 'about'];
if (!$is_logged_in && !in_array($url, $publicRoutes, true)) {
    header('Location: /login');
    exit;
}

// 1. Dynamic Lab Simulation Router (/lab/{slug})
if (strpos($url, 'lab/') === 0) {
    if (!$is_logged_in) {
        header('Location: /login');
        exit;
    }
    
    $lab_slug = basename($url);
    $lab_path = __DIR__ . "/lab/{$lab_slug}.php";
    
    if (file_exists($lab_path)) {
        include $lab_path;
        exit;
    }
}

// 2. Page Route Matrix
$routes = [
    'home'     => 'home.php',
    'lab'      => 'lab.php',
    'login'    => 'login.php',
    'signup'   => 'signup.php',
    'logout'   => 'logout.php',
    'about'    => 'about.php',
    'theory'   => 'theory.php',
    'progress' => 'progress.php',
    'settings' => 'settings.php',
];

// Auto route lab simulation files
$labFiles = glob(__DIR__.'/lab/*.php');
foreach ($labFiles as $file) {
    $slug = 'lab/' . basename($file, '.php');
    // Store the relative path for include
    $routes[$slug] = 'lab/' . basename($file);
}



// 3. Delegate to internal page if matched
if (array_key_exists($url, $routes)) {
    include __DIR__ . '/' . $routes[$url];
    exit;
}

// 4. Handle 404 for unknown non-empty routes
if ($url !== '' && $url !== 'index') {
    http_response_code(404);
    $pageTitle = 'Page Not Found - BurmaLab';
    include 'includes/head.php';
    include 'includes/nav.php';
    ?>
    <main class="flex-grow flex items-center justify-center py-20 px-4">
        <div class="max-w-md w-full text-center bg-white p-8 sm:p-10 rounded-3xl border border-[#CEB5EF]/40 shadow-xl space-y-4">
            <span class="inline-block p-4 bg-indigo-50 text-indigo-600 rounded-2xl text-3xl font-black">404</span>
            <h1 class="text-3xl font-black text-slate-900">Page Not Found</h1>
            <p class="text-slate-500 text-sm leading-relaxed">The simulation module or page you are looking for does not exist or has been moved.</p>
            <a href="/home" class="inline-block w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl transition shadow-lg shadow-indigo-200">Return to Dashboard</a>
        </div>
    </main>
    <?php
    include 'includes/footer.php';
    exit;
}

// 5. Landing Page View (Default Route: '/' or '/index')
$pageTitle = 'BurmaLab | Interactive Physics Suite for Myanmar';
include 'includes/head.php';
?>

<!-- Background Glow Accent -->
<div class="absolute top-0 left-1/2 -translate-x-1/2 w-[300px] sm:w-[800px] h-[300px] sm:h-[500px] bg-gradient-to-br from-indigo-300/30 via-violet-300/20 to-transparent rounded-full blur-[100px] sm:blur-[140px] pointer-events-none -z-10"></div>

<?php include 'includes/nav.php'; ?>

<main class="w-full flex-grow space-y-16 sm:space-y-28 pb-16 sm:pb-28">

    <!-- Hero Section -->
    <section class="w-full min-h-[75vh] sm:min-h-[85vh] flex flex-col items-center justify-center text-center px-4 sm:px-10 lg:px-16 pt-8 sm:pt-12 relative">
        <div class="max-w-5xl mx-auto space-y-6 sm:space-y-8">
            
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full bg-white border border-indigo-200 text-[11px] sm:text-xs font-bold text-indigo-600 shadow-sm tracking-wide uppercase">
                <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Myanmar Mechanics · Grades 10–12
            </div>

            <h1 class="text-4xl sm:text-6xl lg:text-8xl font-black tracking-tight text-slate-900 leading-[1.1] sm:leading-[1.05]">
                Master Physics Through <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Virtual Labs</span>
            </h1>

            <p class="text-base sm:text-xl lg:text-2xl text-slate-500 max-w-3xl mx-auto font-normal leading-relaxed px-2">
                BurmaLab connects Myanmar's mechanics curriculum to interactive Matter.js simulations — forces, motion, projectiles, and collisions in real time.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2 sm:pt-4 w-full px-4 sm:px-0">
                <?php if ($is_logged_in): ?>
                    <a href="/lab" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition-all shadow-lg shadow-indigo-200 active:scale-95">
                        Launch Labs &rarr;
                    </a>
                    <a href="/theory" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-white hover:bg-slate-50 border border-indigo-200 text-slate-700 font-bold text-base transition-all shadow-sm active:scale-95">
                        View Theory &rarr;
                    </a>
                <?php else: ?>
                    <a href="/signup" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition-all shadow-lg shadow-indigo-200 active:scale-95">
                        Get Started Free &rarr;
                    </a>
                    <a href="/login" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-white hover:bg-slate-50 border border-indigo-200 text-slate-700 font-bold text-base transition-all shadow-sm active:scale-95">
                        Log In to Continue &rarr;
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Hero Canvas Preview Banner -->
        <div class="w-full max-w-[1300px] mt-12 sm:mt-20 mx-auto rounded-2xl sm:rounded-[32px] p-2 sm:p-3.5 bg-white/80 border border-indigo-100 backdrop-blur-2xl shadow-xl sm:shadow-2xl shadow-indigo-100 relative group">
            <div class="rounded-xl sm:rounded-[24px] overflow-hidden border border-indigo-100 bg-slate-900 aspect-[16/10] sm:aspect-[16/9] relative">
                <img src="assets/1.jpg" alt="Physics simulation workspace" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 opacity-90">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent flex items-end p-5 sm:p-12 text-left">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center w-full gap-4 sm:gap-6">
                        <div>
                            <span class="text-[10px] sm:text-xs font-mono tracking-widest text-indigo-300 uppercase bg-white/10 px-2.5 py-1 sm:px-3.5 sm:py-1.5 rounded-lg border border-white/20">Live Simulation Canvas</span>
                            <h3 class="text-lg sm:text-3xl font-extrabold text-white mt-1.5 sm:mt-2">Newton's Laws, Projectiles & Collisions</h3>
                        </div>
                        <?php if ($is_logged_in): ?>
                            <a href="/lab" class="px-5 py-2.5 sm:px-6 sm:py-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-900 text-xs sm:text-sm font-bold shadow-lg transition-all flex-shrink-0">Launch Labs &rarr;</a>
                        <?php else: ?>
                            <a href="/login" class="px-5 py-2.5 sm:px-6 sm:py-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-900 text-xs sm:text-sm font-bold shadow-lg transition-all flex-shrink-0">Log In to Access &rarr;</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Stats Bar -->
    <section class="w-full bg-white border-y border-[#CEB5EF]/40 py-10 sm:py-16">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16 grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 text-center">
            <div class="space-y-1 lg:border-r border-indigo-100">
                <p class="text-3xl sm:text-5xl font-black text-indigo-600"><?php echo count($activeLabs ?? []); ?></p>
                <p class="text-xs sm:text-sm font-semibold text-slate-500 uppercase tracking-wider">Physics Simulations</p>
            </div>
            <div class="space-y-1 lg:border-r border-indigo-100">
                <p class="text-3xl sm:text-5xl font-black text-indigo-600">10</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-500 uppercase tracking-wider">Curriculum Chapters</p>
            </div>
            <div class="space-y-1 lg:border-r border-indigo-100">
                <p class="text-3xl sm:text-5xl font-black text-indigo-600">60 FPS</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-500 uppercase tracking-wider">Matter.js Engine</p>
            </div>
            <div class="space-y-1">
                <p class="text-3xl sm:text-5xl font-black text-indigo-600">100% Free</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-500 uppercase tracking-wider">For All Students</p>
            </div>
        </div>
    </section>

    <!-- Feature Showcase Section 1 -->
    <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 items-center bg-gradient-to-br from-white via-indigo-50/30 to-purple-50/20 p-6 sm:p-16 rounded-3xl sm:rounded-[40px] border border-indigo-100 shadow-xl shadow-indigo-100/40 relative overflow-hidden">
            <div class="lg:col-span-6 space-y-4 sm:space-y-6 relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-indigo-100/80 text-indigo-700 text-[11px] sm:text-xs font-extrabold uppercase tracking-widest border border-indigo-200">
                    Precision Hardware Calibration
                </div>
                <h2 class="text-2xl sm:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Engineered for Absolute Experimental Accuracy
                </h2>
                <p class="text-slate-600 text-sm sm:text-lg leading-relaxed">
                    Every virtual component—from tension cables to incline planes—is mathematically modeled to mirror real physical laws, enabling safe yet rigorous experimentation.
                </p>
                <div class="pt-2">
                    <a href="/lab" class="inline-flex items-center gap-3 px-5 py-3 sm:px-6 sm:py-3.5 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white font-bold text-xs sm:text-sm transition-all shadow-md group">
                        Explore Lab Equipment 
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6 relative z-10">
                <div class="rounded-2xl sm:rounded-3xl overflow-hidden border border-indigo-100 shadow-lg bg-white p-2">
                    <div class="rounded-xl sm:rounded-2xl overflow-hidden w-full h-auto">
                        <img src="assets/2.jpg" alt="Lab equipment setup" class="w-full h-auto object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Showcase Section 2 -->
    <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 items-center bg-gradient-to-br from-purple-50/20 via-indigo-50/30 to-white p-6 sm:p-16 rounded-3xl sm:rounded-[40px] border border-indigo-100 shadow-xl shadow-indigo-100/40 relative overflow-hidden">
            <div class="lg:col-span-6 order-2 lg:order-1 relative z-10">
                <div class="rounded-2xl sm:rounded-3xl overflow-hidden border border-indigo-100 shadow-lg bg-white p-2 max-w-lg mx-auto">
                    <div class="rounded-xl sm:rounded-2xl overflow-hidden w-full h-auto">
                        <img src="assets/3.jpg" alt="Detailed simulation analysis" class="w-full h-auto object-cover">
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 order-1 lg:order-2 space-y-4 sm:space-y-6 relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-purple-100/80 text-purple-700 text-[11px] sm:text-xs font-extrabold uppercase tracking-widest border border-purple-200">
                    Advanced Telemetry Focus
                </div>
                <h2 class="text-2xl sm:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Inspect Force Vectors & Motion Frame-by-Frame
                </h2>
                <p class="text-slate-600 text-sm sm:text-lg leading-relaxed">
                    Dive down to micro-level interactions. Pause, slow down, or analyze instantaneous velocity changes to gain a deep conceptual grasp of mechanics theory.
                </p>
                <div class="pt-2">
                    <a href="/theory" class="inline-flex items-center gap-3 px-5 py-3 sm:px-6 sm:py-3.5 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white font-bold text-xs sm:text-sm transition-all shadow-md group">
                        Read Measurement Guides 
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16 space-y-8 sm:space-y-12">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div class="space-y-2 sm:space-y-3">
                <span class="text-[11px] sm:text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3.5 py-1.5 rounded-full border border-indigo-200">Built for Learning</span>
                <h2 class="text-2xl sm:text-5xl font-black text-slate-900 tracking-tight">Everything you need for mechanics</h2>
            </div>
            <p class="text-slate-500 text-sm sm:text-base max-w-md leading-relaxed">Bridge textbook formulas with spatial intuition using live telemetry and adjustable parameters.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <div class="bg-white p-6 sm:p-10 rounded-2xl sm:rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-4 sm:space-y-6">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl sm:text-2xl font-bold">⚡</div>
                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Live Telemetry</h3>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Watch velocity, acceleration, tension, and friction update in real time as you change simulation parameters.</p>
            </div>
            <div class="bg-white p-6 sm:p-10 rounded-2xl sm:rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-4 sm:space-y-6">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl sm:text-2xl font-bold">🎯</div>
                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Interactive Labs</h3>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Projectile motion, Atwood machines, incline planes, double pulleys, collisions, friction, and Newton's second law.</p>
            </div>
            <div class="bg-white p-6 sm:p-10 rounded-2xl sm:rounded-[32px] border border-[#CEB5EF]/40 shadow-xl shadow-indigo-100/30 space-y-4 sm:space-y-6">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-xl sm:text-2xl font-bold">📚</div>
                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Theory Reference</h3>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Quick-access formula sheets aligned to each grade — from kinematics to momentum conservation.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-10 lg:px-16">
        <div class="bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 rounded-3xl sm:rounded-[36px] p-8 sm:p-20 text-center text-white space-y-6 sm:space-y-8 shadow-2xl shadow-indigo-500/20 relative overflow-hidden">
            <h2 class="text-2xl sm:text-6xl font-black tracking-tight max-w-4xl mx-auto leading-tight">Ready to explore mechanics interactively?</h2>
            <p class="text-slate-100 text-sm sm:text-xl max-w-2xl mx-auto opacity-90 leading-relaxed">Join Myanmar high school students building stronger physics intuition with BurmaLab.</p>
            <div class="pt-2 sm:pt-4 flex flex-col sm:flex-row justify-center gap-3.5">
                <?php if ($is_logged_in): ?>
                    <a href="/lab" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-white text-indigo-600 hover:bg-slate-50 font-extrabold text-base transition-all shadow-xl active:scale-95">Launch Labs &rarr;</a>
                    <a href="/theory" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-base transition-all border border-white/30 active:scale-95">View Theory Notes &rarr;</a>
                <?php else: ?>
                    <a href="/signup" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-white text-indigo-600 hover:bg-slate-50 font-extrabold text-base transition-all shadow-xl active:scale-95">Create Free Account &rarr;</a>
                    <a href="/login" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 sm:px-10 sm:py-5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-base transition-all border border-white/30 active:scale-95">Log In to Continue &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>