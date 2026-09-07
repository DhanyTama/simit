                        <?php
                            $con=mysqli_connect("localhost","root","","eit");
                            $tgl=date('Y-m');
                            if (!$con) {
                              die('Could not connect: ' . mysql_error());
                            }

                            
                            // Data for Sugar
                            $query = mysqli_query($con,"SELECT Komputer FROM grafik where tanggal like'%$tgl%'");
                            while ($p = mysqli_fetch_array($query)) { echo '"' . $p['Komputer'] . '",';}
                        ?>