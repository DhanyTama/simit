
                                    <?php
                   
                    
	              
	               $query1="SELECT tgllapor, jnskendala, kendala, petugas, tglperbaikan, jamperbaikan, status
							FROM pengunjung
							WHERE tgllapor like '%$_GET[tahunsim]-$_GET[bulansim]%' 
							AND depart='$_GET[depart]'";
                    
                    $tampil=mysql_query($query1) or die(mysql_error());
					$departemen = $_GET['depart'];
                    ?>
                  <table id="example" class="table table-hover table-bordered">
                  <thead>
				  <tr>
				  	<td colspan="7">Departemen &nbsp; : &nbsp;[<?php echo $departemen; ?>]</td>
				  </tr>
                      <tr>
                        <th><center>Tgl Lapor </center></th>
                        <th><center>Deskripsi Kendala </center></th>
                        <th><center>Jenis Kendala </center></th>
                        <th><center>Petugas </center></th>
                        <th><center>Tgl Perbaikan </center></th>
                        <th><center>Jam Perbaikan </center></th>
						<th><center>Jam Status </center></th>
                      </tr>
                  </thead>
                     <?php while($data=mysql_fetch_array($tampil))
                    { ?>
                    
                    <tr>
                    <td><?php echo $data['tgllapor']; ?></td>
                    <td><?php echo $data['jnskendala'];?></td>
                    <td><?php echo $data['kendala'];?></td>
                    <td><?php echo $data['petugas'];?></td>
					<td><?php echo $data['tglperbaikan'];?></td>
                    <td><?php echo $data['jamperbaikan'];?></td>
					<td><?php echo $data['status'];?></td>
					</tr></div>
                 <?php   
              } 
              ?>
                   
                   </table>
 