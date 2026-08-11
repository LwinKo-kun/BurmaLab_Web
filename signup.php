<?php
require_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $hashed_password]);
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            $error = "Registration failed: Email or username already exists.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - BurmaLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F4FF] text-slate-800 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl shadow-[#CEB5FF]/20 w-full max-w-md border border-[#D3D3FF]">
        <h2 class="text-2xl font-bold text-[#5580E9] mb-6 text-center">Create Account</h2>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-sm text-center border border-red-200">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-slate-600 mb-1">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-2 bg-slate-50 border border-[#D3D3FF] rounded-xl focus:outline-none focus:border-[#80A8FF] text-slate-800">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 bg-slate-50 border border-[#D3D3FF] rounded-xl focus:outline-none focus:border-[#80A8FF] text-slate-800">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required class="w-full px-4 py-2 pr-10 bg-slate-50 border border-[#D3D3FF] rounded-xl focus:outline-none focus:border-[#80A8FF] text-slate-800">
                    <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Confirm Password</label>
                <div class="relative">
                    <input type="password" name="confirm_password" id="confirm_password" required class="w-full px-4 py-2 pr-10 bg-slate-50 border border-[#D3D3FF] rounded-xl focus:outline-none focus:border-[#80A8FF] text-slate-800">
                    <button type="button" onclick="togglePassword('confirm_password', 'eyeIcon2')" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full py-2.5 bg-[#80A8FF] hover:bg-[#5580E9] text-white font-bold rounded-xl transition-colors shadow-md shadow-[#80A8FF]/20">Sign Up</button>
        </form>

        <p class="mt-4 text-center text-sm text-slate-500">
            Already have an account? <a href="login.php" class="text-[#5580E9] hover:underline font-semibold">Login</a>
        </p>
    </div>

    <script>
    function togglePassword(fieldId, iconId) {
        const passwordInput = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
    </script>
</body>
</html>