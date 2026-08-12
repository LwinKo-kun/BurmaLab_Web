<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit();
    }
    $error = 'Invalid email or password.';
}

$pageTitle = 'Sign In - BurmaLab';
$bodyClass = 'bg-[#F6F6FF] text-slate-800 flex items-center justify-center min-h-screen p-4 selection:bg-indigo-500 selection:text-white';
include 'includes/head.php';
?>

<div class="bg-white border border-[#CEB5EF]/40 shadow-2xl shadow-indigo-100/50 p-8 sm:p-10 rounded-[32px] w-full max-w-md relative overflow-hidden">
    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="text-center mb-8 relative z-10">
        <a href="landing.php" class="bg-indigo-600 text-white p-3 rounded-2xl text-base inline-block mb-4 shadow-lg shadow-indigo-200">⚛</a>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Sign In to BurmaLab</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Access your physics simulations and saved progress</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-rose-50 text-rose-600 p-3.5 rounded-2xl mb-6 text-xs text-center border border-rose-200 font-medium"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-5 relative z-10">
        <div>
            <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Email</label>
            <input type="email" name="email" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 text-sm transition-all">
        </div>
        <div>
            <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Password</label>
            <input type="password" name="password" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 text-sm transition-all">
        </div>
        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl transition-all shadow-xl shadow-indigo-200 text-sm active:scale-95">Sign In</button>
    </form>

    <p class="mt-8 text-center text-xs text-slate-500 relative z-10">
        Don't have an account? <a href="signup.php" class="text-indigo-600 hover:underline font-bold">Sign up</a>
    </p>
</div>

</body>
</html>
