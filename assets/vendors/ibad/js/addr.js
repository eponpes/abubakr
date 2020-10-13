function get_cities_by_prov(province_id, regency_id){       
        
    $.ajax({       
        type   : "POST",
        url    : "<?php echo site_url('web/get_cities_by_prov'); ?>",
        data   : { province_id : province_id , regency_id: regency_id},               
        async  : false,
        success: function(response){                                                   
           if(response)
           {
               $('#add_regency_id').html(response);
            }
        }
    });  
                 
    
}

function get_district_by_city(regency_id, district_id){       
    
    $.ajax({       
        type   : "POST",
        url    : "<?php echo site_url('web/get_district_by_city'); ?>",
        data   : { regency_id : regency_id , district_id: district_id},               
        async  : false,
        success: function(response){                                                   
           if(response)
           {
               
                   $('#add_district_id').html(response);
               
           }
        }
    });  
                 
    
}

function get_villages_by_district(district_id, villages_id){       
        $.ajax({       
        type   : "POST",
        url    : "<?php echo site_url('web/get_villages_by_district'); ?>",
        data   : { district_id : district_id , villages_id: villages_id},               
        async  : false,
        success: function(response){                                                   
           if(response)
           {
              
                   $('#add_villages_id').html(response);
              
           }
        }
    });  
                 
    
}

function get_postal_code(){

    
        var urban = $('#add_villages_id option:selected').text();
        var sub_district = $('#add_district_id option:selected').text();
        var city = $('#add_regency_id option:selected').text();
        var province_code = $('#add_province_id option:selected').val();
    
    
    var kab = city.startsWith("KABUPATEN");
    var kota = city.startsWith("KOTA");

    if(kab){
        city = city.slice(10);
    } else if(kota){
        city = city.slice(5);
    }


    $.ajax({       
        type   : "POST",
        url    : "<?php echo site_url('web/get_postal_code'); ?>",
        data   : { urban : urban , sub_district : sub_district, city : city, province_code : province_code},               
        async  : false,
        success: function(response){                                                   
           if(response)
           {
               
                   $('#add_postal_code').val(response);
               
           } else {
            
                $('#add_postal_code').val("");
            
           }
        }
    }); 

    
}

        $('#add_province_id').select2({
            placeholder: 'Pilih Provinsi',
            language: "id"
        });
        $('#add_regency_id').select2({
            placeholder: 'Pilih Kota/Kab',
            language: "id"
        });
        $('#add_district_id').select2({
            placeholder: 'Pilih Kecamatan',
            language: "id"
        });
        $('#add_villages_id').select2({
            placeholder: 'Pilih Kelurahan',
            language: "id"
        });
        function change_school(url){
            if(url){
                window.location.href = url; 
            }
        }   