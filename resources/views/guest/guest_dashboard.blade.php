<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Trong blade layout -->


  <!-- Latest compiled JavaScript -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="shortcut icon" href="{{ asset('assets/images/logo.svg') }}" />
      <title>CDC -Contrustion</title>
  
      <style>
          * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
  }
  .error-message {
    color: red;
    font-size: 12px;
    margin-top: 5px;
}

input:invalid, textarea:invalid {
    border-color: red;
}

  .header {
      position: relative;
      width: 100%;
      height: 100vh; /* Chiều cao toàn màn hình */
      overflow: hidden;
      background-color: 
  }
  
  .navbar {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      color: white;
      padding: 15px;
      display: flex;
      justify-content: space-around; /* Căn đều các mục trong navbar */
      z-index: 10; /* Đặt navbar lên trên video */
  }
  
  .navbar ul {
      list-style: none;
      display: flex;
      gap: 20px; /* Khoảng cách giữa các mục */
  }
  
  .navbar a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
  }
  
  .video-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
  }
  
  .background-video {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Video sẽ bao phủ toàn bộ header mà không bị méo hình */
  }
      </style>
</head>

	
<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <header class="header ">
      
      <nav class="navbar navbar-expand-sm navbar-light px-5 ">
          <div class="">
              <a class="navbar-brand" href="#">
              <img style="width: 100px" src="{{ asset('image/logo.svg') }}" alt="TITC">
          </a>
          </div>
          <div class="">
              <ul class="navbar-nav ">
                  <li class="nav-item ms-2">
                      <a class="nav-link active text-dark" href="#">Trang chủ</a>
                  </li>
                  <li class="nav-item ms-2">
                      <a class="nav-link text-secondary" href="#gioithieu">Giới thiệu</a>
                  </li>
                  <li class="nav-item ms-2">
                      <a class="nav-link text-secondary" href="#project">Dự án và đang triển khai</a>
                  </li>
                  <li class="nav-item ms-2">
                      <a class="nav-link text-secondary" href="#linhvuc">Lĩnh vực hoạt động</a>
                  </li>
                  <li class="nav-item ms-2">
                      <a class="nav-link text-secondary" href="#lienhe">Liên hệ</a>
                  </li>
                  </ul>
          </div>
      </nav>
  



      <div class="video-container">
          <video autoplay muted loop playsinline class="background-video">
              <source src="{{ asset('image/Intro-Construction.mp4') }}" type="video/mp4">
          </video>
      </div>
      
  </header>


      <section class="container " id="gioithieu">
          <div class="py-3">
              <h1 class="mt-3 text-center " style="color: #ff6600">VỀ CHÚNG TÔI</h1>
          </div>
          <div class="text-center">
              Công ty Cổ phần Xây dựng CDC là doanh nghiệp hoạt động trong nhiều lĩnh vực: Tổng thầu xây dựng,  Thiết kế và thi công ...
          </div>
          <div class="text-center">
              <img  src="{{ asset('image/kt-1.jpg') }}" style="width:250px" alt="">
          </div>
          <div class="row mt-4 mb-5">
              <div class="col">
                  <h5 class="text-center">Tầm nhìn</h5>
                  <div class="h6">Trở thành tổng thầu hàng đầu của ngành xây dựng Việt Nam, vươn tầm quốc tế</div>
                  <div>CDC với Đội ngũ nhân sự trách nhiệm và trí tuệ, Hệ thống quản trị hiện đại và Công nghệ thi công tiên tiến kiến tạo nên những công trình chất lượng, đẳng cấp dẫn đầu ngành xây dựng Việt Nam, từng bước vươn tầm quốc tế.</div>
              </div>
              <div class="col">
                  <h5 class="text-center">Sứ mệnh</h5>
                  <div class="h6">Góp phần nâng cao vị thế ngành xây dựng Việt Nam bằng trách nhiệm và trí tuệ</div>
                  <div>Tổng thầu xây dựng CDC cam kết xây dựng nên những công trình có chất lượng vượt trội và quy mô tầm cỡ nhằm nâng cao vị thế ngành xây dựng Việt Nam; đồng thời mang lại sự hài lòng cao nhất cho Khách hàng và Đối tác, hướng đến sự phát triển bền vững.</div>
              </div>
              <div class="col">
                  <h5 class="text-center">Đổi mới</h5>
                  <div class="h6">CDC luôn lấy ĐỔI MỚI, sáng tạo làm nền tảng vững chãi nhất cho sự phát triển từ tốt đến vĩ đại.</div>
                  <div>Chủ động điều chỉnh nhanh nhất, hiệu quả nhất để bắt kịp xu hướng và đáp ứng nhu cầu của thị trường thông qua các giải pháp mới về công nghệ và kỹ thuật, kiến tạo nên những công trình đẳng cấp dẫn đầu ngành xây dựng.</div>
              </div>
              <div class="col">
                  <h5 class="text-center">Chất lượng</h5>
                  <div class="h6">CDC lấy CHẤT LƯỢNG làm kim chỉ nam cho mọi hành động</div>
                  <div>Luôn đặt trọng tâm vào chất lượng sản phẩm, chất lượng dịch vụ và mang đến sự hài lòng cao nhất cho Khách hàng và Đối tác, hướng đến sự phát triển bền vững.</div>
              </div>
              
          </div>
      </section>
      

  
  <section class="py-3 pb-5" style="background-color:  rgba(244, 244, 244, 0.939)" id="project">
      <h1 class="mt-3 text-center " style="color: #ff6600">DỰ ÁN TIÊU BIỂU</h1>
      <div class="text-center mt-4 mb-4">
          Các công trình CDC Xây Dựng thi công luôn đảm bảo 
          <span class="h6 mb-4">An toàn - Chất lượng - Tiến độ</span>

      </div>

      <!-- Carousel -->
      <div class="row">
        <div id="demo" class="carousel slide col-4 mx-auto" data-bs-ride="carousel">

            <!-- Indicators/dots -->
          
          
            <!-- The slideshow/carousel -->
            <div class="carousel-inner" > 
              <div class="carousel-item active">
                <img src="{{ asset('image/slideshow/1.jpg') }}" style="height:300px" alt="Los Angeles" class="d-block w-100">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('image/slideshow/2.jpg') }}" style="height:300px" alt="Chicago" class="d-block w-100">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('image/slideshow/3.jpg') }}" style="height:300px" class="d-block w-100">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('image/slideshow/4.jpg') }}" style="height:300px" class="d-block w-100">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('image/slideshow/5.jpg') }}" style="height:300px" class="d-block w-100">
              </div>
            </div>
          
            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
          </div>
      </div>
      
      
  </section>

  <section class="mt-3 container mb-5" id="linhvuc">
      <h1 class="text-center mb-2" style="color: #ff6600">LĨNH VỰC HOẠT ĐỘNG</h1>
      <div class="text-center mt-2">Với thế mạnh về đội ngũ cán bộ được đào tạo bài bản, trình độ chuyên môn cao, đã được tham gia qua nhiều dự án lớn và luôn luôn không ngừng học hỏi, đổi mới, sáng tạo.</div>
      <div class="text-center">Công ty Cổ phần Xây dựng CDC đã từng bước khẳng định được thương hiệu của mình.</div>
      <div class="mt-4 row ">
          <div class="col ">
              <div class="text-center"><img style="height:150px" src="{{ asset('image/k.jpg') }}" alt=""></div>
              <div class="h6 text-center mt-2">Xây dựng hạ tâng - giao thông</div>
              <div>
                Xây dựng hạ tầng - kỹ thuật là lĩnh vực quan trọng trong ngành xây dựng, chịu trách nhiệm phát triển và duy trì hệ thống cơ sở vật chất cần thiết cho sự vận hành của các khu dân cư, khu công nghiệp và các công trình công cộng khác.
            </div>
          </div>
          <div class="col">
              <div class="text-center"><img style="height:150px" src="{{ asset('image/k1.jpg') }}" alt=""></div>
              <div class="h6 text-center mt-2">Xây dựng dân dụng</div>
              <div>
                  Xây dựng dân dụng là lĩnh vực xây dựng các công trình phục vụ trực tiếp cho đời sống con người như nhà ở, chung cư, trường học, bệnh viện, và các công trình công cộng.
              </div>
          </div>
          <div class="col">
              <div class="text-center"><img style="height:150px" src="{{ asset('image/k2.jpg') }}" alt=""></div>
              <div class="h6 text-center mt-2">Xây dựng công nghiệp</div>
              <div>
                  Xây dựng công nghiệp chuyên về việc xây dựng các công trình phục vụ sản xuất và kinh doanh như nhà máy, xí nghiệp, kho bãi, và các công trình hạ tầng kỹ thuật. 
              </div>
          </div>
      </div>
  </section>

  <section class="p-3 pb-3 px-5"  id="lienhe">
      <h1 class="mt-3 text-center " style="color: #ff6600">LIÊN HỆ</h1>
      <div class="text-center mt-4">
          Các công trình CDC Xây Dựng thi công luôn đảm bảo 
          <span class="h6">An toàn - Chất lượng - Tiến độ</span>
      </div>
      <div class="row mt-4">
          <div class="col-5 mx-auto">
              <h6 class="text-center">Gửi yêu cầu tư vấn</h6>
              <div class="mt-3">Nếu bạn có thắc mắc gì, có thể gửi yêu cầu cho chúng tôi, và chúng tôi sẽ liên lạc với bạn sớm nhất có thể.</div>
              <div class="mt-3">
                <form action="{{ route('client.store') }}" method="POST" id="signupForm" class="signupForm">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="name">Tên:</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <div class="error-message" id="name-error"></div> <!-- Error message for name -->
                    </div>
                
                    <div class="mb-3 mt-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <div class="error-message" id="email-error"></div> <!-- Error message for email -->
                    </div>
                
                    <div class="mb-3 mt-3">
                        <label for="phone">Số điện thoại:</label>
                        <input class="form-control" value="(+84)" name="phone" id="phone" >
                        <div class="error-message" id="phone-error"></div> <!-- Error message for phone -->
                    </div>
                
                    <div class="mb-3 mt-3">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" class="form-control" name="address" id="addresss">
                        <div class="error-message " id="address-error"></div> <!-- Error message for address -->
                    </div>
                
                    <div class="mb-3 mt-3">
                        <label for="description">Mô tả yêu cầu:</label>
                        <textarea class="form-control" name="description" id="description" rows="6"></textarea>
                        <div class="error-message" id="description-error"></div> <!-- Error message for description -->
                    </div>
                
                    <div class="text-center">
                        <button class="btn btn-primary px-3" type="submit">Gửi</button>
                    </div>
                </form>
                
              </div>
          </div>
      </div>
      
  </section>

  @include('guest.body.footer')
</body>

    <script>
		@if(Session::has('message'))
			var type = "{{ Session::get('alert-type', 'info') }}";
			var message = "{!! Session::get('message') !!}";
			switch(type){
				case 'info':
					toastr.info(message);
					break;
				case 'success':
					toastr.success(message);
					break;
				case 'warning':
					toastr.warning(message);
					break;
				case 'error':
					toastr.error(message);
					break;
			}
		@endif
	</script>
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            // Ngừng gửi form nếu có lỗi
            event.preventDefault();
    
            // Lấy các giá trị của các trường
            let name = document.getElementById('name').value;
            let email = document.getElementById('email').value;
            let phone = document.getElementById('phone').value;
            let address = document.getElementById('addresss').value;
            let description = document.getElementById('description').value;
    
            let isValid = true; // Biến để kiểm tra tính hợp lệ
    
            // Reset các thông báo lỗi cũ
            document.querySelectorAll('.error-message').forEach(function(errorDiv) {
                errorDiv.textContent = '';
            });
    
            // Kiểm tra trường "Tên"
            if (!name.trim()) {
                document.getElementById('name-error').textContent = 'Tên không được để trống.';
                isValid = false;
            }
    
            // Kiểm tra trường "Email"
            let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!email.trim()) {
                document.getElementById('email-error').textContent = 'Email không được để trống.';
                isValid = false;
            } else if (!emailRegex.test(email)) {
                document.getElementById('email-error').textContent = 'Email không hợp lệ.';
                isValid = false;
            }
    
            // Kiểm tra trường "Số điện thoại"
            let phoneRegex = /^\(\+\d{2,3}\)\s?\d{4}-\d{4}$/;
            if (!phone.trim()) {
                document.getElementById('phone-error').textContent = 'Số điện thoại không được để trống.';
                isValid = false;
            } else if (!phoneRegex.test(phone)) {
                document.getElementById('phone-error').textContent = 'Số điện thoại không hợp lệ.';
                isValid = false;
            }
    
            // Kiểm tra trường "Địa chỉ"
            if (!address.trim()) {
                document.getElementById('address-error').textContent = 'Địa chỉ không được để trống.';
                isValid = false;
            }
    
            // Kiểm tra trường "Mô tả yêu cầu"
            if (!description.trim()) {
                document.getElementById('description-error').textContent = 'Mô tả yêu cầu không được để trống.';
                isValid = false;
            }
    
            // Nếu tất cả các trường hợp lệ, mới gửi form
            if (isValid) {
                document.getElementById('signupForm').submit(); // Gửi form nếu không có lỗi
            }
        });
    </script>
    
      
</html>