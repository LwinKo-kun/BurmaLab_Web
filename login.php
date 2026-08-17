<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (is_authenticated()) {
    header('Location: /home');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, username, email, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            login_user($user);

            // Update user streak & last login date
            $today = date('Y-m-d');
            $streakStmt = $pdo->prepare('SELECT last_login_date, current_streak FROM user_streaks WHERE user_id = ?');
            $streakStmt->execute([$user['id']]);
            $streak = $streakStmt->fetch();

            if (!$streak) {
                // Initialize streak if record missing
                $initStreak = $pdo->prepare('INSERT INTO user_streaks (user_id, current_streak, last_login_date, total_xp) VALUES (?, 1, ?, 10)');
                $initStreak->execute([$user['id'], $today]);
            } else if ($streak['last_login_date'] !== $today) {
                $lastLogin = new DateTime($streak['last_login_date']);
                $currentDate = new DateTime($today);
                $interval = $lastLogin->diff($currentDate)->days;

                if ($interval === 1) {
                    // Consecutive day streak
                    $updateStreak = $pdo->prepare('UPDATE user_streaks SET current_streak = current_streak + 1, last_login_date = ?, total_xp = total_xp + 10 WHERE user_id = ?');
                    $updateStreak->execute([$today, $user['id']]);
                } else if ($interval > 1) {
                    // Reset streak
                    $updateStreak = $pdo->prepare('UPDATE user_streaks SET current_streak = 1, last_login_date = ? WHERE user_id = ?');
                    $updateStreak->execute([$today, $user['id']]);
                }
            }

            header('Location: /home');
            exit();
        } else {
            $error = 'Invalid email address or password.';
        }
    }
}

$pageTitle = 'Sign In - BurmaLab';
$bodyClass = 'bg-[#F6F6FF] text-slate-800 flex items-center justify-center min-h-screen p-4 sm:p-6 selection:bg-indigo-500 selection:text-white';
include 'includes/head.php';
?>

<div class="bg-white border border-[#CEB5EF]/40 shadow-2xl shadow-indigo-100/50 p-6 sm:p-10 rounded-[28px] sm:rounded-[32px] w-full max-w-md relative overflow-hidden my-auto">
    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="text-center mb-6 sm:mb-8 relative z-10">
        <a href="/" class="bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-2xl text-base inline-block mb-3 sm:mb-4 shadow-lg shadow-indigo-200 transition-all active:scale-95">⚛</a>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Sign In to BurmaLab</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Access your physics simulations and lab telemetry</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-rose-50 text-rose-600 p-3.5 rounded-2xl mb-6 text-xs sm:text-sm text-center border border-rose-200 font-medium animate-fade-in">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4 sm:space-y-5 relative z-10" autocomplete="on">
        <div>
            <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-2">Email Address</label>
            <input type="email" id="email" name="email" required autocomplete="email" placeholder="student@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 text-slate-800 text-base sm:text-sm transition-all">
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Password</label>
            </div>
            <div class="relative">
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full px-4 py-3.5 pr-12 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 text-slate-800 text-base sm:text-sm transition-all">
                <button type="button" onclick="togglePassword('password', 'eyeIconLogin')" aria-label="Toggle password visibility" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 focus:outline-none p-1">
                    <svg id="eyeIconLogin" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-extrabold rounded-2xl transition-all shadow-xl shadow-indigo-200/80 text-sm sm:text-base active:scale-[0.98]">
            Sign In
        </button>
    </form>

    <p class="mt-6 sm:mt-8 text-center text-xs sm:text-sm text-slate-500 relative z-10">
        Don't have an account? <a href="/signup" class="text-indigo-600 hover:underline font-bold">Sign up</a>
    </p>
</div>

<script>
function togglePassword(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    }
}
</script>

</body>
</html>