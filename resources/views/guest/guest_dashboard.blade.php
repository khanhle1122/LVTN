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

	<!-- core:css -->
	<link rel="stylesheet" href="../../../assets/vendors/core/core.css">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="../../../assets/vendors/select2/select2.min.css">
	<link rel="stylesheet" href="../../../assets/vendors/jquery-tags-input/jquery.tagsinput.min.css">
	<link rel="stylesheet" href="../../../assets/vendors/dropzone/dropzone.min.css">
	<link rel="stylesheet" href="../../../assets/vendors/dropify/dist/dropify.min.css">
	<link rel="stylesheet" href="../../../assets/vendors/pickr/themes/classic.min.css">
	<link rel="stylesheet" href="../../../assets/vendors/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../../../assets/vendors/flatpickr/flatpickr.min.css">
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="../../../assets/fonts/feather-font/css/iconfont.css">
	<link rel="stylesheet" href="../../../assets/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->
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
      <div class="text-center mt-4">
          Các công trình CDC Xây Dựng thi công luôn đảm bảo 
          <span class="h6">An toàn - Chất lượng - Tiến độ</span>

      </div>

      <div id="demo" class="carousel slide mx-auto mt-5" data-bs-ride="carousel" style="width: 500px;height:300px">

          <!-- Indicators/dots -->
          
          
          <!-- The slideshow/carousel -->
          <div class="carousel-inner text-center">
            <div class="carousel-item active">
              <img style="height:300px" src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
              <div class="carousel-caption">
                <h3>Los Angeles</h3>
                <p>We had such a great time in LA!</p>
              </div>
            </div>
            <div class="carousel-item">
              <img style="height:300px" src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
              <div class="carousel-caption">
                <h3>Chicago</h3>
                <p>Thank you, Chicago!</p>
              </div> 
            </div>
            <div class="carousel-item">
              <img style="height:300px" src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
              <div class="carousel-caption">
                <h3>New York</h3>
                <p>We love the Big Apple!</p>
              </div>  
            </div>
          </div>
          
          <!-- Left and right controls/icons -->
         
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
                          <label for="">Tên:</label>
                          <input type="text" class="form-control" name="name" id="name">
                      </div>
                      <div class="mb-3 mt-3">
                        <label for="">Email:</label>
                        <input  type="email" class="form-control" name="email" id="email">
                    </div>
                      <div class="mb-3 mt-3">
                          <label for="">Số điện thoại:</label>
                          <input  class="form-control" name="phone" id="phone" data-inputmask-alias="(+99) 9999-9999">
                      </div>

                      <div class="mb-3 mt-3">
                          <label for="">Địa chỉ:</label>
                          <input type="text" class="form-control" name="address" id="addresss">
                      </div>
                     
                      <div class="mb-3 mt-3">
                          <label for="">Mô tả yêu cầu:</label>
                            <textarea class="form-control" name="description" id="description" rows="6"></textarea>
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

	<!-- core:js -->
	<script src="../../../assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<script src="../../../assets/vendors/jquery-validation/jquery.validate.min.js"></script>
	<script src="../../../assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
	<script src="../../../assets/vendors/inputmask/jquery.inputmask.min.js"></script>
	<script src="../../../assets/vendors/select2/select2.min.js"></script>
	<script src="../../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
	<script src="../../../assets/vendors/jquery-tags-input/jquery.tagsinput.min.js"></script>
	<script src="../../../assets/vendors/dropzone/dropzone.min.js"></script>
	<script src="../../../assets/vendors/dropify/dist/dropify.min.js"></script>
	<script src="../../../assets/vendors/pickr/pickr.min.js"></script>
	<script src="../../../assets/vendors/moment/moment.min.js"></script>
	<script src="../../../assets/vendors/flatpickr/flatpickr.min.js"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
	<script src="../../../assets/js/template.js"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<script src="../../../assets/js/form-validation.js"></script>
	<script src="../../../assets/js/bootstrap-maxlength.js"></script>
	<script src="../../../assets/js/inputmask.js"></script>
	<script src="../../../assets/js/select2.js"></script>
	<script src="../../../assets/js/typeahead.js"></script>
	<script src="../../../assets/js/tags-input.js"></script>
	<script src="../../../assets/js/dropzone.js"></script>
	<script src="../../../assets/js/dropify.js"></script>
	<script src="../../../assets/js/pickr.js"></script>
	<script src="../../../assets/js/flatpickr.js"></script>
	<!-- End custom js for this page -->

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
</html>