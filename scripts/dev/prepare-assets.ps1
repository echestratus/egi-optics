<#
.SYNOPSIS
  Collects, renames and optimises the source media for the content migration into ./assets/import
  (git-ignored). The folder is then mounted into wp-env (egi-assets) or rsynced to the server.

.PARAMETER HoldingDir
  Path to EGI-Resources-Holding/frontend/public/defence-system/egi-optic

.PARAMETER NewsDir
  Path to the Paspampres demonstration photos.

.EXAMPLE
  pwsh scripts/dev/prepare-assets.ps1
#>
param(
	[string]$HoldingDir = "C:\Users\Hakim\Documents\Freelance\EGI-Resources-Holding\frontend\public\defence-system\egi-optic",
	[string]$NewsDir = "$PSScriptRoot\..\..\assets\news\demo-di-paspampres",
	[string]$ExistingDir = "$PSScriptRoot\..\..\assets\import\existing",
	[string]$LogoDir = "$env:TEMP\egi-media"
)

$ErrorActionPreference = 'Stop'
$out = Join-Path $PSScriptRoot "..\..\assets\import"
New-Item -ItemType Directory -Force -Path $out | Out-Null
Add-Type -AssemblyName System.Drawing

function Copy-Asset($src, $name) {
	if (-not (Test-Path $src)) { Write-Warning "missing: $src"; return }
	Copy-Item $src (Join-Path $out $name) -Force
	Write-Host "+ $name"
}

# --- Product images (existing high-res renders from the previous site + holding assets)
Copy-Asset "$ExistingDir\laser-gun-2.png"      'laser-weapon-system-counter-uav-laser-gun.png'
Copy-Asset "$ExistingDir\laser-gun-3.png"      'laser-weapon-system-laser-gun-side.png'
Copy-Asset "$ExistingDir\laser-gun-4.png"      'laser-weapon-system-fpv-camera-disruption.png'
Copy-Asset "$HoldingDir\laser-weapon-system-1.png" 'laser-weapon-system-render.png'
Copy-Asset "$ExistingDir\laser-weapon-1.png"   'fenix-counter-uav-laser-complex-turret.png'
Copy-Asset "$HoldingDir\counter-uav-laser-complex-on-truck.png" 'fenix-counter-uav-laser-complex-maz-chassis.png'
Copy-Asset "$ExistingDir\laser-weapon-2.png"   'fenix-counter-uav-laser-complex-overview.png'
Copy-Asset "$ExistingDir\laser-weapon-3.png"   'fenix-counter-uav-laser-complex-container.png'
Copy-Asset "$HoldingDir\remote-control-unit-anoa.webp" 'remote-control-observation-unit-anoa-apc.webp'
Copy-Asset "$HoldingDir\remote-control-unit-1.png" 'remote-control-observation-unit.png'
Copy-Asset "$ExistingDir\laser-point-1.png"    'laser-point-lad-21t.png'
Copy-Asset "$ExistingDir\laser-point-2.png"    'laser-point-lad-21t-side.png'
Copy-Asset "$ExistingDir\thermal-2.png"        'thermal-vision-sight-tvd-35.png'
Copy-Asset "$ExistingDir\thermal-3.png"        'thermal-vision-sight-tvd-35-front.png'
Copy-Asset "$ExistingDir\thermal-4.png"        'thermal-vision-sight-tvd-35-side.png'
Copy-Asset "$ExistingDir\nvg-3.png"            'night-vision-monocular-nv-m-19-helmet.png'
Copy-Asset "$ExistingDir\nvg-2.png"            'night-vision-goggles-nv-g-14.png'
Copy-Asset "$HoldingDir\nvg.png"               'night-vision-monocular-nv-m-19.png'
Copy-Asset "$HoldingDir\nvg-on-rifle.png"      'night-vision-monocular-nv-m-19-rifle.png'
Copy-Asset "$ExistingDir\fusion-2.png"         'fusion-tn-ks-2.png'
Copy-Asset "$ExistingDir\fusion-3.png"         'fusion-tn-ks-2-black.png'
Copy-Asset "$ExistingDir\fusion-4.png"         'fusion-tn-ks-2-helmet-mount.png'
Copy-Asset "$ExistingDir\FUSION-2-1.png"       'fusion-tn-ks-2-channels-diagram.png'

# --- Videos + posters
# name => new name, poster timestamp (skip intro slides / static openings)
$videos = @{
	'laser-kopassus-trial.mp4'               = @('laser-weapon-system-kopassus-live-fire-trial.mp4', '00:00:12')
	'laser-gun-final.mp4'                    = @('laser-gun-laboratory-material-test.mp4', '00:00:24')
	'uji-coba-laser-lab.mp4'                 = @('fiber-laser-rnd-laboratory.mp4', '00:00:24')
	'nvg-test-clean-n-room-transition.mp4'   = @('nvg-clean-room-to-dark-room-transition.mp4', '00:00:24')
}
foreach ($k in $videos.Keys) {
	$name = $videos[$k][0]; $ts = $videos[$k][1]
	Copy-Asset "$HoldingDir\$k" $name
	$poster = $name.Replace('.mp4', '-poster.jpg')
	& ffmpeg -v error -y -ss $ts -i (Join-Path $out $name) -frames:v 1 -q:v 3 -vf "scale='min(1600,iw)':-2" (Join-Path $out $poster)
	Write-Host "+ $poster ($ts)"
}

# --- Datasheets
Copy-Asset "$HoldingDir\documents\NVG-GEN-4-EGI-OPTIK.pdf"            'EGI-Night-Vision-Monocular-NV-M-19-Gen4-Datasheet.pdf'
Copy-Asset "$HoldingDir\documents\Thermal-vision-sight-TVD35.pdf"     'EGI-Thermal-Vision-Sight-TVD-35-Datasheet.pdf'
Copy-Asset "$HoldingDir\documents\laser-point.pdf"                    'EGI-Laser-Point-LAD-21T-Datasheet.pdf'
Copy-Asset "$HoldingDir\documents\laserweaponsystem-counteruavlasercomplex-remotecontrolunit.pdf" 'EGI-Laser-Weapon-System-Fenix-Complex-Remote-Control-Unit-Datasheet.pdf'

# --- News photos: resize to 2000px wide JPEG
$photos = @{
	'brigjen-laode1.jpg'                 = 'paspampres-demonstration-brig-gen-la-ode-laser-gun.jpg'
	'brigjen-laode-2.jpg'                = 'paspampres-demonstration-brig-gen-la-ode-egi-team.jpg'
	'letkol-infanteri-denny-sopyan.jpg'  = 'paspampres-demonstration-lt-col-deni-sofyan-laser-gun.jpg'
}
foreach ($k in $photos.Keys) {
	$src = Join-Path $NewsDir $k
	if (-not (Test-Path $src)) { Write-Warning "missing: $src"; continue }
	& ffmpeg -v error -y -i $src -vf "scale=2000:-2" -q:v 3 (Join-Path $out $photos[$k])
	Write-Host "+ $($photos[$k])"
}

# --- Logo + site icon
Copy-Asset "$LogoDir\logo-egi-optik-indonesia.png"       'logo-egi-optik-indonesia.png'
Copy-Asset "$LogoDir\logo-egi-optik-indonesia-light.png" 'logo-egi-optik-indonesia-light.png'
$logo = [System.Drawing.Bitmap]::FromFile("$LogoDir\logo-egi-optik-indonesia.png")
$icon = New-Object System.Drawing.Bitmap 512, 512, ([System.Drawing.Imaging.PixelFormat]::Format32bppArgb)
$g = [System.Drawing.Graphics]::FromImage($icon)
$g.InterpolationMode = 'HighQualityBicubic'
$g.Clear([System.Drawing.Color]::FromArgb(255, 4, 8, 20))
$s = [Math]::Min(460 / $logo.Width, 460 / $logo.Height)
$w = [int]($logo.Width * $s); $h = [int]($logo.Height * $s)
$g.DrawImage($logo, [int]((512 - $w) / 2), [int]((512 - $h) / 2), $w, $h)
$g.Dispose(); $logo.Dispose()
$icon.Save((Join-Path $out 'site-icon-egi-optik.png'), [System.Drawing.Imaging.ImageFormat]::Png); $icon.Dispose()
Write-Host "+ site-icon-egi-optik.png"

Write-Host "`nAssets prepared in $out"
Get-ChildItem $out -File | Measure-Object -Property Length -Sum | ForEach-Object { "{0} files, {1:N1} MB" -f $_.Count, ($_.Sum / 1MB) }
