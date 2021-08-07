<?php /*<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('online_admission'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('online_admission'); ?></a></li>
        </ul>
    </div>
</section>*/ ?>
<section>
    <div class="container text-center">        
        <?php $this->load->view('layout/message'); ?> 
    </div>
</section>
<style>
    .navbar-custom {
        background: #253049;
    }
    </style>
<div class="top-header-100" style="margin-top: 100px; ">
&nbsp;
</div>
<section class="page-contact-area">
    <div class="container">
        <form action="<?php echo site_url('admission-online'); ?>" method="post" id="admission" name="admission" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="admission-form">
                    <div class="row"> 
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="admission-address">
                                <div><h3><?php echo $school->school_name; ?></h3></div>                                
                                <div><?php echo $school->address; ?></div>
                                <div><?php echo $school->phone; ?></div>
                                <div><?php echo $school->email; ?></div>
                                <div><h4><?php echo $this->lang->line('online_admission'); ?></h4></div>
                            </div>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><hr></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('basic_information'); ?>:</strong></p> </div>
                    </div>                     
                      
                      <div class="row">
                      <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                 <label for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                 <select  class="form-control col-md-7 col-xs-12 quick-field" name="class_id" id="add_class_id" required="required" onchange="get_section_by_class(this.value, '');">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php 
                                        $code = $_GET['code']; 
                                        if($code == 'pistol'){
                                            $post['class_id'] = '13';
                                        } else if($code == 'karantina'){
                                            $post['class_id'] = '14';
                                        } else if($code == 'workshop'){
                                            $post['class_id'] = '15';
                                        }
                                    ?>
                                    <?php foreach($classes as $obj){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('class_id'); ?></div>
                             </div>
                         </div>      
                      </div>
                    <div class="row">                  
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                <input  class="form-control col-md-12 col-xs-12"  name="name"  id="name" value="<?php echo isset($post['name']) ?  $post['name'] : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('name'); ?></div> 
                            </div>
                        </div>   
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="pob">Tempat <span class="required">*</span></label>
                                <input  class="form-control col-md-12 col-xs-12"  name="pob"  id="pob" value="<?php echo isset($post['pob']) ?  $post['pob'] : ''; ?>" placeholder="<?php echo $this->lang->line('pob'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('pob'); ?></div> 
                            </div>
                        </div>                   
                        <div class="col-md-4 col-sm-4 col-xs-12">
                             <div class="item form-group">
                                <label  for="dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                <input  class="form-control col-md-12 col-xs-12"  name="dob"  id="dob" value="<?php echo isset($post['dob']) ?  $post['dob'] : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('dob'); ?></div>
                             </div>
                        </div>  
                    </div>
                    <div class="row"> 
                         <div class="col-md-4 col-sm-4 col-xs-12">
                             <div class="item form-group">
                                 <label for="gender"><?php echo $this->lang->line('gender'); ?> <span class="required">*</span></label>
                                  <select  class="form-control col-md-12 col-xs-12"  name="gender"  id="gender" required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php $genders = get_genders(); ?>
                                    <?php foreach($genders as $key=>$value){ ?>
                                        <option value="<?php echo $key; ?>" <?php echo isset($post['gender']) && $post['gender'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('gender'); ?></div>
                             </div>
                         </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                            <label for="email"><?php echo $this->lang->line('email'); ?> </label>
                            <input  class="form-control col-md-12 col-xs-12"  name="email"  id="email" value="<?php echo isset($post['email']) ?  $post['email'] : ''; ?>" placeholder="<?php echo $this->lang->line('email'); ?>" type="email" autocomplete="off">
                            <div class="help-block"><?php echo form_error('email'); ?></div>
                            </div>
                        </div>                       
                       
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span></label>
                                <input  class="form-control col-md-12 col-xs-12"  name="phone"  id="phone" value="<?php echo isset($post['phone']) ?  $post['phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('phone'); ?></div>
                            </div>
                        </div>
                    </div>           
                    
                        
                    <div class="row">   
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="present_address"><?php echo $this->lang->line('present_address'); ?> </label>
                                 <textarea  class="form-control col-md-12 col-xs-12 textarea-4column"  name="present_address"  id="present_address"  placeholder="<?php echo $this->lang->line('present_address'); ?>"><?php echo isset($post['present_address']) ?  $post['present_address'] : ''; ?></textarea>
                                 <div class="help-block"><?php echo form_error('present_address'); ?></div>
                            </div>
                        </div>      
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="prov">Provinsi <span class="required">*</span></label><br>
                                <select  class="form-control col-md-12 col-xs-12"  name="province_id"  id="add_province_id" required="required" onchange="get_cities_by_prov(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach($provinces as $prov){ ?>
                                    <option value="<?php echo $prov->id; ?>" <?php echo isset($post['prov']) && $post['prov'] == $prov->id ?  'selected="selected"' : ''; ?>><?php echo $prov->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('prov'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                            <label for="regency_id">Kota <span class="required">*</span></label><br>
                            <select  class="form-control col-md-12 col-xs-12 quick-field" name="regency_id" id="add_regency_id" required="required"  onchange="get_district_by_city(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('regency_id'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                            <label for="district_id">Kecamatan <span class="required">*</span></label><br>
                            <select  class="form-control col-md-12 col-xs-12 quick-field" name="district_id" id="add_district_id" required="required"  onchange="get_villages_by_district(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('district_id'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                            <label for="district_id">Kelurahan <span class="required">*</span></label><br>
                            <select  class="form-control col-md-12 col-xs-12 quick-field" name="villages_id" id="add_villages_id" required="required" onchange="get_postal_code(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('villages_id'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                            <label for="postal_code">Kode Pos <span class="required">*</span></label>
                            <input  class="form-control col-md-12 col-xs-12"  name="postal_code"  id="add_postal_code" value="<?php echo isset($post['postal_code']) ?  $post['postal_code'] : ''; ?>" placeholder="<?php echo $this->lang->line('postal_code'); ?>"  type="text" autocomplete="off">
                            <div class="help-block"><?php echo form_error('postal_code'); ?></div>
                            </div>
                        </div>        
                   </div>
                <div class="row">
                   <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="totalmemo">Jumlah Hafalan (jika ada) </label>
                            <input  class="form-control col-md-12 col-xs-12"  name="totalmemo"  id="totalmemo" value="<?php echo isset($post['totalmemo']) ?  $post['totalmemo'] : ''; ?>" placeholder="Total Hafalan"  type="text" autocomplete="off">
                            <div class="help-block"><?php echo form_error('totalmemo'); ?></div> 
                        </div>
                    </div>                       

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="education">Pendidikan Terakhir</label>
                            <select  class="form-control col-md-12 col-xs-12"  name="education"  id="education">
                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            <?php $educations = get_educations(); ?>
                            <?php foreach($educations as $key=>$value){ ?>
                                <option value="<?php echo $key; ?>" <?php echo isset($post['education']) && $post['education'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                        <div class="help-block"><?php echo form_error('education'); ?></div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="job">Pekerjaan</label>
                            <select  class="form-control col-md-12 col-xs-12"  name="job"  id="job">
                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            <?php $jobs = get_jobs(); ?>
                            <?php foreach($jobs as $key=>$value){ ?>
                                <option value="<?php echo $key; ?>" <?php echo isset($post['job']) && $post['job'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                        <div class="help-block"><?php echo form_error('job'); ?></div>
                        </div>
                    </div>
                            </div>

                    
                    
                    <div class="ln_solid"><hr/></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 margin-top">
                        <button type="submit" class="btn btn-info glbscl-link-btn hvr-bs"> <?php echo $this->lang->line('submit'); ?></button>
                        <?php /*<a  class="btn btn-info glbscl-link-btn hvr-bs"  href="<?php echo site_url('admission-form'); ?>"> <i class="fa fa-print"></i>  <?php echo $this->lang->line('admission_form'); ?></a> */ ?>
                    </div>
                </div>
                </div>
            </div>         
        </div>
        </form>     
    </div>
</section>
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <script type="text/javascript">     
     
    $('#dob').datepicker({ startView: 2 });
    $('#admission').validate();
    
        
    function check_guardian_type(guardian_type){

         $('#relation_with').val('');  
         $('#gud_name').val('');  
         $('#gud_phone').val('');  
         $('#gud_present_address').val('');  
         $('#gud_permanent_address').val('');  
         $('#gud_religion').val(''); 
         $('#gud_profession').val(''); 
         $('#gud_national_id').val(''); 
         $('#gud_email').val(''); 
         $('#gud_other_info').val(''); 

        if(guardian_type == 'father'){

            $('#relation_with').val('<?php echo $this->lang->line('father'); ?>'); 
            $('.fn_existing_guardian').hide();
            $('.fn_except_exist').show();                          
            $('#gud_name').prop('required', true);               
            $('#gud_phone').prop('required', true);               
            $('#gud_email').prop('required', true);               

            var f_name = $('#father_name').val();
            var f_phone = $('#father_phone').val(); 
            var f_profession = $('#father_profession').val(); 

            $('#gud_name').val(f_name);  
            $('#gud_phone').val(f_phone); 
            $('#gud_profession').val(f_profession); 

        }else if(guardian_type == 'mother'){

            $('#relation_with').val('<?php echo $this->lang->line('mother'); ?>');   
            $('.fn_existing_guardian').hide();
            $('.fn_except_exist').show();            
            $('#gud_name').prop('required', true);               
            $('#gud_phone').prop('required', true);               
            $('#gud_email').prop('required', true); 

            var m_name = $('#mother_name').val();
            var m_phone = $('#mother_phone').val(); 
            var m_profession = $('#mother_profession').val(); 

            $('#gud_name').val(m_name);  
            $('#gud_phone').val(m_phone); 
            $('#gud_profession').val(m_profession); 

        }else if(guardian_type == 'other'){
            $('#relation_with').val('<?php echo $this->lang->line('other'); ?>');    
            $('.fn_existing_guardian').hide();
            $('.fn_except_exist').show();           
            $('#gud_name').prop('required', true);               
            $('#gud_phone').prop('required', true);               
            $('#gud_email').prop('required', true); 

        }else if(guardian_type == 'exist_guardian'){
            $('.fn_existing_guardian').show();
            $('.fn_except_exist').hide();            
            $('#gud_name').prop('required', false);               
            $('#gud_phone').prop('required', false);               
            $('#gud_email').prop('required', false); 

        }else{
             $('#relation_with').val('');   
             $('.fn_existing_guardian').hide();
             $('.fn_except_exist').show();             
             $('#gud_name').prop('required', true);               
             $('#gud_phone').prop('required', true);               
             $('#gud_email').prop('required', true); 
        }

     }
     
    $('#same_as_guardian').on('click', function(){
        
        if($(this).is(":checked")) {
            
            var present =  $('#gud_present_address').val();  
            var permanent = $('#gud_permanent_address').val(); 
            
            $('#present_address').val(present);  
            $('#permanent_address').val(permanent);  
        }else{
             $('#present_address').val('');  
             $('#permanent_address').val(''); 
        }
    });
        
         
    $('#fn_find').on('click', function(){
           
        var phone = $('#gud_phone').val();

        if(!phone){
            $('#gud_phone').focus();
            return false;
        }

        $.ajax({       
        type   : "POST",
        dataType: "json",
        url    : "<?php echo site_url('web/get_guardian_info'); ?>",
        data   : { phone : phone},               
        async  : true,
        success: function(response){ 
           if(response)
           {
                $('#guardian_id').val(response.id);  
                $('#gud_name').val(response.name);  
                $('#gud_email').val(response.email);  
                $('#gud_national_id').val(response.national_id);  
                $('#gud_profession').val(response.profession);  
                $('#gud_religion').val(response.religion);  
                $('#gud_present_address').val(response.present_address);  
                $('#gud_permanent_address').val(response.permanent_address); 
                $('#gud_phone').val(response.phone);                    

           }else{

                $('#guardian_id').val('');  
                $('#gud_name').val('');  
                $('#gud_email').val('');  
                $('#gud_national_id').val('');  
                $('#gud_profession').val('');  
                $('#gud_religion').val('');  
                $('#gud_present_address').val('');  
                $('#gud_permanent_address').val(''); 
                $('#gud_phone').val(''); 
                
                }
             }
         });  
     });
        
        
</script>
