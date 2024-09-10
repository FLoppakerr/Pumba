new DataTable('#example', {
    layout: {
        topStart: {
            pageLength: {
                menu: [ 10, 25, 50, 100 ]
            }
        },
        topEnd: {
            search: {
                placeholder: 'Type search here'
            }
        },
        bottomEnd: {
            paging: {
                buttons: 3
            }
        }
    }
});