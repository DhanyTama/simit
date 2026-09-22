<?php
date_default_timezone_set('Asia/Jakarta');
// ✅ Tambahkan is_sent dan nohp di SELECT
$query1 = "SELECT *, is_sent FROM pengunjung WHERE status='Complete' ORDER BY id DESC LIMIT 200";
$tampil = mysqli_query($connect, $query1) or die(mysqli_error($connect));
?>

<!-- Basic Examples -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>DATA MAINTENANCE/TROUBLE/REQUEST IT COMPLETE ALL</h2>
        </div>
        <div class="body">
            <!-- Loading State -->
            <div id="loading-alldata" style="padding: 60px 20px; text-align: center;">
                <div class="preloader pl-size-l">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p style="margin-top: 20px; font-weight: 700; color: #1e293b; font-size: 15px; letter-spacing: 0.3px;">
                    Memuat data... Harap tunggu sebentar
                </p>
                <small style="color: #64748b; font-size: 12.5px;">Sedang menyiapkan data transaksi complete</small>
            </div>

            <div class="table-responsive" id="table-wrapper-alldata" style="display: none;">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Start date</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="text-align: center !important;">Status</th>
                            <th>Repair Date</th>
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
                            <tr>
                                <td align="center" style="font-weight: 600; color: #64748b;"><?php echo $no ?></td>
                                <td>
                                    <span style="font-weight: 600; color: #1e293b;"><?php echo date('d M Y', strtotime($data['tgllapor'])); ?></span>
                                    <br><small style="color: #64748b; font-size: 11px;">[<?php echo $data['jamlapor']; ?>]</small>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars((string)($data['nama'] ?? '')); ?></span>
                                    <br><span style="color: #64748b; font-size: 11.5px;">[<?php echo htmlspecialchars((string)($data['depart'] ?? '')); ?>]</span>
                                    <?php if (!empty($data['nohp'])) { ?>
                                        <br><span style="color: #0284c7; font-size: 11px; font-weight: 500;">📱 <a href="https://wa.me/<?php echo htmlspecialchars((string)$data['nohp']); ?>"><?php echo htmlspecialchars((string)$data['nohp']); ?></a></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars((string)($data['jnskendala'] ?? '')); ?><br>
                                    <a class="waves-effect m-b-15" role="button" data-toggle="collapse" href="#<?php echo $cekidx; ?>" aria-expanded="false" aria-controls="collapseExample" style="font-size: 12px; font-weight: 600;">Detail...</a>
                                    <div class="collapse" id="<?php echo $cekidx; ?>" style="margin-top: 6px; padding: 8px 12px; background: #f8fafc; border-radius: 6px; border-left: 3px solid #0284c7;">
                                        <small style="color: #475569; font-style: normal; display: block; line-height: 1.6;">
                                            <strong>Kerusakan:</strong> <?php echo htmlspecialchars((string)($data['kerusakan'] ?? '-')); ?><br>
                                            <strong>Tindakan:</strong> <?php echo htmlspecialchars((string)($data['tindakan'] ?? '-')); ?><br>
                                            <strong>Petugas IT:</strong> <?php echo htmlspecialchars((string)($data['petugas'] ?? '-')); ?><br>
                                            <strong>Prioritas:</strong> <?php echo htmlspecialchars((string)($data['nama_prioritas'] ?? '-')); ?><br>
                                            <strong>Kategori:</strong> <?php echo htmlspecialchars((string)($data['jenis'] ?? '-')); ?><br>
                                            <strong>Jenis Kendala:</strong> <?php echo htmlspecialchars((string)($data['kendala'] ?? '-')); ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center" align="center" style="text-align: center !important;"><span class="label bg-green" style="font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600; display: inline-block;">Complete</span></td>
                                <td>
                                    <?php
                                    if (!empty($data['tglperbaikan']) && $data['tglperbaikan'] != '0000-00-00') {
                                        echo "<span style='font-weight: 600; color: #1e293b;'>" . date('d M Y', strtotime($data['tglperbaikan'])) . "</span><br><small style='color: #64748b; font-size: 11px;'>[" . $data['jamperbaikan'] . "]</small>";
                                    } else {
                                        echo "<span class='text-muted'>-</span>";
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
                                        if ($cek_status == "Complete") {
                                            // Tombol Edit Data
                                            echo "<a href='index.php?page=dataedit&kd=$cek_id' title='Edit Data'>
                                                    <button type='button' class='btn bg-orange waves-effect'>
                                                        <i class='material-icons'>visibility</i>
                                                    </button>
                                                  </a>";
                                            // === TOMBOL GENERATE LINK FEEDBACK (Selalu muncul) ===
                                            echo "<a href='$feedback_url' target='_blank' title='Generate Feedback Link'>
                                                    <button type='button' class='btn bg-grey waves-effect'>
                                                        <i class='material-icons'>link</i>
                                                    </button>
                                                  </a>";

                                            // === 🟢 TOMBOL WHATSAPP VIA API (Hanya jika nohp ada) ===
                                            if (!empty($data['nohp'])) {
                                                // Cek status is_sent
                                                $is_sent = !empty($data['is_sent']) && $data['is_sent'] == 1;

                                                if ($is_sent) {
                                                    // ✅ Sudah dikirim: tombol disabled + icon centang
                                                    echo "<button type='button' 
                                                            class='btn bg-grey waves-effect' 
                                                            title='Pesan WhatsApp sudah dikirim'
                                                            disabled
                                                            style='opacity: 0.65; cursor: not-allowed;'>
                                                            <i class='material-icons'>check</i>
                                                          </button>";
                                                } else {
                                                    // 🔘 Belum dikirim: tombol aktif hijau
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

<script>
    // Fallback aman tanpa dependensi jQuery langsung di sini
    window.addEventListener('load', function() {
        setTimeout(function() {
            var l = document.getElementById('loading-alldata');
            var w = document.getElementById('table-wrapper-alldata');
            if (l) l.style.display = 'none';
            if (w) w.style.display = 'block';
        }, 600);
    });
</script>

<!-- SweetAlert2 CDN untuk notifikasi profesional -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript: Handle Kirim WhatsApp via AJAX + Preview Text + Fallback Copy -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan hanya attach event listener sekali
        if (window.waButtonInitialized) return;
        window.waButtonInitialized = true;

        // Delegated event listener untuk tombol dinamis di tabel
        document.querySelector('.table-responsive')?.addEventListener('click', function(e) {
            const btn = e.target.closest('.send-wa-api-btn');
            if (!btn || btn.disabled) return;

            // Cegah double-click dalam 2 detik
            if (btn.dataset.processing === '1') return;
            btn.dataset.processing = '1';

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
                                        dark: { popupBg: '#1e293b', previewBg: '#0f172a', previewBorder: '#334155', previewText: '#f1f5f9', fallbackBg: 'rgba(15, 23, 42, 0.75)', fallbackBorder: '#334155', fallbackAccent: '#38bdf8', label: '#cbd5e1', sub: '#94a3b8', nohp: '#38bdf8' },
                                        light: { popupBg: '#ffffff', previewBg: '#f8fafc', previewBorder: '#cbd5e1', previewText: '#1e293b', fallbackBg: '#f8fafc', fallbackBorder: '#e2e8f0', fallbackAccent: '#0284c7', label: '#475569', sub: '#64748b', nohp: '#0284c7' }
                                    },
                                    cappuccino: {
                                        dark: { popupBg: '#231c17', previewBg: '#1b1411', previewBorder: '#382a22', previewText: '#faedcd', fallbackBg: 'rgba(27, 20, 17, 0.85)', fallbackBorder: '#382a22', fallbackAccent: '#d4a373', label: '#d4a373', sub: '#d4a373', nohp: '#e9c46a' },
                                        light: { popupBg: '#fffdfa', previewBg: '#fdfaf6', previewBorder: '#ebdcd0', previewText: '#4a3427', fallbackBg: '#fbf5ee', fallbackBorder: '#ebdcd0', fallbackAccent: '#9c6742', label: '#6f4e37', sub: '#8c674b', nohp: '#6f4e37' }
                                    },
                                    everforest: {
                                        dark: { popupBg: '#1e2522', previewBg: '#171d1b', previewBorder: '#2d3a34', previewText: '#d3c6aa', fallbackBg: 'rgba(23, 29, 27, 0.85)', fallbackBorder: '#2d3a34', fallbackAccent: '#a7c080', label: '#a7c080', sub: '#9da993', nohp: '#a7c080' },
                                        light: { popupBg: '#fdfaf4', previewBg: '#f4edd9', previewBorder: '#d3c6aa', previewText: '#2d353b', fallbackBg: '#f7efe0', fallbackBorder: '#e2d9c6', fallbackAccent: '#4a7a40', label: '#4a7a40', sub: '#5c6a72', nohp: '#4a7a40' }
                                    },
                                    tokyo: {
                                        dark: { popupBg: '#1a1b26', previewBg: '#16161e', previewBorder: '#292e42', previewText: '#c0caf5', fallbackBg: 'rgba(22, 22, 30, 0.85)', fallbackBorder: '#414868', fallbackAccent: '#7aa2f7', label: '#7aa2f7', sub: '#a9b1d6', nohp: '#7aa2f7' },
                                        light: { popupBg: '#ffffff', previewBg: '#edf0f7', previewBorder: '#cfd5e5', previewText: '#24283b', fallbackBg: '#f0f2f9', fallbackBorder: '#e1e4ed', fallbackAccent: '#2e7de9', label: '#2e7de9', sub: '#617292', nohp: '#2e7de9' }
                                    },
                                    pb: {
                                        dark: { popupBg: '#0d141e', previewBg: '#090e16', previewBorder: 'rgba(0, 210, 255, 0.3)', previewText: '#e2f1f8', fallbackBg: 'rgba(9, 14, 22, 0.85)', fallbackBorder: 'rgba(0, 210, 255, 0.3)', fallbackAccent: '#00d2ff', label: '#00d2ff', sub: '#88a4bc', nohp: '#00d2ff' },
                                        light: { popupBg: '#0d141e', previewBg: '#090e16', previewBorder: 'rgba(0, 210, 255, 0.3)', previewText: '#e2f1f8', fallbackBg: 'rgba(9, 14, 22, 0.85)', fallbackBorder: 'rgba(0, 210, 255, 0.3)', fallbackAccent: '#00d2ff', label: '#00d2ff', sub: '#88a4bc', nohp: '#00d2ff' }
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
                        })
                        .finally(() => {
                            // Reset processing flag
                            btn.dataset.processing = '0';
                        });
                } else {
                    // Reset processing flag jika user batal
                    btn.dataset.processing = '0';
                }
            });
        });
    });

    // Tambahkan animasi spin jika belum ada
    if (!document.querySelector('style#wa-spin-animation')) {
        const style = document.createElement('style');
        style.id = 'wa-spin-animation';
        style.textContent = `@-webkit-keyframes spin { from { -webkit-transform: rotate(0deg); } to { -webkit-transform: rotate(360deg); } } @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }`;
        document.head.appendChild(style);
    }
</script>