 function loadLaporanAmiPanel() {
            loadPdfDocumentPanel({
                title: 'Laporan AMI',
                subtitle: 'Upload, kelola, dan hapus laporan Audit Mutu Internal (AMI). Perubahan langsung tampil di halaman publik.',
                placeholderTitle: 'Laporan AMI Tahun 2026',
                publicUrl: '/capaian/laporan-ami',
                apiBase: '/admin/laporan-ami',
                downloadBase: '/laporan-ami',
                iconClass: 'fa-file-invoice',
                bgDotClass: 'bg-emerald-500',
                categories: ['Laporan AMI', 'Audit Mutu Internal', 'Formulir AMI', 'Dokumen Pendukung']
            });
        }