function showModal() {
    fetch('insertdata.html')
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalContainer').innerHTML = html;
            $('#addCustomerModal').modal('show');
        })
        .catch(error => console.error('Error loading modal:', error));
}
