  <div id="modalOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[90] hidden flex items-center justify-center p-4 transition-all opacity-0 pointer-events-none" style="transition: opacity 0.3s ease;">
        
        <!-- EDIT MODAL -->
        <div id="modalEdit" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-transform duration-300 hidden flex-col">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-2xl font-display tracking-tight mb-1">Edit Konfigurasi</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Modifikasi Parameter Sistem</p>
                </div>
                <button onclick="closeModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-10">
                <div class="modal-body-scroll">
                    <div id="edit-fields-container" class="space-y-4"></div>
                </div>
                <div class="mt-8 flex justify-end space-x-4 border-t border-slate-100 pt-6">
                    <button onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                    <button onclick="saveData()" class="px-8 py-4 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(59,130,246,0.3)] hover:bg-blue-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Simpan Perubahan</button>
                </div>
            </div>
        </div>

        <!-- TAMBAH MODAL -->
        <div id="modalTambah" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-transform duration-300 hidden flex-col">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-2xl font-display tracking-tight mb-1">Tambah Data Baru</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Registrasi Parameter Sistem</p>
                </div>
                <button onclick="closeModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-10">
                <div class="modal-body-scroll">
                    <div id="add-fields-container" class="space-y-4"></div>
                </div>
                <div class="mt-8 flex justify-end space-x-4 border-t border-slate-100 pt-6">
                    <button onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                    <button onclick="addNewData()" class="px-8 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.3)] hover:bg-emerald-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Tambahkan Data</button>
                </div>
            </div>
        </div>
 
        <!-- IMPORT KUESIONER MODAL -->
        <div id="modalImportKuesioner" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-transform duration-300 hidden flex-col">
            <div class="px-10 py-8 border-b border-slate-100 bg-emerald-50/50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-2xl font-display tracking-tight mb-1">Impor Data Kuesioner</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Excel Synchronizer</p>
                </div>
                <button onclick="closeModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-10">
                <form id="formImportKuesioner" onsubmit="event.preventDefault(); submitImportKuesioner();" class="space-y-6">
                    <div class="p-6 rounded-2xl bg-blue-50/50 border border-blue-100/30 space-y-4">
                        <div>
                            <label class="block text-[11px] font-black text-blue-600 uppercase tracking-widest mb-3">Tahun Akademik <span class="text-rose-500">*</span></label>
                            <input type="text" id="ik_tahun" placeholder="Contoh: 2024/2025 Genap" required class="w-full p-4 border border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 outline-none text-sm font-semibold text-slate-700 bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-blue-600 uppercase tracking-widest mb-3">File Excel (.xlsx / .xls) <span class="text-rose-500">*</span></label>
                            <input type="file" id="ik_file" accept=".xlsx,.xls" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4 border-t border-slate-100 pt-6">
                        <button type="button" onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                        <button type="submit" id="ik_submit_btn" class="px-8 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.3)] hover:bg-emerald-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Mulai Impor</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none"></div>



    <!-- SCRIPTS -->
    <script>
        window.dashboardConfig = {
            uploadImageRoute: '{{ route('admin.upload_content_image') }}',
            csrfToken: '{{ csrf_token() }}'
        };

        let currentTitle = ""; 
        let defaultDashboardContent = "";
        let mainChart = null;
        let kuesionerChart = null;
        let accreditationDonutChart = null;

        document.addEventListener('DOMContentLoaded', () => {
            defaultDashboardContent = document.getElementById('dynamic-content').innerHTML;
            renderDashboardRenstraChart();
            renderDashboardKuesionerChart();
            renderAccreditationDonutChart();
            initializeSidebarInteractions();
        });

        function initializeSidebarInteractions() {
            // Use event delegation on the sidebar nav for robust click handling
            const sidebarNav = document.querySelector('aside nav') || document.querySelector('nav');
            if (!sidebarNav) return;

            sidebarNav.addEventListener('click', function(event) {
                const btn = event.target.closest('button.sidebar-item, button.submenu-item');
                if (!btn) return;

                // Sidebar group toggles (has data-toggle-target)
                if (btn.classList.contains('sidebar-item')) {
                    const target = btn.dataset.toggleTarget;
                    if (target) {
                        toggleMenu(target);
                        return;
                    }
                    // Sidebar items with data-page but no submenu (e.g., Media Sosial, Logo Poljam)
                    const page = btn.dataset.page;
                    if (page && typeof loadPage === 'function') {
                        loadPage(page);
                        return;
                    }
                    // Sidebar items with only onclick (e.g., Slider) — let native onclick handle it
                    return;
                }

                // Submenu page loads via data-page (e.g., Visi Dan Misi, Dokumen SPMI)
                if (btn.classList.contains('submenu-item')) {
                    // If the button has an onclick attribute, let the native handler run
                    if (btn.getAttribute('onclick')) return;

                    const page = btn.dataset.page;
                    if (page && typeof loadPage === 'function') {
                        loadPage(page);
                    }
                }
            }, false);
        }

        function createGradient(ctx, color) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            const parts = color.match(/[\d.]+/g);
            if (parts && parts.length >= 3) {
                gradient.addColorStop(0, `rgba(${parts[0]}, ${parts[1]}, ${parts[2]}, 0.35)`);
                gradient.addColorStop(1, `rgba(${parts[0]}, ${parts[1]}, ${parts[2]}, 0.05)`);
            } else {
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');
            }
            return gradient;
        }

        const allProgramStats = @json($allProgramStats ?? []);
        const availableYearsForChart = @json($availableYearsForChart ?? []).sort();
        const kuesionerDosenData = @json($kuesionerDosenData);
        const kuesionerMahasiswaData = @json($kuesionerMahasiswaData);

        function renderDashboardRenstraChart() {
            const canvas = document.getElementById('mainChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            if (mainChart) mainChart.destroy();
            
            const dbPilars = @json($pilars ?? []);
            const pillarColors = {};
            const pillarLabelsShort = {};
            const pillarFullTitles = {};
            
            dbPilars.forEach(p => {
                pillarColors[p.kode] = p.warna || '#4f46e5';
                pillarLabelsShort[p.kode] = 'Pilar ' + p.kode;
                pillarFullTitles[p.kode] = p.judul;
            });

            const datasets = Object.keys(pillarColors).map(key => {
                return {
                    label: pillarLabelsShort[key],
                    backgroundColor: pillarColors[key],
                    borderRadius: 6,
                    data: availableYearsForChart.map(year => {
                        const progKey = Object.keys(allProgramStats).find(p => p.startsWith(key + '.'));
                        if (progKey && allProgramStats[progKey]) {
                            const stats = allProgramStats[progKey].find(s => s.tahun == year);
                            return stats ? stats.avg_realisasi : 0;
                        }
                        return 0;
                    }),
                    barThickness: 8,
                    maxBarThickness: 10,
                };
            });

            mainChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: availableYearsForChart,
                    datasets: datasets
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#64748b',
                                font: { family: 'Arial', size: 10, weight: 'bold' },
                                boxWidth: 12,
                                padding: 20
                            }
                        },
                        tooltip: {
                            enabled: false,
                            position: 'nearest',
                            external: function(context) {
                                const tooltipEl = document.getElementById('chartTooltip');
                                const tooltipModel = context.tooltip;
                                
                                if (!tooltipEl) return;
                                
                                if (tooltipModel.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }
                                
                                if (tooltipModel.body) {
                                    const dataPoint = tooltipModel.dataPoints[0];
                                    const key = Object.keys(pillarLabelsShort).find(k => pillarLabelsShort[k] === dataPoint.dataset.label);
                                    const fullTitle = pillarFullTitles[key] || dataPoint.dataset.label;
                                    const color = dataPoint.dataset.backgroundColor;
                                    tooltipEl.innerHTML = `
                                        <div class="mb-2 pb-2 border-b border-slate-100 flex items-center justify-between">
                                            <div class="text-blue-600 font-black text-sm">${dataPoint.label}</div>
                                            <span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:${color}"></span>
                                        </div>
                                        <div class="text-[11px] leading-relaxed text-slate-700">
                                            <strong class="text-slate-900">${dataPoint.dataset.label}.</strong> ${fullTitle}: <span class="font-black text-blue-700 text-lg ml-1">${dataPoint.raw}%</span>
                                        </div>
                                    `;
                                }
                                
                                const position = context.chart.canvas.getBoundingClientRect();
                                const tooltipWidth = tooltipEl.offsetWidth;
                                const tooltipHeight = tooltipEl.offsetHeight;
                                
                                let left = tooltipModel.caretX + 20;
                                let top = tooltipModel.caretY - tooltipHeight / 2;
                                
                                if (top < 0) top = 5;
                                if (top + tooltipHeight > position.height) top = position.height - tooltipHeight - 5;
                                
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.left = left + 'px';
                                tooltipEl.style.top = top + 'px';
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: true,
                        axis: 'y'
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: 'rgba(15, 23, 42, 0.05)', drawBorder: false },
                            ticks: { 
                                color: '#64748b', 
                                font: { family:'Arial', size: 10, weight: 'bold' },
                                callback: v => v + '%'
                            }
                        },
                        y: {
                            grid: { display: false, drawBorder: false },
                            ticks: { 
                                color: '#64748b', 
                                font: { family:'Arial', size: 12, weight: 'bold' }
                            }
                        }
                    },
                    animation: { duration: 1500, easing: 'easeOutQuart' }
                }
            });
        }

        let kuesionerDosenChartObj = null;
        let kuesionerMahasiswaChartObj = null;

        function renderDashboardKuesionerChart() {
            const dosenCanvas = document.getElementById('kuesionerDosenChart');
            const mhsCanvas = document.getElementById('kuesionerMahasiswaChart');
            
            const labels = ['Sangat Setuju', 'Setuju', 'Cukup', 'Tidak Setuju', 'Sangat Tidak Setuju'];
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { family: 'Arial', size: 13 },
                        bodyFont: { family: 'Arial', size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(15, 23, 42, 0.05)', drawBorder: false },
                        ticks: { font: { family: 'Arial', size: 11, weight: 'bold' }, color: '#64748b' }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: 'Arial', size: 10, weight: 'bold' }, color: '#64748b', maxRotation: 45, minRotation: 0 }
                    }
                },
                animation: { duration: 1400, easing: 'easeOutQuad' }
            };

            if (dosenCanvas) {
                const ctxDosen = dosenCanvas.getContext('2d');
                if (kuesionerDosenChartObj) kuesionerDosenChartObj.destroy();
                
                let maxDosen = Math.max(...kuesionerDosenData, 10);
                let dosenOpts = JSON.parse(JSON.stringify(commonOptions));
                dosenOpts.scales.y.suggestedMax = maxDosen;

                kuesionerDosenChartObj = new Chart(ctxDosen, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Dosen & Karyawan',
                            data: kuesionerDosenData,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                            barThickness: 24
                        }]
                    },
                    options: dosenOpts
                });
            }


        }

        function renderAccreditationDonutChart() {
            const canvas = document.getElementById('accreditationDonutChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            if (accreditationDonutChart) accreditationDonutChart.destroy();
            accreditationDonutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Unggul', 'Baik', 'Cukup'],
                    datasets: [
                        {
                            data: [{{ $akreditasiUnggul ?? 5 }}, {{ $akreditasiBaik ?? 7 }}, {{ $akreditasiCukup ?? 3 }}],
                            backgroundColor: ['#10b981', '#3b82f6', '#f59e0b'],
                            hoverOffset: 12,
                            borderWidth: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, boxHeight: 12, color: '#475569', font: { family: 'Arial', size: 12, weight: 'bold' } }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { family: 'Arial', size: 13 },
                            bodyFont: { family: 'Arial', size: 14, weight: 'bold' },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: true
                        }
                    },
                    animation: { duration: 1400, easing: 'easeOutQuad' }
                }
            });
        }


        // Toast Notification Logic
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            toast.className = 'flex items-center gap-4 px-6 py-4 rounded-2xl shadow-[0_15px_40px_rgba(0,0,0,0.1)] border bg-white/90 backdrop-blur-xl transform transition-all duration-500 translate-y-10 opacity-0 pointer-events-auto';
            
            const icon = type === 'success' ? '<div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg"><i class="fas fa-check"></i></div>' : 
                                              '<div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-lg"><i class="fas fa-exclamation"></i></div>';
            
            toast.classList.add(type === 'success' ? 'border-emerald-100' : 'border-rose-100');

            const safeMessage = escapeHtml(message);
            toast.innerHTML = `
                ${icon}
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-slate-800">${type === 'success' ? 'Berhasil' : 'Peringatan'}</h4>
                    <p class="text-xs font-medium text-slate-500">${safeMessage}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-2 w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button>
            `;

            container.appendChild(toast);

            // Animate In
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            });

            // Auto Remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // Profile Dropdown Logic
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');
            if (!sidebar || !overlay) return;

            const isOpen = sidebar.classList.contains('translate-x-0');
            if (isOpen) {
                closeMobileSidebar();
                return;
            }

            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');
            if (sidebar) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
            if (overlay) overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileArea = document.getElementById('userProfileArea');
            const dropdown = document.getElementById('profileDropdown');
            if (profileArea && !profileArea.contains(event.target) && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeMobileSidebar();
            }
        });

        // Clock & Date Logic
        function updateClock() {
            const now = new Date();
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', timeOptions);
            document.getElementById('date-display').innerText = now.toLocaleDateString('id-ID', dateOptions);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Menu Toggle
        function toggleMenu(id) {
            const menu = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (menu.classList.contains('hidden')) {
                // Hanya tutup menu lain jika yang diklik adalah menu utama (berawalan 'menu')
                if (id.startsWith('menu')) {
                    document.querySelectorAll('[id^="menu"]').forEach(m => {
                        if(m.id !== id && !m.classList.contains('hidden') && m.id !== 'modalOverlay' && m.id !== 'modalEdit' && m.id !== 'modalTambah') {
                            m.classList.add('hidden');
                            const otherIcon = document.getElementById('icon-' + m.id);
                            if(otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                        }
                    });
                }

                menu.classList.remove('hidden');
                menu.classList.add('animate-fade-in');
                if (icon) icon.style.transform = 'rotate(90deg)';
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('animate-fade-in');
                if (icon) icon.style.transform = 'rotate(0deg)';
            }
        }

        function showHome() {
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;
            setTimeout(() => {
                content.innerHTML = defaultDashboardContent;
                content.style.opacity = 1;
                setTimeout(() => {
                    renderDashboardRenstraChart();
                    renderDashboardKuesionerChart();
                    renderAccreditationDonutChart();
                }, 50); // Small delay to ensure DOM is ready
            }, 300);
        }

        // Module Pages & Live AJAX Client
        let loadedFields = [];
        let loadedDefaults = {};
        let currentEditId = null;
        let retrievedData = [];

        // Editor Logic (CKEditor 5)
        let activeEditors = {};

        class ContentImageUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);

                    const request = new XMLHttpRequest();
                    request.open('POST', window.dashboardConfig.uploadImageRoute, true);
                    request.setRequestHeader('X-CSRF-TOKEN', window.dashboardConfig.csrfToken);
                    request.responseType = 'json';

                    request.addEventListener('load', () => {
                        if (request.status >= 200 && request.status < 300 && request.response?.url) {
                            resolve({ default: request.response.url });
                        } else {
                            reject(request.response?.message || 'Gagal mengunggah gambar.');
                        }
                    });
                    request.addEventListener('error', () => reject('Gagal mengunggah gambar.'));
                    request.addEventListener('abort', () => reject('Upload gambar dibatalkan.'));
                    request.send(data);
                }));
            }

            abort() {
                // No special abort handling needed
            }
        }

        async function initRichEditor(selector) {
            const elements = document.querySelectorAll(selector);
            for (const el of elements) {
                // Skip if already initialized
                if (el.dataset.editorId) continue;

                try {
                    // Custom upload adapter plugin function
                    function ContentImageUploadAdapterPlugin(editor) {
                        editor.plugins.get('FileRepository').createUploadAdapter = loader => new ContentImageUploadAdapter(loader);
                    }

                    const editor = await CKEDITOR.ClassicEditor.create(el, {
                        extraPlugins: [ContentImageUploadAdapterPlugin],
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'link', '|',
                                'uploadImage', '|',
                                'bulletedList', 'numberedList', '|',
                                'blockQuote', 'insertTable', '|',
                                'undo', 'redo'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        removePlugins: [
                            'CKBox', 'CKFinder', 'EasyImage',
                            'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                            'RealTimeCollaborativeRevisionHistory', 'PresenceList', 'Comments',
                            'TrackChanges', 'TrackChangesData', 'RevisionHistory',
                            'Pagination', 'WProofreader', 'MathType', 'SlashCommand',
                            'Template', 'DocumentOutline', 'FormatPainter',
                            'TableOfContents', 'PasteFromOfficeEnhanced', 'AIAssistant',
                            'MultiLevelList',
                            'ExportPdf', 'ExportWord',
                            'RestrictedEditingMode', 'StandardEditingMode',
                            'ImageResize',
                            // Remove CaseChange plugin which requires license in super-build
                            'CaseChange', 'CaseChangeEditing', 'CaseChangeUI'
                        ]
                    });

                    // Unlock read-only mode imposed by super-build
                    if (editor.isReadOnly) {
                        try { editor.disableReadOnlyMode('model'); } catch(e) {}
                    }
                    // Try all known lock IDs used by the super-build
                    try { editor.disableReadOnlyMode('lock'); } catch(e) {}

                    const editorId = 'editor-' + Math.random().toString(36).substr(2, 9);
                    el.dataset.editorId = editorId;
                    activeEditors[editorId] = editor;

                    // Ensure the original textarea is not marked readonly/disabled
                    try {
                        el.removeAttribute && el.removeAttribute('readonly');
                        el.removeAttribute && el.removeAttribute('disabled');
                        el.style.pointerEvents = 'auto';
                    } catch(e) {}

                    // Force editor out of any read-only mode that may be imposed by the build
                    try {
                        if (typeof editor.isReadOnly !== 'undefined') editor.isReadOnly = false;
                        if (editor.enableReadOnlyMode && editor.disableReadOnlyMode) {
                            try { editor.disableReadOnlyMode('model'); } catch(e) {}
                            try { editor.disableReadOnlyMode('lock'); } catch(e) {}
                        }
                    } catch(e) {}

                    // Make sure the editable view accepts pointer events (in case of overlays)
                    try {
                        const editableEl = editor.ui && editor.ui.view && editor.ui.view.editable && editor.ui.view.editable.element;
                        if (editableEl) {
                            editableEl.style.pointerEvents = 'auto';
                        }
                    } catch(e) {}

                    // Focus the editor so users can type immediately
                    try { editor.editing.view.focus(); } catch(e) {}

                    // Sync content on change
                    editor.model.document.on('change:data', () => {
                        el.value = editor.getData();
                    });
                } catch (error) {
                    console.error('CKEditor initialization failed:', error);

                    // Fallback: try to load the simpler Classic build from CDN and initialize.
                    // This avoids changing UI while ensuring the editor becomes editable.
                    try {
                        const loadScript = (src) => new Promise((resolve, reject) => {
                            if (document.querySelector('script[src="' + src + '"]')) return resolve();
                            const s = document.createElement('script'); s.src = src; s.onload = resolve; s.onerror = reject; document.head.appendChild(s);
                        });

                        // Use a known-stable Classic build CDN (no paid plugins)
                        const classicUrl = 'https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js';
                        await loadScript(classicUrl);

                        const Classic = window.ClassicEditor || (window.CKEDITOR && window.CKEDITOR.ClassicEditor);
                        if (Classic) {
                            const simpleEditor = await Classic.create(el, {
                                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo', 'insertTable', 'uploadImage']
                            });
                            const fallbackId = 'editor-fallback-' + Math.random().toString(36).substr(2, 9);
                            el.dataset.editorId = fallbackId;
                            activeEditors[fallbackId] = simpleEditor;
                            try { simpleEditor.editing.view.focus(); } catch(e) {}
                            simpleEditor.model.document.on('change:data', () => { el.value = simpleEditor.getData(); });
                        } else {
                            console.warn('Classic build loaded but editor constructor not found. Falling back to textarea only.');
                            // Ensure textarea is writable
                            try { el.removeAttribute('readonly'); el.removeAttribute('disabled'); el.style.pointerEvents = 'auto'; } catch(e){}
                        }
                    } catch (fbErr) {
                        console.error('Fallback CKEditor initialization failed:', fbErr);
                        try { el.removeAttribute('readonly'); el.removeAttribute('disabled'); el.style.pointerEvents = 'auto'; } catch(e){}
                    }
                }
            }
        }

        function destroyEditors() {
            Object.values(activeEditors).forEach(editor => {
                editor.destroy().catch(err => console.error('Destroy failed:', err));
            });
            activeEditors = {};
            document.querySelectorAll('[data-editor-id]').forEach(el => delete el.dataset.editorId);
        }

        @include('dashboard.partials.js-router')

        // Simpan Halaman Editor Tunggal (Visi Misi, dll)
        function saveSingleContent() {
            const textarea = document.getElementById('single-editor-textarea');
            const editorId = textarea.dataset.editorId;
            const val = activeEditors[editorId] ? activeEditors[editorId].getData() : textarea.value;
            fetch('/admin/save-page-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    title: currentTitle,
                    isi_konten: val
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    loadPage(currentTitle);
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                showToast('Gagal memproses pembaruan data.', 'warning');
            });
        }

        // Modal Logic
        function showOverlay() {
            const overlay = document.getElementById('modalOverlay');
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
            }, 10);
        }

        function hideOverlay() {
            const overlay = document.getElementById('modalOverlay');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                overlay.classList.add('hidden');
                document.getElementById('modalEdit').classList.add('hidden');
                document.getElementById('modalTambah').classList.add('hidden');
            }, 300);
        }

        function closeModal() {
            document.getElementById('modalEdit').classList.add('scale-95');
            document.getElementById('modalTambah').classList.add('scale-95');
            destroyEditors();
            hideOverlay();
        }

        function openModalEdit(id) {
            currentEditId = id;
            const record = retrievedData.find(item => item.id == id);
            if (!record) return;

            // Generate form fields dynamically
            generateFormFields('edit-fields-container', loadedFields, record);

            showOverlay();
            const modal = document.getElementById('modalEdit');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
            
            // Re-init Editor for any textareas in the newly opened modal
            setTimeout(() => initRichEditor('textarea[id^="field-"]'), 300);
        }

        function openTambah() {
            // Generate form fields dynamically (with defaults for certain modules)
            generateFormFields('add-fields-container', loadedFields, loadedDefaults);

            showOverlay();
            const modal = document.getElementById('modalTambah');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
            
            // Re-init Editor for any textareas in the newly opened modal
            setTimeout(() => initRichEditor('textarea[id^="field-"]'), 300);
        }



        const isImageField = (f) => f.toLowerCase().includes('gambar') || f.toLowerCase().includes('foto') || f.toLowerCase().includes('file');
        const isStatusField = (f) => f.toLowerCase() === 'status';
        
        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe)
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
        }

        function escapeJsString(unsafe) {
            return String(unsafe ?? '')
                .replace(/\\/g, '\\\\')
                .replace(/'/g, "\\'")
                .replace(/\r/g, '\\r')
                .replace(/\n/g, '\\n');
        }

        function generateFormFields(containerId, fields, values = {}) {
            const container = document.getElementById(containerId);
            container.innerHTML = "";
            fields.forEach(field => {
                const labelText = field.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                const rawVal = values[field] || "";
                const val = typeof rawVal === 'string' ? escapeHtml(rawVal) : rawVal;
                const isTextArea = ['isi_konten', 'deskripsi', 'konten'].includes(field);
                const isDateField = field.toLowerCase().includes('tanggal') || 
                                    field.toLowerCase().includes('date');
                
                let inputHtml = "";
                if (isStatusField(field)) {
                    // Status field as dropdown select
                    inputHtml = `<select id="field-${containerId}-${field}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">
                        <option value="aktif" ${val === 'aktif' ? 'selected' : ''}>Aktif</option>
                        <option value="non-aktif" ${val === 'non-aktif' ? 'selected' : ''}>Non-Aktif</option>
                    </select>`;
                } else if (isImageField(field)) {
                    // Show current image preview if exists
                    const isURL = val && (val.startsWith('http://') || val.startsWith('https://'));
                    const isLogoField = field.toLowerCase() === 'logo_file';
                    let previewHtml = '';
                    
                    if (val && !isURL) {
                        // Determine preview URL based on path format
                        let previewSrc = '';
                        if (val.startsWith('/')) {
                            previewSrc = val.includes('storage/') ? val : '/storage/' + val;
                        } else if (val.includes('storage/')) {
                            previewSrc = '/' + val;
                        } else if (val.includes('images/')) {
                            previewSrc = '/' + val;
                        } else {
                            previewSrc = '/storage/' + val;
                        }
                        previewHtml = `<div class="mb-3"><img src="${previewSrc}" class="h-24 w-auto rounded-xl border border-slate-200 shadow-sm object-cover" onerror="this.style.display='none'"><p class="text-[10px] text-slate-400 mt-1 font-semibold">File/Gambar saat ini: ${val}</p></div>`;
                    } else if (val && isURL) {
                        previewHtml = `<div class="mb-3"><img src="${val}" class="h-24 w-auto rounded-xl border border-slate-200 shadow-sm object-cover" onerror="this.style.display='none'"><p class="text-[10px] text-slate-400 mt-1 font-semibold">File/Gambar saat ini (URL)</p></div>`;
                    }
                    
                    const isDocField = field.toLowerCase().includes('file') || field.toLowerCase().includes('dokumen');
                    let urlInputHtml = "";
                    let acceptAttr = "image/*";
                    let formatText = "Format: JPG, PNG, WEBP. Max: 2MB";
                    
                    if (isDocField && !isLogoField) {
                        acceptAttr = ".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,image/*";
                        formatText = "Format: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR, Gambar. Max: 10MB";
                        urlInputHtml = `
                            <div class="mt-2">
                                <label class="block text-[9px] font-black text-slate-400 mb-1 uppercase tracking-[0.2em]">Atau Hubungkan ke URL Website (misal: https://example.com)</label>
                                <input type="text" id="field-${containerId}-${field}-url" value="${isURL ? val : ''}" placeholder="https://example.com" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">
                            </div>
                        `;
                    }
                    
                    const logoOnlyText = isLogoField ? `<p class="text-[10px] text-blue-600 font-semibold mt-2">💡 Unggah logo dengan format gambar (JPG, PNG, WEBP)</p>` : '';
                    
                    inputHtml = `
                        ${previewHtml}
                        <input type="file" id="field-${containerId}-${field}" accept="${acceptAttr}" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:tracking-widest file:shadow-lg transition-all cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">${formatText}</p>
                        ${logoOnlyText}
                        ${urlInputHtml}
                    `;
                } else if (isTextArea) {
                    inputHtml = `<textarea id="field-${containerId}-${field}" rows="5" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner leading-relaxed">${val}</textarea>`;
                } else if (isDateField) {
                    // Try to format value to YYYY-MM-DD for input type="date"
                    let dateVal = val;
                    if (val && !val.includes('-')) {
                        // If it's something like "4 April 2026", Carbon on backend will handle it, 
                        // but for input type="date" we might need a clean value.
                        // However, if we are editing, it's safer to leave empty or try to parse.
                        // For now, let's just make it a date input.
                    }
                    inputHtml = `<input type="date" id="field-${containerId}-${field}" value="${val}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">`;
                } else {
                    inputHtml = `<input type="text" id="field-${containerId}-${field}" value="${val}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">`;
                }
                
                container.innerHTML += `
                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-slate-400 mb-2 uppercase tracking-[0.2em]">${labelText}</label>
                        ${inputHtml}
                    </div>
                `;
            });
        }

        function saveData() {
            // Check if we are in Renstra context (renstra_id element exists)
            if (document.getElementById('renstra_id')) {
                submitRenstra(true);
                return;
            }
            // Check if we are in Pilar Renstra context
            if (document.getElementById('pilar_id')) {
                submitPilar(true);
                return;
            }

            const fd = new FormData();
            fd.append('title', currentTitle);
            fd.append('id', currentEditId);

            // isImageField is now defined globally

            loadedFields.forEach(field => {
                const elId = `field-edit-fields-container-${field}`;
                const el = document.getElementById(elId);
                if (isImageField(field)) {
                    const urlEl = document.getElementById(`${elId}-url`);
                    if (el.files && el.files[0]) {
                        fd.append(field, el.files[0]);
                    } else if (urlEl && urlEl.value.trim() !== "") {
                        fd.append(field, urlEl.value.trim());
                    } else if (field === 'link_file' && el && el.value) {
                        // Plain text input for link_file is handled by text input path
                        fd.append(field, el.value);
                    }
                } else {
                    // Check if Editor is active for this field
                    const editorId = el.dataset.editorId;
                    const val = (editorId && activeEditors[editorId]) ? activeEditors[editorId].getData() : el.value;
                    fd.append(field, val);
                }
            });

            fetch('/admin/save-page-data', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: fd
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    closeModal();
                    loadPage(currentTitle);
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                showToast('Gagal memperbarui data.', 'warning');
            });
        }

        function addNewData() {
            // Check if we are in Renstra context
            if (document.getElementById('renstra_id')) {
                submitRenstra(false);
                return;
            }
            // Check if we are in Pilar Renstra context
            if (document.getElementById('pilar_id')) {
                submitPilar(false);
                return;
            }

            const fd = new FormData();
            fd.append('title', currentTitle);

            let hasEmpty = false;
            // isImageField is now defined globally

            loadedFields.forEach(field => {
                const elId = `field-add-fields-container-${field}`;
                const el = document.getElementById(elId);
                if (isImageField(field)) {
                    const urlEl = document.getElementById(`${elId}-url`);
                    if (el.files && el.files[0]) {
                        fd.append(field, el.files[0]);
                    } else if (urlEl && urlEl.value.trim() !== "") {
                        fd.append(field, urlEl.value.trim());
                    } else if (field === 'link_file' && el && el.value) {
                        fd.append(field, el.value);
                    }
                    // Image fields are optional — don't flag as empty
                } else {
                    // Check if Editor is active for this field
                    const editorId = el.dataset.editorId;
                    const val = (editorId && activeEditors[editorId]) ? activeEditors[editorId].getData() : el.value;
                    
                    // Relax validation: allow empty if we have a default for it on the backend
                    // Or if it's meant to be managed by the system
                    if (val.trim() === "" || val.trim() === "<p></p>") {
                        if (!loadedDefaults[field]) {
                            hasEmpty = true;
                        }
                    }
                    fd.append(field, val);
                }
            });

            if (hasEmpty) {
                alert("Validasi Gagal: Semua kolom isian harus diisi.");
                return;
            }

            fetch('/admin/add-row', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: fd
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    closeModal();
                    loadPage(currentTitle);
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                showToast('Gagal menambahkan data baru.', 'warning');
            });
        }

        // Kuesioner Import Logic
        function openImportKuesioner() {
            showOverlay();
            const modal = document.getElementById('modalImportKuesioner');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
        }

        function submitImportKuesioner() {
            const tahun = document.getElementById('ik_tahun').value;
            const file = document.getElementById('ik_file').files[0];
            const btn = document.getElementById('ik_submit_btn');
            
            if (!tahun || !file) {
                showToast('Tahun dan File wajib diisi.', 'warning');
                return;
            }

            const fd = new FormData();
            fd.append('tahun_akademik', tahun);
            fd.append('file', file);
            fd.append('_token', '{{ csrf_token() }}');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengimpor...';

            fetch('/admin/kuesioner-dosen/import', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = 'Mulai Impor';
                if (res.success) {
                    showToast(res.message, 'success');
                    closeModal();
                    loadPage(currentTitle);
                } else {
                    showToast(res.message || 'Gagal mengimpor data.', 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = 'Mulai Impor';
                console.error(err);
                showToast('Terjadi kesalahan saat mengimpor.', 'warning');
            });
        }

        window.swalConfirm = function(msg) {
            return Swal.fire({
                title: 'Konfirmasi Hapus',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i> Ya, Lanjutkan!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl font-bold text-sm',
                    cancelButton: 'rounded-xl font-bold text-sm'
                }
            }).then(res => res.isConfirmed);
        };

        function confirmDelete(id, btn) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Data akan dihapus secara permanen dari basis data dan tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl font-bold text-sm',
                    cancelButton: 'rounded-xl font-bold text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/delete-row', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title: currentTitle,
                            id: id
                        })
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            showToast(res.message, 'success');
                            const row = btn.closest('tr');
                            row.style.opacity = 0;
                            row.style.transform = 'translateX(20px)';
                            row.style.transition = 'all 0.3s ease';
                            setTimeout(() => row.remove(), 300);
                        } else {
                            showToast(res.message, 'warning');
                        }
                    })
                    .catch(err => {
                        showToast('Gagal menghapus data.', 'warning');
                    });
                }
            });
        }
        // ================================================================
        // DOKUMEN SPMI — Fungsi Panel Upload
        // ================================================================
        function toggleUploadForm() {
            const formContainer = document.getElementById('uploadFormContainer');
            if (formContainer) {
                if (formContainer.classList.contains('hidden')) {
                    formContainer.classList.remove('hidden');
                    // Add slight delay for animation
                    setTimeout(() => {
                        formContainer.classList.remove('opacity-0', 'translate-y-4');
                    }, 10);
                } else {
                    formContainer.classList.add('opacity-0', 'translate-y-4');
                    setTimeout(() => {
                        formContainer.classList.add('hidden');
                    }, 300);
                }
            }
        }

      @include('dashboard.partials.panels.renstra')
      @include('dashboard.partials.panels.pilar-renstra')

       @include('dashboard.partials.panels.dokumen-spmi')

        // ================================================================
        // GENERIC PDF DOCUMENT MANAGEMENT (SPMI, AMI, RTM)
        // ================================================================
        function loadPdfDocumentPanel(config) {
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;
            
            setTimeout(() => {
                content.innerHTML = `
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas ${config.iconClass || 'fa-file-alt'}"></i></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full ${config.bgDotClass || 'bg-blue-500'} shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Dokumen</p>
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">${config.title}</h2>
                            <p class="text-slate-500 text-sm mt-2">${config.subtitle}</p>
                        </div>
                        <a href="${config.publicUrl}" target="_blank" class="relative z-10 inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-5 py-3 rounded-xl transition-all">
                            <i class="fas fa-external-link-alt text-xs"></i> Lihat Halaman Publik
                        </a>
                    </div>

                    <!-- Upload Form -->
                    <div id="uploadFormContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                            <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Upload Dokumen Baru</h3>
                            <button onclick="toggleUploadForm()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest"><i class="fas fa-times mr-1"></i> Tutup</button>
                        </div>
                        <form id="uploadDokumenForm" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Dokumen <span class="text-rose-500">*</span></label>
                                    <input type="text" id="ud_judul" placeholder="Contoh: ${config.placeholderTitle}" required
                                        class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun <span class="text-rose-500">*</span></label>
                                    <input type="number" id="ud_tahun" min="2000" max="2099" placeholder="${new Date().getFullYear()}" required
                                        class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                                    <input type="text" id="ud_kategori" placeholder="Ketik kategori baru atau pilih..." list="kategori_list"
                                        class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                                    <datalist id="kategori_list">
                                        ${config.categories.map(c => `<option value="${c}"></option>`).join('')}
                                    </datalist>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                                    <input type="text" id="ud_deskripsi" placeholder="Opsional — keterangan singkat dokumen"
                                        class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                                </div>
                            </div>

                            <!-- Drag & Drop Zone -->
                            <div id="dropzone" onclick="document.getElementById('ud_file').click()"
                                class="border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-3xl p-12 flex flex-col items-center justify-center cursor-pointer transition-all bg-slate-50 hover:bg-blue-50/30 group">
                                <div id="dropzone-icon" class="w-16 h-16 rounded-2xl bg-white border border-slate-200 group-hover:border-blue-200 shadow-sm flex items-center justify-center mb-4 transition-all">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>
                                </div>
                                <p id="dropzone-text" class="text-sm font-bold text-slate-500 group-hover:text-blue-600 transition-colors">Klik atau seret file ke sini</p>
                                <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP — Maks. 20MB</p>
                                <input type="file" id="ud_file" name="file" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar">
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button" id="uploadBtn" onclick="submitUploadPdfDocument('${config.apiBase}')"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-widest px-10 py-4 rounded-2xl shadow-[0_10px_25px_rgba(37,99,235,0.3)] hover:-translate-y-1 transition-all flex items-center gap-3">
                                    <i class="fas fa-upload"></i> Upload Dokumen
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Dokumen Table -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
                        <div class="px-10 py-7 border-b border-slate-100 flex flex-wrap items-center justify-between bg-slate-50/50 gap-4">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 font-display">Daftar Dokumen</h3>
                                <p id="dok-count" class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Memuat...</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button onclick="toggleUploadForm()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-sm flex items-center gap-2">
                                    <i class="fas fa-plus"></i> Tambah Dokumen
                                </button>
                                <button onclick="fetchPdfDocumentList('${config.apiBase}', '${config.downloadBase}')" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 flex items-center justify-center transition-all" title="Refresh">
                                    <i class="fas fa-sync-alt text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div id="dokumen-table-wrap" class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-12">#</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Judul Dokumen</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-24">Tahun</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-36">Kategori</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-28">File</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-20">downloads</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right w-36">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dokumen-tbody" class="divide-y divide-slate-50">
                                    <tr><td colspan="7" class="px-8 py-10 text-center text-slate-400 font-medium">
                                        <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...
                                    </td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div id="editDokumenModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] flex items-center justify-center p-4">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden">
                        <div class="px-10 py-7 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-black text-slate-800 text-xl font-display">Edit Dokumen</h3>
                            <button onclick="closeEditDokModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="p-10 space-y-4">
                            <input type="hidden" id="edit_dok_id">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Dokumen</label>
                                <input type="text" id="edit_judul" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun</label>
                                    <input type="number" id="edit_tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                                    <input type="text" id="edit_kategori" list="kategori_list" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                                <input type="text" id="edit_deskripsi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti File (opsional)</label>
                                <input type="file" id="edit_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                                    class="w-full p-3 border border-slate-200 rounded-2xl text-sm text-slate-600 bg-slate-50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                                <p id="edit_current_file" class="text-xs text-slate-400 mt-2"></p>
                            </div>
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button onclick="closeEditDokModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs rounded-2xl hover:bg-slate-50 transition tracking-widest uppercase">Batal</button>
                                <button onclick="submitEditPdfDocument('${config.apiBase}', '${config.downloadBase}')" class="px-8 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase flex items-center gap-2">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                // Drag-drop events
                const dropzone = document.getElementById('dropzone');
                const fileInput = document.getElementById('ud_file');
                if (dropzone && fileInput) {
                    dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('border-blue-400', 'bg-blue-50/50'); });
                    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-blue-400', 'bg-blue-50/50'));
                    dropzone.addEventListener('drop', e => {
                        e.preventDefault();
                        dropzone.classList.remove('border-blue-400', 'bg-blue-50/50');
                        if (e.dataTransfer.files.length > 0) {
                            fileInput.files = e.dataTransfer.files;
                            updateDropzoneUI(e.dataTransfer.files[0]);
                        }
                    });
                    fileInput.addEventListener('change', () => {
                        if (fileInput.files.length > 0) updateDropzoneUI(fileInput.files[0]);
                    });
                }

                fetchPdfDocumentList(config.apiBase, config.downloadBase);
                content.style.opacity = 1;
            }, 300);
        }

        function fetchPdfDocumentList(apiBase, downloadBase) {
            fetch(apiBase)
                .then(r => r.json())
                .then(res => {
                    if (!res.success) return;
                    const tbody = document.getElementById('dokumen-tbody');
                    const countEl = document.getElementById('dok-count');
                    if (!tbody) return;

                    countEl.textContent = res.data.length + ' dokumen tersimpan di database';

                    if (res.data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="7" class="px-8 py-12 text-center text-slate-400 font-medium"><i class="fas fa-folder-open text-3xl block mb-3 opacity-30"></i>Belum ada dokumen. Upload dokumen pertama Anda di atas.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = res.data.map((d, i) => `
                        <tr class="hover:bg-blue-50/20 transition-colors group">
                            <td class="px-8 py-6 text-center">
                                <span class="text-[11px] font-black text-slate-400">${String(i+1).padStart(2,'0')}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <i class="${d.icon_class || 'fas fa-file-alt text-slate-400'} text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm leading-snug">${d.judul}</p>
                                        ${d.deskripsi ? `<p class="text-xs text-slate-400 mt-0.5 line-clamp-1">${d.deskripsi}</p>` : ''}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-black px-3 py-1.5 rounded-xl">${d.tahun}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-semibold text-slate-500">${d.kategori}</span>
                            </td>
                            <td class="px-8 py-6">
                                ${d.nama_file ? `
                                <div>
                                    <span class="inline-block bg-slate-100 text-slate-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">${d.tipe_file || 'file'}</span>
                                    <p class="text-[10px] text-slate-400 mt-1">${d.ukuran_file || ''}</p>
                                </div>` : '<span class="text-slate-300 text-xs">—</span>'}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-sm font-bold text-slate-500">${d.downloads || 0}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                     <a href="${downloadBase}/${d.id}/download" target="_blank"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Download">
                                        <i class="fas fa-download text-xs"></i>
                                    </a>
                                    <button onclick="openEditPdfDocModal(${JSON.stringify(d).replace(/"/g,'&quot;')})"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <button onclick="deletePdfDocument('${apiBase}', '${downloadBase}', ${d.id}, this)"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join('');
                })
                .catch(() => showToast('Gagal memuat daftar dokumen.', 'warning'));
        }

        function submitUploadPdfDocument(apiBase) {
            const judul = document.getElementById('ud_judul')?.value?.trim();
            const tahun = document.getElementById('ud_tahun')?.value?.trim();
            const file  = document.getElementById('ud_file')?.files[0];

            if (!judul) { showToast('Judul dokumen wajib diisi!', 'warning'); return; }
            if (!tahun) { showToast('Tahun wajib diisi!', 'warning'); return; }
            if (!file)  { showToast('Pilih file untuk diupload!', 'warning'); return; }

            const formData = new FormData();
            formData.append('judul',    judul);
            formData.append('tahun',    tahun);
            formData.append('deskripsi', document.getElementById('ud_deskripsi')?.value || '');
            formData.append('kategori', document.getElementById('ud_kategori')?.value || '');
            formData.append('file',     file);
            formData.append('_token',   '{{ csrf_token() }}');

            const btn = document.getElementById('uploadBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';

            fetch(`${apiBase}/upload`, { 
                method: 'POST', 
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(async r => {
                    const data = await r.json();
                    if (!r.ok) {
                        throw new Error(data.message || 'Terjadi kesalahan sistem.');
                    }
                    return data;
                })
                .then(res => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-upload"></i> Upload Dokumen';
                    if (res.success) {
                        showToast(res.message, 'success');
                        document.getElementById('ud_judul').value = '';
                        document.getElementById('ud_tahun').value = '';
                        document.getElementById('ud_deskripsi').value = '';
                        document.getElementById('ud_file').value = '';
                        document.getElementById('dropzone-text').textContent = 'Klik atau seret file ke sini';
                        document.getElementById('dropzone-text').classList.remove('text-blue-600');
                        document.getElementById('dropzone-icon').innerHTML = '<i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>';
                        fetchPdfDocumentList(apiBase, apiBase.replace('/admin', ''));
                    } else {
                        showToast(res.message || 'Upload gagal.', 'warning');
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-upload"></i> Upload Dokumen';
                    showToast(err.message || 'Terjadi kesalahan saat upload.', 'warning');
                });
        }

        function openEditPdfDocModal(d) {
            document.getElementById('edit_dok_id').value   = d.id;
            document.getElementById('edit_judul').value    = d.judul;
            document.getElementById('edit_tahun').value    = d.tahun;
            document.getElementById('edit_deskripsi').value= d.deskripsi || '';
            document.getElementById('edit_current_file').textContent = d.nama_file ? 'File saat ini: ' + d.nama_file + ' (' + (d.ukuran_file||'') + ')' : 'Belum ada file';
            document.getElementById('edit_kategori').value = d.kategori;
            document.getElementById('editDokumenModal').classList.remove('hidden');
        }

        function submitEditPdfDocument(apiBase, downloadBase) {
            const id = document.getElementById('edit_dok_id').value;
            const formData = new FormData();
            formData.append('judul',    document.getElementById('edit_judul').value);
            formData.append('tahun',    document.getElementById('edit_tahun').value);
            formData.append('deskripsi',document.getElementById('edit_deskripsi').value);
            formData.append('kategori', document.getElementById('edit_kategori').value);
            formData.append('_token',   '{{ csrf_token() }}');
            formData.append('_method',  'POST');
            const fileEl = document.getElementById('edit_file');
            if (fileEl.files.length > 0) formData.append('file', fileEl.files[0]);

            fetch(`${apiBase}/${id}/update`, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showToast(res.message, 'success');
                        closeEditDokModal();
                        fetchPdfDocumentList(apiBase, downloadBase);
                    } else {
                        showToast(res.message || 'Gagal menyimpan.', 'warning');
                    }
                })
                .catch(() => showToast('Terjadi kesalahan.', 'warning'));
        }

        async function deletePdfDocument(apiBase, downloadBase, id, btn) {
            if (!(await window.swalConfirm('Hapus dokumen ini beserta file-nya secara permanen?'))) return;
            fetch(`${apiBase}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    const row = btn.closest('tr');
                    row.style.opacity = 0; row.style.transform = 'translateX(20px)'; row.style.transition = 'all 0.3s';
                    setTimeout(() => { row.remove(); fetchPdfDocumentList(apiBase, downloadBase); }, 300);
                } else {
                    showToast(res.message || 'Gagal menghapus.', 'warning');
                }
            })
            .catch(() => showToast('Terjadi kesalahan.', 'warning'));
        }

       @include('dashboard.partials.panels.laporan-ami')

       @include('dashboard.partials.panels.rtm')

       @include('dashboard.partials.panels.slider')
   

        var kuesionerData = [];
        // kuesionerChart is already declared at the top level
        var kuesionerEditId = null;

        var kuesionerDataStudent = [];
        var kuesionerChartStudent = null;
        var kuesionerEditIdStudent = null;

        @include('dashboard.partials.panels.kuesioner-dosen')

       
       @include('dashboard.partials.panels.kuesioner-mahasiswa')

       @include('dashboard.partials.panels.galeri-foto')
       
        @include('dashboard.partials.panels.galeri-video')

        // Logic Fetching & Uploading
        function fetchAlbums() {
            fetch('/admin/galeri-album').then(r => r.json()).then(res => {
                const tbody = document.getElementById('galeri-foto-tbody');
                if (!tbody || !res.success) return;
                tbody.innerHTML = res.data.map((d, i) => {
                    let coverUrl = '/images/gedung-poljam.png';
                    if (d.sampul_foto) {
                        coverUrl = d.sampul_foto.startsWith('http') ? d.sampul_foto : '/storage/gallery/' + d.sampul_foto;
                    } else if (d.first_foto) {
                        coverUrl = '/storage/gallery/' + d.first_foto.file_path;
                    }

                    const safeCoverUrl = escapeHtml(coverUrl);
                    const safeAlbumName = escapeHtml(d.nama_album || '');
                    const safeCreatedAt = escapeHtml(d.created_at ? d.created_at.substring(0,10) : '');
                    const safeAlbumNameForJs = escapeJsString(d.nama_album || '');
                    
                    return `
                    <tr class="hover:bg-blue-50/10 border-b border-slate-50 transition-colors">
                        <td class="px-8 py-4 text-center text-[11px] font-black text-slate-400 uppercase">${String(i+1).padStart(2,'0')}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <img src="${safeCoverUrl}" 
                                     class="w-12 h-8 rounded-lg object-cover shadow-sm bg-slate-100" onerror="this.src='/images/gedung-poljam.png'">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">${safeAlbumName}</p>
                                    <p class="text-[10px] text-slate-400">${safeCreatedAt}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-end gap-2">
                                <button onclick="openManagePhotos(${d.id}, '${safeAlbumNameForJs}')"
                                    class="text-emerald-500 hover:text-emerald-700 py-2 px-3 bg-emerald-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-images mr-1"></i> Foto
                                </button>
                                <button onclick="openEditAlbum(${d.id}, '${safeAlbumNameForJs}')"
                                    class="text-blue-500 hover:text-blue-700 py-2 px-3 bg-blue-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-pen mr-1"></i>
                                </button>
                                <button onclick="deleteAlbum(${d.id})" class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                }).join('') || '<tr><td colspan="3" class="px-8 py-10 text-center text-slate-300">Belum ada album.</td></tr>';
            });
        }

        function fetchVideos() {
            fetch('/admin/galeri-video').then(r => r.json()).then(res => {
                const tbody = document.getElementById('galeri-video-tbody');
                if (!tbody || !res.success) return;
                tbody.innerHTML = res.data.map((d, i) => {
                    let youtubeId = null;
                    let isLocal = false;
                    if (d.link_youtube) {
                        const m = d.link_youtube.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/);
                        if (m) youtubeId = m[1];
                        else if (!d.link_youtube.startsWith('http')) isLocal = true;
                    }
                    const thumbHtml = youtubeId 
                        ? `<img src="https://img.youtube.com/vi/${youtubeId}/default.jpg" class="w-full h-full object-cover">`
                        : isLocal 
                            ? `<div class="w-full h-full flex items-center justify-center bg-slate-100"><i class="fas fa-film text-slate-400 text-lg"></i></div>`
                            : `<div class="w-full h-full flex items-center justify-center bg-slate-100"><i class="fas fa-video-slash text-slate-300 text-lg"></i></div>`;  

                    const safeTitle = escapeHtml(d.judul || '');
                    const safeLinkText = escapeHtml(d.link_youtube || '-');
                    const safeTitleForJs = escapeJsString(d.judul || '');
                    const safeLinkForJs = escapeJsString(d.link_youtube || '');
                    const safeDescriptionForJs = escapeJsString(d.deskripsi || '');

                    return `
                    <tr class="hover:bg-blue-50/10 border-b border-slate-50 transition-colors">
                        <td class="px-8 py-4 text-center text-[11px] font-black text-slate-400 uppercase">${String(i+1).padStart(2,'0')}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative w-12 h-8 rounded-lg overflow-hidden group/thumb cursor-pointer" 
                                     onclick="playDashboardVideo('${safeLinkForJs}', '${safeTitleForJs}')">
                                    ${thumbHtml}
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-white opacity-0 group-hover/thumb:opacity-100 transition-opacity">
                                        <i class="fas fa-play text-[10px]"></i>
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate">${safeTitle}</p>
                                    <p class="text-[10px] text-slate-400 max-w-xs truncate">${safeLinkText}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4 sticky right-0 z-10 bg-white/95 backdrop-blur-sm border-l border-slate-100">
                            <div class="flex justify-end gap-2 whitespace-nowrap">
                                <button onclick="playDashboardVideo('${safeLinkForJs}', '${safeTitleForJs}')"
                                    class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button onclick="openEditVideo(${d.id}, '${safeTitleForJs}', '${safeLinkForJs}', '${safeDescriptionForJs}')"
                                    class="text-blue-500 hover:text-blue-700 py-2 px-3 bg-blue-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-pen mr-1"></i>
                                </button>
                                <button onclick="deleteVideo(${d.id})" class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                }).join('') || '<tr><td colspan="3" class="px-8 py-10 text-center text-slate-300">Belum ada video.</td></tr>';
            });
        }

        function submitUploadAlbum() {
            const nama = document.getElementById('ga_nama').value;
            const file = document.getElementById('ga_file').files[0];
            const link = document.getElementById('ga_link').value;
            if(!nama) return showToast('Nama album wajib diisi', 'warning');

            const fd = new FormData();
            fd.append('nama_album', nama);
            if(file) fd.append('sampul_foto', file);
            if(link) fd.append('link_extern', link);
            fd.append('_token', '{{ csrf_token() }}');

            const btn = document.getElementById('uploadAlbumBtn');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';

            fetch('/admin/galeri-album/upload', {
                method: 'POST', 
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => {
                if (!r.ok) return r.json().then(err => { throw err; });
                return r.json();
            })
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                if(res.success) { 
                    showToast(res.message, 'success'); 
                    toggleUploadForm(); 
                    fetchAlbums(); 
                    document.getElementById('uploadGaleriFotoForm').reset();
                } else {
                    showToast(res.message || 'Gagal menyimpan.', 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                console.error(err);
                let msg = 'Terjadi kesalahan sistem.';
                if (err.errors) {
                    msg = Object.values(err.errors).flat().join(' ');
                } else if (err.message) {
                    msg = err.message;
                }
                showToast(msg, 'warning');
            });
        }

        function setVideoSource(type) {
            const fileSection = document.getElementById('gvFileSection');
            const linkSection = document.getElementById('gvLinkSection');
            const btnFile = document.getElementById('gvSrcFile');
            const btnLink = document.getElementById('gvSrcLink');
            if (type === 'file') {
                fileSection.classList.remove('hidden');
                linkSection.classList.add('hidden');
                btnFile.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                btnLink.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            } else {
                fileSection.classList.add('hidden');
                linkSection.classList.remove('hidden');
                btnLink.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                btnFile.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            }
        }

        function submitUploadVideo() {
            const judul = document.getElementById('gv_judul').value;
            const fileSectionVisible = !document.getElementById('gvFileSection').classList.contains('hidden');
            const file = document.getElementById('gv_file').files[0];
            const link = document.getElementById('gv_link').value.trim();
            const desc = document.getElementById('gv_deskripsi').value;
            if(!judul) return showToast('Judul video wajib diisi', 'warning');
            if(fileSectionVisible && !file) return showToast('File video wajib diunggah', 'warning');
            if(!fileSectionVisible && !link) return showToast('Link video wajib diisi', 'warning');

            const fd = new FormData();
            fd.append('judul', judul);
            fd.append('deskripsi', desc);
            if(fileSectionVisible && file) fd.append('video_file', file);
            if(!fileSectionVisible && link) fd.append('link_youtube', link);
            fd.append('_token', '{{ csrf_token() }}');

            const btn = document.getElementById('uploadVideoBtn');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';

            fetch('/admin/galeri-video/upload', {
                method: 'POST', 
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => {
                if (!r.ok) return r.json().then(err => { throw err; });
                return r.json();
            })
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                if(res.success) { 
                    showToast(res.message, 'success'); 
                    toggleUploadForm(); 
                    fetchVideos(); 
                    document.getElementById('uploadGaleriVideoForm').reset();
                } else {
                    showToast(res.message || 'Gagal menyimpan.', 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                console.error(err);
                let msg = 'Terjadi kesalahan sistem.';
                if (err.errors) {
                    msg = Object.values(err.errors).flat().join(' ');
                } else if (err.message) {
                    msg = err.message;
                }
                showToast(msg, 'warning');
            });
        }

        async function deleteAlbum(id) {
            if(!(await window.swalConfirm('Hapus album ini secara permanen?'))) return;
            fetch('/admin/galeri-album/' + id, {method: 'DELETE', body: new FormData(), headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})
                .then(r => r.json()).then(res => { if(res.success) { showToast(res.message, 'success'); fetchAlbums(); } });
        }

        async function deleteVideo(id) {
            if(!(await window.swalConfirm('Hapus video ini secara permanen?'))) return;
            fetch('/admin/galeri-video/' + id, {method: 'DELETE', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})
                .then(r => r.json()).then(res => { if(res.success) { showToast(res.message, 'success'); fetchVideos(); } });
        }

        function toggleUploadForm() {
            const container = document.getElementById('uploadFormContainer');
            if(!container) return;
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                setTimeout(() => { container.classList.remove('opacity-0', 'translate-y-4'); }, 10);
            } else {
                container.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => { container.classList.add('hidden'); }, 300);
            }
        }

        // ================================================================
        // EDIT ALBUM
        // ================================================================
        let currentEditAlbumId = null;
        function openEditAlbum(id, namaAlbum) {
            currentEditAlbumId = id;
            document.getElementById('ea_nama').value = namaAlbum;
            document.getElementById('ea_link').value = '';
            document.getElementById('editAlbumModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editAlbumModal').classList.remove('opacity-0');
                document.getElementById('editAlbumModalBox').classList.remove('scale-95');
            }, 10);
        }
        function closeEditAlbumModal() {
            document.getElementById('editAlbumModal').classList.add('opacity-0');
            document.getElementById('editAlbumModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('editAlbumModal').classList.add('hidden'), 200);
        }
        function saveEditAlbum() {
            const nama = document.getElementById('ea_nama').value;
            const file = document.getElementById('ea_file').files[0];
            const link = document.getElementById('ea_link').value;
            if(!nama) return showToast('Nama album wajib diisi', 'warning');
            const fd = new FormData();
            fd.append('nama_album', nama);
            if(file) fd.append('sampul_foto', file);
            if(link) fd.append('link_extern', link);
            fd.append('_token', '{{ csrf_token() }}');
            fetch('/admin/galeri-album/' + currentEditAlbumId + '/update', {
                method:'POST', 
                body: fd, 
                headers: { 'Accept': 'application/json' }
            })
                .then(r => {
                    if (!r.ok) return r.json().then(err => { throw err; });
                    return r.json();
                })
                .then(res => {
                    if(res.success) { showToast(res.message, 'success'); closeEditAlbumModal(); fetchAlbums(); }
                    else showToast(res.message || 'Gagal menyimpan.', 'warning');
                })
                .catch(err => {
                    console.error(err);
                    let msg = 'Gagal memperbarui album.';
                    if (err.errors) msg = Object.values(err.errors).flat().join(' ');
                    showToast(msg, 'warning');
                });
        }

        // ================================================================
        // EDIT VIDEO
        // ================================================================
        let currentEditVideoId = null;
        function openEditVideo(id, judul, link, deskripsi) {
            currentEditVideoId = id;
            document.getElementById('ev_judul').value = judul.trim();
            document.getElementById('ev_deskripsi').value = deskripsi.trim();
            const evLink = document.getElementById('ev_link');
            if (evLink) evLink.value = link.trim();
            // Auto-detect source type
            const isLocal = link && !link.startsWith('http');
            const isYoutube = link && link.startsWith('http');
            setEditVideoSource(isLocal ? 'file' : (isYoutube ? 'link' : 'file'));
            if (isYoutube && evLink) evLink.value = link.trim();
            document.getElementById('editVideoModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editVideoModal').classList.remove('opacity-0');
                document.getElementById('editVideoModalBox').classList.remove('scale-95');
            }, 10);
        }

        function setEditVideoSource(type) {
            const fileSection = document.getElementById('evFileSection');
            const linkSection = document.getElementById('evLinkSection');
            const btnFile = document.getElementById('evSrcFile');
            const btnLink = document.getElementById('evSrcLink');
            if (!fileSection || !linkSection) return;
            if (type === 'file') {
                fileSection.classList.remove('hidden');
                linkSection.classList.add('hidden');
                if(btnFile) btnFile.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                if(btnLink) btnLink.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            } else {
                fileSection.classList.add('hidden');
                linkSection.classList.remove('hidden');
                if(btnLink) btnLink.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                if(btnFile) btnFile.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            }
        }
        function closeEditVideoModal() {
            document.getElementById('editVideoModal').classList.add('opacity-0');
            document.getElementById('editVideoModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('editVideoModal').classList.add('hidden'), 200);
        }
        function saveEditVideo() {
            const judul = document.getElementById('ev_judul').value;
            const desc = document.getElementById('ev_deskripsi').value;
            const fileSectionVisible = document.getElementById('evFileSection') && !document.getElementById('evFileSection').classList.contains('hidden');
            const file = document.getElementById('ev_file') ? document.getElementById('ev_file').files[0] : null;
            const link = document.getElementById('ev_link') ? document.getElementById('ev_link').value.trim() : '';
            if(!judul) return showToast('Judul video wajib diisi', 'warning');
            const fd = new FormData();
            fd.append('judul', judul);
            if(desc) fd.append('deskripsi', desc);
            if(fileSectionVisible && file) fd.append('video_file', file);
            if(!fileSectionVisible && link) fd.append('link_youtube', link);
            fd.append('_token', '{{ csrf_token() }}');
            fetch('/admin/galeri-video/' + currentEditVideoId + '/update', {
                method:'POST', 
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
                .then(r => {
                    if (!r.ok) return r.json().then(err => { throw err; });
                    return r.json();
                })
                .then(res => {
                    if(res.success) { showToast(res.message, 'success'); closeEditVideoModal(); fetchVideos(); }
                    else showToast(res.message || 'Gagal menyimpan.', 'warning');
                })
                .catch(err => {
                    console.error(err);
                    let msg = 'Gagal memperbarui video.';
                    if (err.errors) msg = Object.values(err.errors).flat().join(' ');
                    showToast(msg, 'warning');
                });
        }

        // ================================================================
        // MANAGE PHOTOS IN ALBUM
        // ================================================================
        let currentManageAlbumId = null;

        function openManagePhotos(id, namaAlbum) {
            currentManageAlbumId = id;
            document.getElementById('mp_album_name').innerText = namaAlbum;
            document.getElementById('managePhotosModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('managePhotosModal').classList.remove('opacity-0');
                document.getElementById('managePhotosModalBox').classList.remove('scale-95');
            }, 10);
            fetchAlbumPhotos();
        }

        function closeManagePhotosModal() {
            document.getElementById('managePhotosModal').classList.add('opacity-0');
            document.getElementById('managePhotosModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('managePhotosModal').classList.add('hidden'), 200);
        }

        function fetchAlbumPhotos() {
            const container = document.getElementById('mp_photos_grid');
            container.innerHTML = '<div class="col-span-full py-10 text-center"><i class="fas fa-spinner fa-spin text-slate-300 text-2xl"></i></div>';
            
            fetch(`/admin/galeri-album/${currentManageAlbumId}/photos`)
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        container.innerHTML = res.data.map(p => {
                            const safeTitle = escapeHtml(p.judul || 'Foto');
                            const safeDescription = escapeHtml(p.deskripsi || 'Tanpa deskripsi');
                            const safeTitleForJs = escapeJsString(p.judul || '');
                            const safeDescriptionForJs = escapeJsString(p.deskripsi || '');
                            const safeFilePath = escapeHtml(p.file_path && p.file_path.startsWith('http') ? p.file_path : '/storage/gallery/' + (p.file_path || ''));

                            return `
                            <div class="relative group rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 shadow-sm">
                                <img src="${safeFilePath}" class="w-full h-36 object-cover">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-3 text-white">
                                    <p class="text-[10px] font-black uppercase tracking-widest truncate">${safeTitle}</p>
                                    <p class="text-[9px] opacity-80 truncate">${safeDescription}</p>
                                </div>
                                <div class="absolute top-2 right-2 flex gap-2">
                                    <button onclick="openEditPhoto(${p.id}, '${safeTitleForJs}', '${safeDescriptionForJs}')" class="w-8 h-8 rounded-lg bg-blue-500/90 text-white flex items-center justify-center hover:bg-blue-600 transition-colors">
                                        <i class="fas fa-pen text-[10px]"></i>
                                    </button>
                                    <button onclick="deletePhoto(${p.id})" class="w-8 h-8 rounded-lg bg-rose-500/90 text-white flex items-center justify-center hover:bg-rose-600 transition-colors">
                                        <i class="fas fa-trash text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        }).join('') || '<div class="col-span-full py-10 text-center text-slate-300 font-semibold uppercase tracking-widest text-[10px]">Belum ada foto di album ini.</div>';
                    }
                });
        }

        function submitAddPhotos() {
            const files = document.getElementById('mp_files').files;
            const linksInput = document.getElementById('mp_links');
            const title = document.getElementById('mp_title').value;
            const description = document.getElementById('mp_description').value;
            const links = linksInput ? linksInput.value.trim() : '';
            if (files.length === 0 && !links) return showToast('Pilih foto atau isi link foto terlebih dahulu', 'warning');

            const btn = document.getElementById('mp_upload_btn');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';

            const fd = new FormData();
            for (let i = 0; i < files.length; i++) {
                fd.append('photos[]', files[i]);
            }
            if (links) fd.append('photo_links', links);
            if (title) fd.append('judul', title);
            if (description) fd.append('deskripsi', description);
            fd.append('_token', '{{ csrf_token() }}');

            fetch(`/admin/galeri-album/${currentManageAlbumId}/photos/upload`, {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => {
                if (!r.ok) return r.json().then(err => { throw err; });
                return r.json();
            })
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                if (res.success) {
                    showToast(res.message, 'success');
                    document.getElementById('mp_files').value = '';
                    if (linksInput) linksInput.value = '';
                    document.getElementById('mp_title').value = '';
                    document.getElementById('mp_description').value = '';
                    fetchAlbumPhotos();
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                let msg = 'Gagal mengunggah foto.';
                if (err.errors) msg = Object.values(err.errors).flat().join(' ');
                showToast(msg, 'warning');
            });
        }

        let currentEditPhotoId = null;
        function openEditPhoto(id, title, description) {
            currentEditPhotoId = id;
            document.getElementById('ep_title').value = title || '';
            document.getElementById('ep_description').value = description || '';
            document.getElementById('editPhotoModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editPhotoModal').classList.remove('opacity-0');
                document.getElementById('editPhotoModalBox').classList.remove('scale-95');
            }, 10);
        }

        function closeEditPhotoModal() {
            document.getElementById('editPhotoModal').classList.add('opacity-0');
            document.getElementById('editPhotoModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('editPhotoModal').classList.add('hidden'), 200);
        }

        function saveEditPhoto() {
            const title = document.getElementById('ep_title').value;
            const description = document.getElementById('ep_description').value;
            const file = document.getElementById('ep_file').files[0];

            const fd = new FormData();
            if (title) fd.append('judul', title);
            if (description) fd.append('deskripsi', description);
            if (file) fd.append('photo_file', file);
            fd.append('_token', '{{ csrf_token() }}');

            fetch(`/admin/galeri-foto/${currentEditPhotoId}/update`, {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    closeEditPhotoModal();
                    fetchAlbumPhotos();
                } else {
                    showToast(res.message || 'Gagal memperbarui foto.', 'warning');
                }
            });
        }

        async function deletePhoto(id) {
            if (!(await window.swalConfirm('Hapus foto ini?'))) return;
            fetch(`/admin/galeri-foto/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    fetchAlbumPhotos();
                }
            });
        }

        function playDashboardVideo(url, title) {
            let youtubeId = null;
            let isLocal = false;
            if (url) {
                const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/;
                const matches = url.match(regex);
                if (matches && matches[1]) {
                    youtubeId = matches[1];
                } else if (!url.startsWith('http')) {
                    isLocal = true;
                }
            }

            const safeTitle = escapeHtml(title || '');
            if (youtubeId) {
                Swal.fire({
                    title: `<span class="text-slate-800 font-bold text-lg">${safeTitle}</span>`,
                    html: `
                        <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl border border-slate-100 mt-4">
                            <iframe width="100%" height="100%" 
                                src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0&modestbranding=1&playsinline=1&enablejsapi=1" 
                                title="${safeTitle}" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen></iframe>
                        </div>
                    `,
                    background: '#fff',
                    width: '800px',
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'rounded-[2.5rem] border border-white shadow-2xl',
                        closeButton: 'text-slate-400 hover:text-rose-500'
                    }
                });
            } else if (isLocal) {
                const videoUrl = escapeHtml('/storage/gallery/videos/' + (url || ''));
                Swal.fire({
                    title: `<span class="text-slate-800 font-bold text-lg">${safeTitle}</span>`,
                    html: `
                        <div class="rounded-2xl overflow-hidden shadow-2xl border border-slate-100 mt-4">
                            <video width="100%" height="auto" controls autoplay playsinline style="max-height: 70vh;">
                                <source src="${videoUrl}" type="video/mp4">
                                Browser Anda tidak mendukung tag pemutar video HTML5.
                            </video>
                        </div>
                    `,
                    background: '#fff',
                    width: '800px',
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'rounded-[2.5rem] border border-white shadow-2xl',
                        closeButton: 'text-slate-400 hover:text-rose-500'
                    }
                });
            } else {
                showToast('Url video tidak valid atau video tidak ditemukan.', 'warning');
            }
        }
    </script>