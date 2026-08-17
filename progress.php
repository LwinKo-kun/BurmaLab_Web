<?php
/**
 * Progress Overview Page
 * Simple page showing user's completed labs.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Ensure user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$pageTitle = 'Progress - BurmaLab';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/nav.php';
?>
<main class="flex-grow flex items-center justify-center py-20 px-4">
    <div class="max-w-lg w-full bg-white p-8 rounded-3xl border border-[#CEB5EF]/40 shadow-xl">
        <h1 class="text-3xl font-black text-slate-900 mb-4">Your Progress</h1>
        <?php
        // Example: count completed labs from a table `user_lab_progress`
        try {
            require_once __DIR__ . '/includes/db.php';
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM user_lab_progress WHERE user_id = :uid');
            $stmt->execute(['uid' => $_SESSION['user_id']]);
            $completed = $stmt->fetchColumn();
        } catch (Exception $e) {
            $completed = 0;
        }
        ?>
        <p class="text-lg text-slate-600 mb-4">You have completed <strong><?php echo $completed; ?></strong> labs.</p>
        <a href="/lab" class="inline-block w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl text-center transition">Go to Labs</a>
    </div>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
