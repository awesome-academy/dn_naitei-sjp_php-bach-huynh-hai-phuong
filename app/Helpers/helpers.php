<?php

if (!function_exists('getSurroundingPages')) {
    function getSurroundingPages(int $totalPages, int $page): array
    {
        if ($page < 1 || $page > $totalPages) {
            return [];
        }

        $leftPage = max(1, $page - 2);
        $rightPage = min($totalPages, $page + 2);

        $surroundingPages = [];

        if ($leftPage !== 1) {
            $surroundingPages[] = 1;
        }

        if ($leftPage - 1 > 1) {
            $surroundingPages[] = 0;
        }

        for ($i = $leftPage; $i <= $rightPage; $i++) {
            $surroundingPages[] = $i;
        }

        if ($totalPages - $rightPage > 1) {
            $surroundingPages[] = 0;
        }

        if ($rightPage !== $totalPages) {
            $surroundingPages[] = $totalPages;
        }

        return $surroundingPages;
    }

}

if (!function_exists('formatDate')) {
    function formatDate($date): string
    {
        return $date ? \Carbon\Carbon::parse($date)->format('M j, Y') : '?';
    }
}
