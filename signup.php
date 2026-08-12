<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/auth.php';
require_once 'includes/db.php';

if (is_authenticated()) {
    header('Location: home.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'An account with this email address already exists.';
        } else {
            try {
                $pdo->beginTransaction();

                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $insert = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
                $insert->execute([$username, $email, $hashedPassword]);

                $userId = (int)$pdo->lastInsertId();

                // Initialize user streak and total XP (10 starting XP)
                $streak = $pdo->prepare('INSERT INTO user_streaks (user_id, current_streak, last_login_date, total_xp) VALUES (?, 1, CURRENT_DATE(), 10)');
                $streak->execute([$userId]);

                $pdo->commit();

                login_user([
                    'id' => $userId,
                    'username' => $username,
                    'email' => $email
                ]);

                header('Location: home.php');
                exit();
            } catch (\Exception $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log("Signup Error: " . $e->getMessage());
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}

$pageTitle = 'Create Account - BurmaLab';
$bodyClass = 'bg-[#F6F6FF] text-slate-800 flex items-center justify-center min-h-screen p-4 sm:p-6 selection:bg-indigo-500 selection:text-white';
include 'includes/head.php';
?>

<div class="bg-white border border-[#CEB5EF]/40 shadow-2xl shadow-indigo-100/50 p-6 sm:p-10 rounded-[28px] sm:rounded-[32px] w-full max-w-md relative overflow-hidden my-auto">
    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="text-center mb-6 sm:mb-8 relative z-10">
        <a href="index.php" class="bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-2xl text-base inline-block mb-3 sm:mb-4 shadow-lg shadow-indigo-200 transition-all active:scale-95">⚛</a>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Join BurmaLab</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Create your student account to access the physics sandbox</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-rose-50 text-rose-600 p-3.5 rounded-2xl mb-6 text-xs sm:text-sm text-center border border-rose-200 font-medium">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4 sm:space-y-5 relative z-10" autocomplete="on">
        <div>
            <label for="username" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-2">Username</label>
            <input type="text" id="username" name="username" required autocomplete="username" placeholder="PhysicsExplorer" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 text-slate-800 text-base sm:text-sm transition-all">
        </div>

        <div>
            <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-2">Email Address</label>
            <input type="email" id="email" name="email" required autocomplete="email" placeholder="student@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 text-slate-800 text-base sm:text-sm transition-all">
        </div>

        <div>
            <label for="password" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-2">Password</label>
            <div class="relative">
                <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Min. 6 characters" class="w-full px-4 py-3.5 pr-12 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 text-slate-800 text-base sm:text-sm transition-all">
                <button type="button" onclick="togglePassword('password', 'eyeIconPass')" aria-label="Toggle password visibility" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 focus:outline-none p-1">
                    <svg id="eyeIconPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        <div>
            <label for="confirm_password" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-500 mb-2">Confirm Password</label>
            <div class="relative">
                <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password" placeholder="Repeat password" class="w-full px-4 py-3.5 pr-12 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 text-slate-800 text-base sm:text-sm transition-all">
                <button type="button" onclick="togglePassword('confirm_password', 'eyeIconConfirm')" aria-label="Toggle password visibility" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 focus:outline-none p-1">
                    <svg id="eyeIconConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-extrabold rounded-2xl transition-all shadow-xl shadow-indigo-200/80 text-sm sm:text-base active:scale-[0.98]">
            Create Account
        </button>
    </form>

    <p class="mt-6 sm:mt-8 text-center text-xs sm:text-sm text-slate-500 relative z-10">
        Already have an account? <a href="login.php" class="text-indigo-600 hover:underline font-bold">Sign in</a>
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