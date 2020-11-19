<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-calculator"></i><small> Groups</small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
           
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li  class="<?php if(isset($single)){ echo 'active'; }?>"><a href="<?php echo site_url('groups/groups/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> Kelola Groups</a> </li>                          
                            
                         <li class="li-class-list">
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                             <select  class="form-control col-md-7 col-xs-12" onchange="get_invoice_by_school(this.value);">
                                     <option value="<?php echo site_url('accounting/invoice/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                 <?php foreach($schools as $obj ){ ?>
                                     <option value="<?php echo site_url('accounting/invoice/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                 <?php } ?>   
                             </select>
                         <?php } ?>  
                        </li>      
                            
                    </ul>
                    <br/>                    
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_invoice_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('invoice_number'); ?></th>
                                        <th><?php echo $this->lang->line('student'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('gross_amount'); ?></th>
                                        <th><?php echo $this->lang->line('discount'); ?></th>
                                        <th><?php echo $this->lang->line('net_amount'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($invoices) && !empty($invoices)){ ?>
                                        <?php foreach($invoices as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->custom_invoice_id; ?></td>
                                            <td><?php echo $obj->student_name; ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->gross_amount; ?></td>
                                            <td><?php echo $obj->discount; ?></td>
                                            <td><?php echo $obj->net_amount; ?></td>
                                            <td><?php echo get_paid_status($obj->paid_status); ?></td>
                                            <td>
                                                <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>
                                                    <a href="<?php echo site_url('accounting/invoice/view/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                    <?php if($obj->paid_status != 'paid'){ ?>
                                                        <a href="<?php echo site_url('accounting/payment/index/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('pay_now'); ?></a>
                                                    <?php } ?>  
                                                    
                                                <?php } ?> 
                                                <?php if(has_permission(DELETE, 'accounting', 'invoice')){ ?>
                                                    <?php //if($obj->paid_status == 'unpaid'){ ?>
                                                        <a href="<?php echo site_url('accounting/invoice/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                    <?php //} ?>
                                                <?php } ?>                                                       
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        
                        <?php if(isset($single)){ ?>
                        <div  class="tab-pane fade in <?php if(isset($single)){ echo 'active'; }?>" id="tab_single_invoice">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('groups/groups/add'), array('name' => 'single', 'id' => 'single', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="class_id"  id="class_id" required="required" onchange="get_student_by_class(this.value, '');" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($classes) && !empty($classes)){ ?>
                                                <?php foreach($classes as $obj ){ ?>
                                                    <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="student_id"><?php echo $this->lang->line('student'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="student_id[]"  id="student_id" required="required" onchange="reset_form_data()" multiple="multiple">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                      
                                        </select>
                                        <div class="help-block"><?php echo form_error('student_id'); ?></div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="teacher_id"><?php echo $this->lang->line('teacher'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="teacher_id"  id="teacher_id" required="required" onchange="reset_form_data()">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>   
                                        </select>
                                        <div class="help-block"><?php echo form_error('teacher_id'); ?></div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="updatetype">Tipe <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="updatetype"  id="updatetype" required="required">
                                            <option value="tahfidz">Tahfidz</option> 
                                            <option value="bpi">BPI</option>                                                                                 
                                        </select>
                                        <div class="help-block"><?php echo form_error('updatetype'); ?></div>
                                    </div>
                                </div>
                                    
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="single" name="type" />
                                        <a href="<?php echo site_url('groups/groups/add'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>
                        
                                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 
<script type="text/javascript"> 
    
    $("#month").datepicker( {
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"
    });

    
    function check_paid_status(paid_status) {

        if (paid_status == "paid") {   
            
            $('.fn_paid_status').show(); 
            $('#payment_method').prop('required', true);                

        } else{
            
            $('.fn_cheque').hide();           
            $('.fn_receipt').hide();           
            $('.fn_paid_status').hide();  
            $('#payment_method').prop('required', false);               
        }
        
        $("select#payment_method").prop('selectedIndex', 0);
    }
              
    function check_payment_method(payment_method) {

        if (payment_method == "cheque") {
            
            $('.fn_cheque').show();                
            $('.fn_receipt').hide();                
            $('#bank_name').prop('required', true);
            $('#cheque_no').prop('required', true);  
            $('#bank_receipt').prop('required', false);  
            
        }else if (payment_method == "receipt") {
            
            $('.fn_receipt').show();                
            $('.fn_cheque').hide();     
            $('#bank_receipt').prop('required', true);
            $('#bank_name').prop('required', false);
            $('#cheque_no').prop('required', false);                

        } else{
            
            $('.fn_cheque').hide();  
            $('.fn_receipt').hide();  
            $('#bank_name').prop('required', false);
            $('#cheque_no').prop('required', false); 
            $('#bank_receipt').prop('required', false); 
        } 
    }
          
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var class_id = '';       
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                     
                   $('#class_id').html(response); 
               }
               
               get_single_fee_type_by_school(school_id);
               get_bulk_fee_type_by_school(school_id);
            }
        });

        get_teachers();
    }); 
     

    // single
    function get_student_by_class(class_id, student_id){       
        
        var school_id = $('.fn_school_id').val();
               
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
                
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_student_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , student_id : student_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {     
                    $('#student_id').html(response); 
               }
            }
        });                 
        
    }

    // single
    function get_teachers(school_id, teacher_id){       
        
        var school_id = $('.fn_school_id').val();
               
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
                
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('groups/groups/get_teachers'); ?>",
            data   : {school_id:school_id, teacher_id : teacher_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {     
                    $('#teacher_id').html(response); 
               }
            }
        });                 
        
    }
   
   
  // single  
   function get_single_fee_type_by_school(school_id){
   
    $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_single_fee_type_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                    $('.fn_single_fee_item').html(response);
               }
            }
        });   
   }
   
    // single
    function get_single_fee_amount(income_head_id){
            
        var student_id = $('#student_id').val(); 
        var class_id = $('#class_id').val(); 
        var school_id = $('.fn_school_id').val();
        var amount = $('#amount').val();
        var check_status = '';
        
        if(!student_id){            
            toastr.error('<?php echo $this->lang->line('select_student'); ?>');
            $('#income_head_id_'+income_head_id).prop('checked', false);
            return false;
        }
        
        if($('#income_head_id_'+income_head_id).is(":checked")){
            check_status = true;           
        }else{
            check_status = false;
        }         
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_single_fee_amount'); ?>",
            data   : { school_id : school_id, income_head_id : income_head_id, class_id : class_id,  student_id:student_id, amount:amount, check_status:check_status},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   $('#amount').val(response);                     
               }
            }
        });  
   }
   
   
   
   //common
   function reset_form_data(){
      $('.fn_income_head_id').prop('checked', false);
      $('#amount').val('0.00');
      $('#month').val('');
      $('#is_applicable_discount').prop('selectedIndex', 0);
      $('#paid_status').prop('selectedIndex', 0);
      $('#payment_method').prop('selectedIndex', 0);
      $('#fn_student_container').html('');
      $('.fn_check_button').hide();
   }
   
   
   
 /* Bulk invoice */ 
    function get_bulk_fee_type_by_school(school_id){
   
    $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_bulk_fee_type_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                    $('.fn_bulk_fee_item').html(response);
               }
            }
        });   
   }
   
    function get_bulk_fee_amount(income_head_id){
            
        var school_id = $('.fn_school_id').val();
        var class_id = $('#class_id').val(); 
        var check_status = '';
        
        if(!class_id){            
            toastr.error('<?php echo $this->lang->line('select_class'); ?>');
            $('#income_head_id_'+income_head_id).prop('checked', false);
            return false;
        }
        
        if($('#income_head_id_'+income_head_id).is(":checked")){
            check_status = true;           
        }else{
            check_status = false;
        }  
        
        var head_ids = [];     
        $("input[name^='income_head_id']").each(function() {  
            if($(this).is(':checked')){
                head_ids += $(this).attr('itemid')+',';
             }
        });
       
                
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('accounting/invoice/get_bulk_fee_amount'); ?>",
            data   : { school_id:school_id, class_id:class_id, head_ids:head_ids},               
            async  : false,
            success: function(response){                                                   
               if(response == 'ay')
               {  
                    toastr.error('<?php echo $this->lang->line('set_academic_year_for_school'); ?>');
                    reset_form_data();                    
               }else{
                   $('#fn_student_container').html(response);
                   $('.fn_check_button').show(); 
               }
            }
        });  
    }

   // bulk
   $('#check_all').on('click', function(){
        $('#fn_student_container').children().find('input[type="checkbox"]').prop('checked', true);;
   });
   $('#uncheck_all').on('click', function(){
        $('#fn_student_container').children().find('input[type="checkbox"]').prop('checked', false);;
   });
  
 </script>
 
 
 
 <!-- datatable with buttons -->
 <script type="text/javascript">
        $(document).ready(function() {

        $('#student_id').select2({
            placeholder: 'Pilih Siswa',
            language: 'id',
        }); 

        $('#teacher_id').select2({
            placeholder: 'Pilih Guru',
            language: 'id',
        }); 

          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
        });
        
    $("#add").validate();     
    $("#bulk").validate();      
    $("#edit").validate(); 
    
     function get_invoice_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }  
    
</script>