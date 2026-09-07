                        <?php
                            $con=mysqli_connect("localhost","root","","eit");
                            $tgl=date('2017-12');
                            if (!$con) {
                              die('Could not connect: ' . mysql_error());
                            }

                            
                            // Data for Sugar
                            $query = mysqli_query($con,"SELECT Komputer, Printer, Telepon, Iphone  FROM grafik where tanggal like'%$tgl%'");
                            while ($p = mysqli_fetch_array($query)) { echo '"' . $p['Komputer'] . '"+"' . $p['Printer'] . '"+"' . $p['Telepon'] . '",';}
                        ?>