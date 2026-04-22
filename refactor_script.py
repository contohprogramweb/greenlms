#!/usr/bin/env python3
import os
import re

# Mapping tabel: English -> Indonesian
TABLE_MAPPINGS = {
    'bookcategory': 'kategori_buku',
    'storebookcategory': 'kategori_buku_toko',
    'paymentanddiscount': 'pembayaran_dan_diskon',
    'libraryconfigure': 'konfigurasi_perpustakaan',
    'generalsetting': 'pengaturan_umum',
    'emailsetting': 'pengaturan_surel',
    'emailtemplate': 'templat_surel',
    'permissionlog': 'catatan_izin',
    'requestbook': 'permintaan_buku',
    'resetpassword': 'reset_kata_sandi',
    'storebookimage': 'gambar_buku_toko',
    'storebook': 'buku_toko',
    'bookissue': 'peminjaman_buku',
    'orderitems': 'item_pesanan',
    'finehistory': 'riwayat_denda',
    'bookitem': 'item_buku',
    'newsletter': 'buletin',
    'ebook': 'buku_elektronik',
    'emailsend': 'kirim_email',
    'expense': 'pengeluaran',
    'income': 'pemasukan',
    'member': 'anggota',
    'orders': 'pesanan',
    'rack': 'rak',
    'role': 'peran',
    'book': 'buku',
    'chat': 'obrolan',
    'menu': 'menu',
    'permissions': 'izin',
    'updates': 'pembaruan',
}

# Mapping field per tabel (English -> Indonesian)
FIELD_MAPPINGS = {
    'bookID': 'id_buku',
    'bookCategoryID': 'id_kategori_buku',
    'bookIssueID': 'id_peminjaman',
    'bookItemID': 'id_item_buku',
    'bookNo': 'nomor_buku',
    'chatID': 'id_obrolan',
    'ebookID': 'id_buku_elektronik',
    'emailSendID': 'id_kirim_email',
    'emailTemplateID': 'id_templat_email',
    'expenseID': 'id_pengeluaran',
    'fineHistoryID': 'id_riwayat_denda',
    'incomeID': 'id_pemasukan',
    'libraryConfigureID': 'id_konfigurasi_perpustakaan',
    'memberID': 'id_anggota',
    'menuID': 'id_menu',
    'menuName': 'nama_menu',
    'menuLink': 'tautan_menu',
    'menuIcon': 'ikon_menu',
    'parentMenuID': 'id_menu_induk',
    'newsletterID': 'id_buletin',
    'orderItemID': 'id_item_pesanan',
    'orderID': 'id_pesanan',
    'storeBookID': 'id_buku_toko',
    'storeBookCategoryID': 'id_kategori_buku_toko',
    'storeBookImageID': 'id_gambar_buku_toko',
    'paymentAndDiscountID': 'id_pembayaran_dan_diskon',
    'permissionLogID': 'id_catatan_izin',
    'requestBookID': 'id_permintaan_buku',
    'resetPasswordID': 'id_reset_kata_sandi',
    'roleID': 'id_peran',
    'rackID': 'rackID',
    'updateID': 'id_pembaruan',
    'isbnNo': 'nomor_isbn',
    'coverImage': 'foto_sampul',
    'codeNo': 'nomor_kode',
    'editionNo': 'nomor_edisi',
    'editionDate': 'tanggal_edisi',
    'publishDate': 'tanggal_terbit',
    'deleted_at': 'dihapus_pada',
    'create_date': 'tanggal_dibuat',
    'create_member_id': 'id_anggota_pembuat',
    'create_role_id': 'id_peran_pembuat',
    'update_date': 'tanggal_diubah',
    'update_member_id': 'id_anggota_pengubah',
    'update_role_id': 'id_peran_pengubah',
    'name': 'nama',
    'author': 'penulis',
    'quantity': 'jumlah',
    'price': 'harga',
    'publisher': 'penerbit',
    'note': 'catatan',
    'status': 'status',
    'description': 'deskripsi',
    'dob': 'tanggal_lahir',
    'gender': 'jenis_kelamin',
    'religion': 'agama',
    'email': 'surel',
    'phone': 'telepon',
    'bloodGroup': 'golongan_darah',
    'address': 'alamat',
    'joinDate': 'tanggal_bergabung',
    'photo': 'foto',
    'username': 'nama_pengguna',
    'password': 'kata_sandi',
    'message': 'pesan',
    'file': 'file',
    'originalFileName': 'nama_file_asli',
    'subject': 'subjek',
    'senderName': 'nama_pengirim',
    'senderMemberID': 'id_anggota_pengirim',
    'senderRoleID': 'id_peran_pengirim',
    'optionKey': 'kunci_opsi',
    'optionValue': 'nilai_opsi',
    'template': 'templat',
    'priority': 'prioritas',
    'date': 'tanggal',
    'amount': 'jumlah',
    'bookStatusID': 'id_status_buku',
    'renewed': 'diperbarui',
    'fromDate': 'dari_tanggal',
    'toDate': 'ke_tanggal',
    'fineAmount': 'jumlah_denda',
    'maxBookBorrow': 'maksimal_buku_pinjaman',
    'maxRenewLimit': 'batas_maksimal_perpanjangan',
    'renewDaysLimit': 'hari_batas_perpanjangan',
    'finePerDay': 'denda_buku_per_hari',
    'borrowLimitAmount': 'jumlah_batas_pinjaman',
    'menuName': 'nama_menu',
    'verified': 'verifikasi',
    'created_at': 'dibuat_pada',
    'unitPrice': 'harga_satuan',
    'subTotal': 'sub_total',
    'mobile': 'seluler',
    'deliveryCharge': 'biaya_pengiriman',
    'total': 'total',
    'paymentStatus': 'status_pembayaran',
    'paymentMethod': 'metode_pembayaran',
    'paidAmount': 'jumlah_pembayaran',
    'discountAmount': 'jumlah_diskon',
    'others': 'lainnya',
    'active': 'aktif',
    'isbnNo': 'nomor_isbn',
    'code': 'kode',
    'version': 'versi',
    'fileName': 'nama_file',
    'clientName': 'nama_klien',
    'meta': 'meta',
}

def replace_table_names(content):
    result = content
    sorted_tables = sorted(TABLE_MAPPINGS.items(), key=lambda x: len(x[0]), reverse=True)
    for en_name, id_name in sorted_tables:
        # Replace quoted table names in PHP strings
        result = re.sub(rf"['\"]{en_name}['\"]", f"'{id_name}'", result)
        # Replace unquoted table names (word boundaries for SQL)
        result = re.sub(rf"\b{en_name}\b", id_name, result)
    return result

def replace_field_names(content):
    result = content
    sorted_fields = sorted(FIELD_MAPPINGS.items(), key=lambda x: len(x[0]), reverse=True)
    for en_name, id_name in sorted_fields:
        # Replace backtick-quoted field names (SQL)
        result = re.sub(rf"`{re.escape(en_name)}`", f"`{id_name}`", result)
        # Replace single/double quoted field names (PHP strings/arrays)
        result = re.sub(rf"['\"]{re.escape(en_name)}['\"]", f"'{id_name}'", result)
        # Replace object property access (->field)
        result = re.sub(rf"->{re.escape(en_name)}(?![a-zA-Z0-9_])", f"->{id_name}", result)
        # Replace array access ['field'] or ["field"]
        result = re.sub(rf"\['{re.escape(en_name)}'\]", f"['{id_name}']", result)
        result = re.sub(rf'\["{re.escape(en_name)}"\]', f'["{id_name}"]', result)
    return result

def refactor_file(filepath):
    try:
        with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        original_content = content
        content = replace_table_names(content)
        content = replace_field_names(content)
        if content != original_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
    except Exception as e:
        print(f"Error processing {filepath}: {e}")
    return False

def main():
    app_dir = '/workspace/application'
    modified_files = []
    skipped_files = []
    
    for root, dirs, files in os.walk(app_dir):
        for file in files:
            if file.endswith('.php'):
                filepath = os.path.join(root, file)
                if refactor_file(filepath):
                    modified_files.append(filepath)
    
    print(f"\n=== Summary ===")
    print(f"Total files modified: {len(modified_files)}")
    for f in sorted(modified_files):
        print(f"  - {f}")

if __name__ == '__main__':
    main()
