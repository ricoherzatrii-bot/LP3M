<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/super-build/ckeditor.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                        display: ['Roboto', 'sans-serif']
                    }
                }
            }
        }
    </script>
    @include('dashboard.partials.styles')
</head>
<body class="text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <div class="app-container">
        
        <!-- SIDEBAR (FLOATING) -->
    @include('dashboard.partials.sidebar')

        <div id="mobileSidebarOverlay" class="fixed inset-0 z-[60] hidden bg-slate-950/50 backdrop-blur-sm md:hidden" onclick="closeMobileSidebar()"></div>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 glass-panel rounded-3xl flex flex-col overflow-hidden relative shadow-[0_0_50px_rgba(0,0,0,0.05)] border border-white/60">
            
            <!-- HEADER FLOATING -->
            @include('dashboard.partials.header')

            <!-- DYNAMIC CONTENT SCROLL AREA -->
            <div id="dynamic-content" class="flex-1 overflow-y-auto p-6 lg:p-10 relative scroll-smooth">
                
                <div class="max-w-7xl mx-auto">

                    <!-- DASHBOARD OVERVIEW PANELS -->
                    @include('dashboard.partials.panels.overview')
                </div>
            </div>
            
        </main>
    </div>

    <!-- UNIVERSAL MODALS FOR CRUD -->
  @include('dashboard.partials.modals') 
   @include('dashboard.partials.edit-album') 
   
</body>
</html>