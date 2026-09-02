<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Physics Simulations Lab | Interactive Physics Suite';
}
$bodyClass = $bodyClass ?? 'bg-[#F6F6FF] text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white';
$htmlClass = $htmlClass ?? '';
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo htmlspecialchars($htmlClass); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <!-- Specialized Physics Canvas Stylesheet -->
    <link rel="stylesheet" href="css/lab.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, kbd, samp, pre { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="<?php echo htmlspecialchars($bodyClass); ?>">