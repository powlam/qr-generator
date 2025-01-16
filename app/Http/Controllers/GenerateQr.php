<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\QrGenerateRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;

final class GenerateQr extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @see QrCode docs: https://github.com/SimpleSoftwareIO/simple-qrcode/tree/develop/docs/en
     */
    public function __invoke(QrGenerateRequest $request): Factory|View
    {
        /** @var Generator $qrCode */
        $qrCode = QrCode::size(300)->margin(1);

        /** @var array{linkToConvert: string, qrColor?: string, qrType?: string} $validated */
        $validated = $request->validated();

        if (isset($validated['qrColor'])) {
            $rgb = $this->extractColorComponents($validated['qrColor']);
            $qrCode->color($rgb['red'], $rgb['green'], $rgb['blue']);
        }

        if (isset($validated['qrType'])) {
            $qrCode->style($validated['qrType']);
        }

        if ($isPNG = self::canGeneratePNG()) {
            $qrCode->format('png');
        }

        $qr = $qrCode->generate($validated['linkToConvert']);

        return view('welcome', [
            'qr' => $qr,
            'png' => $isPNG,
            'link' => $validated['linkToConvert'],
            'color' => $validated['qrColor'] ?? '',
            'style' => $validated['qrType'] ?? '',
        ]);
    }

    public static function canGeneratePNG(): bool
    {
        // You must install the imagick PHP extension if you plan on using the png image format: https://mlocati.github.io/articles/php-windows-imagick.html
        return extension_loaded('imagick');
    }

    /**
     * @return array{red: int, green: int, blue: int}
     */
    private function extractColorComponents(string $colorHex): array
    {
        // how to convert color string to RGB integer values: https://www.php.net/manual/en/function.hexdec.php#99478
        $colorVal = hexdec($colorHex);

        return [
            'red' => 0xFF & ($colorVal >> 0x10),
            'green' => 0xFF & ($colorVal >> 0x8),
            'blue' => 0xFF & $colorVal,
        ];
    }
}
