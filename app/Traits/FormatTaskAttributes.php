<?php

namespace App\Traits;

trait FormatTaskAttributes
{
    /**
     * Get HTML badge for task status.
     */
    protected function getStatusBadge(string $status): string
    {
        $color = match ($status) {
            'completed' => 'success',
            'in_progress' => 'primary',
            'cancelled' => 'danger',
            default => 'warning'
        };
        $label = str_replace('_', ' ', $status);
        return '<span class="badge bg-' . $color . '">' . ucwords($label) . '</span>';
    }

    /**
     * Get HTML badge for task priority.
     */
    protected function getPriorityBadge(string $priority): string
    {
        $color = match ($priority) {
            'urgent' => 'danger',
            'high' => 'warning',
            'medium' => 'info',
            default => 'secondary'
        };
        return '<span class="badge bg-' . $color . '">' . ucfirst($priority) . '</span>';
    }
}
