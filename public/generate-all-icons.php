<?php
// File ini akan membuat icon persegi dari logo Anda
$sourceFile = __DIR__ . '/images/logo-puskesmas.png';

if (!file_exists($sourceFile)) {
    die("Logo tidak ditemukan di: " . $sourceFile . "\nPastikan file logo-puskesmas.png ada di folder public/images/");
}

// Semua ukuran yang diperlukan
$sizes = [
    // Favicon sizes
    16, 32,
    // PWA sizes
    72, 96, 128, 144, 152, 192, 384, 512
];

// Load source image
$sourceImage = imagecreatefrompng($sourceFile);
if (!$sourceImage) {
    $sourceImage = imagecreatefromjpeg($sourceFile);
}

if (!$sourceImage) {
    die("Gagal memuat gambar. Pastikan file adalah PNG atau JPEG.");
}

// Dapatkan dimensi asli
$srcWidth = imagesx($sourceImage);
$srcHeight = imagesy($sourceImage);

// Tentukan ukuran crop (ambil sisi terpendek untuk membuat persegi)
$cropSize = min($srcWidth, $srcHeight);
$srcX = ($srcWidth - $cropSize) / 2;
$srcY = ($srcHeight - $cropSize) / 2;

$outputDir = __DIR__ . '/images/';

echo "Memproses icon untuk PWA dan Favicon...\n";
echo "Source file: {$sourceFile}\n";
echo "Ukuran asli: {$srcWidth}x{$srcHeight}\n";
echo "Ukuran crop: {$cropSize}x{$cropSize}\n\n";

foreach ($sizes as $size) {
    // Buat gambar kosong dengan background putih
    $newImage = imagecreatetruecolor($size, $size);

    // Isi background putih
    $white = imagecolorallocate($newImage, 255, 255, 255);
    imagefill($newImage, 0, 0, $white);

    // Crop dan resize gambar ke ukuran persegi
    imagecopyresampled(
        $newImage, $sourceImage,
        0, 0, $srcX, $srcY,
        $size, $size, $cropSize, $cropSize
    );

    // Simpan sebagai PNG
    $outputFile = $outputDir . "logo-puskesmas-{$size}.png";
    imagepng($newImage, $outputFile);

    echo "✓ Created: images/logo-puskesmas-{$size}.png ({$size}x{$size})\n";

    // Bersihkan memory
    imagedestroy($newImage);
}

imagedestroy($sourceImage);

echo "\n✅ Selesai! " . count($sizes) . " icon telah dibuat.\n";
echo "📁 File tersimpan di folder public/images/\n";
