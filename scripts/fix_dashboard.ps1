$path = "resources/views/dashboard.blade.php"
$text = Get-Content -Raw -Path $path
$inc = "@include('dashboard.partials.sidebar')"
$overlay = '<div id="mobileSidebarOverlay" class="fixed inset-0 z-[60] hidden bg-slate-950/50 backdrop-blur-sm md:hidden" onclick="closeMobileSidebar()"></div>'
$start = $text.IndexOf($inc)
$end = $text.IndexOf($overlay, $start)
if ($start -lt 0 -or $end -lt 0) {
    Write-Host "pattern not found start=$start end=$end"
    exit 1
}
$replacement = "$inc`r`n`r`n        $overlay"
$newText = $text.Substring(0, $start) + $replacement + $text.Substring($end + $overlay.Length)
Set-Content -Path $path -Value $newText -Encoding utf8
Write-Host 'updated'