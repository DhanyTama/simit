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
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Start date</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>NOTE</th>
                            <th>End date</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php 
                        $no = 0;
                        while($data = mysqli_fetch_array($tampil)){ 
                        $no++;
                        $cek_status = $data['status'];
                        $cekidx = $data['id'];
                     ?>
                        <tr>
                            <td align="center"><?php echo $no?></td>
                            <td><?php echo date('d F Y', strtotime($data['tgllapor']))." [".$data['jamlapor']."]";?></td>
                            <td>
                                <?php 
                                    echo $data['nama']."<br>[".$data['depart']."]";
                                    if (!empty($data['nohp'])) {
                                        echo "<br>📱 [".$data['nohp']."]";
                                    }
                                ?>
                            </td>
                            <td><?php echo $data['jnskendala'];?><br>
                                <a class="waves-effect m-b-15" role="button" data-toggle="collapse" href="#<?php echo $cekidx;?>" aria-expanded="false" aria-controls="collapseExample">Detail...</a>
                                <div class="collapse" id="<?php echo $cekidx;?>">
                                    <i>
                                        <br>Petugas IT : [<?php echo $data['petugas'];?>]
                                        <br>Prioritas : [<?php echo $data['nama_prioritas'];?>]
                                        <br>Kategori : [<?php echo $data['jenis'];?>]
                                        <br>Jenis Kendala : [<?php echo $data['kendala'];?>]
                                    </i>
                                </div> 
                            </td>
                            <td><?php echo $data['status']; ?></td>
                            <td><?php echo $data['noteperbaikan'];?></td>
                            <td><?php echo $data['tglselesai']." [".$data['jamselesai']."]";?></td>
                            <td>
                                <!-- Container tombol 1 line: nowrap + scroll horizontal jika perlu -->
                                <div class="icon-button-demo" style="display: flex; gap: 3px; flex-wrap: nowrap; overflow-x: auto; padding-bottom: 2px; white-space: nowrap;">
                                    <?php
                                        $cek_id = $data['id'];
                                        
                                        // === GENERATE FEEDBACK URL ===
                                        $val_kendala = !empty($data['jnskendala']) ? urlencode($data['jnskendala']) : '';
                                        $val_depart = !empty($data['depart']) ? "&ea6710ff-c1a0-475b-a751-ca6aed483200=" . urlencode($data['depart']) : '';
                                        $feedback_url = "https://form.rsanwarmedika.com/forms/feedbackit?eec382ce-3874-42c2-9271-ab2f0838c0c8=" . $val_kendala . $val_depart;
                                        
                                       
                                        
                                        // === TOMBOL AKSI BERDASARKAN STATUS ===
                                        if($cek_status == "Open"){
                                            echo "<a href='index.php?page=accept&kd=$cek_id' title='Accept Ticket'>
                                                    <button type='button' class='btn bg-green waves-effect' style='min-width: 36px; padding: 0 8px; margin: 0;'>
                                                        <i class='material-icons' style='font-size: 18px;'>verified_user</i>
                                                    </button>
                                                  </a>";
                                        }
                                        elseif ($cek_status == "In Progress") {
                                            echo "<a href='index.php?page=solution&kd=$cek_id' title='Add Solution'>
                                                    <button type='button' class='btn bg-light-blue waves-effect' style='min-width: 36px; padding: 0 8px; margin: 0;'>
                                                        <i class='material-icons' style='font-size: 18px;'>content_paste</i>
                                                    </button>
                                                  </a>";
                                        }
                                        elseif ($cek_status == "Complete") {
                                            // Tombol Edit Data
                                            echo "<a href='index.php?page=dataedit&kd=$cek_id' title='Edit Data'>
                                                    <button type='button' class='btn bg-orange waves-effect' style='min-width: 36px; padding: 0 8px; margin: 0;'>
                                                        <i class='material-icons' style='font-size: 18px;'>edit</i>
                                                    </button>
                                                  </a>";
                                                   // === TOMBOL GENERATE LINK FEEDBACK (Selalu muncul) ===
                                        echo "<a href='$feedback_url' target='_blank' title='Generate Feedback Link'>
                                                <button type='button' class='btn bg-grey waves-effect' style='min-width: 36px; padding: 0 8px; margin: 0;'>
                                                    <i class='material-icons' style='font-size: 18px;'>link</i>
                                                </button>
                                              </a>";
                                            
                                            
                                            // === 🟢 TOMBOL WHATSAPP VIA API (Hanya jika nohp ada DAN belum dikirim) ===
                                            if (!empty($data['nohp'])) {
                                                // Cek status is_sent (asumsikan query SELECT sudah mengambil kolom is_sent)
                                                $is_sent = !empty($data['is_sent']) && $data['is_sent'] == 1;
                                                
                                                if ($is_sent) {
                                                    // ✅ Tampilkan tombol "Sudah Terkirim" (disabled, abu-abu, icon centang)
                                                    echo "<button type='button' 
                                                            class='btn bg-grey waves-effect' 
                                                            title='Pesan WhatsApp sudah dikirim'
                                                            disabled
                                                            style='min-width: 36px; max-width: 36px; width: 36px; padding: 0; margin: 0; flex-shrink: 0; display: flex; align-items: center; justify-content: center; opacity: 0.7; cursor: not-allowed;'>
                                                            <i class='material-icons' style='font-size: 18px; line-height: 1; color: #fff;'>check</i>
                                                          </button>";
                                                } else {
                                                    // 🔘 Tampilkan tombol aktif untuk kirim WhatsApp
                                                    echo "<button type='button' 
                                                            class='btn bg-green waves-effect send-wa-api-btn' 
                                                            data-ticket-id='$cek_id' 
                                                            data-nama='".htmlspecialchars($data['nama'])."'
                                                            data-nohp='".htmlspecialchars($data['nohp'])."'
                                                            title='Kirim Notifikasi via WhatsApp API'
                                                            style='min-width: 36px; max-width: 36px; width: 36px; padding: 0; margin: 0; flex-shrink: 0; display: flex; align-items: center; justify-content: center;'>
                                                            <i class='material-icons' style='font-size: 18px; line-height: 1;'>chat</i>
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
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
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