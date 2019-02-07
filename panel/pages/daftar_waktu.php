<?php
	if(!isset($_COOKIE['beeuser'])){
	header("Location: login.php");}
include "../../config/server.php";
if(isset($_REQUEST['aksi'])){
//echo "delete from cbt_waktu where Urut = '$_REQUEST[urut]'";
$sql = mysqli_query($sqlconn,"delete from cbt_ujian where Urut = '$_REQUEST[urut]'");
}


if(isset($_REQUEST['simpan'])){
	$sql = mysqli_query($sqlconn,"update cbt_ujian set XTokenUjian = '$_REQUEST[txt_token]', XKodeUjian = '$_REQUEST[txt_koduji]', XKodeKelas = '$_REQUEST[txt_kodkel]', XKodeJurusan = '$_REQUEST[txt_jur]',
	XSesi = '$_REQUEST[txt_sesi]', XKodeSoal = '$_REQUEST[txt_kodsoal]', XTglUjian = '$_REQUEST[txt_tuji]', XJamUjian = '$_REQUEST[txt_juji]', 
	XLamaUjian = '$_REQUEST[txt_durasi]', XBatasMasuk = '$_REQUEST[txt_bmasuk]', XTampil = '$_REQUEST[txt_hasil]', XStatusToken = '$_REQUEST[txt_statustoken]', XListening = '$_REQUEST[txt_listen]',
	XStatusUjian = '$_REQUEST[txt_suji]', XPdf = '$_REQUEST[txt_xpdf]',XFilePdf = '$_REQUEST[txt_filepdf]' 
	where Urut = '$_REQUEST[id]'");
}

if(isset($_REQUEST['tambah'])){

$sqlcek = mysqli_num_rows(mysqli_query($sqlconn,"select * from cbt_kelas where XKodeKelas = '$_REQUEST[txt_kodkel]'"));
	if($sqlcek>0){
	$message = "Kode Kelas SUDAH ADA";
	echo "<script type='text/javascript'>alert('$message');</script>";
	} else {
		if(!$_REQUEST['txt_kodkel']==""||!$_REQUEST['txt_jur']==""){
		$sql = mysqli_query($sqlconn,"insert into cbt_kelas (XKodeLevel, XNamaKelas, XKodeJurusan,XKodeKelas, XKodeSekolah) values  
		('$_REQUEST[txt_kodlev]','$_REQUEST[txt_namkel]','$_REQUEST[txt_jur]','$_REQUEST[txt_kodkel]','$_REQUEST[txt_kodesek]')");
		}
	}
}

$tgx = 29;
$blx = '09';
$thx = 2016;

$tglx = date("Y/m/d");
$jamx = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  
</head>

<body>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit & Hapus DataBase Ujian</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Data & Jadwal Ujian
                           
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
	                                    <th width="5%">No</th>
										<th width="15%">Kode Ujian</th>
                                        <th width="10%">Kelas</th>
                                        <th width="35%">Kode Mapel</th>                                           
                                        <th width="25%">Kode Soal</th>   
                                         <th width="15%">Tgl Ujian</th> 
                                         <th width="15%">Ujian Mulai </th> 
                                         <th width="15%">Ujian Tutup </th>	
                                          <th width="15%">Status</th>										 
                                        <th width="15%">Edit</th>  
                                 </tr>
                                </thead>
                                <tbody>
<?php 
$no=0;

$sql = mysqli_query($sqlconn,"select u.*,m.*,u.Urut as Urut,u.XKodeKelas as kokel from cbt_ujian u left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel 
left join cbt_paketsoal p on p.XKodeSoal = u.XKodeSoal where u.XStatusUjian='1'");
/*/
$sql = mysqli_query($sqlconn,"select u.*,m.*,u.Urut as Urut,u.XKodeKelas as kokel from cbt_ujian u left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel 
left join cbt_paketsoal p on p.XKodeSoal = u.XKodeSoal ");
/*/
					while($s = mysqli_fetch_array($sql)){ 
					
$time1 = "$s[XJamUjian]";
$time2 = "$s[XLamaUjian]";

$secs = strtotime($time2)-strtotime("00:00:00");
$jamhabis = date("H:i:s",strtotime($time1)+$secs);	
$sekarang = date("H:i:s");	
$tglsekarang = date("Y-m-d");	
$tglujian = "$s[XTglUjian]";	
$no++;		
								if($s['XStatusUjian']=="0"||$s['XStatusUjian']=="9"||$tglsekarang>$tglujian||$sekarang > $jamhabis){ 
										$status="Selesai dikerjakan";
										} 
										else if($tglsekarang==$tglujian&&$sekarang < $time1){
										$status="Akan dikerjakan";
										} else { 
										$status="Sedang dikerjakan";
								}
								?>
                                
                                    <tr class="odd gradeX">
                                        <td align="center"><input type="hidden" value="<?php echo $s['Urutan']; ?>" id="txt_mapel<?php echo $s['Urutan']; ?>"> <?php echo $no; ?></td>
											<input type="hidden" value="<?php echo $s['XKodeSoal']; ?>" id="txt_soal<?php echo $s['Urutan']; ?>">
										<td align="center"><?php echo $s['XKodeUjian']; ?></td>
                                        <td align="center"><?php echo $s['kokel']." - ".$s['XKodeJurusan'] ?></td> 
                                        <td align="center"><?php echo $s['XKodeMapel']." - ".$s['XNamaMapel']; ?></td>
                                        
                                        <td align="center"><?php echo $s['XKodeSoal']; ?></td>
                                        <td align="center"><?php echo $s['XTglUjian']; ?></td> 
										<td align="center"><?php echo $s['XJamUjian']; ?></td>
										<td align="center"><?php echo $s['XBatasMasuk']; ?></td>
                                        <td align="center"><?php echo $status; ?></td>						 
										<td align="center">	<?php echo "<a href='#myModal' id='custId' data-toggle='modal' data-id=".$s['Urut'].">"; ?>
                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button></a>
                                            
                                                           
                                    </tr>
 
 <script>
function myFunction<?php echo $s['Urut']; ?>() {
	alert(<?php echo $s['Urut']; ?>);
    document.getElementById("demo").innerHTML = "Hello World";
}
</script>
  <!-- Button trigger modal -->
                                    
                                        
                                <?php } ?>
                                   
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="well">
                                <h4><span style="color: #1B06CF;"><?php echo $skull; ?>-CBT</span></h4>
                                <p><b>Fitur Edit Seting Ujian :</b> Edit Kode Ujian, Kelas, Waktu, Tampil Nilai, Tampil Token pada login siswa dsb. 
								
                                </p>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
       
       
       
       
       
    <script src="../vendor/jquery/jquery-1.12.3.js"></script>
    <script src="../vendor/jquery/jquery.dataTables.min.js"></script>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    
	
	
	});
    </script>
    <script>$(document).ready(function() {
    var table = $('#example').DataTable();
 
    $('#example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );</script>
    
<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
				
                   
                    <h4 class="modal-title">Edit Jadwal dan Data Ujian</h4>
                </div>
                <div class="modal-body">
                    <div class="fetched-data"></div>
                </div>
                <div class="modal-footer">
                
                ( KODE KELAS  Harus sesuai template Excel kolom "B" )
                <br> ( JURUSAN/ROMBEL Harus sesuai template Excel kolom "D" )
                <br> ( Ujian : UH, UTS, UAS TO1 s/d TO5 )
		
                </div>
            </div>
        </div>
    </div>
 
  <script src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'edit_waktu.php',
                data :  'urut='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 
		  $('#myTam').on('show.bs.modal', function (e) {
           // var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'tambah_kelas.php',
                data :  'urut='+ rowid,
                success : function(data){
                $('.fetched-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 
    });
  </script>
 
</body>

</html>

 