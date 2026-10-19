<?php
?>

    <!-- TAB ABOUT ME -->
        <div id="tab-<?= $role === 'Guru' ? 'menu5' : 'menu9'; ?>" class="tab-content" style="display: none;">
          <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="p-4 bg-maroon text-white" style="background: linear-gradient(135deg, #02008b 0%, #070157 100%);">
              <h4 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i>Profil Pengembang / User</h4>
              <p class="mb-0 text-white-50 small">Sistem Informasi UKK 2026</p>
            </div>
            <div class="card-body p-4 bg-white">
              <div class="row align-items-center">
                <div class="col-md-4 text-center mb-3 mb-md-0 border-end border-light">
                  <img src="foto-profil.jpg" alt="Foto Profil" class="img-fluid rounded-circle shadow border border-4 border-danger mb-3" style="width: 160px; height: 160px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/160?text=Foto+Profil';">
                  <h5 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($nama); ?></h5>
                  <span class="badge bg-danger mt-1 px-3 py-1 rounded-pill"><?= $role; ?></span>
                </div>
                <div class="col-md-8 ps-md-4">
                  <h5 class="text-danger fw-bold mb-3"><i class="bi bi-info-square me-2"></i>Informasi Biodata</h5>
                  <table class="table table-borderless mb-0">
                    <tbody>
                      <tr><th width="30%" class="text-muted">Nama Lengkap</th><td width="5%">:</td><td class="fw-semibold"><?= htmlspecialchars($nama); ?></td></tr>
                      <tr><th class="text-muted">Email</th><td>:</td><td><?= htmlspecialchars($email); ?></td></tr>
                      <tr><th class="text-muted">Role / Jabatan</th><td>:</td><td><?= $role; ?> Sistem</td></tr>
                      <tr><th class="text-muted">Kelas / Jurusan</th><td>:</td><td>XII Rekayasa Perangkat Lunak (RPL)</td></tr>
                      <tr><th class="text-muted">Proyek</th><td>:</td><td>Uji Kompetensi Keahlian (UKK) 2026</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer bg-light text-muted text-center py-3 border-0">
              <small>&copy; 2026 UKK Project - Dikembangkan dengan dedikasi penuh.</small>
            </div>
          </div>
        </div>
                </tbody>
              </table>
            </div>
          </div>
        </div>