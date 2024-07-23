$(document).ready(function(){
    $('#provinces').change(function(){
        var province_id = $(this).val();
        if(province_id){
            $.ajax({
                type:'POST',
                url:'thai_area/get_amphures.php',
                data:{province_id: province_id},
                success:function(html){
                    $('#amphures').html(html);
                    $('#districts').html('<option value="">-กรุณาเลือกตำบล-</option>');
                }
            });
        } else {
            $('#amphures').html('<option value="">-กรุณาเลือกอำเภอ-</option>');
            $('#districts').html('<option value="">-กรุณาเลือกตำบล-</option>');
        }
    });

    $('#amphures').change(function(){
        var amphure_id = $(this).val();
        if(amphure_id){
            $.ajax({
                type:'POST',
                url:'thai_area/get_districts.php',
                data:{amphure_id: amphure_id},
                success:function(html){
                    $('#districts').html(html);
                }
            });
        } else {
            $('#districts').html('<option value="">-กรุณาเลือกตำบล-</option>');
        }
    });

    $('#districts').change(function() {
        var district_id = $(this).val();
        if (district_id) {
            $.ajax({
                type: 'POST',
                url: 'thai_area/get_zip_code.php',
                data: { district_id: district_id },
                success: function(response) {
                    $('#zip_code').html(response);
                }
            });
        } else {
            $('#zip_code').html('<option value="" selected disabled>-กรุณาเลือกรหัสไปรษณีย์-</option>');
        }
    });
});
