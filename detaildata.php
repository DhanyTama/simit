<div class="col-xs-12">
                            <div class="panel">
                                <header class="panel-heading">
                                    <b>Data Trouble atau Maintenace IT</b>

                                </header>
                                <!-- <div class="box-header"> -->
                                    <!-- <h3 class="box-title">Responsive Hover Table</h3> -->

                                <!-- </div> -->
                                <div class="panel-body table-responsive">
                                    <div class="box-tools m-b-15">
                                    <form action="index.php?p=detaildata" method="POST">
                                        <div class="input-group">
                                        <input type='text' class="form-control input-sm pull-right" style="width: 150px;"  name='qcari' placeholder='Nama/Kendala/Status' required /> 
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>    
                                    </div>
                                    <?php
									include 'pagination1.php';
                    $query1="select * from pengunjung order by id desc";
                    
                    if(isset($_POST['qcari'])){
	               $qcari=$_POST['qcari'];
	               $query1="SELECT * FROM  pengunjung 
	               where kendala like '%$qcari%'
	               or nama like '%$qcari%' or status like '%$qcari%'";
                    }
                    $tampil=mysql_query($query1) or die(mysql_error());
					//pagination config start
        $rpp = 10; // jumlah record per halaman
        $reload = "index.php?p=detaildata";
        $page = intval($_GET["page"]);
        if($page<=0) $page = 1;  
        $tcount = mysql_num_rows($tampil);
        $tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
        $count = 0;
        $i = ($page-1)*$rpp;
        $no_urut = ($page-1)*$rpp;
        //pagination config end
                    ?>
                                    <table id="example" class="table table-hover table-bordered">
                  <thead>
                      <tr>
					  	<th><center>Tgl </center></th>
                        <th><center>Jam </center></th>
                        <th><center>Jenis </center></th>  
                        <th><center>Nama </center></th>
                        <th><center>Departemen </center></th>
                        <th><center>Kendala </center></th>
                        <th><center>Deskripsi Kendala </center></th>
						<th><center>Petugas </center></th>
						<th><center>Tindakan </center></th>
						<th><center>Status </center></th>
                      </tr>
                  </thead>
                     <?php 
					  while(($count<$rpp) && ($i<$tcount)) {
                        mysql_data_seek($tampil,$i);
                        $data = mysql_fetch_array($tampil);
					
					
					?>
                    <tbody>
                    <tr>
                    <td><?php echo $data['tgllapor']; ?></td>
					<td><?php echo $data['jamlapor']; ?></td>
                    <td><?php echo $data['jamlapor']; ?></td>    
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['depart'];?></td>
                    <td><?php echo $data['kendala'];?></td>
                    <td><?php echo $data['jnskendala'];?></td>
                    <td><?php echo $data['petugas'];?></td>
                    <td><?php echo $data['tindakan'];?></td>
					<td><?php echo $data['status'];?></td>
					</tr>
                 <?php   
				 $i++; 
                        $count++;
              } 
              ?>
                   </tbody>
                   </table>
                   <center><?php echo paginate_one($reload, $page, $tpages); ?></center>
                  <?php $tampil=mysql_query("select * from pengunjung order by id");
                        $user=mysql_num_rows($tampil);
                    ?>
                  <center><h4>Jumlah : <?php echo "$user"; ?> Trouble/Maintenance IT  </h4> </center>
                  
                <div class="text-center" style="margin-top: 10px;">
                 <a href="index.php?p=detaildata" class="btn btn-sm btn-info">Refresh <i class="fa fa-refresh"></i></a>
				 
                </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>