<?php 
echo "<div class='paragraph-row'>
	<div class='column6'>"; 
		include "slide.php";
	echo "</div>
	<div class='column4 hidden-xs'>
		<div class='paragraph-row'>
			<div class='column12'>
				<a target='_BLANK' href='https://www.iegcodestore.my.id/'><img src='".base_url()."asset/foto_iklanatas/$ik1[gambar]' style='width:100%; height: 190px;'></a>
			</div>
		</div>
		<div class='paragraph-row'>
			<div class='column6' style='margin-top:10px'>
				<a target='_BLANK' href='https://www.iegcodestore.my.id/'><img src='".base_url()."asset/foto_iklanatas/$ik2[gambar]' style='width:100%; height: 180px;'></a>
			</div>
			<div class='column6' style='margin-top:10px'>
				<a target='_BLANK' href='https://www.iegcodestore.my.id/'><img src='".base_url()."asset/foto_iklanatas/$ik3[gambar]' style='width:100%; height: 180px;'></a>
			</div>
		</div>
	</div>
	<div class='column2 hidden-xs'>
		<a target='_BLANK' href='https://www.iegcodestore.my.id/'><img src='".base_url()."asset/foto_iklanatas/$ik4[gambar]' style='width:100%; min-height: 380px;'></a>
	</div>
</div>
<br>

<div class='row hidden-xs'>";
$kategori_button = $this->db->query("SELECT * FROM rb_kategori_produk ORDER BY RAND() DESC LIMIT 8");
foreach ($kategori_button->result_array() as $rows) {
	echo "<div class='col-md-3 col-xs-6' style='margin-bottom:5px'>
		<a style='border-radius:0px; text-align:left' class='btn btn-block btn-default' href='".base_url()."produk/kategori/$rows[kategori_seo]'> 
		<span class='glyphicon glyphicon-th-large'></span> $rows[nama_kategori]
		</a>
	</div>";
}
echo "</div><hr>";

$no = 1;
foreach ($kategori->result_array() as $kat) {
	$produk = $this->model_reseller->produk_perkategori(0,0,$kat['id_kategori_produk'],6);
		if ($no==2){
			echo "<div class='paragraph-row'>";
			$iklan = $this->db->query("SELECT * FROM iklantengah where judul like '%home%' ORDER BY id_iklantengah ASC LIMIT 3");
			foreach ($iklan->result_array() as $ia) {
				echo "<div class='column4'><a href='$ia[url]' target='_blank'>";
					$string = $ia['gambar'];
					if ($ia['gambar'] != ''){
						if(preg_match("/swf\z/i", $string)) {
							echo "<embed style='margin-top:-10px' src='".base_url()."asset/foto_iklantengah/$ia[gambar]' width='100%' height=90px quality='high' type='application/x-shockwave-flash'>";
						} else {
							echo "<img style='margin-top:-10px; margin-bottom:5px' width='100%' src='".base_url()."asset/foto_iklantengah/$ia[gambar]' title='$ia[judul]' />";
						}
					}
				echo "</a></div>";
			}
			echo "</div><br>";
		}

		echo "<p class='sidebar-title text-danger produk-title'><a href='".base_url()."produk/kategori/$kat[kategori_seo]'>$kat[nama_kategori]</a></p>
			<div class='container'>";
	    foreach ($produk->result_array() as $row){
	    $ex = explode(';', $row['gambar']);
	    if (trim($ex[0])==''){ $foto_produk = 'no-image.png'; }else{ $foto_produk = $ex[0]; }
	    if (strlen($row['nama_produk']) > 38){ $judul = substr($row['nama_produk'],0,38).',..';  }else{ $judul = $row['nama_produk']; }
	    $jual = $this->model_reseller->jual_reseller($row['id_reseller'],$row['id_produk'])->row_array();
	    $beli = $this->model_reseller->beli_reseller($row['id_reseller'],$row['id_produk'])->row_array();
	    if ($beli['beli']-$jual['jual']<=0){ $stok = '<b style="color:#000">Stok Habis</b>'; }else{ $stok = "<span style='color:green'>Stok ".($beli['beli']-$jual['jual'])." $row[satuan]</span>"; }

	    $disk = $this->model_app->view_where("rb_produk_diskon",array('id_produk'=>$row['id_produk']))->row_array();
	    $diskon = rupiah(($disk['diskon']/$row['harga_konsumen'])*100,0)."%";
	    if ($diskon>0){ $diskon_persen = "<div class='top-right'>$diskon</div>"; }else{ $diskon_persen = ''; }
	    if ($diskon>=1){ 
	    	$harga =  "<del style='color:#8a8a8a'><small>Rp ".rupiah($row['harga_konsumen'])."</small></del> Rp ".rupiah($row['harga_konsumen']-$disk['diskon']);
	    }else{
	    	$harga =  "Rp ".rupiah($row['harga_konsumen']);
	    }
	    echo "<div class='produk col-md-2 col-xs-6'>
	              <center>
	                
	                <div style='height:140px; overflow:hidden'>
	                  <a title='$row[nama_produk]' href='".base_url()."produk/detail/$row[produk_seo]'><img style=' min-height:140px; width:100%' src='".base_url()."asset/foto_produk/$foto_produk'></a>
	                  		$diskon_persen
	                </div>
	                <h4 class='produk-title'><a title='$row[nama_produk]' href='".base_url()."produk/detail/$row[produk_seo]'>$judul</a></h4>
	                <span class='harga'>$harga</span><br>
	                <i>$stok</i>
	                <br><small>$row[nama_kota]</small>";
	                
	                echo "</center>
	          </div>";

	      
	    }
	    echo "</div>";

	  echo "<div style='clear:both'><br></div>";

	$no++;
	  
}
?>
<br><br>
<!-- 
<div class="block">
<div class="block-content">
	<ul class="article-block-big">
	<?php 
			$no = 1;
			$hot = $this->model_utama->view_join_two('berita','users','kategori','username','id_kategori',array('utama' => 'Y','status' => 'Y'),'id_berita','DESC',0,6);
			foreach ($hot->result_array() as $row) {	
			$total_komentar = $this->model_utama->view_where('komentar',array('id_berita' => $row['id_berita']))->num_rows();
			$tgl = tgl_indo($row['tanggal']);
			echo "<li style='width:180px'>
					<div class='article-photo'>
						<a href='".base_url()."$row[judul_seo]' class='hover-effect'>";
							if ($row['gambar'] ==''){
								echo "<a class='hover-effect' href='".base_url()."$row[judul_seo]'><img style='height:110px; width:200px' src='".base_url()."asset/foto_berita/no-image.jpg' alt='' /></a>";
							}else{
								echo "<a class='hover-effect' href='".base_url()."$row[judul_seo]'><img style='height:110px; width:200px' src='".base_url()."/asset/foto_berita/$row[gambar]' alt='' /></a>";
							}
					echo "</a>
					</div>
					<div class='article-content'>
						<h4><a href='".base_url()."$row[judul_seo]'>$row[judul]</a><a href='".base_url()."$row[judul_seo].html' class='h-comment'>$total_komentar</a></h4>
						<span class='meta'>
							<a href='".base_url()."$row[judul_seo]'><span class='icon-text'>&#128340;</span>$row[jam], $tgl</a>
						</span>
					</div>
				  </li>";
			}
		?>
	
	</ul>
</div>
</div> -->


