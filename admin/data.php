<?php
date_default_timezone_set('Asia/Jakarta');
$tanggal = date("Y-m-d");
$tampil = mysqli_query($connect, "SELECT * FROM pengunjung WHERE tgllapor='$tanggal' OR status='In Progress' OR status='Open' ORDER BY CASE WHEN status='Open' THEN 1 WHEN status='In Progress' THEN 2 WHEN status='Complete' OR status='Completed' OR status='Selesai' THEN 3 ELSE 4 END ASC, CASE WHEN status='In Progress' AND UPPER(nama_prioritas) LIKE '%EMERG%' THEN 1 WHEN status='In Progress' AND UPPER(nama_prioritas) LIKE '%URGENT%' THEN 2 WHEN status='In Progress' AND UPPER(nama_prioritas) LIKE '%HIGH%' THEN 3 WHEN status='In Progress' AND UPPER(nama_prioritas) LIKE '%MED%' THEN 4 WHEN status='In Progress' AND UPPER(nama_prioritas) LIKE '%LOW%' THEN 5 WHEN status='In Progress' THEN 6 ELSE 7 END ASC, id DESC");

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
    .status-filter-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 10px 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .filter-group-wrapper {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        letter-spacing: 0.2px;
    }

    .status-filter-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .btn-filter-pill:hover {
        transform: translateY(-1px);
    }

    /* Active Base */
    .btn-filter-pill.active {
        color: #ffffff !important;
    }

    .btn-filter-pill.active .pill-count {
        background: rgba(255, 255, 255, 0.28) !important;
        color: #ffffff !important;
    }

    /* Dots warna pada pill status */
    .pill-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    .pill-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1;
        transition: all 0.2s ease;
    }

    /* --- LIGHT MODE SPESIFIK TIAP STATUS --- */
    /* 1. SEMUA */
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

    /* 2. OPEN (Merah Muda / Crimson Rose) */
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

    /* 3. IN PROGRESS (Biru Muda / Sky Blue) */
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

    /* 4. COMPLETE (Hijau / Emerald) */
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
        background: #1e293b;
        border-color: #334155;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .dark-mode .filter-label {
        color: #f1f5f9;
    }

    .dark-mode .btn-filter-pill[data-status="ALL"] {
        background: #0f172a;
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
        background: #3b82f6 !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 0 12px rgba(59, 130, 246, 0.5) !important;
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
        box-shadow: 0 0 12px rgba(225, 29, 72, 0.5) !important;
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
        box-shadow: 0 0 12px rgba(2, 132, 199, 0.5) !important;
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
        box-shadow: 0 0 12px rgba(22, 163, 74, 0.5) !important;
    }

    .dark-mode .btn-filter-pill[data-status="Complete"].active .pill-dot {
        background: #bbf7d0 !important;
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
        display: none !important;
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
            <!-- 🔘 STATUS FILTER TOOLBAR -->
            <div class="status-filter-toolbar">
                <div class="filter-group-wrapper">
                    <div class="filter-label">
                        <i class="material-icons" style="font-size: 17px; vertical-align: middle; margin-right: 4px;">filter_list</i>
                        <span>Filter Status:</span>
                    </div>
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


            </div>

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
                            $cekidx = $data['id'];
                        ?>
                            <tr data-status="<?php echo htmlspecialchars((string)$cek_status); ?>" data-priority="<?php echo htmlspecialchars((string)normalizePriorityName($data['nama_prioritas'] ?? '')); ?>">
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
                                            <strong>Petugas IT:</strong> <?php echo htmlspecialchars((string)($data['petugas'] ?? '-')); ?><br>
                                            <strong>Prioritas:</strong> <?php echo htmlspecialchars((string)normalizePriorityName($data['nama_prioritas'] ?? '-')); ?><br>
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
                                    <?php if ($cek_status != 'Open') { ?>
                                        <div class="pb-priority-clickable <?php echo ($cek_status == 'In Progress') ? 'btn-ubah-prioritas' : ''; ?>"
                                            data-id="<?php echo $cek_id; ?>"
                                            data-nama="<?php echo htmlspecialchars((string)($data['nama'] ?? '')); ?>"
                                            data-kendala="<?php echo htmlspecialchars((string)($data['jnskendala'] ?? '')); ?>"
                                            data-prioritas="<?php echo htmlspecialchars((string)normalizePriorityName($data['nama_prioritas'] ?? '')); ?>"
                                            <?php echo ($cek_status == 'In Progress') ? 'title="Klik untuk ubah prioritas"' : ''; ?>>
                                            <?php
                                            $pbBadgeHtml = renderPbPriorityBadge($data['nama_prioritas'] ?? '');
                                            if (!empty($pbBadgeHtml)) {
                                                echo $pbBadgeHtml;
                                            } elseif ($cek_status == 'In Progress') {
                                                echo '<span class="pb-badge pb-none" style="font-size:10px; cursor:pointer;" title="Klik untuk atur prioritas">+ Prioritas</span>';
                                            }
                                            ?>
                                        </div>
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
                                            // Tombol Ganti Prioritas (Hanya untuk In Progress)
                                            echo "<button type='button' 
                                                    class='btn bg-purple waves-effect btn-ubah-prioritas' 
                                                    data-id='$cek_id' 
                                                    data-nama='" . htmlspecialchars((string)($data['nama'] ?? '')) . "' 
                                                    data-kendala='" . htmlspecialchars((string)($data['jnskendala'] ?? '')) . "' 
                                                    data-prioritas='" . htmlspecialchars((string)normalizePriorityName($data['nama_prioritas'] ?? '')) . "' 
                                                    title='Ganti Prioritas'>
                                                    <i class='material-icons'>flag</i>
                                                  </button>";
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
            <form id="formUbahPrioritas">
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
            Swal.fire({
                title: '📱 Kirim WhatsApp?',
                html: `Kirim notifikasi penyelesaian ke <b>${namaPelapor}</b>?<br>
                   <small>Nomor: ${nohp}<br>Pesan akan berisi link feedback profesional.</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '✅ Kirim Sekarang',
                cancelButtonText: '❌ Batal',
                confirmButtonColor: '#25D366',
                cancelButtonColor: '#f44336',
                reverseButtons: true,
                backdrop: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading state pada tombol
                    const originalIcon = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="material-icons" style="font-size:18px;animation:spin 1s linear infinite;">refresh</i>';

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

                                // Build error content dengan preview text + tombol copy
                                let errorContent = `<b>${data?.message || 'Gagal mengirim via API'}</b>`;
                                if (data?.data?.error) {
                                    errorContent += `<br><small style="color:#666">${data.data.error}</small>`;
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
                                <div style="margin-top:15px">
                                    <!-- Preview Box (Scrollable) -->
                                    <div style="margin-bottom:10px">
                                        <small style="display:block;margin-bottom:5px;color:#555;font-weight:500">
                                            📝 Preview Pesan:
                                        </small>
                                        <div style="
                                            max-height:200px;
                                            overflow-y:auto;
                                            background:#fff;
                                            border:1px solid #ddd;
                                            border-radius:4px;
                                            padding:10px;
                                            font-size:12px;
                                            line-height:1.5;
                                            white-space:pre-wrap;
                                            font-family:monospace;
                                            color:#333;
                                        ">${escapedText}</div>
                                    </div>
                                    
                                    <!-- Copy Button Section -->
                                    <div style="padding:12px;background:#f8f9fa;border-radius:6px;border-left:4px solid #ffc107">
                                        <small style="display:block;margin-bottom:8px;color:#555;font-weight:500">
                                            📋 Fallback Manual:
                                        </small>
                                        <button id="swal-copy-btn" class="btn btn-primary" 
                                                style="width:100%;background:#25D366;border-color:#25D366;color:#fff;font-weight:500">
                                            <i class="material-icons" style="font-size:16px;vertical-align:middle;margin-right:4px">content_copy</i>
                                            Copy Pesan untuk Kirim Manual
                                        </button>
                                        <small style="display:block;margin-top:8px;color:#777;font-size:11px">
                                            Klik tombol di atas, lalu paste di WhatsApp Web/App ke nomor:<br>
                                            <b style="color:#333">${targetNohp}</b>
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
                                    title: 'Gagal Mengirim ❌',
                                    html: errorContent,
                                    confirmButtonText: '❌ Tutup',
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
    // STATUS FILTER INTERACTIVITY & REAL-TIME COUNTERS
    // ========================================================
    (function() {
        var currentStatusFilter = 'ALL';

        function normalizeStatus(st) {
            if (!st) return '';
            var s = st.toString().trim().toLowerCase();
            if (s === 'open') return 'Open';
            if (s === 'in progress' || s === 'progress') return 'In Progress';
            if (s === 'complete' || s === 'completed' || s === 'selesai') return 'Complete';
            return st.trim();
        }

        // 1. Hitung counter langsung dari elemen DOM tabel
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
            var elProg = document.getElementById('count-progress');
            var elComp = document.getElementById('count-complete');

            if (elAll) elAll.textContent = counts.ALL;
            if (elOpen) elOpen.textContent = counts.Open;
            if (elProg) elProg.textContent = counts['In Progress'];
            if (elComp) elComp.textContent = counts.Complete;
        }

        // 2. Re-index nomor urut kolom 'No' untuk baris yang tampak
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

        // 3. Terapkan filter status ke tabel
        function applyStatusFilter(status, clickedBtn) {
            currentStatusFilter = status || 'ALL';

            // Update status tombol aktif di toolbar
            var pills = document.querySelectorAll('.btn-filter-pill');
            pills.forEach(function(p) {
                p.classList.remove('active');
            });
            if (clickedBtn) {
                clickedBtn.classList.add('active');
            }

            // Jika DataTables sudah aktif di tabel, manfaatkan DataTables draw
            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.dataTable && window.jQuery.fn.dataTable.isDataTable('#table-today')) {
                window.jQuery('#table-today').DataTable().draw();
            } else {
                // Fallback instan jika DataTables belum siap
                var normFilter = normalizeStatus(currentStatusFilter).toLowerCase();
                var rows = document.querySelectorAll('#table-today tbody tr');
                rows.forEach(function(tr) {
                    if (tr.classList.contains('dataTables_empty')) return;
                    var st = tr.getAttribute('data-status') || '';
                    if (!st) {
                        var lbl = tr.querySelector('.label');
                        if (lbl) st = lbl.textContent;
                    }
                    var normRow = normalizeStatus(st).toLowerCase();
                    if (normFilter === 'all' || normFilter === '' || normRow === normFilter) {
                        tr.style.display = '';
                    } else {
                        tr.style.display = 'none';
                    }
                });
            }

            reindexTableRows();
        }

        // 4. Delegated Event Listener untuk klik tombol filter pill (bekerja instan tanpa dependensi)
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.btn-filter-pill');
            if (!btn) return;
            e.preventDefault();
            var status = btn.getAttribute('data-status') || 'ALL';
            applyStatusFilter(status, btn);
        });

        // 5. Integrasi DataTables saat jQuery & DataTables sudah siap
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
                    if (!currentStatusFilter || currentStatusFilter === 'ALL') {
                        return true;
                    }

                    var rowNode = settings.aoData[dataIndex].nTr;
                    var rowStatus = '';
                    if (rowNode) {
                        rowStatus = $(rowNode).attr('data-status') || '';
                        if (!rowStatus) {
                            var lbl = rowNode.querySelector ? rowNode.querySelector('.label') : null;
                            if (lbl) rowStatus = lbl.textContent;
                        }
                    }
                    if (!rowStatus && data && data[4]) {
                        rowStatus = data[4];
                    }

                    var normRow = normalizeStatus(rowStatus).toLowerCase();
                    var normFilter = normalizeStatus(currentStatusFilter).toLowerCase();
                    return normRow === normFilter;
                });
            }

            function bindTableDrawEvent() {
                if ($.fn.dataTable.isDataTable('#table-today')) {
                    var table = $('#table-today').DataTable();
                    table.off('draw.simitStatus').on('draw.simitStatus', function() {
                        reindexTableRows();
                    });
                    updateStatusCounters();
                    reindexTableRows();
                } else {
                    setTimeout(bindTableDrawEvent, 100);
                }
            }
            bindTableDrawEvent();
        }

        // Inisialisasi awal saat dokumen siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                updateStatusCounters();
                reindexTableRows();
                initDataTablesSearchHook();
            });
        } else {
            updateStatusCounters();
            reindexTableRows();
            initDataTablesSearchHook();
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

        document.addEventListener('submit', function(e) {
            if (e.target && e.target.id === 'formUbahPrioritas') {
                e.preventDefault();

                var submitBtn = document.getElementById('btn-submit-prio');
                var originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="material-icons" style="font-size:16px;animation:spin 1s linear infinite;vertical-align:middle;margin-right:4px;">refresh</i> Menyimpan...';
                }

                var ticketId = document.getElementById('modal-prio-input-id').value;
                var selectedRadio = document.querySelector('input[name="prio_choice"]:checked');
                var newPriority = selectedRadio ? selectedRadio.value : '';

                var formData = new FormData();
                formData.append('ticket_id', ticketId);
                formData.append('nama_prioritas', newPriority);

                fetch('update_priority_handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(function(res) {
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
        });
    })();
</script>