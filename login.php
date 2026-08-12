<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - BurmaLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F4FF] text-slate-800 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white border border-[#CEB5FF]/50 shadow-2xl shadow-[#CEB5FF]/15 p-8 rounded-3xl w-full max-w-md">
        <div class="text-center mb-6">
            <span class="bg-[#5580E9] text-white p-2.5 rounded-2xl text-sm inline-block mb-3 shadow-lg shadow-[#5580E9]/25">⚛</span>
            <h2 class="text-2xl font-extrabold text-slate-900">Sign In to BurmaLab</h2>
            <p class="text-slate-500 text-xs mt-1">Access your simulations and collaborative guild</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-600 p-3.5 rounded-xl mb-4 text-xs text-center border border-red-200">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 bg-[#F8F7FF] border border-[#CEB5FF]/40 rounded-xl focus:outline-none focus:border-[#5580E9] text-slate-800 text-sm">
            </div>
            <div>
                <label class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 bg-[#F8F7FF] border border-[#CEB5FF]/40 rounded-xl focus:outline-none focus:border-[#5580E9] text-slate-800 text-sm">
            </div>
            <button type="submit" class="w-full py-3.5 bg-[#5580E9] hover:bg-[#436cd9] text-white font-bold rounded-xl transition-colors shadow-lg shadow-[#5580E9]/25 text-sm">Sign In</button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-500">
            Don't have an account? <a href="register.php" class="text-[#5580E9] hover:underline font-semibold">Sign up</a>
        </p>
    </div>
</body>
</html>