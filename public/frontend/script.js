
const numberInput = document.getElementById('numberInput');

// Hàm định dạng số có dấu chấm
function formatNumberWithDots(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Xử lý khi người dùng nhập liệu vào input
numberInput.addEventListener('input', function (e) {
    // Lấy giá trị hiện tại và loại bỏ các dấu chấm cũ
    let value = e.target.value.replace(/\./g, '');

    // Chỉ giữ lại các ký tự số
    value = value.replace(/\D/g, '');

    // Định dạng lại với dấu chấm
    e.target.value = formatNumberWithDots(value);
});




