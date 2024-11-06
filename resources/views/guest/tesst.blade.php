<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
<style>
    .body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .carousel-container {
      position: relative;
      width: auto;
      height: 600px;
      perspective: 1500px;
      transform-style: preserve-3d;
    }

    .carousel {
      position: relative;
      width: 100%;
      height: 100%;
      transform-style: preserve-3d;
    }

    .carousel-item {
      position: absolute;
      width: 400px;
      height: 300px;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      transition: all 0.5s ease;
      cursor: pointer;
    }

    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.3);
      transition: all 0.5s ease;
    }

    .carousel-item.active {
      width: 600px;
      height: 450px;
      z-index: 10;
      transform: translate(-50%, -50%) scale(1);
    }

    .carousel-item.prev,
    .carousel-item.next {
      width: 400px;
      height: 300px;
      z-index: 5;
      opacity: 0.7;
    }

    .carousel-item.prev {
      transform: translate(-125%, -50%) scale(0.8);
    }

    .carousel-item.next {
      transform: translate(25%, -50%) scale(0.8);
    }

    .carousel-item.back {
      transform: translate(-50%, -50%) scale(0.6);
      opacity: 0.3;
      z-index: 1;
    }

    .carousel-nav {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 20;
      display: flex;
      gap: 10px;
    }

    .nav-button {
      padding: 10px 20px;
      background: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }

    .nav-button:hover {
      background: #eee;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
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
                        <a class="nav-link text-secondary" href="">Giới thiệu</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link text-secondary" href="">Lĩnh vực hoạt động</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link text-secondary" href="">Dự án và đang triển khai</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link text-secondary" href="">Liên hệ</a>
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


        <section class="container ">
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
        

    
    <section class="py-3 pb-5" style="background-color:  rgba(244, 244, 244, 0.939)">
        <h1 class="mt-3 text-center " style="color: #ff6600">DỰ ÁN TIÊU BIỂU</h1>
        <div class="text-center mt-4">
            Các công trình CDC Xây Dựng thi công luôn đảm bảo 
            <span class="h6">An toàn - Chất lượng - Tiến độ</span>

        </div>

        <div class="body">
            <div class="carousel-container">
                <div class="carousel">
                  <div class="carousel-item">
                    <img src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
                </div>
                  <div class="carousel-item">
                    <img src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
                </div>
                  <div class="carousel-item">
                    <img src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
                </div>
                  <div class="carousel-item">
                    <img src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
                </div>
                  <div class="carousel-item">
                    <img src="{{ asset('image/slideshow/3.jpg') }}" alt="Image 3">
                </div>
                </div>
                <div class="carousel-nav">
                  <button class="nav-button prev-button">Previous</button>
                  <button class="nav-button next-button">Next</button>
                </div>
            </div>
        </div>
        
        
    </section>

    <section class="mt-3 container">
        <h1 class="text-center mb-2" style="color: #ff6600">LĨNH VỰC HOẠT ĐỘNG</h1>
        <div class="text-center">Với thế mạnh về đội ngũ cán bộ được đào tạo bài bản, trình độ chuyên môn cao, đã được tham gia qua nhiều dự án lớn và luôn luôn không ngừng học hỏi, đổi mới, sáng tạo.</div>
        <div class="text-center">Công ty Cổ phần Xây dựng CDC đã từng bước khẳng định được thương hiệu của mình.</div>
    </section>

    <section class="py-3 pb-3" style="background-color:  rgba(244, 244, 244, 0.939)">
        <h1 class="mt-3 text-center " style="color: #ff6600">LIÊN HỆ</h1>
        <div class="text-center mt-4">
            Các công trình CDC Xây Dựng thi công luôn đảm bảo 
            <span class="h6">An toàn - Chất lượng - Tiến độ</span>
        </div>
        
    </section>

    @include('guest.body.footer')
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    let currentIndex = 0;
    const items = $('.carousel-item');
    const totalItems = items.length;

    function updateCarousel() {
      items.removeClass('active prev next back');
      
      // Active (center) item
      items.eq(currentIndex).addClass('active');
      
      // Previous item
      const prevIndex = (currentIndex - 1 + totalItems) % totalItems;
      items.eq(prevIndex).addClass('prev');
      
      // Next item
      const nextIndex = (currentIndex + 1) % totalItems;
      items.eq(nextIndex).addClass('next');
      
      // Back items
      items.each(function(index) {
        if (index !== currentIndex && 
            index !== prevIndex && 
            index !== nextIndex) {
          $(this).addClass('back');
        }
      });
    }

    // Initialize carousel
    updateCarousel();

    // Next button click
    $('.next-button').click(function() {
      currentIndex = (currentIndex + 1) % totalItems;
      updateCarousel();
    });

    // Previous button click
    $('.prev-button').click(function() {
      currentIndex = (currentIndex - 1 + totalItems) % totalItems;
      updateCarousel();
    });

    // Click on carousel items
    $('.carousel-item').click(function() {
      const clickedIndex = $(this).index();
      if (clickedIndex !== currentIndex) {
        currentIndex = clickedIndex;
        updateCarousel();
      }
    });

    // Auto rotation
    setInterval(function() {
      currentIndex = (currentIndex + 1) % totalItems;
      updateCarousel();
    }, 5000);
  });
</script>
</html>