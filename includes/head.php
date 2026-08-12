<?php
if (!isset($pageTitle)) {
    $pageTitle = 'BurmaLab | Interactive Physics Suite';
}
$bodyClass = $bodyClass ?? 'bg-[#F6F6FF] text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white';
$htmlClass = $htmlClass ?? '';
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo htmlspecialchars($htmlClass); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="<?php echo htmlspecialchars($bodyClass); ?>">
