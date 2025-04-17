//INDEX
const pause = document.getElementById('myCarousel');

  // Dừng carousel khi trỏ chuột vào
  myCarousel.addEventListener('mouseenter', function () {
    myCarousel.carousel('pause');
  });

  // Tiếp tục chạy carousel khi rời chuột ra
  myCarousel.addEventListener('mouseleave', function () {
    myCarousel.carousel('cycle');
  });


// REGISTER
document.addEventListener("DOMContentLoaded", function() {
    // Lấy các phần tử cần sử dụng
    var passwordInput = document.getElementById("password");
    var confirmPWInput = document.getElementById("confirmPW");
    var registerBtn = document.getElementById("registerBtn");
    var messageDiv = document.getElementById("message");
  
    // Thêm sự kiện click vào nút Register
    registerBtn.addEventListener("click", function(event) {
      // Lấy giá trị của mật khẩu và mật khẩu xác nhận
      var password = passwordInput.value;
      var confirmPW = confirmPWInput.value;
  
      // Kiểm tra xem mật khẩu và mật khẩu xác nhận có trùng nhau
      if (password === confirmPW) {
        alert("Đăng ký thành công!");

      } else {
        alert("Đăng ký không thành công. Kiểm tra lại mật khẩu!");
        // Ngăn chặn sự kiện mặc định (form submission)
        event.preventDefault();
      }
    });
  });

// PRODUCT 




  