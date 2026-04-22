#!/usr/bin/env python3
"""
Script untuk refactor nama folder dan file di application (controllers, models, views)
dari bahasa Inggris ke bahasa Indonesia, serta memperbarui semua referensi di kode program.
"""

import os
import re
import shutil

BASE_DIR = "/workspace/application"

# Mapping nama file/folder dari Inggris ke Indonesia
CONTROLLER_MAPPING = {
    "Backup.php": "Cadangan.php",
    "Book.php": "Buku.php",
    "Bookbarcode.php": "Kodebatangbuku.php",
    "Bookbarcodereport.php": "Laporankodebatangbuku.php",
    "Bookcategory.php": "Kategoribuku.php",
    "Bookissue.php": "Peminjamanbuku.php",
    "Bookissuereport.php": "Laporanpeminjamanbuku.php",
    "Bookreport.php": "Laporanbuku.php",
    "Dashboard.php": "Dasbor.php",
    "Ebook.php": "Bukuelektronik.php",
    "Emailsend.php": "Kirimemail.php",
    "Emailsetting.php": "Pengaturanemail.php",
    "Emailtemplate.php": "Templatemail.php",
    "Exceptionpage.php": "Halamaneksepsi.php",
    "Expense.php": "Pengeluaran.php",
    "Frontend.php": "Beranda.php",
    "Generalsetting.php": "Pengaturanumum.php",
    "Idcardreport.php": "Laporankartuidentitas.php",
    "Income.php": "Pemasukan.php",
    "Install.php": "Instalasi.php",
    "Libraryconfigure.php": "Konfigurasiperpustakaan.php",
    "Login.php": "Masuk.php",
    "Member.php": "Anggota.php",
    "Memberreport.php": "Laporananggota.php",
    "Menu.php": "Menu.php",
    "Myaccount.php": "Akunsaya.php",
    "Order.php": "Pesanan.php",
    "Paymentsetting.php": "Pengaturanpembayaran.php",
    "Permissionlog.php": "Catatanizin.php",
    "Permissions.php": "Izin.php",
    "Profile.php": "Profil.php",
    "Rack.php": "Rak.php",
    "Requestbook.php": "Permintaanbuku.php",
    "Role.php": "Peran.php",
    "Smssetting.php": "Pengaturansms.php",
    "Storebook.php": "Toko_buku.php",
    "Storebookcategory.php": "Tokokategoribuku.php",
    "Themesetting.php": "Pengaturantema.php",
    "Transactionreport.php": "Laporantransaksi.php",
    "Update.php": "Pembaruan.php",
}

MODEL_MAPPING = {
    "Book_m.php": "Buku_m.php",
    "Bookcategory_m.php": "Kategoribuku_m.php",
    "Bookissue_m.php": "Peminjamanbuku_m.php",
    "Bookitem_m.php": "Itembuku_m.php",
    "Chat_m.php": "Obrolan_m.php",
    "Dashboard_m.php": "Dasbor_m.php",
    "Ebook_m.php": "Bukuelektronik_m.php",
    "Emailsend_m.php": "Kirimemail_m.php",
    "Emailsetting_m.php": "Pengaturanemail_m.php",
    "Emailtemplate_m.php": "Templatemail_m.php",
    "Expense_m.php": "Pengeluaran_m.php",
    "Finehistory_m.php": "Riwayatketerlambatan_m.php",
    "Generalsetting_m.php": "Pengaturanumum_m.php",
    "Income_m.php": "Pemasukan_m.php",
    "Install_m.php": "Instalasi_m.php",
    "Libraryconfigure_m.php": "Konfigurasiperpustakaan_m.php",
    "Login_m.php": "Masuk_m.php",
    "Member_m.php": "Anggota_m.php",
    "Menu_m.php": "Menu_m.php",
    "Newsletter_m.php": "Buletin_m.php",
    "Order_m.php": "Pesanan_m.php",
    "Orderitem_m.php": "Itempesanan_m.php",
    "Paymentanddiscount_m.php": "Pembayarandandiskon_m.php",
    "Permissionlog_m.php": "Catatanizin_m.php",
    "Permissions_m.php": "Izin_m.php",
    "Rack_m.php": "Rak_m.php",
    "Requestbook_m.php": "Permintaanbuku_m.php",
    "Resetpassword_m.php": "Aturulangikatasandi_m.php",
    "Role_m.php": "Peran_m.php",
    "Smssetting_m.php": "Pengaturansms_m.php",
    "Smstemplate_m.php": "Templatsms_m.php",
    "Storebook_m.php": "Toko_buku_m.php",
    "Storebookcategory_m.php": "Tokokategoribuku_m.php",
    "Storebookimage_m.php": "Gambar_toko_buku_m.php",
    "Themesetting_m.php": "Pengaturantema_m.php",
    "Update_m.php": "Pembaruan_m.php",
}

VIEW_FOLDER_MAPPING = {
    "backup": "cadangan",
    "book": "buku",
    "bookbarcode": "kodebatangbuku",
    "bookcategory": "kategoribuku",
    "bookissue": "peminjamanbuku",
    "dashboard": "dasbor",
    "ebook": "bukuelektronik",
    "emailsend": "kirimemail",
    "emailsetting": "pengaturanemail",
    "emailtemplate": "templatemail",
    "expense": "pengeluaran",
    "frontend": "beranda",
    "generalsetting": "pengaturanumum",
    "income": "pemasukan",
    "install": "instalasi",
    "libraryconfigure": "konfigurasiperpustakaan",
    "login": "masuk",
    "member": "anggota",
    "menu": "menu",
    "order": "pesanan",
    "paymentsetting": "pengaturanpembayaran",
    "permissionlog": "catatanizin",
    "permissions": "izin",
    "profile": "profil",
    "rack": "rak",
    "report": "laporan",
    "requestbook": "permintaanbuku",
    "role": "peran",
    "smssetting": "pengaturansms",
    "storebook": "toko_buku",
    "storebookcategory": "tokokategoribuku",
    "themesetting": "pengaturantema",
    "update": "pembaruan",
}

def get_all_php_files(directory):
    """Mendapatkan semua file PHP dalam direktori secara rekursif."""
    php_files = []
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.php') or file.endswith('.html'):
                php_files.append(os.path.join(root, file))
    return php_files

def rename_controllers():
    """Rename file controller dari Inggris ke Indonesia."""
    controllers_dir = os.path.join(BASE_DIR, "controllers")
    renamed_map = {}
    
    for old_name, new_name in CONTROLLER_MAPPING.items():
        old_path = os.path.join(controllers_dir, old_name)
        new_path = os.path.join(controllers_dir, new_name)
        
        if os.path.exists(old_path):
            shutil.move(old_path, new_path)
            renamed_map[old_name.replace('.php', '')] = new_name.replace('.php', '')
            print(f"Renamed controller: {old_name} -> {new_name}")
    
    return renamed_map

def rename_models():
    """Rename file model dari Inggris ke Indonesia."""
    models_dir = os.path.join(BASE_DIR, "models")
    renamed_map = {}
    
    for old_name, new_name in MODEL_MAPPING.items():
        old_path = os.path.join(models_dir, old_name)
        new_path = os.path.join(models_dir, new_name)
        
        if os.path.exists(old_path):
            shutil.move(old_path, new_path)
            renamed_map[old_name.replace('.php', '')] = new_name.replace('.php', '')
            print(f"Renamed model: {old_name} -> {new_name}")
    
    return renamed_map

def rename_view_folders():
    """Rename folder view dari Inggris ke Indonesia."""
    views_dir = os.path.join(BASE_DIR, "views")
    renamed_map = {}
    
    for old_name, new_name in VIEW_FOLDER_MAPPING.items():
        old_path = os.path.join(views_dir, old_name)
        new_path = os.path.join(views_dir, new_name)
        
        if os.path.exists(old_path) and os.path.isdir(old_path):
            shutil.move(old_path, new_path)
            renamed_map[old_name] = new_name
            print(f"Renamed view folder: {old_name} -> {new_name}")
    
    return renamed_map

def update_references_in_file(file_path, controller_map, model_map, view_folder_map):
    """Update semua referensi nama file/folder dalam sebuah file PHP."""
    try:
        with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        original_content = content
        
        # Update referensi controller
        for old_name, new_name in controller_map.items():
            # Pattern untuk load controller: $this->load->controller('Oldname')
            patterns = [
                (f"controller('{old_name}", f"controller('{new_name}"),
                (f'controller("{old_name}', f'controller("{new_name}'),
                (f"controller('{old_name}/", f"controller('{new_name}/"),
                (f'controller("{old_name}/', f'controller("{new_name}/'),
                (f"'{old_name}.php'", f"'{new_name}.php'"),
                (f'"{old_name}.php"', f'"{new_name}.php"'),
                (f"site_url('{old_name}/", f"site_url('{new_name}/"),
                (f'site_url("{old_name}/', f'site_url("{new_name}/'),
                (f"base_url('{old_name}/", f"base_url('{new_name}/"),
                (f'base_url("{old_name}/', f'base_url("{new_name}/'),
                (f"/{old_name}/", f"/{new_name}/"),
                (f"class {old_name}", f"class {new_name}"),
                (f"extends {old_name}", f"extends {new_name}"),
            ]
            for pattern, replacement in patterns:
                content = re.sub(re.escape(pattern), replacement, content, flags=re.IGNORECASE)
        
        # Update referensi model
        for old_name, new_name in model_map.items():
            patterns = [
                (f"model('{old_name}", f"model('{new_name}"),
                (f'model("{old_name}', f'model("{new_name}'),
                (f"model('{old_name}_m',", f"model('{new_name}_m',"),
                (f'model("{old_name}_m",', f'model("{new_name}_m",'),
                (f"'{old_name}_m.php'", f"'{new_name}_m.php'"),
                (f'"{old_name}_m.php"', f'"{new_name}_m.php"'),
                (f"\$this->{old_name.lower()}->", f"$this->{new_name.lower()}->"),
                (f"\$this->{old_name}->", f"$this->{new_name}->"),
                (f"class {old_name}_m", f"class {new_name}_m"),
                (f"extends {old_name}_m", f"extends {new_name}_m"),
            ]
            for pattern, replacement in patterns:
                content = re.sub(re.escape(pattern), replacement, content, flags=re.IGNORECASE)
        
        # Update referensi view folder
        for old_name, new_name in view_folder_map.items():
            patterns = [
                (f"view('{old_name}/", f"view('{new_name}/"),
                (f'view("{old_name}/', f'view("{new_name}/'),
                (f"view('{old_name}", f"view('{new_name}"),
                (f'view("{old_name}', f'view("{new_name}'),
                (f"'{old_name}/", f"'{new_name}/"),
                (f'"{old_name}/', f'"{new_name}/'),
                (f"/{old_name}/", f"/{new_name}/"),
                (f"site_url('{old_name}", f"site_url('{new_name}"),
                (f'site_url("{old_name}', f'site_url("{new_name}'),
                (f"base_url('{old_name}", f"base_url('{new_name}"),
                (f'base_url("{old_name}', f'base_url("{new_name}'),
            ]
            for pattern, replacement in patterns:
                content = re.sub(re.escape(pattern), replacement, content, flags=re.IGNORECASE)
        
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
    print("MEMULAI REFACTORING NAMA FILE DAN FOLDER KE BAHASA INDONESIA")
    print("=" * 60)
    
    # Step 1: Rename controllers
    print("\n[1/4] Merename file controllers...")
    controller_map = rename_controllers()
    
    # Step 2: Rename models
    print("\n[2/4] Merename file models...")
    model_map = rename_models()
    
    # Step 3: Rename view folders
    print("\n[3/4] Merename folder views...")
    view_folder_map = rename_view_folders()
    
    # Step 4: Update semua referensi di file PHP
    print("\n[4/4] Memperbarui referensi di semua file PHP...")
    all_files = get_all_php_files(BASE_DIR)
    
    updated_count = 0
    for file_path in all_files:
        if update_references_in_file(file_path, controller_map, model_map, view_folder_map):
            updated_count += 1
            print(f"  Updated: {os.path.relpath(file_path, BASE_DIR)}")
    
    print("\n" + "=" * 60)
    print("REFACTORING SELESAI!")
    print(f"- Controllers yang direname: {len(controller_map)}")
    print(f"- Models yang direname: {len(model_map)}")
    print(f"- View folders yang direname: {len(view_folder_map)}")
    print(f"- File yang diupdate referensinya: {updated_count}")
    print("=" * 60)

if __name__ == "__main__":
    main()
