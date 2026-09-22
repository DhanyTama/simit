<?php
date_default_timezone_set('Asia/Jakarta');
$tanggal = date("Y-m-d");
$tampil = mysqli_query($connect, "SELECT * FROM pengunjung WHERE tgllapor='$tanggal' OR status='In Progress' OR status='Open' ORDER BY id DESC");

if (!function_exists('normalizePriorityName')) {
    /**
     * Normalisasi penulisan prioritas agar konsisten dan benar secara ejaan (EMERGENCY)
     */
    function normalizePriorityName($prio)
    {
        $p = trim((string)$prio);
        if (strcasecmp($p, 'EMERGANCY') === 0) {
            return 'EMERGENCY';
        }
        return $p;
    }
}

if (!function_exists('renderPbPriorityBadge')) {
    /**
     * Menampilkan lambang prioritas bergaya
     * - EMERGENCY / EMERGANCY: 💀 Tengkorak (Skull)
     * - URGENT: 💀 Tengkorak (Skull)
     * - HIGH / HIGH PRIORITY: ⬆️ Panah Atas (Chevron Up tebal)
     * - MEDIUM / MEDIUM PRIORITY: ➖ Minus (Horizontal Strip tebal)
     * - LOW / LOW PRIORITY: ⬇️ Panah Bawah (Chevron Down tebal)
     */
    function renderPbPriorityBadge($prio)
    {
        $prioClean = strtoupper(trim((string)$prio));
        if (empty($prioClean) || $prioClean === '-' || $prioClean === 'NULL') {
            return '';
        }

        // 💀 Tengkorak (EMERGANCY / EMERGENCY)
        if ($prioClean === 'EMERGANCY' || $prioClean === 'EMERGENCY') {
            return '<div class="pb-priority-wrapper">'
                . '<span class="pb-badge pb-emergency" title="Prioritas: EMERGENCY">'
                . '<svg class="pb-svg-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2a8 8 0 00-8 8c0 2.5 1.1 4.7 2.8 6.2.2.2.3.4.3.7V19a1 1 0 001 1h7.8a1 1 0 001-1v-2.1c0-.3.1-.5.3-.7C18.9 14.7 20 12.5 20 10a8 8 0 00-8-8zm-3.5 10a1.75 1.75 0 110-3.5 1.75 1.75 0 010 3.5zm7 0a1.75 1.75 0 110-3.5 1.75 1.75 0 010 3.5zm-5 4.5a.75.75 0 010-1.5h3a.75.75 0 010 1.5h-3zm-1.5 2.5v-1h6v1H9z"/></svg>'
                . '</span></div>';
        }

        // 💀 Tengkorak (URGENT)
        if ($prioClean === 'URGENT') {
            return '<div class="pb-priority-wrapper">'
                . '<span class="pb-badge pb-urgent" title="Prioritas: URGENT">'
                . '<svg class="pb-svg-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2a8 8 0 00-8 8c0 2.5 1.1 4.7 2.8 6.2.2.2.3.4.3.7V19a1 1 0 001 1h7.8a1 1 0 001-1v-2.1c0-.3.1-.5.3-.7C18.9 14.7 20 12.5 20 10a8 8 0 00-8-8zm-3.5 10a1.75 1.75 0 110-3.5 1.75 1.75 0 010 3.5zm7 0a1.75 1.75 0 110-3.5 1.75 1.75 0 010 3.5zm-5 4.5a.75.75 0 010-1.5h3a.75.75 0 010 1.5h-3zm-1.5 2.5v-1h6v1H9z"/></svg>'
                . '</span></div>';
        }

        // ⬆️ Panah Atas (HIGH / HIGH PRIORITY) - Chevron Up ala Pangkat Sersan PB
        if (strpos($prioClean, 'HIGH') !== false) {
            return '<div class="pb-priority-wrapper">'
                . '<span class="pb-badge pb-high" title="Prioritas: HIGH">'
                . '<svg class="pb-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="miter"><path d="M4.5 15.5L12 8L19.5 15.5"/></svg>'
                . '</span></div>';
        }

        // ➖ Minus (MEDIUM / MEDIUM PRIORITY) - Strip / Bar ala Pangkat Prajurit PB
        if (strpos($prioClean, 'MED') !== false) {
            return '<div class="pb-priority-wrapper">'
                . '<span class="pb-badge pb-medium" title="Prioritas: MEDIUM">'
                . '<svg class="pb-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="4.8" stroke-linecap="round"><path d="M4 12h16"/></svg>'
                . '</span></div>';
        }

        // ⬇️ Panah Bawah (LOW / LOW PRIORITY) - Chevron Down ala Pangkat PB
        if (strpos($prioClean, 'LOW') !== false) {
            return '<div class="pb-priority-wrapper">'
                . '<span class="pb-badge pb-low" title="Prioritas: LOW">'
                . '<svg class="pb-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="miter"><path d="M4.5 8.5L12 16L19.5 8.5"/></svg>'
                . '</span></div>';
        }

        // Default fallback
        return '<div class="pb-priority-wrapper">'
            . '<span class="pb-badge pb-medium" title="Prioritas: ' . htmlspecialchars($prioClean) . '">'
            . '<svg class="pb-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="4.8" stroke-linecap="round"><path d="M4 12h16"/></svg>'
            . '</span></div>';
    }
}
?>

<style>
    /* ========================================================
   STATUS FILTER & PRIORITY STYLES
   ======================================================== */
    /* ========================================================
   STATUS FILTER & PRIORITY STYLES (PILL BUTTONS)
   ======================================================== */
    .status-filter-toolbar {
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
        padding: 12px 16px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        margin-bottom: 16px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        box-sizing: border-box !important;
    }

    .filter-toolbar-row {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        flex-wrap: wrap !important;
        gap: 8px 14px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .filter-row-divider {
        width: 100% !important;
        height: 1px !important;
        background: #f1f5f9 !important;
        margin: 2px 0 !important;
    }

    .filter-group-wrapper {
        display: inline-flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
        box-sizing: border-box !important;
    }

    .filter-label {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #64748b !important;
        display: inline-block !important;
        min-width: 72px !important;
        width: 72px !important;
        white-space: nowrap !important;
        letter-spacing: 0.5px !important;
        text-transform: uppercase !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box !important;
    }

    .filter-label-petugas {
        min-width: auto !important;
        width: auto !important;
        margin-right: 2px !important;
    }

    .status-filter-pills,
    .priority-filter-pills {
        display: inline-flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
    }

    .btn-filter-pill,
    .btn-filter-pill-prio {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        height: 30px !important;
        min-height: 30px !important;
        max-height: 30px !important;
        padding: 0 10px !important;
        border-radius: 15px !important;
        border-width: 1.5px !important;
        border-style: solid !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: normal !important;
        cursor: pointer !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        box-sizing: border-box !important;
        white-space: nowrap !important;
    }

    .btn-filter-pill:hover,
    .btn-filter-pill-prio:hover {
        transform: translateY(-1px) !important;
    }

    .btn-filter-pill:active,
    .btn-filter-pill-prio:active {
        transform: scale(0.97) !important;
    }

    /* Active Base */
    .btn-filter-pill.active,
    .btn-filter-pill-prio.active {
        color: #ffffff !important;
    }

    .btn-filter-pill.active .pill-count,
    .btn-filter-pill-prio.active .pill-count {
        background: rgba(255, 255, 255, 0.28) !important;
        color: #ffffff !important;
    }

    /* Dots warna */
    .pill-dot,
    .prio-dot {
        width: 8px !important;
        height: 8px !important;
        min-width: 8px !important;
        min-height: 8px !important;
        border-radius: 50% !important;
        display: inline-block !important;
        flex-shrink: 0 !important;
    }

    .pill-count {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 18px !important;
        height: 18px !important;
        padding: 0 5px !important;
        border-radius: 9px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        line-height: 1 !important;
        box-sizing: border-box !important;
        transition: all 0.2s ease !important;
    }

    /* --- LIGHT MODE STATUS PILLS --- */
    .btn-filter-pill[data-status="ALL"] {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #334155;
    }

    .btn-filter-pill[data-status="ALL"] .pill-dot {
        background: #64748b;
    }

    .btn-filter-pill[data-status="ALL"] .pill-count {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-filter-pill[data-status="ALL"]:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .btn-filter-pill[data-status="ALL"].active {
        background: #2563eb !important;
        border-color: #1d4ed8 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.35) !important;
    }

    .btn-filter-pill[data-status="ALL"].active .pill-dot {
        background: #93c5fd !important;
    }

    .btn-filter-pill[data-status="Open"] {
        background: #fff5f7;
        border-color: #fecdd3;
        color: #be123c;
    }

    .btn-filter-pill[data-status="Open"] .pill-dot {
        background: #e11d48;
    }

    .btn-filter-pill[data-status="Open"] .pill-count {
        background: #ffe4e6;
        color: #be123c;
    }

    .btn-filter-pill[data-status="Open"]:hover {
        background: #ffe4e6;
        border-color: #fda4af;
        color: #9f1239;
    }

    .btn-filter-pill[data-status="Open"].active {
        background: #e11d48 !important;
        border-color: #be123c !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(225, 29, 72, 0.35) !important;
    }

    .btn-filter-pill[data-status="Open"].active .pill-dot {
        background: #fecdd3 !important;
    }

    .btn-filter-pill[data-status="In Progress"] {
        background: #f0f9ff;
        border-color: #bae6fd;
        color: #0369a1;
    }

    .btn-filter-pill[data-status="In Progress"] .pill-dot {
        background: #0284c7;
    }

    .btn-filter-pill[data-status="In Progress"] .pill-count {
        background: #e0f2fe;
        color: #0369a1;
    }

    .btn-filter-pill[data-status="In Progress"]:hover {
        background: #e0f2fe;
        border-color: #7dd3fc;
        color: #075985;
    }

    .btn-filter-pill[data-status="In Progress"].active {
        background: #0284c7 !important;
        border-color: #0369a1 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.35) !important;
    }

    .btn-filter-pill[data-status="In Progress"].active .pill-dot {
        background: #bae6fd !important;
    }

    .btn-filter-pill[data-status="Complete"] {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #15803d;
    }

    .btn-filter-pill[data-status="Complete"] .pill-dot {
        background: #16a34a;
    }

    .btn-filter-pill[data-status="Complete"] .pill-count {
        background: #dcfce7;
        color: #15803d;
    }

    .btn-filter-pill[data-status="Complete"]:hover {
        background: #dcfce7;
        border-color: #86efac;
        color: #166534;
    }

    .btn-filter-pill[data-status="Complete"].active {
        background: #16a34a !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.35) !important;
    }

    .btn-filter-pill[data-status="Complete"].active .pill-dot {
        background: #bbf7d0 !important;
    }

    /* --- LIGHT MODE PRIORITAS PILLS --- */
    .btn-filter-pill-prio[data-priority="ALL"] {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #334155;
    }

    .btn-filter-pill-prio[data-priority="ALL"] .prio-dot {
        background: #64748b;
    }

    .btn-filter-pill-prio[data-priority="ALL"] .pill-count {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-filter-pill-prio[data-priority="ALL"]:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .btn-filter-pill-prio[data-priority="ALL"].active {
        background: #475569 !important;
        border-color: #334155 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(71, 85, 105, 0.35) !important;
    }

    .btn-filter-pill-prio[data-priority="ALL"].active .prio-dot {
        background: #cbd5e1 !important;
    }

    .btn-filter-pill-prio[data-priority="EMERGENCY"] {
        background: #fef2f2;
        border-color: #fecaca;
        color: #b91c1c;
    }

    .btn-filter-pill-prio[data-priority="EMERGENCY"] .prio-dot {
        background: #ef4444;
    }

    .btn-filter-pill-prio[data-priority="EMERGENCY"] .pill-count {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-filter-pill-prio[data-priority="EMERGENCY"]:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #991b1b;
    }

    .btn-filter-pill-prio[data-priority="EMERGENCY"].active {
        background: #dc2626 !important;
        border-color: #b91c1c !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.35) !important;
    }

    .btn-filter-pill-prio[data-priority="EMERGENCY"].active .prio-dot {
        background: #fecaca !important;
    }

    .btn-filter-pill-prio[data-priority="HIGH PRIORITY"] {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
    }

    .btn-filter-pill-prio[data-priority="HIGH PRIORITY"] .prio-dot {
        background: #f59e0b;
    }

    .btn-filter-pill-prio[data-priority="HIGH PRIORITY"] .pill-count {
        background: #fef3c7;
        color: #b45309;
    }

    .btn-filter-pill-prio[data-priority="HIGH PRIORITY"]:hover {
        background: #fef3c7;
        border-color: #fcd34d;
        color: #92400e;
    }

    .btn-filter-pill-prio[data-priority="HIGH PRIORITY"].active {
        background: #d97706 !important;
        border-color: #b45309 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(217, 119, 6, 0.35) !important;
    }

    .btn-filter-pill-prio[data-priority="HIGH PRIORITY"].active .prio-dot {
        background: #fde68a !important;
    }

    .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"] {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"] .prio-dot {
        background: #64748b;
    }

    .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"] .pill-count {
        background: #e2e8f0;
        color: #475569;
    }

    .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"]:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"].active {
        background: #475569 !important;
        border-color: #334155 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(71, 85, 105, 0.35) !important;
    }

    .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"].active .prio-dot {
        background: #cbd5e1 !important;
    }

    .btn-filter-pill-prio[data-priority="LOW PRIORITY"] {
        background: #f0f9ff;
        border-color: #bae6fd;
        color: #0369a1;
    }

    .btn-filter-pill-prio[data-priority="LOW PRIORITY"] .prio-dot {
        background: #0ea5e9;
    }

    .btn-filter-pill-prio[data-priority="LOW PRIORITY"] .pill-count {
        background: #e0f2fe;
        color: #0369a1;
    }

    .btn-filter-pill-prio[data-priority="LOW PRIORITY"]:hover {
        background: #e0f2fe;
        border-color: #7dd3fc;
        color: #075985;
    }

    .btn-filter-pill-prio[data-priority="LOW PRIORITY"].active {
        background: #0284c7 !important;
        border-color: #0369a1 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.35) !important;
    }

    .btn-filter-pill-prio[data-priority="LOW PRIORITY"].active .prio-dot {
        background: #bae6fd !important;
    }

    /* --- PETUGAS SELECT & RESET (LIGHT MODE) --- */
    .petugas-filter-wrapper {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        margin-left: auto !important;
    }

    @media (max-width: 991px) {
        .petugas-filter-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
            padding-top: 4px !important;
        }
    }

    select.select-petugas-filter {
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        height: 30px !important;
        min-height: 30px !important;
        max-height: 30px !important;
        padding: 0 26px 0 12px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 28px !important;
        border-radius: 15px !important;
        border: 1.5px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 8px center !important;
        background-size: 12px 12px !important;
        color: #334155 !important;
        cursor: pointer !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        min-width: 150px !important;
        max-width: 200px !important;
        display: inline-block !important;
        box-sizing: border-box !important;
        transition: all 0.2s ease !important;
    }

    select.select-petugas-filter:focus {
        border-color: #2563eb !important;
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
    }

    .btn-filter-reset {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
        height: 30px !important;
        min-height: 30px !important;
        max-height: 30px !important;
        padding: 0 12px !important;
        border-radius: 15px !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #f8fafc !important;
        color: #64748b !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 28px !important;
        cursor: pointer !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-sizing: border-box !important;
        white-space: nowrap !important;
    }

    .btn-filter-reset:hover {
        background: #e2e8f0 !important;
        color: #0f172a !important;
        border-color: #94a3b8 !important;
    }

    .btn-filter-reset:active {
        transform: scale(0.97) !important;
    }

    /* PB Priority Badges */
    .pb-priority-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 5px;
    }

    .pb-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 22px;
        padding: 0;
        border-radius: 5px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        user-select: none;
    }

    .pb-badge:hover {
        transform: translateY(-1px) scale(1.1);
    }

    .pb-badge .pb-svg-icon {
        display: inline-block;
        vertical-align: middle;
        flex-shrink: 0;
    }

    /* 💀 PB Tengkorak - EMERGENCY (Light Mode: Clean Enamel Crimson) */
    .pb-emergency {
        background: linear-gradient(180deg, #ffffff 0%, #fee2e2 100%);
        border: 1.5px solid #ef4444;
        box-shadow: 0 1px 3px rgba(220, 38, 38, 0.15);
    }

    .pb-emergency .pb-svg-icon {
        color: #dc2626;
        filter: drop-shadow(0 1px 0 rgba(255, 255, 255, 0.8));
    }

    /* 💀 PB Tengkorak - URGENT (Light Mode: Clean Enamel Orange) */
    .pb-urgent {
        background: linear-gradient(180deg, #ffffff 0%, #ffedd5 100%);
        border: 1.5px solid #f97316;
        box-shadow: 0 1px 3px rgba(234, 88, 12, 0.15);
    }

    .pb-urgent .pb-svg-icon {
        color: #ea580c;
        filter: drop-shadow(0 1px 0 rgba(255, 255, 255, 0.8));
    }

    /* ⬆️ PB Panah Atas - HIGH PRIORITY (Light Mode: Clean Enamel Gold) */
    .pb-high {
        background: linear-gradient(180deg, #ffffff 0%, #fef3c7 100%);
        border: 1.5px solid #eab308;
        box-shadow: 0 1px 3px rgba(202, 138, 4, 0.15);
    }

    .pb-high .pb-svg-icon {
        color: #ca8a04;
        filter: drop-shadow(0 1px 0 rgba(255, 255, 255, 0.8));
    }

    /* ➖ PB Minus (Strip) - MEDIUM PRIORITY (Light Mode: Clean Enamel Steel) */
    .pb-medium {
        background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        border: 1.5px solid #94a3b8;
        box-shadow: 0 1px 3px rgba(71, 85, 105, 0.12);
    }

    .pb-medium .pb-svg-icon {
        color: #475569;
        filter: drop-shadow(0 1px 0 rgba(255, 255, 255, 0.8));
    }

    /* ⬇️ PB Panah Bawah - LOW PRIORITY (Light Mode: Clean Enamel Cyan/Sky) */
    .pb-low {
        background: linear-gradient(180deg, #ffffff 0%, #e0f2fe 100%);
        border: 1.5px solid #06b6d4;
        box-shadow: 0 1px 3px rgba(2, 132, 199, 0.15);
    }

    .pb-low .pb-svg-icon {
        color: #0284c7;
        filter: drop-shadow(0 1px 0 rgba(255, 255, 255, 0.8));
    }

    /* Muted / Pending */
    .pb-none {
        background: #f8fafc;
        color: #94a3b8;
        border: 1.5px dashed #cbd5e1;
        font-size: 11px;
        font-weight: 700;
        box-shadow: none;
    }

    /* PB Legend in toolbar */
    .pb-legend-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pb-legend-title {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pb-legend-items {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .pb-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #475569;
    }

    /* ========================================================
       DARK MODE OVERRIDES - Cyber Neon Dark Tactical Badges
       ======================================================== */
    .dark-mode .pb-legend-item {
        color: #cbd5e1;
    }

    .dark-mode .status-filter-toolbar {
        background: #0f172a !important;
        border-color: #334155 !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35) !important;
    }

    .dark-mode .filter-label {
        color: #94a3b8 !important;
    }

    .dark-mode .filter-row-divider {
        background: rgba(255, 255, 255, 0.08) !important;
    }

    /* --- DARK MODE STATUS PILLS --- */
    .dark-mode .btn-filter-pill[data-status="ALL"] {
        background: #141f32;
        border-color: #334155;
        color: #cbd5e1;
    }

    .dark-mode .btn-filter-pill[data-status="ALL"] .pill-dot {
        background: #64748b;
    }

    .dark-mode .btn-filter-pill[data-status="ALL"] .pill-count {
        background: #334155;
        color: #e2e8f0;
    }

    .dark-mode .btn-filter-pill[data-status="ALL"]:hover {
        background: #1e293b;
        border-color: #64748b;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill[data-status="ALL"].active {
        background: #2563eb !important;
        border-color: #3b82f6 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4) !important;
    }

    .dark-mode .btn-filter-pill[data-status="ALL"].active .pill-dot {
        background: #bfdbfe !important;
    }

    .dark-mode .btn-filter-pill[data-status="Open"] {
        background: #1a0f16;
        border-color: #4c0519;
        color: #fda4af;
    }

    .dark-mode .btn-filter-pill[data-status="Open"] .pill-dot {
        background: #f43f5e;
    }

    .dark-mode .btn-filter-pill[data-status="Open"] .pill-count {
        background: #4c0519;
        color: #fda4af;
    }

    .dark-mode .btn-filter-pill[data-status="Open"]:hover {
        background: #2a121e;
        border-color: #e11d48;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill[data-status="Open"].active {
        background: #e11d48 !important;
        border-color: #fb7185 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(225, 29, 72, 0.4) !important;
    }

    .dark-mode .btn-filter-pill[data-status="Open"].active .pill-dot {
        background: #fecdd3 !important;
    }

    .dark-mode .btn-filter-pill[data-status="In Progress"] {
        background: #0b1a28;
        border-color: #075985;
        color: #7dd3fc;
    }

    .dark-mode .btn-filter-pill[data-status="In Progress"] .pill-dot {
        background: #38bdf8;
    }

    .dark-mode .btn-filter-pill[data-status="In Progress"] .pill-count {
        background: #0c4a6e;
        color: #7dd3fc;
    }

    .dark-mode .btn-filter-pill[data-status="In Progress"]:hover {
        background: #0f2b42;
        border-color: #0284c7;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill[data-status="In Progress"].active {
        background: #0284c7 !important;
        border-color: #38bdf8 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4) !important;
    }

    .dark-mode .btn-filter-pill[data-status="In Progress"].active .pill-dot {
        background: #bae6fd !important;
    }

    .dark-mode .btn-filter-pill[data-status="Complete"] {
        background: #0b1d16;
        border-color: #14532d;
        color: #86efac;
    }

    .dark-mode .btn-filter-pill[data-status="Complete"] .pill-dot {
        background: #4ade80;
    }

    .dark-mode .btn-filter-pill[data-status="Complete"] .pill-count {
        background: #14532d;
        color: #86efac;
    }

    .dark-mode .btn-filter-pill[data-status="Complete"]:hover {
        background: #0f2e20;
        border-color: #16a34a;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill[data-status="Complete"].active {
        background: #16a34a !important;
        border-color: #4ade80 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.4) !important;
    }

    .dark-mode .btn-filter-pill[data-status="Complete"].active .pill-dot {
        background: #bbf7d0 !important;
    }

    /* --- DARK MODE PRIORITAS PILLS --- */
    .dark-mode .btn-filter-pill-prio[data-priority="ALL"] {
        background: #141f32;
        border-color: #334155;
        color: #cbd5e1;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="ALL"] .prio-dot {
        background: #64748b;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="ALL"] .pill-count {
        background: #1e293b;
        color: #cbd5e1;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="ALL"]:hover {
        background: #1e293b;
        border-color: #475569;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="ALL"].active {
        background: #334155 !important;
        border-color: #475569 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(51, 65, 85, 0.4) !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="ALL"].active .prio-dot {
        background: #94a3b8 !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="EMERGENCY"] {
        background: #1f0b0f;
        border-color: #881337;
        color: #fda4af;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="EMERGENCY"] .prio-dot {
        background: #f43f5e;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="EMERGENCY"] .pill-count {
        background: #4c0519;
        color: #fda4af;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="EMERGENCY"]:hover {
        background: #2e0d16;
        border-color: #be123c;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="EMERGENCY"].active {
        background: #be123c !important;
        border-color: #f43f5e !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(244, 63, 94, 0.4) !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="EMERGENCY"].active .prio-dot {
        background: #fecdd3 !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="HIGH PRIORITY"] {
        background: #1c1305;
        border-color: #78350f;
        color: #fde68a;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="HIGH PRIORITY"] .prio-dot {
        background: #f59e0b;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="HIGH PRIORITY"] .pill-count {
        background: #451a03;
        color: #fde68a;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="HIGH PRIORITY"]:hover {
        background: #2e1d08;
        border-color: #b45309;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="HIGH PRIORITY"].active {
        background: #b45309 !important;
        border-color: #f59e0b !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4) !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="HIGH PRIORITY"].active .prio-dot {
        background: #fef3c7 !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"] {
        background: #141f32;
        border-color: #334155;
        color: #cbd5e1;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"] .prio-dot {
        background: #64748b;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"] .pill-count {
        background: #1e293b;
        color: #cbd5e1;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"]:hover {
        background: #1e293b;
        border-color: #475569;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"].active {
        background: #475569 !important;
        border-color: #64748b !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(100, 116, 139, 0.4) !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="MEDIUM PRIORITY"].active .prio-dot {
        background: #cbd5e1 !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="LOW PRIORITY"] {
        background: #081726;
        border-color: #075985;
        color: #7dd3fc;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="LOW PRIORITY"] .prio-dot {
        background: #38bdf8;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="LOW PRIORITY"] .pill-count {
        background: #0c4a6e;
        color: #7dd3fc;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="LOW PRIORITY"]:hover {
        background: #0f2b42;
        border-color: #0284c7;
        color: #ffffff;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="LOW PRIORITY"].active {
        background: #0284c7 !important;
        border-color: #38bdf8 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4) !important;
    }

    .dark-mode .btn-filter-pill-prio[data-priority="LOW PRIORITY"].active .prio-dot {
        background: #bae6fd !important;
    }

    /* --- DARK MODE PETUGAS SELECT & RESET (EXACT SAME SIZES) --- */
    .dark-mode select.select-petugas-filter {
        height: 30px !important;
        min-height: 30px !important;
        max-height: 30px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 28px !important;
        border-radius: 15px !important;
        padding: 0 26px 0 12px !important;
        background-color: #141f32 !important;
        border: 1.5px solid #334155 !important;
        color: #f1f5f9 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 8px center !important;
        background-size: 12px 12px !important;
        box-sizing: border-box !important;
    }

    .dark-mode select.select-petugas-filter:hover {
        border-color: #475569 !important;
    }

    .dark-mode select.select-petugas-filter:focus {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.25) !important;
        outline: none !important;
    }

    .dark-mode select.select-petugas-filter option {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
        padding: 4px 8px !important;
        font-size: 12px !important;
    }

    .dark-mode .btn-filter-reset {
        height: 30px !important;
        min-height: 30px !important;
        max-height: 30px !important;
        padding: 0 12px !important;
        border-radius: 15px !important;
        border: 1.5px solid #334155 !important;
        background: #141f32 !important;
        color: #94a3b8 !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 28px !important;
        box-sizing: border-box !important;
    }

    .dark-mode .btn-filter-reset:hover {
        background: #1e293b !important;
        color: #ffffff !important;
        border-color: #475569 !important;
    }

    /* ==========================================================================
       SKIN-SPECIFIC FILTER TOOLBAR (CAPPUCCINO, EVERFOREST, TOKYO, PB)
       ========================================================================== */
    /* --- CAPPUCCINO --- */
    html.skin-cappuccino.dark-mode .status-filter-toolbar,
    body.skin-cappuccino.dark-mode .status-filter-toolbar,
    .skin-cappuccino.dark-mode .status-filter-toolbar {
        background: #1b1411 !important;
        border-color: #382a22 !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4) !important;
    }

    html.skin-cappuccino.dark-mode .filter-label,
    body.skin-cappuccino.dark-mode .filter-label,
    .skin-cappuccino.dark-mode .filter-label {
        color: #d4a373 !important;
    }

    html.skin-cappuccino.dark-mode .filter-row-divider,
    body.skin-cappuccino.dark-mode .filter-row-divider,
    .skin-cappuccino.dark-mode .filter-row-divider {
        background: rgba(212, 163, 115, 0.15) !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"],
    body.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"],
    .skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"] {
        background: #241b16;
        border-color: #382a22;
        color: #faedcd;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"] .pill-dot,
    body.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"] .pill-dot {
        background: #d4a373;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"] .pill-count,
    body.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"] .pill-count {
        background: #382a22;
        color: #faedcd;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"]:hover,
    body.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"]:hover {
        background: #2f221c;
        border-color: #d4a373;
        color: #ffffff;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"].active,
    body.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"].active,
    .skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"].active {
        background: #d4a373 !important;
        border-color: #e9c46a !important;
        color: #181310 !important;
        box-shadow: 0 2px 8px rgba(212, 163, 115, 0.4) !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"].active .pill-dot,
    body.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"].active .pill-dot {
        background: #181310 !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"].active .pill-count,
    body.skin-cappuccino.dark-mode .btn-filter-pill[data-status="ALL"].active .pill-count {
        background: #181310 !important;
        color: #d4a373 !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"],
    body.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"],
    .skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"] {
        background: #241b16;
        border-color: #382a22;
        color: #faedcd;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"] .pill-dot,
    body.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"] .pill-dot {
        background: #d4a373;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"] .pill-count,
    body.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"] .pill-count {
        background: #382a22;
        color: #faedcd;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"]:hover,
    body.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"]:hover {
        background: #2f221c;
        border-color: #d4a373;
        color: #ffffff;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active,
    body.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active,
    .skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active {
        background: #d4a373 !important;
        border-color: #e9c46a !important;
        color: #181310 !important;
        box-shadow: 0 2px 8px rgba(212, 163, 115, 0.4) !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active .pill-dot,
    body.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active .pill-dot {
        background: #181310 !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active .pill-count,
    body.skin-cappuccino.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active .pill-count {
        background: #181310 !important;
        color: #d4a373 !important;
    }

    html.skin-cappuccino.dark-mode select.select-petugas-filter,
    body.skin-cappuccino.dark-mode select.select-petugas-filter,
    .skin-cappuccino.dark-mode select.select-petugas-filter {
        background-color: #241b16 !important;
        border-color: #382a22 !important;
        color: #faedcd !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23d4a373' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    }

    html.skin-cappuccino.dark-mode select.select-petugas-filter:hover,
    body.skin-cappuccino.dark-mode select.select-petugas-filter:hover {
        border-color: #d4a373 !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-reset,
    body.skin-cappuccino.dark-mode .btn-filter-reset,
    .skin-cappuccino.dark-mode .btn-filter-reset {
        background: #241b16 !important;
        border-color: #382a22 !important;
        color: #d4a373 !important;
    }

    html.skin-cappuccino.dark-mode .btn-filter-reset:hover,
    body.skin-cappuccino.dark-mode .btn-filter-reset:hover {
        background: #2f221c !important;
        color: #ffffff !important;
        border-color: #d4a373 !important;
    }

    /* --- EVERFOREST --- */
    html.skin-everforest.dark-mode .status-filter-toolbar,
    body.skin-everforest.dark-mode .status-filter-toolbar,
    .skin-everforest.dark-mode .status-filter-toolbar {
        background: #171d1b !important;
        border-color: #2d3a34 !important;
    }

    html.skin-everforest.dark-mode .filter-label,
    body.skin-everforest.dark-mode .filter-label {
        color: #a7c080 !important;
    }

    html.skin-everforest.dark-mode .filter-row-divider,
    body.skin-everforest.dark-mode .filter-row-divider {
        background: rgba(167, 192, 128, 0.15) !important;
    }

    html.skin-everforest.dark-mode .btn-filter-pill[data-status="ALL"],
    body.skin-everforest.dark-mode .btn-filter-pill[data-status="ALL"] {
        background: #1e2522;
        border-color: #2d3a34;
        color: #d3c6aa;
    }

    html.skin-everforest.dark-mode .btn-filter-pill[data-status="ALL"].active,
    body.skin-everforest.dark-mode .btn-filter-pill[data-status="ALL"].active,
    html.skin-everforest.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active,
    body.skin-everforest.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active {
        background: #a7c080 !important;
        border-color: #83c092 !important;
        color: #1e2326 !important;
        box-shadow: 0 2px 8px rgba(167, 192, 128, 0.4) !important;
    }

    html.skin-everforest.dark-mode select.select-petugas-filter,
    body.skin-everforest.dark-mode select.select-petugas-filter {
        background-color: #1e2522 !important;
        border-color: #2d3a34 !important;
        color: #d3c6aa !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23a7c080' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    }

    html.skin-everforest.dark-mode .btn-filter-reset,
    body.skin-everforest.dark-mode .btn-filter-reset {
        background: #1e2522 !important;
        border-color: #2d3a34 !important;
        color: #a7c080 !important;
    }

    /* --- TOKYO --- */
    html.skin-tokyo.dark-mode .status-filter-toolbar,
    body.skin-tokyo.dark-mode .status-filter-toolbar,
    .skin-tokyo.dark-mode .status-filter-toolbar {
        background: #16161e !important;
        border-color: #292e42 !important;
    }

    html.skin-tokyo.dark-mode .filter-label,
    body.skin-tokyo.dark-mode .filter-label {
        color: #7aa2f7 !important;
    }

    html.skin-tokyo.dark-mode .filter-row-divider,
    body.skin-tokyo.dark-mode .filter-row-divider {
        background: rgba(122, 162, 247, 0.15) !important;
    }

    html.skin-tokyo.dark-mode .btn-filter-pill[data-status="ALL"],
    body.skin-tokyo.dark-mode .btn-filter-pill[data-status="ALL"] {
        background: #1a1b26;
        border-color: #292e42;
        color: #c0caf5;
    }

    html.skin-tokyo.dark-mode .btn-filter-pill[data-status="ALL"].active,
    body.skin-tokyo.dark-mode .btn-filter-pill[data-status="ALL"].active,
    html.skin-tokyo.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active,
    body.skin-tokyo.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active {
        background: #7aa2f7 !important;
        border-color: #bb9af7 !important;
        color: #13141f !important;
        box-shadow: 0 2px 8px rgba(122, 162, 247, 0.4) !important;
    }

    html.skin-tokyo.dark-mode select.select-petugas-filter,
    body.skin-tokyo.dark-mode select.select-petugas-filter {
        background-color: #1a1b26 !important;
        border-color: #292e42 !important;
        color: #c0caf5 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237aa2f7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    }

    html.skin-tokyo.dark-mode .btn-filter-reset,
    body.skin-tokyo.dark-mode .btn-filter-reset {
        background: #1a1b26 !important;
        border-color: #292e42 !important;
        color: #7aa2f7 !important;
    }

    /* --- PB --- */
    html.skin-pb.dark-mode .status-filter-toolbar,
    body.skin-pb.dark-mode .status-filter-toolbar,
    .skin-pb.dark-mode .status-filter-toolbar {
        background: #090e16 !important;
        border-color: rgba(0, 210, 255, 0.3) !important;
    }

    html.skin-pb.dark-mode .filter-label,
    body.skin-pb.dark-mode .filter-label {
        color: #00d2ff !important;
    }

    html.skin-pb.dark-mode .filter-row-divider,
    body.skin-pb.dark-mode .filter-row-divider {
        background: rgba(0, 210, 255, 0.2) !important;
    }

    html.skin-pb.dark-mode .btn-filter-pill[data-status="ALL"],
    body.skin-pb.dark-mode .btn-filter-pill[data-status="ALL"] {
        background: #0d141e;
        border-color: rgba(0, 210, 255, 0.3);
        color: #e2f1f8;
    }

    html.skin-pb.dark-mode .btn-filter-pill[data-status="ALL"].active,
    body.skin-pb.dark-mode .btn-filter-pill[data-status="ALL"].active,
    html.skin-pb.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active,
    body.skin-pb.dark-mode .btn-filter-pill-prio[data-priority="ALL"].active {
        background: #00d2ff !important;
        border-color: #00e5ff !important;
        color: #090e16 !important;
        box-shadow: 0 2px 8px rgba(0, 210, 255, 0.4) !important;
    }

    html.skin-pb.dark-mode select.select-petugas-filter,
    body.skin-pb.dark-mode select.select-petugas-filter {
        background-color: #0d141e !important;
        border-color: rgba(0, 210, 255, 0.3) !important;
        color: #e2f1f8 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2300d2ff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    }

    html.skin-pb.dark-mode .btn-filter-reset,
    body.skin-pb.dark-mode .btn-filter-reset {
        background: #0d141e !important;
        border-color: rgba(0, 210, 255, 0.3) !important;
        color: #00d2ff !important;
    }

    .dark-mode .pb-legend-title {
        color: #94a3b8;
    }

    .dark-mode .pb-emergency {
        background: linear-gradient(135deg, #7f1d1d 0%, #450a0a 100%);
        border: 1.5px solid #ef4444;
        box-shadow: 0 0 8px rgba(239, 68, 68, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .dark-mode .pb-emergency .pb-svg-icon {
        color: #ffffff;
        filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.8)) drop-shadow(0 0 6px rgba(239, 68, 68, 0.95));
    }

    .dark-mode .pb-urgent {
        background: linear-gradient(135deg, #9a3412 0%, #431407 100%);
        border: 1.5px solid #f97316;
        box-shadow: 0 0 8px rgba(249, 115, 22, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .dark-mode .pb-urgent .pb-svg-icon {
        color: #ffffff;
        filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.8)) drop-shadow(0 0 6px rgba(249, 115, 22, 0.95));
    }

    .dark-mode .pb-high {
        background: linear-gradient(135deg, #854d0e 0%, #422006 100%);
        border: 1.5px solid #eab308;
        box-shadow: 0 0 8px rgba(234, 179, 8, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .dark-mode .pb-high .pb-svg-icon {
        color: #fef08a;
        filter: drop-shadow(0 0 3px rgba(253, 224, 71, 0.95));
    }

    .dark-mode .pb-medium {
        background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
        border: 1.5px solid #94a3b8;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .dark-mode .pb-medium .pb-svg-icon {
        color: #ffffff;
        filter: drop-shadow(0 0 3px rgba(255, 255, 255, 0.8));
    }

    .dark-mode .pb-low {
        background: linear-gradient(135deg, #0e7490 0%, #083344 100%);
        border: 1.5px solid #06b6d4;
        box-shadow: 0 0 8px rgba(6, 182, 212, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .dark-mode .pb-low .pb-svg-icon {
        color: #67e8f9;
        filter: drop-shadow(0 0 4px rgba(103, 232, 249, 0.95));
    }

    .dark-mode .pb-none {
        background: #1e293b;
        color: #64748b;
        border: 1.5px dashed #334155;
    }

    /* ========================================================
       MODAL UBAH PRIORITAS STYLES
       ======================================================== */
    .pb-priority-clickable {
        display: inline-block;
        cursor: pointer;
        transition: transform 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pb-priority-clickable:hover {
        transform: scale(1.1);
    }

    /* Modal Dialog & Content Base (LIGHT MODE) */
    #modalUbahPrioritas .modal-dialog {
        max-width: 480px;
        margin: 45px auto;
    }

    #modalUbahPrioritas .modal-content {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #1e293b;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.18), 0 0 1px 1px rgba(0, 0, 0, 0.04);
        transition: background-color 0.25s ease, border-color 0.25s ease;
    }

    /* Modal Header */
    #modalUbahPrioritas .modal-header {
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
    }

    #modalUbahPrioritas .modal-header:before,
    #modalUbahPrioritas .modal-header:after {
        display: none !important;
    }

    #modalUbahPrioritas .modal-title {
        font-size: 15.5px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #modalUbahPrioritas .prio-header-flag {
        font-size: 20px;
        color: #f59e0b;
        vertical-align: middle;
    }

    #modalUbahPrioritas .close {
        color: #94a3b8;
        opacity: 0.8;
        font-size: 24px;
        font-weight: 300;
        line-height: 1;
        padding: 0;
        margin: 0 !important;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        outline: none;
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        float: none !important;
    }

    #modalUbahPrioritas .close:hover {
        color: #0f172a;
        background: #f1f5f9;
        opacity: 1;
        transform: none;
    }

    /* Modal Body */
    #modalUbahPrioritas .modal-body {
        padding: 18px 22px;
        background: #ffffff;
    }

    /* Info Singkat Tiket */
    .prio-info-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 16px;
        transition: background-color 0.25s ease, border-color 0.25s ease;
    }

    .prio-info-nama {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }

    .prio-info-kendala {
        font-size: 12px;
        color: #64748b;
        margin-top: 3px;
        line-height: 1.45;
        word-break: break-word;
    }

    .prio-section-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 10px;
        display: block;
    }

    /* Opsi Pilihan Prioritas */
    .prio-options-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .prio-card-option {
        display: block;
        margin: 0;
        cursor: pointer;
        user-select: none;
    }

    .prio-card-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
        width: 1px;
        height: 1px;
    }

    .prio-card-content {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .prio-card-option:hover .prio-card-content {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .prio-card-badge {
        flex-shrink: 0;
        width: 38px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .prio-card-text {
        flex-grow: 1;
    }

    .prio-card-text .prio-name {
        font-size: 13px;
        font-weight: 700;
        line-height: 1.25;
    }

    .prio-name-emergency {
        color: #dc2626;
    }

    .prio-name-urgent {
        color: #ea580c;
    }

    .prio-name-high {
        color: #ca8a04;
    }

    .prio-name-medium {
        color: #475569;
    }

    .prio-name-low {
        color: #0284c7;
    }

    .prio-name-none {
        color: #64748b;
    }

    .prio-card-text .prio-desc {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    .prio-check-icon {
        flex-shrink: 0;
        opacity: 0;
        transform: scale(0.65);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .prio-card-option input[type="radio"]:checked+.prio-card-content .prio-check-icon {
        opacity: 1;
        transform: scale(1);
    }

    /* Selected state colors per priority (LIGHT MODE) */
    .prio-card-option input[value="EMERGENCY"]:checked+.prio-card-content,
    .prio-card-option input[value="EMERGANCY"]:checked+.prio-card-content {
        border-color: #ef4444;
        background: #fef2f2;
        box-shadow: 0 0 0 1px #ef4444, 0 3px 10px rgba(239, 68, 68, 0.16);
    }

    .prio-card-option input[value="EMERGENCY"]:checked+.prio-card-content .prio-check-icon,
    .prio-card-option input[value="EMERGANCY"]:checked+.prio-card-content .prio-check-icon {
        color: #ef4444;
    }

    .prio-card-option input[value="URGENT"]:checked+.prio-card-content {
        border-color: #f97316;
        background: #fff7ed;
        box-shadow: 0 0 0 1px #f97316, 0 3px 10px rgba(249, 115, 22, 0.16);
    }

    .prio-card-option input[value="URGENT"]:checked+.prio-card-content .prio-check-icon {
        color: #f97316;
    }

    .prio-card-option input[value="HIGH PRIORITY"]:checked+.prio-card-content {
        border-color: #eab308;
        background: #fefce8;
        box-shadow: 0 0 0 1px #eab308, 0 3px 10px rgba(234, 179, 8, 0.16);
    }

    .prio-card-option input[value="HIGH PRIORITY"]:checked+.prio-card-content .prio-check-icon {
        color: #ca8a04;
    }

    .prio-card-option input[value="MEDIUM PRIORITY"]:checked+.prio-card-content {
        border-color: #64748b;
        background: #f1f5f9;
        box-shadow: 0 0 0 1px #64748b, 0 3px 10px rgba(100, 116, 139, 0.16);
    }

    .prio-card-option input[value="MEDIUM PRIORITY"]:checked+.prio-card-content .prio-check-icon {
        color: #64748b;
    }

    .prio-card-option input[value="LOW PRIORITY"]:checked+.prio-card-content {
        border-color: #0284c7;
        background: #f0f9ff;
        box-shadow: 0 0 0 1px #0284c7, 0 3px 10px rgba(2, 132, 199, 0.16);
    }

    .prio-card-option input[value="LOW PRIORITY"]:checked+.prio-card-content .prio-check-icon {
        color: #0284c7;
    }

    .prio-card-option input[value=""]:checked+.prio-card-content {
        border-color: #94a3b8;
        background: #f8fafc;
        box-shadow: 0 0 0 1px #94a3b8, 0 3px 10px rgba(148, 163, 184, 0.16);
    }

    .prio-card-option input[value=""]:checked+.prio-card-content .prio-check-icon {
        color: #94a3b8;
    }

    /* Modal Footer */
    #modalUbahPrioritas .modal-footer {
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        padding: 14px 22px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .btn-prio-batal {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        outline: none;
    }

    .btn-prio-batal:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .btn-prio-simpan {
        background: #2563eb;
        border: none;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.28);
        transition: all 0.15s ease;
        outline: none;
    }

    .btn-prio-simpan:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        transform: translateY(-1px);
    }

    /* ========================================================
       DARK / NIGHT MODE MODAL OVERRIDES
       ======================================================== */
    .dark-mode #modalUbahPrioritas .modal-content {
        background: #1e293b;
        color: #f8fafc;
        border: 1px solid #334155;
        box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.7), 0 0 1px 1px rgba(255, 255, 255, 0.06);
    }

    .dark-mode #modalUbahPrioritas .modal-header {
        background: #0f172a !important;
        border-bottom: 1px solid #334155 !important;
    }

    .dark-mode #modalUbahPrioritas .modal-title {
        color: #f8fafc;
    }

    .dark-mode #modalUbahPrioritas .close {
        color: #94a3b8;
    }

    .dark-mode #modalUbahPrioritas .close:hover {
        color: #ffffff;
        background: #334155;
    }

    .dark-mode #modalUbahPrioritas .modal-body {
        background: #1e293b !important;
    }

    .dark-mode #modalUbahPrioritas .prio-info-card {
        background: #0f172a;
        border-color: #334155;
    }

    .dark-mode #modalUbahPrioritas .prio-info-nama {
        color: #f8fafc;
    }

    .dark-mode #modalUbahPrioritas .prio-info-kendala {
        color: #94a3b8;
    }

    .dark-mode #modalUbahPrioritas .prio-section-label {
        color: #94a3b8;
    }

    .dark-mode #modalUbahPrioritas .prio-card-content {
        background: #0f172a;
        border-color: #334155;
    }

    .dark-mode #modalUbahPrioritas .prio-card-option:hover .prio-card-content {
        background: #1e293b;
        border-color: #475569;
    }

    .dark-mode .prio-name-emergency {
        color: #f87171 !important;
    }

    .dark-mode .prio-name-urgent {
        color: #fb923c !important;
    }

    .dark-mode .prio-name-high {
        color: #facc15 !important;
    }

    .dark-mode .prio-name-medium {
        color: #cbd5e1 !important;
    }

    .dark-mode .prio-name-low {
        color: #38bdf8 !important;
    }

    .dark-mode .prio-name-none {
        color: #94a3b8 !important;
    }

    .dark-mode .prio-card-text .prio-desc {
        color: #94a3b8;
    }

    /* Selected state colors per priority (DARK MODE) */
    .dark-mode .prio-card-option input[value="EMERGENCY"]:checked+.prio-card-content,
    .dark-mode .prio-card-option input[value="EMERGANCY"]:checked+.prio-card-content {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.16);
        box-shadow: 0 0 0 1px #ef4444, 0 0 14px rgba(239, 68, 68, 0.28);
    }

    .dark-mode .prio-card-option input[value="EMERGENCY"]:checked+.prio-card-content .prio-check-icon,
    .dark-mode .prio-card-option input[value="EMERGANCY"]:checked+.prio-card-content .prio-check-icon {
        color: #f87171;
    }

    .dark-mode .prio-card-option input[value="URGENT"]:checked+.prio-card-content {
        border-color: #f97316;
        background: rgba(249, 115, 22, 0.16);
        box-shadow: 0 0 0 1px #f97316, 0 0 14px rgba(249, 115, 22, 0.28);
    }

    .dark-mode .prio-card-option input[value="URGENT"]:checked+.prio-card-content .prio-check-icon {
        color: #fb923c;
    }

    .dark-mode .prio-card-option input[value="HIGH PRIORITY"]:checked+.prio-card-content {
        border-color: #eab308;
        background: rgba(234, 179, 8, 0.16);
        box-shadow: 0 0 0 1px #eab308, 0 0 14px rgba(234, 179, 8, 0.28);
    }

    .dark-mode .prio-card-option input[value="HIGH PRIORITY"]:checked+.prio-card-content .prio-check-icon {
        color: #facc15;
    }

    .dark-mode .prio-card-option input[value="MEDIUM PRIORITY"]:checked+.prio-card-content {
        border-color: #94a3b8;
        background: rgba(148, 163, 184, 0.16);
        box-shadow: 0 0 0 1px #94a3b8, 0 0 14px rgba(148, 163, 184, 0.28);
    }

    .dark-mode .prio-card-option input[value="MEDIUM PRIORITY"]:checked+.prio-card-content .prio-check-icon {
        color: #94a3b8;
    }

    .dark-mode .prio-card-option input[value="LOW PRIORITY"]:checked+.prio-card-content {
        border-color: #38bdf8;
        background: rgba(56, 189, 248, 0.16);
        box-shadow: 0 0 0 1px #38bdf8, 0 0 14px rgba(56, 189, 248, 0.28);
    }

    .dark-mode .prio-card-option input[value="LOW PRIORITY"]:checked+.prio-card-content .prio-check-icon {
        color: #38bdf8;
    }

    .dark-mode .prio-card-option input[value=""]:checked+.prio-card-content {
        border-color: #64748b;
        background: rgba(100, 116, 139, 0.16);
        box-shadow: 0 0 0 1px #64748b, 0 0 14px rgba(100, 116, 139, 0.28);
    }

    .dark-mode .prio-card-option input[value=""]:checked+.prio-card-content .prio-check-icon {
        color: #94a3b8;
    }

    .dark-mode #modalUbahPrioritas .modal-footer {
        background: #0f172a !important;
        border-top: 1px solid #334155 !important;
    }

    .dark-mode .btn-prio-batal {
        background: #1e293b;
        border-color: #334155;
        color: #cbd5e1;
    }

    .dark-mode .btn-prio-batal:hover {
        background: #334155;
        color: #ffffff;
        border-color: #475569;
    }

    .dark-mode .btn-prio-simpan {
        background: #2563eb;
    }

    .dark-mode .btn-prio-simpan:hover {
        background: #1d4ed8;
    }
</style>

<!-- Basic Examples -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>DATA MAINTENANCE/TROUBLE/REQUEST IT TODAY</h2>
        </div>
        <div class="body">
            <!-- 🔘 MULTI-FILTER TOOLBAR (STATUS, PRIORITAS, PETUGAS IT - DUA BARIS RAPI) -->
            <!-- <div class="status-filter-toolbar"> -->
            <!-- Baris 1: Filter Status & Petugas IT + Reset -->
            <!-- <div class="filter-toolbar-row filter-row-status">
                    <div class="filter-group-wrapper">
                        <span class="filter-label">STATUS:</span>
                        <div class="status-filter-pills" id="statusFilterPills">
                            <button type="button" class="btn-filter-pill active" data-status="ALL">
                                <span class="pill-dot dot-all"></span>
                                <span>Semua</span>
                                <span class="pill-count" id="count-all">0</span>
                            </button>
                            <button type="button" class="btn-filter-pill" data-status="Open">
                                <span class="pill-dot dot-open"></span>
                                <span>Open</span>
                                <span class="pill-count" id="count-open">0</span>
                            </button>
                            <button type="button" class="btn-filter-pill" data-status="In Progress">
                                <span class="pill-dot dot-progress"></span>
                                <span>In Progress</span>
                                <span class="pill-count" id="count-progress">0</span>
                            </button>
                            <button type="button" class="btn-filter-pill" data-status="Complete">
                                <span class="pill-dot dot-complete"></span>
                                <span>Complete</span>
                                <span class="pill-count" id="count-complete">0</span>
                            </button>
                        </div>
                    </div>

                    <div class="petugas-filter-wrapper">
                        <span class="filter-label filter-label-petugas">PETUGAS:</span>
                        <select id="filterSelectPetugas" class="ms select-petugas-filter">
                            <option value="ALL">Semua Petugas</option>
                            <option value="UNASSIGNED">Belum Di-assign</option>
                            <?php
                            $list_petugas_all = [];
                            $q_petugas = mysqli_query($connect, "SELECT nama_petugas FROM tb_petugas ORDER BY nama_petugas ASC");
                            if ($q_petugas) {
                                while ($p = mysqli_fetch_assoc($q_petugas)) {
                                    $np = trim((string)$p['nama_petugas']);
                                    if (!empty($np) && !in_array($np, $list_petugas_all)) {
                                        $list_petugas_all[] = $np;
                                    }
                                }
                            }
                            natcasesort($list_petugas_all);
                            foreach ($list_petugas_all as $pet) {
                                echo '<option value="' . htmlspecialchars($pet) . '">' . htmlspecialchars($pet) . '</option>';
                            }
                            ?>
                        </select>
                        <button type="button" id="btnResetFilters" class="btn-filter-reset" title="Reset Semua Filter">
                            Reset
                        </button>
                    </div>
                </div> -->

            <!-- Pembatas Garis Horizontal Antar Baris -->
            <!-- <div class="filter-row-divider"></div> -->

            <!-- Baris 2: Filter Prioritas -->
            <!-- <div class="filter-toolbar-row filter-row-priority">
                    <div class="filter-group-wrapper">
                        <span class="filter-label">PRIORITAS:</span>
                        <div class="priority-filter-pills" id="priorityFilterPills">
                            <button type="button" class="btn-filter-pill-prio active" data-priority="ALL">
                                <span class="prio-dot dot-prio-all"></span>
                                <span>Semua</span>
                                <span class="pill-count" id="prio-count-all">0</span>
                            </button>
                            <button type="button" class="btn-filter-pill-prio" data-priority="EMERGENCY">
                                <span class="prio-dot dot-prio-emergency"></span>
                                <span>Emergency</span>
                                <span class="pill-count" id="prio-count-emergency">0</span>
                            </button>
                            <button type="button" class="btn-filter-pill-prio" data-priority="HIGH PRIORITY">
                                <span class="prio-dot dot-prio-high"></span>
                                <span>High</span>
                                <span class="pill-count" id="prio-count-high">0</span>
                            </button>
                            <button type="button" class="btn-filter-pill-prio" data-priority="MEDIUM PRIORITY">
                                <span class="prio-dot dot-prio-medium"></span>
                                <span>Medium</span>
                                <span class="pill-count" id="prio-count-medium">0</span>
                            </button>
                            <button type="button" class="btn-filter-pill-prio" data-priority="LOW PRIORITY">
                                <span class="prio-dot dot-prio-low"></span>
                                <span>Low</span>
                                <span class="pill-count" id="prio-count-low">0</span>
                            </button>
                        </div>
                    </div>
                </div> -->
            <!-- </div> -->

            <div class="table-responsive">
                <table id="table-today" class="table table-bordered table-striped table-hover js-basic-example no-paging dataTable" data-paging="false" data-order="[[0, &quot;asc&quot;]]">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Start date</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="text-align: center !important;">Status</th>
                            <th>NOTE</th>
                            <th>End date</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        while ($data = mysqli_fetch_array($tampil)) {
                            $no++;
                            $cek_status = $data['status'];
                            $cek_id = $data['id'];
                            $cekidx = $data['id'];
                            $petugas_raw = trim((string)($data['petugas'] ?? ''));
                            $petugas_filter_val = ($cek_status === 'Open' && strcasecmp($petugas_raw, 'Open') === 0) ? '' : $petugas_raw;
                            $row_priority = ($cek_status === 'Open') ? '' : normalizePriorityName($data['nama_prioritas'] ?? '');
                        ?>
                            <tr data-status="<?php echo htmlspecialchars((string)$cek_status); ?>" data-priority="<?php echo htmlspecialchars((string)$row_priority); ?>" data-petugas="<?php echo htmlspecialchars($petugas_filter_val); ?>">
                                <td align="center" style="font-weight: 600; color: #64748b;"><?php echo $no ?></td>
                                <td>
                                    <span style="font-weight: 600; color: #1e293b;"><?php echo date('d M Y', strtotime($data['tgllapor'])); ?></span>
                                    <br><small style="color: #64748b; font-size: 11px;">[<?php echo $data['jamlapor']; ?>]</small>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars((string)$data['nama']); ?></span>
                                    <br><span style="color: #64748b; font-size: 11.5px;">[<?php echo htmlspecialchars((string)$data['depart']); ?>]</span>
                                    <?php if (!empty($data['nohp'])) { ?>
                                        <br><span style="color: #0284c7; font-size: 11px; font-weight: 500;">📱 <a href="https://wa.me/<?php echo htmlspecialchars((string)$data['nohp']); ?>"><?php echo htmlspecialchars((string)$data['nohp']); ?></a></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars((string)$data['jnskendala']); ?><br>
                                    <a class="waves-effect m-b-15" role="button" data-toggle="collapse" href="#<?php echo $cekidx; ?>" aria-expanded="false" aria-controls="collapseExample" style="font-size: 12px; font-weight: 600;">Detail...</a>
                                    <div class="collapse" id="<?php echo $cekidx; ?>" style="margin-top: 6px; padding: 8px 12px; background: #f8fafc; border-radius: 6px; border-left: 3px solid #0284c7;">
                                        <small style="color: #475569; font-style: normal; display: block; line-height: 1.6;">
                                            <strong>Petugas IT:</strong> <?php echo htmlspecialchars(($cek_status === 'Open' && strcasecmp($petugas_raw, 'Open') === 0) ? 'Belum Di-assign' : ($petugas_raw ?: '-')); ?><br>
                                            <strong>Prioritas:</strong> <?php echo htmlspecialchars((string)($cek_status === 'Open' ? '-' : normalizePriorityName($data['nama_prioritas'] ?? '-'))); ?><br>
                                            <strong>Kategori:</strong> <?php echo htmlspecialchars((string)($data['jenis'] ?? '-')); ?><br>
                                            <strong>Jenis Kendala:</strong> <?php echo htmlspecialchars((string)($data['kendala'] ?? '-')); ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center" align="center" style="text-align: center !important;">
                                    <div style="margin-bottom: 4px;">
                                        <?php
                                        $st = $data['status'];
                                        if ($st == 'Complete') {
                                            echo "<span class='label bg-green' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>Complete</span>";
                                        } elseif ($st == 'In Progress') {
                                            echo "<span class='label bg-blue' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>In Progress</span>";
                                        } elseif ($st == 'Open') {
                                            echo "<span class='label bg-pink' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>Open</span>";
                                        } else {
                                            echo "<span class='label bg-grey' style='font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;'>" . htmlspecialchars((string)$st) . "</span>";
                                        }
                                        ?>
                                    </div>
                                    <?php if ($cek_status == 'In Progress') { ?>
                                        <div class="pb-priority-clickable btn-ubah-prioritas"
                                            data-id="<?php echo $data['id']; ?>"
                                            data-nama="<?php echo htmlspecialchars((string)($data['nama'] ?? '')); ?>"
                                            data-kendala="<?php echo htmlspecialchars((string)($data['jnskendala'] ?? '')); ?>"
                                            data-prioritas="<?php echo htmlspecialchars((string)normalizePriorityName($data['nama_prioritas'] ?? '')); ?>"
                                            title="Klik untuk ubah prioritas">
                                            <!-- <?php
                                                    $pbBadgeHtml = renderPbPriorityBadge($data['nama_prioritas'] ?? '');
                                                    if (!empty($pbBadgeHtml)) {
                                                        echo $pbBadgeHtml;
                                                    } else {
                                                        echo '<span class="pb-badge pb-none" style="font-size:10px; cursor:pointer;" title="Klik untuk atur prioritas">+ Prioritas</span>';
                                                    }
                                                    ?> -->
                                        </div>
                                    <?php } elseif ($cek_status == 'Complete') { ?>
                                        <!-- <div style="display: inline-block;">
                                            <?php echo renderPbPriorityBadge($data['nama_prioritas'] ?? ''); ?>
                                        </div> -->
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php
                                    if (empty($data['noteperbaikan']) || $data['noteperbaikan'] == '~') {
                                        echo "<span class='text-muted' style='color: #94a3b8;'>~</span>";
                                    } else {
                                        echo htmlspecialchars((string)$data['noteperbaikan']);
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($data['tglselesai']) && $data['tglselesai'] != '0000-00-00') {
                                        echo "<span style='font-weight: 600; color: #1e293b;'>" . date('d M Y', strtotime($data['tglselesai'])) . "</span><br><small style='color: #64748b; font-size: 11px;'>[" . $data['jamselesai'] . "]</small>";
                                    } else {
                                        echo "<span class='text-muted'>-</span>";
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <div class="action-btn-group">
                                        <?php
                                        $cek_id = $data['id'];

                                        // === GENERATE FEEDBACK URL ===
                                        $val_kendala = !empty($data['jnskendala']) ? urlencode($data['jnskendala']) : '';
                                        $val_depart = !empty($data['depart']) ? "&ea6710ff-c1a0-475b-a751-ca6aed483200=" . urlencode($data['depart']) : '';
                                        $feedback_url = "https://form.rsanwarmedika.com/forms/feedbackit?eec382ce-3874-42c2-9271-ab2f0838c0c8=" . $val_kendala . $val_depart;

                                        // === TOMBOL AKSI BERDASARKAN STATUS ===
                                        if ($cek_status == "Open") {
                                            echo "<a href='index.php?page=accept&kd=$cek_id' title='Accept Ticket'>
                                                    <button type='button' class='btn bg-green waves-effect'>
                                                        <i class='material-icons'>verified_user</i>
                                                    </button>
                                                  </a>";
                                        } elseif ($cek_status == "In Progress") {
                                            echo "<a href='index.php?page=solution&kd=$cek_id' title='Add Solution'>
                                                    <button type='button' class='btn bg-light-blue waves-effect'>
                                                        <i class='material-icons'>content_paste</i>
                                                    </button>
                                                  </a>";
                                        } elseif ($cek_status == "Complete") {
                                            // Tombol Edit Data
                                            echo "<a href='index.php?page=dataedit&kd=$cek_id' title='Edit Data'>
                                                    <button type='button' class='btn bg-orange waves-effect'>
                                                        <i class='material-icons'>edit</i>
                                                    </button>
                                                  </a>";
                                            // === TOMBOL GENERATE LINK FEEDBACK (Selalu muncul) ===
                                            echo "<a href='$feedback_url' target='_blank' title='Generate Feedback Link'>
                                                    <button type='button' class='btn bg-grey waves-effect'>
                                                        <i class='material-icons'>link</i>
                                                    </button>
                                                  </a>";

                                            // === 🟢 TOMBOL WHATSAPP VIA API (Hanya jika nohp ada DAN belum dikirim) ===
                                            if (!empty($data['nohp'])) {
                                                // Cek status is_sent
                                                $is_sent = !empty($data['is_sent']) && $data['is_sent'] == 1;

                                                if ($is_sent) {
                                                    // ✅ Tampilkan tombol "Sudah Terkirim" (disabled, abu-abu, icon centang)
                                                    echo "<button type='button' 
                                                            class='btn bg-grey waves-effect' 
                                                            title='Pesan WhatsApp sudah dikirim'
                                                            disabled
                                                            style='opacity: 0.65; cursor: not-allowed;'>
                                                            <i class='material-icons'>check</i>
                                                          </button>";
                                                } else {
                                                    // 🔘 Tampilkan tombol aktif untuk kirim WhatsApp
                                                    echo "<button type='button' 
                                                            class='btn bg-green waves-effect send-wa-api-btn' 
                                                            data-ticket-id='$cek_id' 
                                                            data-nama='" . htmlspecialchars((string)($data['nama'] ?? '')) . "'
                                                            data-nohp='" . htmlspecialchars((string)($data['nohp'] ?? '')) . "'
                                                            title='Kirim Notifikasi via WhatsApp API'>
                                                            <i class='material-icons'>chat</i>
                                                          </button>";
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 🎯 MODAL UBAH PRIORITAS TIKET -->
<div class="modal fade" id="modalUbahPrioritas" tabindex="-1" role="dialog" aria-labelledby="modalUbahPrioritasLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalUbahPrioritasLabel">
                    <i class="material-icons prio-header-flag">flag</i>
                    <span>Ubah Prioritas Tiket #<span id="modal-prio-ticket-id"></span></span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUbahPrioritas" action="javascript:void(0);" method="POST">
                <input type="hidden" name="ticket_id" id="modal-prio-input-id" value="">
                <div class="modal-body">
                    <!-- Info Singkat Tiket -->
                    <div class="prio-info-card">
                        <div class="prio-info-nama" id="modal-prio-nama">-</div>
                        <div class="prio-info-kendala" id="modal-prio-kendala">-</div>
                    </div>

                    <label class="prio-section-label">
                        Pilih Tingkat Prioritas:
                    </label>

                    <!-- Opsi Pilihan Prioritas Berupa Visual Tile -->
                    <div class="prio-options-list">
                        <!-- EMERGENCY -->
                        <label class="prio-card-option">
                            <input type="radio" name="prio_choice" value="EMERGENCY">
                            <div class="prio-card-content">
                                <div class="prio-card-badge">
                                    <span class="pb-badge pb-emergency" style="cursor: default;">
                                        <svg class="pb-svg-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                            <path d="M12 2a8 8 0 00-8 8c0 2.5 1.1 4.7 2.8 6.2.2.2.3.4.3.7V19a1 1 0 001 1h7.8a1 1 0 001-1v-2.1c0-.3.1-.5.3-.7C18.9 14.7 20 12.5 20 10a8 8 0 00-8-8zm-3.5 10a1.75 1.75 0 110-3.5 1.75 1.75 0 010 3.5zm7 0a1.75 1.75 0 110-3.5 1.75 1.75 0 010 3.5zm-5 4.5a.75.75 0 010-1.5h3a.75.75 0 010 1.5h-3zm-1.5 2.5v-1h6v1H9z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="prio-card-text">
                                    <div class="prio-name prio-name-emergency">EMERGENCY</div>
                                    <div class="prio-desc">Prioritas paling kritis & darurat</div>
                                </div>
                                <div class="prio-check-icon"><i class="material-icons">check_circle</i></div>
                            </div>
                        </label>

                        <!-- HIGH PRIORITY -->
                        <label class="prio-card-option">
                            <input type="radio" name="prio_choice" value="HIGH PRIORITY">
                            <div class="prio-card-content">
                                <div class="prio-card-badge">
                                    <span class="pb-badge pb-high" style="cursor: default;">
                                        <svg class="pb-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="miter">
                                            <path d="M4.5 15.5L12 8L19.5 15.5" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="prio-card-text">
                                    <div class="prio-name prio-name-high">HIGH PRIORITY</div>
                                    <div class="prio-desc">Prioritas tinggi / segera</div>
                                </div>
                                <div class="prio-check-icon"><i class="material-icons">check_circle</i></div>
                            </div>
                        </label>

                        <!-- MEDIUM PRIORITY -->
                        <label class="prio-card-option">
                            <input type="radio" name="prio_choice" value="MEDIUM PRIORITY">
                            <div class="prio-card-content">
                                <div class="prio-card-badge">
                                    <span class="pb-badge pb-medium" style="cursor: default;">
                                        <svg class="pb-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="4.8" stroke-linecap="round">
                                            <path d="M4 12h16" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="prio-card-text">
                                    <div class="prio-name prio-name-medium">MEDIUM PRIORITY</div>
                                    <div class="prio-desc">Prioritas normal / standar</div>
                                </div>
                                <div class="prio-check-icon"><i class="material-icons">check_circle</i></div>
                            </div>
                        </label>

                        <!-- LOW PRIORITY -->
                        <label class="prio-card-option">
                            <input type="radio" name="prio_choice" value="LOW PRIORITY">
                            <div class="prio-card-content">
                                <div class="prio-card-badge">
                                    <span class="pb-badge pb-low" style="cursor: default;">
                                        <svg class="pb-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="miter">
                                            <path d="M4.5 8.5L12 16L19.5 8.5" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="prio-card-text">
                                    <div class="prio-name prio-name-low">LOW PRIORITY</div>
                                    <div class="prio-desc">Prioritas rendah / santai</div>
                                </div>
                                <div class="prio-check-icon"><i class="material-icons">check_circle</i></div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-prio-batal waves-effect" data-dismiss="modal">
                        <i class="material-icons" style="font-size: 16px; vertical-align: middle;">close</i>
                        <span>Batal</span>
                    </button>
                    <button type="submit" class="btn btn-prio-simpan waves-effect" id="btn-submit-prio">
                        <i class="material-icons" style="font-size: 16px; vertical-align: middle;">save</i>
                        <span>Simpan Prioritas</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- SweetAlert2 CDN untuk notifikasi profesional -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript: Handle Kirim WhatsApp via AJAX + Preview Text + Fallback Copy -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delegated event listener untuk tombol dinamis di tabel
        document.querySelector('.table-responsive')?.addEventListener('click', function(e) {
            const btn = e.target.closest('.send-wa-api-btn');
            if (!btn) return;

            e.preventDefault();

            const ticketId = btn.dataset.ticketId;
            const namaPelapor = btn.dataset.nama;
            const nohp = btn.dataset.nohp;

            // Konfirmasi sebelum kirim via SweetAlert2
            const isDark = document.documentElement.classList.contains('dark-mode') ||
                document.body.classList.contains('dark-mode') ||
                localStorage.getItem('simit_theme') === 'dark';

            let currentSkin = localStorage.getItem('simit_skin') || 'default';
            if (currentSkin === 'pointblank') currentSkin = 'pb';

            ['cappuccino', 'everforest', 'tokyo', 'pb'].forEach(function(s) {
                if (document.documentElement.classList.contains('skin-' + s) || document.body.classList.contains('skin-' + s)) {
                    currentSkin = s;
                }
            });

            const skinPopupBgs = {
                default: '#1e293b',
                cappuccino: '#231c17',
                everforest: '#1e2522',
                tokyo: '#1a1b26',
                pb: '#0d141e'
            };
            const currentPopupBg = isDark ? (skinPopupBgs[currentSkin] || skinPopupBgs.default) : '#ffffff';

            Swal.fire({
                title: '📱 Kirim WhatsApp?',
                html: `Kirim notifikasi penyelesaian ke <b>${namaPelapor}</b>?<br>
                   <small>Nomor: ${nohp}<br>Pesan akan berisi link feedback profesional.</small>`,
                icon: 'question',
                showCancelButton: true,
                background: currentPopupBg,
                confirmButtonText: '✅ Kirim Sekarang',
                cancelButtonText: '<svg style="width:14px;height:14px;vertical-align:middle;margin-right:4px;display:inline-block;" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>Batal',
                confirmButtonColor: '#25D366',
                cancelButtonColor: '#f44336',
                reverseButtons: true,
                backdrop: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading state pada tombol
                    const originalIcon = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<svg style="width:18px;height:18px;animation:spin 0.8s linear infinite;vertical-align:middle;display:inline-block;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,0.3)" stroke-width="3"></circle><path d="M12 2a10 10 0 0 1 10 10" stroke="#fff" stroke-width="3" stroke-linecap="round"></path></svg>';

                    // Siapkan data untuk AJAX
                    const formData = new FormData();
                    formData.append('ticket_id', ticketId);
                    formData.append('_t', Date.now()); // Cache-busting

                    // Kirim request ke handler
                    fetch('send_wa_handler.php', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(async response => {
                            // ✅ Baca response sebagai text dulu untuk handle malformed JSON
                            const text = await response.text();

                            if (!text || text.trim() === '') {
                                throw new Error('Empty response from server');
                            }

                            // ✅ Handle kemungkinan JSON ganda (}{)
                            let cleanText = text.trim();
                            if (cleanText.includes('}{')) {
                                const parts = cleanText.split('}{');
                                cleanText = '{' + parts[parts.length - 1];
                            }
                            return JSON.parse(cleanText);
                        })
                        .then(data => {
                            if (data && data.success) {
                                // ✅ Sukses via API
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Terkirim! 🎉',
                                    text: data.message || 'Pesan WhatsApp berhasil dikirim',
                                    timer: 2500,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                    backdrop: true
                                });
                                // Ubah tombol jadi centang + nonaktif
                                btn.innerHTML = '<i class="material-icons" style="font-size:18px;color:#fff;">check</i>';
                                btn.classList.remove('bg-green');
                                btn.classList.add('bg-grey');
                                btn.title = 'Pesan terkirim ✓';
                                btn.disabled = true;
                            } else {
                                // ❌ Gagal via API - TAWARKAN PREVIEW + FALLBACK COPY
                                const messageText = data.message_text || '';
                                const targetNohp = data.nohp || nohp;

                                // Deteksi Dark Mode & Skin saat ini agar tampilan modal mengikuti tema & skin
                                const isDark = document.documentElement.classList.contains('dark-mode') ||
                                    document.body.classList.contains('dark-mode') ||
                                    localStorage.getItem('simit_theme') === 'dark';

                                let currentSkin = localStorage.getItem('simit_skin') || 'default';
                                if (currentSkin === 'pointblank') currentSkin = 'pb';

                                ['cappuccino', 'everforest', 'tokyo', 'pb'].forEach(function(s) {
                                    if (document.documentElement.classList.contains('skin-' + s) || document.body.classList.contains('skin-' + s)) {
                                        currentSkin = s;
                                    }
                                });

                                // Palet warna per tema & skin
                                const skinPalettes = {
                                    default: {
                                        dark: {
                                            popupBg: '#1e293b',
                                            previewBg: '#0f172a',
                                            previewBorder: '#334155',
                                            previewText: '#f1f5f9',
                                            fallbackBg: 'rgba(15, 23, 42, 0.75)',
                                            fallbackBorder: '#334155',
                                            fallbackAccent: '#38bdf8',
                                            label: '#cbd5e1',
                                            sub: '#94a3b8',
                                            nohp: '#38bdf8'
                                        },
                                        light: {
                                            popupBg: '#ffffff',
                                            previewBg: '#f8fafc',
                                            previewBorder: '#cbd5e1',
                                            previewText: '#1e293b',
                                            fallbackBg: '#f8fafc',
                                            fallbackBorder: '#e2e8f0',
                                            fallbackAccent: '#0284c7',
                                            label: '#475569',
                                            sub: '#64748b',
                                            nohp: '#0284c7'
                                        }
                                    },
                                    cappuccino: {
                                        dark: {
                                            popupBg: '#231c17',
                                            previewBg: '#1b1411',
                                            previewBorder: '#382a22',
                                            previewText: '#faedcd',
                                            fallbackBg: 'rgba(27, 20, 17, 0.85)',
                                            fallbackBorder: '#382a22',
                                            fallbackAccent: '#d4a373',
                                            label: '#d4a373',
                                            sub: '#d4a373',
                                            nohp: '#e9c46a'
                                        },
                                        light: {
                                            popupBg: '#fffdfa',
                                            previewBg: '#fdfaf6',
                                            previewBorder: '#ebdcd0',
                                            previewText: '#4a3427',
                                            fallbackBg: '#fbf5ee',
                                            fallbackBorder: '#ebdcd0',
                                            fallbackAccent: '#9c6742',
                                            label: '#6f4e37',
                                            sub: '#8c674b',
                                            nohp: '#6f4e37'
                                        }
                                    },
                                    everforest: {
                                        dark: {
                                            popupBg: '#1e2522',
                                            previewBg: '#171d1b',
                                            previewBorder: '#2d3a34',
                                            previewText: '#d3c6aa',
                                            fallbackBg: 'rgba(23, 29, 27, 0.85)',
                                            fallbackBorder: '#2d3a34',
                                            fallbackAccent: '#a7c080',
                                            label: '#a7c080',
                                            sub: '#9da993',
                                            nohp: '#a7c080'
                                        },
                                        light: {
                                            popupBg: '#fdfaf4',
                                            previewBg: '#f4edd9',
                                            previewBorder: '#d3c6aa',
                                            previewText: '#2d353b',
                                            fallbackBg: '#f7efe0',
                                            fallbackBorder: '#e2d9c6',
                                            fallbackAccent: '#4a7a40',
                                            label: '#4a7a40',
                                            sub: '#5c6a72',
                                            nohp: '#4a7a40'
                                        }
                                    },
                                    tokyo: {
                                        dark: {
                                            popupBg: '#1a1b26',
                                            previewBg: '#16161e',
                                            previewBorder: '#292e42',
                                            previewText: '#c0caf5',
                                            fallbackBg: 'rgba(22, 22, 30, 0.85)',
                                            fallbackBorder: '#414868',
                                            fallbackAccent: '#7aa2f7',
                                            label: '#7aa2f7',
                                            sub: '#a9b1d6',
                                            nohp: '#7aa2f7'
                                        },
                                        light: {
                                            popupBg: '#ffffff',
                                            previewBg: '#edf0f7',
                                            previewBorder: '#cfd5e5',
                                            previewText: '#24283b',
                                            fallbackBg: '#f0f2f9',
                                            fallbackBorder: '#e1e4ed',
                                            fallbackAccent: '#2e7de9',
                                            label: '#2e7de9',
                                            sub: '#617292',
                                            nohp: '#2e7de9'
                                        }
                                    },
                                    pb: {
                                        dark: {
                                            popupBg: '#0d141e',
                                            previewBg: '#090e16',
                                            previewBorder: 'rgba(0, 210, 255, 0.3)',
                                            previewText: '#e2f1f8',
                                            fallbackBg: 'rgba(9, 14, 22, 0.85)',
                                            fallbackBorder: 'rgba(0, 210, 255, 0.3)',
                                            fallbackAccent: '#00d2ff',
                                            label: '#00d2ff',
                                            sub: '#88a4bc',
                                            nohp: '#00d2ff'
                                        },
                                        light: {
                                            popupBg: '#0d141e',
                                            previewBg: '#090e16',
                                            previewBorder: 'rgba(0, 210, 255, 0.3)',
                                            previewText: '#e2f1f8',
                                            fallbackBg: 'rgba(9, 14, 22, 0.85)',
                                            fallbackBorder: 'rgba(0, 210, 255, 0.3)',
                                            fallbackAccent: '#00d2ff',
                                            label: '#00d2ff',
                                            sub: '#88a4bc',
                                            nohp: '#00d2ff'
                                        }
                                    }
                                };

                                const pal = (skinPalettes[currentSkin] || skinPalettes.default)[isDark ? 'dark' : 'light'];

                                // Build error content dengan tema & skin adaptif
                                let errorContent = `<b>${data?.message || 'Gagal mengirim via API'}</b>`;
                                if (data?.data?.error) {
                                    errorContent += `<br><small style="color:${pal.sub};word-break:break-all;">${data.data.error}</small>`;
                                }

                                // Jika ada message_text, tampilkan preview + tombol copy
                                if (messageText) {
                                    // Escape HTML untuk aman ditampilkan di preview
                                    const escapedText = messageText
                                        .replace(/&/g, '&amp;')
                                        .replace(/</g, '&lt;')
                                        .replace(/>/g, '&gt;')
                                        .replace(/\n/g, '<br>');

                                    errorContent += `
                                <div style="margin-top:15px;text-align:left;">
                                    <!-- Preview Box (Scrollable) -->
                                    <div style="margin-bottom:10px">
                                        <small style="display:block;margin-bottom:5px;color:${pal.label};font-weight:600">
                                            📝 Preview Pesan:
                                        </small>
                                        <div style="
                                            max-height:200px;
                                            overflow-y:auto;
                                            background:${pal.previewBg};
                                            border:1px solid ${pal.previewBorder};
                                            border-radius:6px;
                                            padding:10px;
                                            font-size:12px;
                                            line-height:1.5;
                                            white-space:pre-wrap;
                                            font-family:monospace;
                                            color:${pal.previewText};
                                        ">${escapedText}</div>
                                    </div>
                                    
                                    <!-- Copy Button Section -->
                                    <div style="padding:12px;background:${pal.fallbackBg};border:1px solid ${pal.fallbackBorder};border-left:4px solid ${pal.fallbackAccent};border-radius:6px">
                                        <small style="display:block;margin-bottom:8px;color:${pal.label};font-weight:600">
                                            📋 Fallback Manual:
                                        </small>
                                        <button id="swal-copy-btn" class="btn btn-primary" 
                                                style="width:100%;background:#25D366;border-color:#25D366;color:#fff;font-weight:600">
                                            <i class="material-icons" style="font-size:16px;vertical-align:middle;margin-right:4px;color:#fff;">content_copy</i>
                                            Copy Pesan untuk Kirim Manual
                                        </button>
                                        <small style="display:block;margin-top:8px;color:${pal.sub};font-size:11px;text-align:center;">
                                            Klik tombol di atas, lalu paste di WhatsApp Web/App ke nomor:<br>
                                            <b style="color:${pal.nohp};font-size:12.5px;">${targetNohp}</b>
                                        </small>
                                    </div>
                                </div>
                            `;

                                    // Store message text for clipboard access
                                    document.body.dataset.waMessage = messageText;
                                    document.body.dataset.waNohp = targetNohp;
                                }

                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal Mengirim',
                                    html: errorContent,
                                    background: pal.popupBg,
                                    confirmButtonText: '<svg style="width:16px;height:16px;vertical-align:middle;margin-right:6px;display:inline-block;" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>Tutup',
                                    confirmButtonColor: '#f44336',
                                    backdrop: true,
                                    width: '500px', // Lebar lebih besar untuk preview
                                    didOpen: () => {
                                        // Attach click handler untuk tombol copy
                                        const copyBtn = document.getElementById('swal-copy-btn');
                                        if (copyBtn) {
                                            copyBtn.addEventListener('click', async function() {
                                                const textToCopy = document.body.dataset.waMessage || '';
                                                const btn = this;

                                                try {
                                                    // Coba Clipboard API modern (HTTPS required)
                                                    if (navigator.clipboard && window.isSecureContext) {
                                                        await navigator.clipboard.writeText(textToCopy);
                                                    } else {
                                                        // Fallback untuk HTTP / browser lama
                                                        const textarea = document.createElement('textarea');
                                                        textarea.value = textToCopy;
                                                        textarea.style.position = 'fixed';
                                                        textarea.style.left = '-9999px';
                                                        textarea.style.top = '0';
                                                        document.body.appendChild(textarea);
                                                        textarea.focus();
                                                        textarea.select();
                                                        const success = document.execCommand('copy');
                                                        document.body.removeChild(textarea);
                                                        if (!success) throw new Error('execCommand failed');
                                                    }

                                                    // Feedback visual sukses
                                                    const originalHtml = btn.innerHTML;
                                                    btn.innerHTML = '<i class="material-icons" style="font-size:16px;vertical-align:middle;margin-right:4px">check</i> Tersalin!';
                                                    btn.disabled = true;
                                                    btn.style.background = '#4caf50';
                                                    btn.style.borderColor = '#4caf50';

                                                    // Toast notification
                                                    Swal.mixin({
                                                        toast: true,
                                                        position: 'top-end',
                                                        showConfirmButton: false,
                                                        timer: 2500,
                                                        timerProgressBar: true
                                                    }).fire({
                                                        icon: 'success',
                                                        title: 'Pesan disalin ke clipboard! 📋'
                                                    });

                                                } catch (err) {
                                                    console.error('Copy failed:', err);
                                                    // Fallback terakhir: prompt dengan teks
                                                    const fallbackText = prompt('Salin pesan berikut untuk dikirim manual ke ' + (document.body.dataset.waNohp || 'nomor tujuan') + ':', textToCopy);
                                                    if (fallbackText !== null) {
                                                        Swal.fire({
                                                            toast: true,
                                                            position: 'top-end',
                                                            icon: 'info',
                                                            title: 'Silakan paste pesan di WhatsApp',
                                                            showConfirmButton: false,
                                                            timer: 2000
                                                        });
                                                    }
                                                }
                                            });
                                        }
                                    }
                                });

                                // Kembalikan tombol ke keadaan semula (jangan disable, biar bisa dicoba lagi)
                                btn.disabled = false;
                                btn.innerHTML = originalIcon;
                            }
                        })
                        .catch(error => {
                            console.error('AJAX Error:', error);

                            let errorMsg = 'Gagal menghubungi server.';
                            if (error.message.includes('JSON')) {
                                errorMsg = 'Response server tidak valid. Hubungi administrator.';
                            } else if (error.message.includes('Empty')) {
                                errorMsg = 'Server tidak merespons. Coba lagi nanti.';
                            } else if (error.message.includes('Network') || error.message.includes('Failed to fetch')) {
                                errorMsg = 'Koneksi internet terputus. Periksa jaringan Anda.';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error Koneksi 🔌',
                                text: errorMsg,
                                footer: '<small style="font-size:11px">Cek console browser untuk detail error</small>',
                                confirmButtonColor: '#f44336',
                                backdrop: true
                            });

                            btn.disabled = false;
                            btn.innerHTML = originalIcon;
                        });
                }
            });
        });
    });

    // Tambahkan animasi spin jika belum ada
    if (!document.querySelector('style#wa-spin-animation')) {
        const style = document.createElement('style');
        style.id = 'wa-spin-animation';
        style.textContent = `@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }`;
        document.head.appendChild(style);
    }

    // ========================================================
    // 🔘 MULTI-FILTER INTERACTIVITY (STATUS, PRIORITAS, PETUGAS IT)
    // ========================================================
    (function() {
        var currentStatusFilter = 'ALL';
        var currentPriorityFilter = 'ALL';
        var currentPetugasFilter = 'ALL';

        function normalizeStatus(st) {
            if (!st) return '';
            var s = st.toString().trim().toLowerCase();
            if (s === 'open') return 'Open';
            if (s === 'in progress' || s === 'progress') return 'In Progress';
            if (s === 'complete' || s === 'completed' || s === 'selesai') return 'Complete';
            return st.trim();
        }

        function normalizePriority(prio) {
            if (!prio) return '';
            var p = prio.toString().trim().toUpperCase();
            if (p.indexOf('EMERG') !== -1) return 'EMERGENCY';
            if (p.indexOf('URGENT') !== -1) return 'URGENT';
            if (p.indexOf('HIGH') !== -1) return 'HIGH PRIORITY';
            if (p.indexOf('MED') !== -1) return 'MEDIUM PRIORITY';
            if (p.indexOf('LOW') !== -1) return 'LOW PRIORITY';
            return p;
        }

        // 1. Evaluasi apakah baris memenuhi ketiga kriteria filter secara bersamaan
        function rowMatchesAllFilters(rowStatus, rowPriority, rowPetugas) {
            // A. Evaluasi Filter Status
            if (currentStatusFilter && currentStatusFilter !== 'ALL') {
                var normRowStatus = normalizeStatus(rowStatus).toLowerCase();
                var normFilterStatus = normalizeStatus(currentStatusFilter).toLowerCase();
                if (normRowStatus !== normFilterStatus) return false;
            }

            // B. Evaluasi Filter Prioritas
            if (currentPriorityFilter && currentPriorityFilter !== 'ALL') {
                var normRowPrio = normalizePriority(rowPriority);
                var normFilterPrio = normalizePriority(currentPriorityFilter);
                if (normRowPrio !== normFilterPrio) return false;
            }

            // C. Evaluasi Filter Petugas IT
            if (currentPetugasFilter && currentPetugasFilter !== 'ALL') {
                var cleanPetugas = (rowPetugas || '').toString().trim();
                if (currentPetugasFilter === 'UNASSIGNED') {
                    if (cleanPetugas !== '' && cleanPetugas !== '-' && cleanPetugas !== '0' && cleanPetugas.toLowerCase() !== 'open') return false;
                } else {
                    if (cleanPetugas.toLowerCase() !== currentPetugasFilter.trim().toLowerCase()) return false;
                }
            }

            return true;
        }

        // 2. Hitung counter status langsung dari elemen DOM tabel
        // 2. Hitung counter status langsung dari elemen DOM tabel
        function updateStatusCounters() {
            var tbl = document.getElementById('table-today');
            if (!tbl) return;

            var rows = tbl.querySelectorAll('tbody tr');
            var counts = {
                ALL: 0,
                Open: 0,
                'In Progress': 0,
                Complete: 0
            };

            rows.forEach(function(tr) {
                if (tr.classList.contains('dataTables_empty')) return;
                var st = tr.getAttribute('data-status') || '';
                if (!st) {
                    var lbl = tr.querySelector('.label');
                    if (lbl) st = lbl.textContent;
                }
                var norm = normalizeStatus(st);
                counts.ALL++;
                if (counts.hasOwnProperty(norm)) {
                    counts[norm]++;
                }
            });

            var elAll = document.getElementById('count-all');
            var elOpen = document.getElementById('count-open');
            var elProgress = document.getElementById('count-progress');
            var elComplete = document.getElementById('count-complete');

            if (elAll) elAll.textContent = counts.ALL;
            if (elOpen) elOpen.textContent = counts.Open;
            if (elProgress) elProgress.textContent = counts['In Progress'];
            if (elComplete) elComplete.textContent = counts.Complete;
        }

        // 3. Hitung counter prioritas langsung dari elemen DOM tabel
        function updatePriorityCounters() {
            var tbl = document.getElementById('table-today');
            if (!tbl) return;

            var rows = tbl.querySelectorAll('tbody tr');
            var pCounts = {
                ALL: 0,
                EMERGENCY: 0,
                'HIGH PRIORITY': 0,
                'MEDIUM PRIORITY': 0,
                'LOW PRIORITY': 0
            };

            rows.forEach(function(tr) {
                if (tr.classList.contains('dataTables_empty')) return;
                var p = tr.getAttribute('data-priority') || '';
                var norm = normalizePriority(p);
                pCounts.ALL++;
                if (pCounts.hasOwnProperty(norm)) {
                    pCounts[norm]++;
                }
            });

            var elAll = document.getElementById('prio-count-all');
            var elEmerg = document.getElementById('prio-count-emergency');
            var elHigh = document.getElementById('prio-count-high');
            var elMed = document.getElementById('prio-count-medium');
            var elLow = document.getElementById('prio-count-low');

            if (elAll) elAll.textContent = pCounts.ALL;
            if (elEmerg) elEmerg.textContent = pCounts.EMERGENCY;
            if (elHigh) elHigh.textContent = pCounts['HIGH PRIORITY'];
            if (elMed) elMed.textContent = pCounts['MEDIUM PRIORITY'];
            if (elLow) elLow.textContent = pCounts['LOW PRIORITY'];
        }

        // 4. Update status active pada pill buttons dan select petugas
        function updateFilterActiveStates() {
            var statusPills = document.querySelectorAll('.btn-filter-pill');
            statusPills.forEach(function(pill) {
                var s = pill.getAttribute('data-status') || 'ALL';
                pill.classList.toggle('active', s === currentStatusFilter);
            });

            var prioPills = document.querySelectorAll('.btn-filter-pill-prio');
            prioPills.forEach(function(pill) {
                var p = pill.getAttribute('data-priority') || 'ALL';
                pill.classList.toggle('active', p === currentPriorityFilter);
            });

            var selPetugas = document.getElementById('filterSelectPetugas');
            if (selPetugas) {
                selPetugas.value = currentPetugasFilter;
            }
        }

        // 5. Re-index nomor urut kolom 'No' untuk baris yang tampak
        function reindexTableRows() {
            var tbl = document.getElementById('table-today');
            if (!tbl) return;
            var rows = tbl.querySelectorAll('tbody tr');
            var counter = 1;
            rows.forEach(function(tr) {
                if (tr.classList.contains('dataTables_empty')) return;
                var isVisible = (tr.style.display !== 'none') && (tr.offsetParent !== null || tr.offsetHeight > 0);
                if (isVisible) {
                    var firstTd = tr.querySelector('td');
                    if (firstTd) {
                        firstTd.textContent = counter++;
                    }
                }
            });
        }

        // 6. Terapkan gabungan semua kriteria filter
        function applyCombinedFilters() {
            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.dataTable && window.jQuery.fn.dataTable.isDataTable('#table-today')) {
                window.jQuery('#table-today').DataTable().draw();
            } else {
                var rows = document.querySelectorAll('#table-today tbody tr');
                rows.forEach(function(tr) {
                    if (tr.classList.contains('dataTables_empty')) return;
                    var st = tr.getAttribute('data-status') || '';
                    if (!st) {
                        var lbl = tr.querySelector('.label');
                        if (lbl) st = lbl.textContent;
                    }
                    var prio = tr.getAttribute('data-priority') || '';
                    var pet = tr.getAttribute('data-petugas') || '';

                    if (rowMatchesAllFilters(st, prio, pet)) {
                        tr.style.display = '';
                    } else {
                        tr.style.display = 'none';
                    }
                });
            }
            reindexTableRows();
        }

        // 7. Event Listener untuk klik Status Pills (delegated)
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.btn-filter-pill');
            if (!btn) return;
            e.preventDefault();
            var status = btn.getAttribute('data-status') || 'ALL';
            currentStatusFilter = status;
            updateFilterActiveStates();
            applyCombinedFilters();
        });

        // 8. Event Listener untuk klik Prioritas Pills (delegated)
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.btn-filter-pill-prio');
            if (!btn) return;
            e.preventDefault();
            var prio = btn.getAttribute('data-priority') || 'ALL';
            currentPriorityFilter = prio;
            updateFilterActiveStates();
            applyCombinedFilters();
        });

        // 9. Event Listener untuk select Petugas IT
        var selectPetugas = document.getElementById('filterSelectPetugas');
        if (selectPetugas) {
            selectPetugas.addEventListener('change', function() {
                currentPetugasFilter = this.value || 'ALL';
                updateFilterActiveStates();
                applyCombinedFilters();
            });
        }

        // 10. Tombol Reset Semua Filter
        var btnReset = document.getElementById('btnResetFilters');
        if (btnReset) {
            btnReset.addEventListener('click', function(e) {
                e.preventDefault();
                currentStatusFilter = 'ALL';
                currentPriorityFilter = 'ALL';
                currentPetugasFilter = 'ALL';

                if (selectPetugas) selectPetugas.value = 'ALL';

                updateFilterActiveStates();
                applyCombinedFilters();
            });
        }

        // 10. Integrasi DataTables saat jQuery & DataTables sudah siap
        function initDataTablesSearchHook() {
            if (typeof window.jQuery === 'undefined' || !window.jQuery.fn || !window.jQuery.fn.dataTable) {
                setTimeout(initDataTablesSearchHook, 50);
                return;
            }

            var $ = window.jQuery;

            if (!$.fn.dataTable.ext._simitFilterReady) {
                $.fn.dataTable.ext._simitFilterReady = true;

                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'table-today') {
                        return true;
                    }

                    var rowNode = settings.aoData[dataIndex].nTr;
                    var rowStatus = '';
                    var rowPriority = '';
                    var rowPetugas = '';

                    if (rowNode) {
                        rowStatus = $(rowNode).attr('data-status') || '';
                        if (!rowStatus) {
                            var lbl = rowNode.querySelector ? rowNode.querySelector('.label') : null;
                            if (lbl) rowStatus = lbl.textContent;
                        }
                        rowPriority = $(rowNode).attr('data-priority') || '';
                        rowPetugas = $(rowNode).attr('data-petugas') || '';
                    }

                    if (!rowStatus && data && data[4]) {
                        rowStatus = data[4];
                    }

                    return rowMatchesAllFilters(rowStatus, rowPriority, rowPetugas);
                });
            }

            function bindTableDrawEvent() {
                if ($.fn.dataTable.isDataTable('#table-today')) {
                    var table = $('#table-today').DataTable();
                    table.off('draw.simitStatus').on('draw.simitStatus', function() {
                        reindexTableRows();
                    });
                    updateStatusCounters();
                    updatePriorityCounters();
                    reindexTableRows();
                } else {
                    setTimeout(bindTableDrawEvent, 100);
                }
            }
            bindTableDrawEvent();
        }

        // Inisialisasi awal saat dokumen siap
        function initFilters() {
            updateStatusCounters();
            updatePriorityCounters();
            updateFilterActiveStates();
            reindexTableRows();
            initDataTablesSearchHook();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFilters);
        } else {
            initFilters();
        }

        // ========================================================
        // 🎯 MODAL UBAH PRIORITAS HANDLER
        // ========================================================
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.btn-ubah-prioritas');
            if (!btn) return;
            e.preventDefault();

            var ticketId = btn.getAttribute('data-id');
            var nama = btn.getAttribute('data-nama') || '-';
            var kendala = btn.getAttribute('data-kendala') || '-';
            var prioritas = (btn.getAttribute('data-prioritas') || '').trim().toUpperCase();

            var inputId = document.getElementById('modal-prio-input-id');
            var txtId = document.getElementById('modal-prio-ticket-id');
            var txtNama = document.getElementById('modal-prio-nama');
            var txtKendala = document.getElementById('modal-prio-kendala');

            if (inputId) inputId.value = ticketId;
            if (txtId) txtId.textContent = ticketId;
            if (txtNama) txtNama.textContent = nama;
            if (txtKendala) txtKendala.textContent = kendala;

            var targetRadioVal = '';
            if (prioritas.indexOf('EMERG') !== -1) targetRadioVal = 'EMERGENCY';
            else if (prioritas.indexOf('URGENT') !== -1) targetRadioVal = 'URGENT';
            else if (prioritas.indexOf('HIGH') !== -1) targetRadioVal = 'HIGH PRIORITY';
            else if (prioritas.indexOf('MED') !== -1) targetRadioVal = 'MEDIUM PRIORITY';
            else if (prioritas.indexOf('LOW') !== -1) targetRadioVal = 'LOW PRIORITY';

            var radios = document.querySelectorAll('input[name="prio_choice"]');
            radios.forEach(function(r) {
                r.checked = (r.value === targetRadioVal || (targetRadioVal === 'EMERGENCY' && (r.value === 'EMERGENCY' || r.value === 'EMERGANCY')));
            });

            if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
                window.jQuery('#modalUbahPrioritas').modal('show');
            } else {
                var modalEl = document.getElementById('modalUbahPrioritas');
                if (modalEl) {
                    modalEl.classList.add('in');
                    modalEl.style.display = 'block';
                }
            }
        });

        // Pastikan klik card opsi memilih radio button
        document.addEventListener('click', function(e) {
            var cardOpt = e.target.closest('.prio-card-option');
            if (!cardOpt) return;
            var radio = cardOpt.querySelector('input[type="radio"]');
            if (radio && !radio.checked) {
                radio.checked = true;
                var ev = new Event('change', {
                    bubbles: true
                });
                radio.dispatchEvent(ev);
            }
        });

        // Close modal fallback untuk tombol data-dismiss="modal"
        document.querySelectorAll('#modalUbahPrioritas [data-dismiss="modal"]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
                    window.jQuery('#modalUbahPrioritas').modal('hide');
                } else {
                    var modalEl = document.getElementById('modalUbahPrioritas');
                    if (modalEl) {
                        modalEl.classList.remove('in');
                        modalEl.style.display = 'none';
                    }
                }
            });
        });

        // Fungsi submit update prioritas
        function doSubmitPriority(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            var ticketId = document.getElementById('modal-prio-input-id') ? document.getElementById('modal-prio-input-id').value : '';
            if (!ticketId) {
                Swal.fire({
                    icon: 'error',
                    title: 'ID Tiket Tidak Valid',
                    text: 'Silakan refresh halaman dan coba kembali.'
                });
                return;
            }

            var selectedRadio = document.querySelector('input[name="prio_choice"]:checked');
            if (!selectedRadio) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Prioritas',
                    text: 'Silakan pilih salah satu tingkat prioritas terlebih dahulu.'
                });
                return;
            }

            var newPriority = selectedRadio.value;
            var submitBtn = document.getElementById('btn-submit-prio');
            var originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="material-icons" style="font-size:16px;animation:spin 1s linear infinite;vertical-align:middle;margin-right:4px;">refresh</i> Menyimpan...';
            }

            var formData = new FormData();
            formData.append('ticket_id', ticketId);
            formData.append('nama_prioritas', newPriority);

            fetch('update_priority_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(function(res) {
                    if (!res.ok) {
                        throw new Error('HTTP ' + res.status + ' ' + res.statusText);
                    }
                    return res.json();
                })
                .then(function(data) {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                    }

                    if (data.success) {
                        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
                            window.jQuery('#modalUbahPrioritas').modal('hide');
                        } else {
                            var modalEl = document.getElementById('modalUbahPrioritas');
                            if (modalEl) {
                                modalEl.classList.remove('in');
                                modalEl.style.display = 'none';
                            }
                        }

                        var labelPrioritas = newPriority || 'Belum Ditentukan';
                        Swal.fire({
                            icon: 'success',
                            title: 'Prioritas Berhasil Diubah! 🎯',
                            text: 'Prioritas tiket #' + ticketId + ' berhasil diubah menjadi ' + labelPrioritas,
                            timer: 1100,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengubah Prioritas',
                            text: data.message || 'Terjadi kesalahan saat menyimpan.'
                        });
                    }
                })
                .catch(function(err) {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Jaringan',
                        text: 'Gagal menghubungi server: ' + err.message
                    });
                });
        }

        var formPrio = document.getElementById('formUbahPrioritas');
        if (formPrio) {
            formPrio.addEventListener('submit', doSubmitPriority);
        }
        var btnSubmitPrio = document.getElementById('btn-submit-prio');
        if (btnSubmitPrio) {
            btnSubmitPrio.addEventListener('click', function(e) {
                e.preventDefault();
                doSubmitPriority(e);
            });
        }
    })();
</script>