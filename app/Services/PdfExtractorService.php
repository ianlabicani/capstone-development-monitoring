<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class PdfExtractorService
{
    /**
     * Extract text content from a PDF file.
     */
    public function extract(string $filePath): string
    {
        $parser = new Parser;
        $pdf = $parser->parseFile($filePath);

        return $pdf->getText();
    }
}
