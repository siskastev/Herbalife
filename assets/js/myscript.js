const flashData = $('.flash-data').data('flashdata');

if(flashData){
	Swal.fire({
		  title: 'Sukses',
		  text : 'Data Kecamatan berhasil ' + flashData,
		  type : 'success'
		})}
	;

//tombol hapus
$('.tombol-hapus').on('click',function(e) {
	//mengcancel a hrefnya dulu
	e.preventDefault();
	const href = $(this).attr('href');

	Swal.fire({
  title: 'Apakah anda yakin ?',
  text: "",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Hapus Data'
}).then((result) => {
  if (result.value) {
     document.location.href = href;
  }
})

});