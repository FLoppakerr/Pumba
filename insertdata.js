function showinsertdataModal() {
    $('#modalContainer').load('insertdata.html', function() {
        $('#addCustomerModal').modal('show');
    });
}
