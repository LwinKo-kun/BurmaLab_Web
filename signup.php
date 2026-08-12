<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "An account with this email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($insert->execute([$username, $email, $hashedPassword])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - BurmaLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F6F6FF] text-slate-800 flex items-center justify-center min-h-screen p-4 selection:bg-indigo-500 selection:text-white">
    <div class="bg-white border border-[#CEB5EF]/40 shadow-2xl shadow-indigo-100/50 p-8 sm:p-10 rounded-[32px] w-full max-w-md relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="text-center mb-8 relative z-10">
            <span class="bg-indigo-600 text-white p-3 rounded-2xl text-base inline-block mb-4 shadow-lg shadow-indigo-200">⚛</span>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Join BurmaLab</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Create your student account to access the physics sandbox</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="bg-rose-50 text-rose-600 p-3.5 rounded-2xl mb-6 text-xs text-center border border-rose-200 font-medium">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5 relative z-10">
            <div>
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 text-sm transition-all">
            </div>
            <div>
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 text-sm transition-all">
            </div>
            <div>
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-400 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-600 focus:bg-white text-slate-800 text-sm transition-all">
            </div>
            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl transition-all shadow-xl shadow-indigo-200 text-sm active:scale-95">Create Account</button>
        </form>

        <p class="mt-8 text-center text-xs text-slate-500 relative z-10">
            Already have an account? <a href="login.php" class="text-indigo-600 hover:underline font-bold">Sign in</a>
        </p>
    </div>
</body>
</html>