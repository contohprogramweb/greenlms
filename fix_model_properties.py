#!/usr/bin/env python3
"""
Script untuk memperbaiki referensi property model di controllers
dari $this->book_m menjadi $this->buku_m, dll.
"""

import os
import re

BASE_DIR = "/workspace/application"

# Mapping nama property model (lowercase)
MODEL_PROPERTY_MAPPING = {
    "book_m": "buku_m",
    "bookcategory_m": "kategoribuku_m",
    "bookissue_m": "peminjamanbuku_m",
    "bookitem_m": "itembuku_m",
    "chat_m": "obrolan_m",
    "dashboard_m": "dasbor_m",
    "ebook_m": "bukuelektronik_m",
    "emailsend_m": "kirimemail_m",
    "emailsetting_m": "pengaturanemail_m",
    "emailtemplate_m": "templatemail_m",
    "expense_m": "pengeluaran_m",
    "finehistory_m": "riwayatketerlambatan_m",
    "generalsetting_m": "pengaturanumum_m",
    "income_m": "pemasukan_m",
    "install_m": "instalasi_m",
    "libraryconfigure_m": "konfigurasiperpustakaan_m",
    "login_m": "masuk_m",
    "member_m": "anggota_m",
    "menu_m": "menu_m",
    "newsletter_m": "buletin_m",
    "order_m": "pesanan_m",
    "orderitem_m": "itempesanan_m",
    "paymentanddiscount_m": "pembayarandandiskon_m",
    "permissionlog_m": "catatanizin_m",
    "permissions_m": "izin_m",
    "rack_m": "rak_m",
    "requestbook_m": "permintaanbuku_m",
    "resetpassword_m": "aturulangikatasandi_m",
    "role_m": "peran_m",
    "smssetting_m": "pengaturansms_m",
    "smstemplate_m": "templatsms_m",
    "storebook_m": "toko_buku_m",
    "storebookcategory_m": "tokokategoribuku_m",
    "storebookimage_m": "gambar_toko_buku_m",
    "themesetting_m": "pengaturantema_m",
    "update_m": "pembaruan_m",
}

def get_all_php_files(directory):
    """Mendapatkan semua file PHP dalam direktori secara rekursif."""
    php_files = []
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.php'):
                php_files.append(os.path.join(root, file))
    return php_files

def update_model_properties(file_path, model_property_map):
    """Update semua referensi property model dalam sebuah file PHP."""
    try:
        with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        original_content = content
        
        # Update referensi property model: $this->book_m -> $this->buku_m
        for old_prop, new_prop in model_property_map.items():
            # Gunakan replace sederhana tanpa regex untuk menghindari masalah escape
            content = content.replace(f"$this->{old_prop}->", f"$this->{new_prop}->")
            content = content.replace(f"$this->{old_prop};", f"$this->{new_prop};")
            content = content.replace(f"$this->{old_prop} ", f"$this->{new_prop} ")
            content = content.replace(f"$this->{old_prop})", f"$this->{new_prop})")
            content = content.replace(f"$this->{old_prop},", f"$this->{new_prop},")
            content = content.replace(f"$this->{old_prop}]", f"$this->{new_prop}]")
            content = content.replace(f"$this->{old_prop}['", f"$this->{new_prop}['")
            content = content.replace(f'$this->{old_prop}["', f'$this->{new_prop}["')
        
        # Jika ada perubahan, simpan file
        if content != original_content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
        
        return False
    
    except Exception as e:
        print(f"Error processing {file_path}: {e}")
        return False

def main():
    print("=" * 60)
    print("MEMPERBAIKI REFERENSI PROPERTY MODEL DI CONTROLLERS")
    print("=" * 60)
    
    # Update semua file di controllers
    controllers_dir = os.path.join(BASE_DIR, "controllers")
    all_controller_files = get_all_php_files(controllers_dir)
    
    updated_count = 0
    for file_path in all_controller_files:
        if update_model_properties(file_path, MODEL_PROPERTY_MAPPING):
            updated_count += 1
            print(f"Updated: {os.path.relpath(file_path, BASE_DIR)}")
    
    # Juga update file di libraries yang mungkin menggunakan model properties
    libraries_dir = os.path.join(BASE_DIR, "libraries")
    if os.path.exists(libraries_dir):
        all_library_files = get_all_php_files(libraries_dir)
        for file_path in all_library_files:
            if update_model_properties(file_path, MODEL_PROPERTY_MAPPING):
                updated_count += 1
                print(f"Updated: {os.path.relpath(file_path, BASE_DIR)}")
    
    print("\n" + "=" * 60)
    print(f"SELESAI! File yang diupdate: {updated_count}")
    print("=" * 60)

if __name__ == "__main__":
    main()
