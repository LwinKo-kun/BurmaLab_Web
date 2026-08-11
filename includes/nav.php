<nav class="bg-white border-b border-[#D3D3FF] px-6 py-4 mb-8 rounded-2xl shadow-sm shadow-[#CEB5FF]/10 flex justify-between items-center">
    <div class="flex items-center space-x-8">
        <a href="index.php" class="text-xl font-bold text-[#5580E9] flex items-center space-x-2">
            <span>BurmaLab</span>
        </a>
        <div class="hidden md:flex space-x-6">
            <a href="index.php" class="text-slate-600 hover:text-[#5580E9] font-medium transition-colors">Dashboard</a>
            <a href="#labs" class="text-slate-600 hover:text-[#5580E9] font-medium transition-colors">Physics Labs</a>
        </div>
    </div>
    <div class="flex items-center space-x-4">
        <span class="text-sm font-semibold text-slate-700 bg-[#F4F4FF] px-3 py-1.5 rounded-xl border border-[#D3D3FF]">
            <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
        </span>
        <a href="logout.php" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-2 rounded-xl text-sm font-semibold transition-colors">
            Logout
        </a>
    </div>
</nav>