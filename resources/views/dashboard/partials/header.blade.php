<!-- HEADER FLOATING -->
<header class="px-8 py-6 flex justify-between items-center border-b border-blue-500/30 bg-blue-600 shadow-md z-30 sticky top-0 relative overflow-hidden">
    <!-- Header Background Glow -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-blue-600 pointer-events-none"></div>
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="flex items-center gap-4 relative z-10">
        <!-- Mobile Menu Toggle -->
        <button onclick="toggleMobileSidebar()" class="md:hidden w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white shadow-sm hover:bg-white/20 transition-colors">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight font-display drop-shadow-sm">Overview</h2>
            <p class="text-xs font-bold text-blue-200 uppercase tracking-widest mt-0.5">Control Panel Mutu</p>
        </div>
    </div>

    <div class="flex items-center gap-4 relative z-10">
        <!-- Notification removed per request -->

        <!-- Date/Clock Panel -->
        <div class="hidden lg:flex items-center bg-white/10 text-white rounded-2xl px-5 py-2.5 shadow-sm border border-white/20 backdrop-blur-md">
            <i class="far fa-clock text-blue-200 mr-3 text-lg"></i>
            <div class="flex flex-col">
                <span id="date-display" class="text-[10px] uppercase font-bold text-blue-200 tracking-widest leading-none mb-1">Senin, 18 Mei 2026</span>
                <span id="clock" class="text-sm font-black tracking-widest leading-none font-display text-white">00:00:00</span>
            </div>
        </div>

        <!-- Import Excel button removed per request -->
    </div>
</header>
