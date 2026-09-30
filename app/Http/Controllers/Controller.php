<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    /**
     * Stream a file from the configured disk inline for viewing in-browser.
     *
     * Used by role-specific controllers to display uploaded documents
     * (e.g. application attachments) without a direct download prompt.
     */
    protected function streamFile(string $path, ?string $downloadName = null)
    {
        $disk = Storage::disk('public');
        abort_unless($disk->exists($path), 404);

        $fullPath = $disk->path($path);
        $mime = $disk->mimeType($path) ?: 'application/octet-stream';
        $name = $downloadName ?: basename($path);

        return Response::make(file_get_contents($fullPath), 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . $name . '"',
        ]);
    }
}
