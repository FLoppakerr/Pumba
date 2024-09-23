    document.getElementById('submitBtn').addEventListener('click', function(event) {
        var businessTypeInput = document.getElementById('business_type');
        var businessNameInput = document.getElementById('business_name');

        // ตรวจสอบว่าช่องประเภทธุรกิจว่างหรือไม่
        if (businessTypeInput.value.trim() === '') {
            // หากว่าง ให้เอาค่าจากช่องชื่อธุรกิจมาแทน
            businessTypeInput.value = businessNameInput.value;
        }
    });
