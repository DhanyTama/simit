<?php
	//$tanggal = date("Y/m/d");
	//tgllapor='$tanggal'
    date_default_timezone_set('Asia/Jakarta');
	$tampil=mysqli_query($connect,"select * from pengunjung where status='Complete' order by id desc limit 1000");
?>

<!-- Basic Examples -->
          <!--  <div class="row clearfix"> -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA MAINTENANCE/TROUBLE/REQUEST IT COMPLETE ALL
                            </h2>
                            
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
											<th>Repair</th>
											<th>End date</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
									 <?php 
										$no=0;
									 	while($data=mysqli_fetch_array($tampil)){ 
										$no++;
										$cekidx = $data['id'];
									 ?>
										<tr>
											<td align="center"><?php echo $no?></td>
											<td><?php echo date ('d F Y',strtotime ($data['tgllapor']));echo" ["; echo $data['jamlapor']; echo"]";?></td>
											<td><?php echo $data['nama']; echo"<br>["; echo $data['depart'];  echo"]";?></td>
											<td><?php echo $data['jnskendala'];?><br>
                                                <a class="waves-effect m-b-15" role="button" data-toggle="collapse" href="#<?php echo $cekidx;?>" aria-expanded="false"
                                                   aria-controls="collapseExample">Detail...</a>

                                                <div class="collapse" id="<?php echo $cekidx;?>">
                                                    <i>
                                                        <br>Kerusakan : <br>[<?php echo $data['kerusakan'];?>]<br>
                                                        <br>Tindakan : <br>[<?php echo $data['tindakan'];?>]<br>
                                                        <br>Petugas IT : [<?php echo $data['petugas'];?>]
                                                        <br>Prioritas : [<?php echo $data['nama_prioritas'];?>]
                                                        <br>Kategori : [<?php echo $data['jenis'];?>]
														<br>Jenis Kendala : [<?php echo $data['kendala'];?>]<br>
														<br>Catatan : [<?php echo $data['noteperbaikan'];?>]
                                                    </i>
                                                </div> 
                                            </td>
                                            <td><?php echo $data['status']; ?></td>
                                            <td><?php echo $data['tglperbaikan'];echo" ["; echo $data['jamperbaikan']; echo"]";?></td>
                                            <td><?php echo $data['tglselesai'];echo" ["; echo $data['jamselesai']; echo"]";?></td>
										</tr>
									<?php   
									} 
									?>
								  	
									</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
       <!--     </div>  -->
            <!-- #END# Basic Examples -->