<?php
include_once 'includes/connection.php';

$restore = [
    [1,  '1783959230_download__5_-removebg-preview.png'],
    [15, '1783960873__Pngtree_smiling_female_executive_wearing_headscarf_17014055-removebg-preview.png'],
    [17, 'Asian_businessman_isolated-removebg-preview.png'],
    [18, '1784633707_131237776639637232.jpg'],
    [19, '1784051186_carousel.jpg'],
    [20, '1784634334_27443878976521386.webp'],
    [21, '1784051202_job manifested.jpg'],
    [22, '1784633740_36873290702046463.webp'],
    [23, '1784051225_Yoon Sang Mi.jpg'],
    [24, '1784634518_Bereit für den nächsten Karriereschritt_ 🚀 Ein professionelles Bewerbungsfoto kann den Unterschied.webp'],
    [25, '1784634554_Vincenzo Fashion.jpg'],
    [26, '1784634586_Lawyer Outfits For Men_ 15 Timeless and Elegant Ideas 2024 7.jpg'],
    [27, '1784051315_formal style.jpg'],
];

foreach ($restore as [$id, $img]) {
    $img_esc = mysqli_real_escape_string($conn, $img);
    $r = mysqli_query($conn, "UPDATE lawyers SET profile_image='$img_esc' WHERE lawyer_id=$id");
    echo ($r ? "✅" : "❌") . " ID $id → $img\n";
}
echo "\nDone! All original images restored.";
