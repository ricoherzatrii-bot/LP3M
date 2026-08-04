const fs = require('fs');
const p = 'resources/views/dashboard.blade.php';
const t = fs.readFileSync(p, 'utf8');
const lines = t.split('\n');
lines.forEach((line, index) => {
  if (line.includes("@include('dashboard.partials.sidebar')")) {
    console.log('sidebar include line', index + 1);
  }
  if (line.includes('<div id="mobileSidebarOverlay"')) {
    console.log('overlay line', index + 1);
  }
});
const sfs = fs.readFileSync('scripts/fix_dashboard.ps1', 'utf8');
sfs.split('\n').forEach((line, index) => {
  if (line.includes('resources/views/dashboard.blade.php')) {
    console.log('script ref line', index + 1);
  }
});
