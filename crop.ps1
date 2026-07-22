Add-Type -AssemblyName System.Drawing
try {
    $srcPath = "c:\Users\USER\Poljam-Project\public\images\logo.png"
    $destPath = "c:\Users\USER\Poljam-Project\public\images\logo-emblem.png"
    
    $src = [System.Drawing.Image]::FromFile($srcPath)
    Write-Output "Loaded image from $srcPath. Size: $($src.Width)x$($src.Height)"
    
    $bmp = new-object System.Drawing.Bitmap($src.Height, $src.Height)
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    
    $rect = new-object System.Drawing.Rectangle(0, 0, $src.Height, $src.Height)
    $g.DrawImage($src, 0, 0, $rect, [System.Drawing.GraphicsUnit]::Pixel)
    
    $bmp.Save($destPath, [System.Drawing.Imaging.ImageFormat]::Png)
    Write-Output "Saved cropped emblem to $destPath successfully."
    
    $g.Dispose()
    $bmp.Dispose()
    $src.Dispose()
} catch {
    Write-Error $_.Exception.Message
}
