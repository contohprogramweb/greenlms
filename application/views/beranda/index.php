 
<?php  if(calculate($bookcategorys)) { ?>
<div class="main-buku-category-list">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="theme_heading_green mb-0">Kategori Buku </h2>
			</div>
		</div>
		<div class="row">
			<?php foreach($bookcategorys as $kategori_buku) { ?>
				<div class="col-sm-2">
				    <div class="single-buku-category">
				        <div class="buku-category-image">
				            <img class="buku-category-thumbnail-image" src="<?=app_image_link($kategori_buku->coverphoto,'uploads/kategori_buku/','kategori_buku.jpg')?>" alt="<?=$kategori_buku->nama?>" />
				        </div>
				        <div class="buku-category-content">
				            <a href="<?=base_url()?>frontend/book_category/<?=$kategori_buku->bookcategoryID?>" class="buku-category-title"><?=$kategori_buku->nama?></a>
				        </div>
				    </div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php } ?>