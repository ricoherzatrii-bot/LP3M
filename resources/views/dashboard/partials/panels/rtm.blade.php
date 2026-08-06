 function loadRtmPanel() {
            loadPdfDocumentPanel({
                title: 'RTM',
                subtitle: 'Upload, kelola, dan hapus dokumen Rapat Tinjauan Manajemen (RTM). Perubahan langsung tampil di halaman publik.',
                placeholderTitle: 'RTM Tahun 2026',
                publicUrl: '/capaian/rtm',
                apiBase: '/admin/rtm',
                downloadBase: '/rtm',
                iconClass: 'fa-file-signature',
                bgDotClass: 'bg-indigo-500',
                categories: ['RTM', 'Rapat Tinjauan Manajemen', 'Dokumen RTM', 'Dokumen Pendukung']
            });
        }