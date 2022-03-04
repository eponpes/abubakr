<style id="table_style" type="text/css">
    body
    {
        font-family: Arial;
        font-size: 10pt;
    }
    table
    {
        border: 1px solid #ccc;
        border-collapse: collapse;
    }
    table th
    {
        background-color: #F7F7F7;
        color: #333;
        font-weight: bold;
    }
    table th, table td
    {
		display: table-cell;
		vertical-align: inherit;
    }
	@media print
	{    
		.no-print, .no-print *
		{
			display: none !important;
		}
	}
</style>

<table id="detail-payment-table" class="slip-table table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
		<tr>
			<td colspan="4">
				<table cellspacing="0" width="100%" style="border:none">
					<tr>
						<th>Nama</th>
						<td><?php echo $payment->name; ?></td>        
						<th>Golongan</th>
						<td><?php echo $payment->grade_name; ?></td>
					</tr>
					<tr>
						<th>Unit</th>
						<td><?php echo $payment->school_name; ?></td>        
						<th>Bulan</th>
						<td><?php echo date('M Y', strtotime('1-'.$payment->salary_month)); ?></td>
					</tr>
					<tr>
						<th>Tahun Masuk</th>
						<td>-</td>        
						<th>Jumlah Anak</th>
						<td>-</td>
					</tr>
				</table>
			</td>
			<td rowspan="6">
				<div class="slip-top no-print">
					<div class="card-logo" style="text-align: center;">
						<?php  if($setting->school_logo != ''){ ?>
							<img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->school_logo; ?>" alt="" /> 
						<?php }else if($school->logo){ ?>
							<img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
						<?php }else if($school->frontend_logo){ ?>
							<img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
						<?php }else{ ?>                                                        
							<img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
						<?php } ?>                                                          
					</div>
					<div class="card-school" style="text-align: center; margin-bottom: 50px;">
						<h4>SLIP GAJI</h4>
						<h6>4 MARET 2022</h6>
						<h6>2 SYA'BAN 1443H</h6>
					</div>
					<div class="card-sign" style="text-align: center;">
						Yang Menyerahkan:
						<br><br><br>
						<u>VERA APNIA HANDAYANI, S.Pd.</u> 
						<br/>
						Kepala Sekolah
					</div>
				</div>
			</td>
		</tr>
		
		<?php if(strtolower($payment->salary_type) == 'monthly'){ ?>

		<tr>
			<td colspan="2">
				<table cellspacing="0" width="100%" style="border:none">
				<tr>
					<td colspan="2"><h4>Penghasilan</h4></td>
				</tr>
				<tr>
					<th>Gaji Pokok</th>
					<td><?php echo moneyformat($payment->basic_salary); ?></td>
				</tr>
				<tr>
					<th>Transport</th>
					<td><?php echo moneyformat($payment->transport); ?></td>
				</tr>
				<tr>
					<th>T. Pengabdian</th>
					<td><?php echo moneyformat($payment->devotion); ?></td>
				</tr>
				<tr>
					<th>T. Keluarga</th>
					<td><?php echo moneyformat($payment->family); ?></td>
				</tr>
				<tr>
					<th>T. Anak</th>
					<td><?php echo moneyformat($payment->child); ?></td>
				</tr>
				<tr>
					<th>T. Jabatan</th>
					<td><?php echo moneyformat($payment->position); ?></td>
				</tr>
				<tr>
					<th>Wali Kelas</th>
					<td><?php echo moneyformat($payment->guardian); ?></td>
				</tr>
				<tr>
					<th>Gugus</th>
					<td><?php echo moneyformat($payment->cluster); ?></td>
				</tr>
				<tr>
					<th>PJ Kegiatan</th>
					<td><?php echo moneyformat($payment->person_in_charge); ?></td>
				</tr>
				<tr>
					<th>Konsumsi</th>
					<td><?php echo moneyformat($payment->consumtion); ?></td>
				</tr>
				<tr>
					<td colspan="2"><h4>Fasilitas Non Cash</h4></td>
				</tr>
				<tr>
					<th>Fasilitas BPJS</th>
					<td><?php echo moneyformat($payment->medical); ?></td>
				</tr>
				</table>
			</td>
			<td colspan="2">
				<table cellspacing="0" width="100%" style="border:none">
				<tr>
					<td colspan="2"><h4>Honor</h4></td>
				</tr>
				<tr>
					<th>Honor Keg. Lain</th>
					<td><?php echo moneyformat($payment->other_bonus); ?></td>
				</tr>
				<tr>
					<th>Koreksi Gaji</th>
					<td><?php echo moneyformat($payment->salary_correction); ?></td>
				</tr>
				<tr>
					<th>Dankes</th>
					<td><?php echo moneyformat($payment->health_fund); ?></td>
				</tr>
				<tr>
					<th>Honor PAS</th>
					<td><?php echo moneyformat($payment->exam_bonus); ?></td>
				</tr>
				<tr>
					<td colspan="2"><h4>Potongan</h4></td>
				</tr>
				<tr>
					<th>Ketidakhadiran</th>
					<td><?php echo moneyformat($payment->absence); ?></td>
				</tr>
				<tr>
					<th>Keterlambatan</th>
					<td><?php echo moneyformat($payment->lateness); ?></td>
				</tr>
				<tr>
					<th>Administrasi Anak</th>
					<td><?php echo moneyformat($payment->child_administration); ?></td>
				</tr>
				<tr>
					<th>BPJS Mandiri</th>
					<td><?php echo moneyformat($payment->self_medical); ?></td>
				</tr>
				<tr>
					<th>Qurban/Pot Pernikahan</th>
					<td><?php echo moneyformat($payment->qurban_or_wedding); ?></td>
				</tr>
				<tr>
					<th>Pinjaman Sekolah</th>
					<td><?php echo moneyformat($payment->school_loan); ?></td>
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="4"><h4>Total Gaji Diterima: <?php echo moneyformat($payment->net_salary); ?></h4></td>
		</tr>
        
        <?php } ?>
        
        <tr>
            <th><?php echo $this->lang->line('payment_method'); ?></th>
            <td colspan="3"><?php echo $this->lang->line($payment->payment_method); ?></td>
        </tr>
        
        <?php if($payment->payment_method == 'cheque'){ ?>
            <tr>
                <th><?php echo $this->lang->line('bank_name'); ?></th>
                <td ><?php echo $payment->bank_name; ?></td>            
                <th><?php echo $this->lang->line('cheque_number'); ?></th>
                <td ><?php echo $payment->cheque_no; ?></td>
            </tr>
        <?php } ?> 
            
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td colspan="3"><?php echo $payment->note; ?></td>
        </tr>
            
    </tbody>
</table>
<input type="button" onclick="PrintTable();" value="Print"/>

<script type="text/javascript">
    function PrintTable() {
        var printWindow = window.open();
        printWindow.document.write('<html><head><title>SLIP GAJI</title>');
 
        //Print the Table CSS.
        var table_style = document.getElementById("table_style").innerHTML;
        printWindow.document.write('<style type = "text/css">');
        printWindow.document.write(table_style);
        printWindow.document.write('</style>');
        printWindow.document.write('</head>');
 
        //Print the DIV contents i.e. the HTML Table.
        printWindow.document.write('<body>');
        var divContents = document.getElementById("detail-payment-table").innerHTML;
        printWindow.document.write(divContents);
        printWindow.document.write('</body>');
 
        printWindow.document.write('</html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>