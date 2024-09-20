new DataTable('#example', {
    layout: {
        topStart: {
            pageLength: {
                menu: [ 10, 25, 50, 100 , 500 , 1000]
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
$(document).ready(function() {
    $('#example').DataTable().destroy();  // ทำลาย DataTable ก่อน
    $('#example').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 0 },  // ปิดการ sorting ในคอลัมน์ checkbox
            { "orderable": true, "targets": '_all' }  // เปิดการ sorting ในคอลัมน์อื่นๆ
        ]
    });
});

const slider = document.querySelector('.table-responsive');
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', (e) => {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});

slider.addEventListener('mouseleave', () => {
  isDown = false;
  slider.classList.remove('active');
});

slider.addEventListener('mouseup', () => {
  isDown = false;
  slider.classList.remove('active');
});

slider.addEventListener('mousemove', (e) => {
  if (!isDown) return;  // ออกถ้าไม่ได้คลิกเมาส์
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const walk = (x - startX) * 2; // ความเร็วในการเลื่อน
  slider.scrollLeft = scrollLeft - walk;
});
