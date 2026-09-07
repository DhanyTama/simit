<?php
$host="192.168.1.200";
$user="postgres";
$password="postgres";
$port="5432";
$dbname="anwar_medika";
$koneksi= pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password") or die("Koneksi gagal");	   
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>
<table width='100%' cellpadding=0 border='1' cellspacing='0' align='center'>
	<tr>
	<th align='center' width='20' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
	<th align='center' width='20' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Norm</th>
	<th align='left' width='600' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Nama</th>
	<th align='center' width='20' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tanggal</th>
	<th align='center' width='20' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Produk</th>
	<th align='center' width='20' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Dokter</th>
	</tr>
				<?php 
				$no = 0;
				
				$query = pg_query($koneksi,"SELECT hmis_journal.journal_internal_number,hmis_product_transaction_selling.journal_department_name, hmis_product_transaction_selling.relation_name, hmis_product_transaction_selling.relation_code,
											hmis_product_transaction_selling.relation_department_name, hmis_product_transaction_selling.contract_name, 
											hmis_product_transaction_selling.mediator_name, hmis_product_transaction_selling.transaction_date, hmis_product_transaction_selling.product_name, 
											hmis_product_transaction_selling.billing_group, hmis_product_transaction_selling.quantity, hmis_product_transaction_selling.price, hmis_product_transaction_selling.total
											FROM public.hmis_journal hmis_journal, public.hmis_product_transaction_selling hmis_product_transaction_selling
											WHERE ('2016-09-01 00:00:01'<=hmis_journal.journal_date) AND (hmis_journal.journal_date<='2016-09-30 00:00:01')
											 AND (hmis_journal.journal_name='PEMBAYARAN-NURSING') AND (hmis_product_transaction_selling.journal_id=hmis_journal.id And 
											 hmis_product_transaction_selling.journal_id=hmis_journal.id) AND (hmis_product_transaction_selling.bl_state='A') and (billing_group='11H')
											 order by hmis_journal.journal_internal_number asc");
				while ($d = pg_fetch_array($query)){					
					$no++;
					?>
					<tr>
						<td style='border:1px solid #000; padding: 0px;' width='20' align='center'><?php echo $no;?></td>
						<td style='border:1px solid #000; padding: 0px;' width='600' align='left'><?php echo $d[relation_code]; ?></td>
						<td style='border:1px solid #000; padding: 0px;' width='600' align='left'><?php echo $d[relation_name]; ?></td>
						<td style='border:1px solid #000; padding: 0px;' width='600' align='left'><?php echo $d[transaction_date]; ?></td>						
						<td style='border:1px solid #000; padding: 0px;' width='600' align='left'><?php echo $d[product_name]; ?></td>						
						<td style='border:1px solid #000; padding: 0px;' width='600' align='left'><?php echo $d[mediator_name]; ?></td>
					</tr>
				<?php }	?>
</table>
				