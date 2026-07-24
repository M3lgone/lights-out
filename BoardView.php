<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lights Out</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center font-sans">

    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">Lights Out</h1>
        <p class="text-slate-400">Goal: Turn off all the lights.</p>
    </div>

    <?php if ($isFinished): ?>
        <div class="mb-6 p-4 text-green-400 rounded-lg font-bold text-xl">
            You won!
        </div>
    <?php endif; ?>

    <div class="bg-slate-800 p-4 rounded-xl border border-slate-700 shadow-lg inline-block">
        <div class="flex flex-col gap-2">
            <?php foreach ($grid as $rowIndex => $row): ?>
                <div class="flex gap-2">
                    <?php foreach ($row as $colIndex => $cellState): ?>
                        <a href="?row=<?= $rowIndex ?>&col=<?= $colIndex ?>"
                           class="w-16 h-16 rounded-lg border-2 transition-colors <?= $cellState ? 'bg-cyan-400 border-cyan-200' : 'bg-slate-700 border-slate-900' ?> <?= $isFinished ? 'pointer-events-none' : 'hover:opacity-80' ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <a href="?reset=1" 
       class="mt-8 px-6 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 hover:bg-slate-600 transition-colors">
        Restart Game
    </a>

</body>
</html>