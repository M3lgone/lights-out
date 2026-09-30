<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lights Out puzzle game built with plain PHP. Turn off all the lights.">
    <title>Lights Out</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center font-sans px-4 py-10">

    <main class="flex flex-col items-center w-full max-w-xl">
        <div class="text-center mb-6">
            <h1 class="text-4xl font-bold text-white mb-2">Lights Out</h1>
            <p class="text-slate-400">Goal: Turn off all the lights.</p>
            <p class="mt-2 text-sm font-semibold tracking-wide text-slate-300" aria-live="polite">Moves: <?= (int) $moves ?></p>
        </div>

        <section aria-label="How to play" class="mb-6 max-w-md text-center text-sm text-slate-400">
            <p>Tap a light to toggle it plus its neighbours. Turn them all off to win.</p>
            <p>Restart retries this puzzle. Randomize deals a new one (size may change).</p>
        </section>

        <?php if ($isFinished): ?>
            <div class="mb-6 px-6 py-4 rounded-lg font-bold text-xl text-green-300 bg-green-900/40 border border-green-700 text-center" role="status">
                You won in <?= (int) $moves ?> moves!
            </div>
        <?php endif; ?>

        <div class="bg-slate-800 p-3 sm:p-4 rounded-xl border border-slate-700 shadow-lg inline-block max-w-full overflow-auto">
            <div class="flex flex-col gap-2">
                <?php foreach ($grid as $rowIndex => $row): ?>
                    <div class="flex gap-2">
                        <?php foreach ($row as $colIndex => $cellState): ?>
                            <?php
                                $r = (int) $rowIndex;
                                $c = (int) $colIndex;
                                $cellClasses = $cellState
                                    ? 'bg-cyan-300 border-cyan-100 shadow-[0_0_12px_rgba(34,211,238,0.7)]'
                                    : 'bg-slate-700 border-slate-900';
                                $disabledClasses = $isFinished ? 'pointer-events-none' : 'hover:brightness-110 active:scale-95';
                            ?>
                            <a href="?row=<?= $r ?>&amp;col=<?= $c ?>"
                               aria-label="Toggle light at row <?= $r + 1 ?>, column <?= $c + 1 ?>"
                               aria-pressed="<?= $cellState ? 'true' : 'false' ?>"
                               class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg border-2 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 <?= $cellClasses ?> <?= $disabledClasses ?>">
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="?restart=1"
               class="px-6 py-2 bg-slate-700 text-white rounded-lg border border-slate-600 hover:bg-slate-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                Restart
            </a>
            <a href="?randomize=1"
               class="px-6 py-2 bg-cyan-500 text-slate-900 font-semibold rounded-lg hover:bg-cyan-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors">
                Randomize
            </a>
        </div>
    </main>

</body>
</html>
