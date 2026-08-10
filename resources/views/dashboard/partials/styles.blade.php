  <style>
        body { 
            font-family: 'Roboto', sans-serif; 
            /* Ultra-Premium Light Mesh Background */
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(224, 242, 254, 0.6) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(209, 250, 229, 0.4) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(238, 242, 255, 0.6) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(254, 226, 226, 0.3) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .font-display { font-family: 'Roboto', sans-serif; }
        
        /* Hidden Scrollbar but functional */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.2); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.4); }

        .table-responsive {
            -webkit-overflow-scrolling: touch;
            touch-action: pan-x;
        }
        @media (max-width: 768px) {
            .table-responsive table {
                min-width: 720px;
            }
        }

        /* Floating Content Area */
        .app-container {
            height: 100vh;
            padding: 1rem;
            display: flex;
            gap: 1.5rem;
            box-sizing: border-box;
        }

        @media (min-width: 1024px) {
            .app-container { padding: 1.5rem; gap: 2rem; }
        }

        /* Glassmorphism Classes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.03), inset 0 1px 0 rgba(255, 255, 255, 1);
        }

        .dark-glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
        }

        /* Fluid Animations */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stagger-1 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards; opacity: 0; }
        .stagger-2 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards; opacity: 0; }
        .stagger-3 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards; opacity: 0; }
        .stagger-4 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.4s forwards; opacity: 0; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .animate-float { animation: float 8s ease-in-out infinite; }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }
        .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }

        /* Sidebar Item Hover Effect */
        .sidebar-item { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; z-index: 1; }
        .sidebar-item::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: all 0.4s ease; z-index: -1;
        }
        .sidebar-item:hover::before { left: 100%; transition: all 0.6s ease; }
        .sidebar-item:hover { transform: translateX(4px); }
        .sidebar-item, .submenu-item { pointer-events: auto; }

        .submenu-item { transition: all 0.3s ease; border-radius: 8px; color: #ffffff; font-weight: 500; }
        .submenu-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff !important;
            padding-left: 1rem;
        }

        /* Card Hover Effects */
        .stat-card { transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); }
        .stat-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 30px 60px -15px rgba(59, 130, 246, 0.15); }
        .stat-card:hover .icon-wrapper { transform: scale(1.1) rotate(-5deg); }
        
        /* CKEditor Height & Scroll Fix */
        .ck-editor__editable_inline {
            min-height: 200px;
            max-height: 400px;
            overflow-y: auto !important;
        }
        
        /* Fix overlapping and focus issues inside Tailwind modals */
        :root {
            --ck-z-default: 10000;
            --ck-z-modal: 10000;
        }
        .ck.ck-editor__editable:not(.ck-editor__nested-editable).ck-focused {
            box-shadow: var(--ck-inner-shadow), 0 0 0 3px rgba(59, 130, 246, 0.4);
            border: 1px solid var(--ck-color-focus-border);
            outline: none;
        }
        /* Ensure dropdowns appear above modal overlay which has z-50 */
        .ck.ck-balloon-panel {
            z-index: 10005 !important;
        }

        /* CKEditor Image Resize Styles */
        .ck-editor__editable .image {
            clear: both;
            text-align: center;
            margin: 0.9em auto;
        }
        .ck-editor__editable .image.image_resized {
            max-width: 100%;
            display: block;
            box-sizing: border-box;
        }
        .ck-editor__editable .image.image_resized img {
            width: 100%;
        }
        .ck-editor__editable .image img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            min-width: 50px;
        }
        .ck-editor__editable .image.image-style-side {
            float: right;
            margin-left: 1.5em;
            max-width: 50%;
        }
        .ck-editor__editable .image.image-style-align-left {
            float: left;
            margin-right: 1.5em;
            max-width: 50%;
        }
        .ck-editor__editable .image.image-style-align-center {
            margin-left: auto;
            margin-right: auto;
        }
        
        .modal-body-scroll {
            max-height: calc(90vh - 200px);
            overflow-y: auto;
            padding-right: 10px;
        }

        .modal-body-scroll::-webkit-scrollbar { width: 4px; }
        .modal-body-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }


    </style>