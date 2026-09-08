<?php
date_default_timezone_set('Asia/Jakarta');
$tanggal = date("Y-m-d");
$tampil = mysqli_query($connect, "SELECT * FROM pengunjung WHERE tgllapor='$tanggal' OR status='In Progress' OR status='Open' ORDER BY id DESC");
?>

<!-- Basic Examples -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>DATA MAINTENANCE/TROUBLE/REQUEST IT TODAY</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table id="table-today" class="table table-bordered table-striped table-hover js-basic-example no-paging dataTable" data-paging="false">
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
                            <tr>
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
                                            <strong>Prioritas:</strong> <?php echo htmlspecialchars((string)($data['nama_prioritas'] ?? '-')); ?><br>
                                            <strong>Kategori:</strong> <?php echo htmlspecialchars((string)($data['jenis'] ?? '-')); ?><br>
                                            <strong>Jenis Kendala:</strong> <?php echo htmlspecialchars((string)($data['kendala'] ?? '-')); ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center" align="center" style="text-align: center !important;">
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
</script>