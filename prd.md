# Product Requirement Document (PRD)

# Sistem Peminjaman Ruangan
Fakultas Pendidikan Ekonomi dan Bisnis (FPEB) Universitas Pendidikan Indonesia

Version : 1.0
Author : Microteaching Pea
Status : Draft

---

# 1. Latar Belakang

Proses peminjaman ruangan di lingkungan Fakultas Pendidikan Ekonomi dan Bisnis masih dilakukan secara manual sehingga sering menimbulkan beberapa permasalahan seperti:

- Jadwal bentrok antar peminjam
- Sulit mengetahui ketersediaan ruangan
- Proses persetujuan memerlukan waktu lama
- Riwayat peminjaman sulit dilacak
- Tidak adanya notifikasi otomatis kepada pengguna

Untuk mengatasi permasalahan tersebut dibangun sebuah Sistem Informasi Peminjaman Ruangan berbasis web yang mampu mengelola proses peminjaman secara terintegrasi.

---

# 2. Tujuan

Membangun sistem yang mampu:

- Menampilkan seluruh ruangan beserta fasilitasnya
- Menampilkan kalender ketersediaan ruangan
- Memungkinkan dosen/prodi mengajukan peminjaman
- Membantu admin melakukan approval
- Mengirim notifikasi perubahan status
- Mengurangi konflik jadwal

---

# 3. Stakeholder

| Stakeholder | Peran |
|------------|-------|
| Admin | Mengelola seluruh sistem |
| Dosen / Program Studi | Mengajukan peminjaman |
| Fakultas | Pemilik sistem |

---

# 4. User Role

## Admin

Hak akses:

- Login
- Dashboard
- Mengelola Ruangan
- Mengelola Fasilitas
- Mengelola User
- Mengelola Role
- Mengelola Permission
- Approval Booking
- Mengirim Notifikasi

---

## Dosen / Program Studi

Hak akses:

- Login
- Melihat daftar ruangan
- Melihat kalender
- Mengajukan booking
- Melihat status booking
- Melihat notifikasi

---

# 5. Scope

## In Scope

✔ Login

✔ Dashboard

✔ Daftar Ruangan

✔ Detail Ruangan

✔ Kalender Booking

✔ Form Booking

✔ Approval

✔ Notification

✔ CRUD Ruangan

✔ CRUD User

✔ CRUD Role

✔ CRUD Permission

---

## Out of Scope

Pembayaran

Integrasi Google Calendar

Single Sign On (SSO)

Export PDF

Mobile Application

---

# 6. User Flow

## Dosen

Login

↓

Melihat daftar ruangan

↓

Memilih ruangan

↓

Melihat kalender

↓

Memilih tanggal

↓

Mengisi form peminjaman

↓

Submit

↓

Status Pending

↓

Menunggu Approval

↓

Menerima Notifikasi

---

## Admin

Login

↓

Dashboard

↓

Melihat daftar booking

↓

Membuka detail booking

↓

Approve / Reject

↓

Sistem memperbarui status

↓

Sistem mengirim notifikasi

---

# 7. Functional Requirement

## Authentication

### Login

Deskripsi

Pengguna melakukan login menggunakan email dan password.

Acceptance Criteria

- Email wajib
- Password wajib
- Password terenkripsi
- Role otomatis dikenali

---

## Dashboard

Admin dapat melihat:

- Total Booking
- Booking Pending
- Booking Disetujui
- Booking Ditolak
- Total User

---

## Display Ruangan

Pengguna dapat melihat:

- Nama Ruangan
- Foto
- Kapasitas
- Fasilitas
- Tombol Pilih

---

## Detail Ruangan

Menampilkan:

- Foto
- Kapasitas
- Fasilitas
- Kalender Booking

---

## Kalender

Kalender menampilkan:

Status:

- Kosong
- Pending
- Approved
- Rejected

Klik tanggal akan membuka form booking.

---

## Booking

Field:

- Pengaju
- Program Studi
- Tanggal
- Jam Mulai
- Jam Selesai
- Alasan

Validasi:

- Tidak boleh bentrok
- Jam selesai > jam mulai
- Tidak boleh tanggal lampau

Status awal:

Pending

---

## Approval

Admin dapat:

Approve

atau

Reject

Jika reject wajib mengisi alasan.

---

## Notification

Ketika:

Booking dibuat

↓

Admin menerima notifikasi

Ketika:

Booking disetujui

↓

User menerima notifikasi

Ketika:

Booking ditolak

↓

User menerima notifikasi

---

## CRUD Ruangan

Admin dapat:

Tambah

Edit

Hapus

Melihat daftar ruangan

---

## CRUD User

Admin dapat:

Tambah User

Edit User

Hapus User

Assign Role

---

## CRUD Role

Admin dapat:

Tambah Role

Edit Role

Hapus Role

Assign Permission

---

## CRUD Permission

Admin dapat:

Tambah Permission

Edit Permission

Hapus Permission

---

# 8. Non Functional Requirement

## Performance

- Respon < 2 detik
- Support minimal 100 user

## Security

Password menggunakan Hash

Session Login

Role Based Access Control

CSRF Protection

Input Validation

---

## Compatibility

Chrome

Firefox

Microsoft Edge

---

## Availability

24/7

---

# 9. Database

## users

- id
- nama
- email
- password
- role
- created_at
- updated_at

---

## ruangan

- id
- name
- capacity
- description

---

## fasilitas

- id
- nama

---

## fasilitas_ruangan

- room_id
- facility_id

---

## bookings

- id
- room_id
- user_id
- date
- start_time
- end_time
- reason
- status

---

## notif

- id
- user_id
- title
- message
- is_read

---

# 10. Business Rules

1. User wajib login.

2. Booking hanya dapat dilakukan pada ruangan yang tersedia.

3. Tidak boleh ada booking yang bertabrakan.

4. Booking baru memiliki status Pending.

5. Hanya Admin yang dapat melakukan approval.

6. Booking yang ditolak harus memiliki alasan.

7. Setelah approval sistem mengirim notifikasi.

8. User hanya dapat melihat booking miliknya.

9. Admin dapat melihat seluruh booking.

---

# 11. Status Booking

Pending

↓

Approved

atau

Rejected

Status tidak dapat berubah kembali menjadi Pending.

---

# 12. Permission Matrix

| Fitur | Dosen | Admin |
|--------|-------|-------|
| Login | ✅ | ✅ |
| Lihat Ruangan | ✅ | ✅ |
| Booking | ✅ | ✅ |
| Kalender | ✅ | ✅ |
| Notifikasi | ✅ | ✅ |
| Approval | ❌ | ✅ |
| CRUD Ruangan | ❌ | ✅ |
| CRUD User | ❌ | ✅ |
| CRUD Role | ❌ | ✅ |
| CRUD Permission | ❌ | ✅ |

---

# 13. UI yang Dibangun

## Landing Page

- Hero
- Tombol Login
- Cek Ketersediaan

---

## Login

- Email
- Password
- Remember Me

---

## Display Ruangan

Grid Card

Informasi:

- Foto
- Kapasitas
- Fasilitas

---

## Detail Ruangan

- Banner
- Kalender
- Form Booking

---

## Dashboard Admin

- Statistik
- Approval
- CRUD

---

# 14. Future Improvement

- Integrasi SSO UPI
- Email Notification
- WhatsApp Notification
- Export PDF
- Dashboard Statistik
- QR Code Booking
- Kalender Google
- Riwayat Aktivitas
- Audit Log