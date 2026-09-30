<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lights Out puzzle game built with plain PHP. Turn off all the lights.">
    <title>Lights Out</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes win-in {
            from { opacity: 0; transform: translateY(6px) scale(0.98); }
            to { opacity: 1; transform: none; }
        }
        .animate-win-in { animation: win-in 300ms ease-out both; }
        @media (prefers-reduced-motion: reduce) {
            .animate-win-in { animation: none; }
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex flex-col items-center justify-center font-sans px-4 py-8 sm:py-12 relative overflow-x-hidden">

    <div aria-hidden="true" class="pointer-events-none absolute left-1/2 top-[-160px] h-[320px] w-[520px] max-w-[90vw] -translate-x-1/2 rounded-full bg-cyan-500/10 blur-3xl"></div>

    <main class="relative flex flex-col items-center w-full max-w-md sm:max-w-lg">
        <div class="text-center mb-5">
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white mb-2">LIGHTS <span class="text-cyan-300">OUT</span></h1>
            <p class="text-slate-400 text-sm sm:text-[15px]">Goal: Turn off all the lights.</p>
            <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-slate-700/80 bg-slate-800/80 px-4 py-1.5 text-sm shadow-sm" aria-live="polite" aria-atomic="true">
                <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Moves</span>
                <span class="min-w-[2ch] text-center text-base font-bold tabular-nums text-white"><?= (int) $moves ?></span>
            </div>
        </div>

        <?php if ($isFinished): ?>
            <div class="mb-5 inline-flex items-center gap-2.5 rounded-xl border border-emerald-400/30 bg-emerald-500/10 px-5 py-3 text-lg sm:text-xl font-bold tracking-tight text-emerald-200 shadow-[0_0_28px_rgba(52,211,153,0.18)] animate-win-in text-center" role="status">
                <span aria-hidden="true" class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-400/20 text-sm">✓</span>
                <span>You won in <?= (int) $moves ?> moves!</span>
            </div>
        <?php endif; ?>

        <div class="bg-slate-800 p-3 sm:p-4 rounded-xl border border-slate-700 shadow-xl ring-1 ring-white/5 inline-block max-w-full overflow-auto">
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

        <div class="mt-6 flex w-full max-w-xs sm:max-w-none sm:w-auto flex-col sm:flex-row items-center justify-center gap-3">
            <a href="?restart=1"
               class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-center rounded-xl border border-slate-600/80 bg-slate-800 text-slate-200 hover:bg-slate-700 hover:border-slate-500 hover:text-white active:scale-[0.97] transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950">
                Restart
            </a>
            <a href="?randomize=1"
               class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-center rounded-xl bg-cyan-400 text-slate-950 shadow-[0_0_20px_rgba(34,211,238,0.25)] hover:bg-cyan-300 hover:shadow-[0_0_28px_rgba(34,211,238,0.35)] active:scale-[0.97] transition-all duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950">
                Randomize
            </a>
        </div>

        <section aria-label="How to play" class="mt-6 max-w-sm text-center text-xs leading-relaxed text-slate-500 border-t border-slate-800/80 pt-4">
            <p>Tap a light to toggle it plus its neighbours. Turn them all off to win.</p>
            <p class="mt-1 text-slate-600">Restart retries this puzzle · Randomize deals a new one (size may change).</p>
        </section>
    </main>

</body>
</html>
