<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/font.css')}}">
    <link rel="stylesheet" href="{{asset('css/aos.css')}}">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <title>{{ config('app.name', 'Mallnage') }}</title>


    <style>
        body{
            background: #fbfcfd !important;
        }

        *{
            font-family: 'Kanit', sans-serif !important;
        }

        .bg-p{
            background-color: #7c1df9;
        }

        .athiti-font{
            font-family: 'Athiti', sans-serif !important;
        }

        .navbar-brand{
            color: rgba(255, 255, 255) !important;
        }

        .nav-link {
            color: rgba(255,255,255,.75) !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover{
            color: #ffffff !important;
        }

        .sign-in{
            background-color: #3eced4 !important;
            transition: all 0.2s ease !important;
            border-radius: 6px;
            color: #ffffff !important;


            padding: 10px 20px 10px 20px !important;
            text-decoration: none;
            display: block;
            width: fit-content;
        }

        .sign-in:hover{
            background-color: #33a8ac !important;
            color: #d1cfcf !important;

        }

        .p-bg{
            background-color: #7c1df9;

        }

        .text-white-custom{
            color: rgba(255,255,255,.75) !important;
        }

        .description1,
        .description2,
        .f-18px{
            font-size: 18px !important; 
        }

        .btn-register{
            display: inline-block;
            padding: 12px 0px;
            width: 100%;
            background-color: #a360fa;
            font-weight: 600;
            line-height: 1.7;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            border: 0px;
            outline: none;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-register:hover{
            background-color: #9455e7;    
            color: rgb(194, 194, 194);
        }
        

        .product-card{
            width: 100%;
            box-shadow: 0 0 30px rgb(0 0 0 / 3%);
            transition: all 0.5s ease;
            border-radius: 6px;

            display: flex;
            justify-content: center;
            padding: 2em;
        }


        .product-card:hover{
            transform: translateY(-3%);
            background-color: rgb(241, 241, 241);
        }



        .product-card-p{
            width: 100%;
            box-shadow: 0 0 30px rgb(0 0 0 / 3%);
            transition: all 0.5s ease;
            border-radius: 6px;
            background-color: #964afa;
            color: white;

            display: flex;
            justify-content: center;
            padding: 2em;
        }

        .product-card-p:hover{
            transform: translateY(-3%);
        }

        /* width */
        ::-webkit-scrollbar {
            width: 0px;
        }



    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-p sticky-top">
        <div class="container py-2">
            <a class="navbar-brand" href="#">Mallnage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
 
                    <li class="nav-item mx-2">
                        <a class="nav-link" target="_blank" href="https://www.facebook.com/profile.php?id=100071754115831">ติดต่อเรา</a>
                    </li>
                    <li class="nav-item mx-2 ">
                        <div>
                            <a class="sign-in" href="{{route('signup')}}">ลงทะเบียน</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section style="padding-top: 5em;" class="p-bg" > <!-- HOME -->
        <div class="container pb-5 " data-aos="fade-up">
            <div class="row flex-row-reverse">
                <div class="col-lg-6 col-md-12 mb-5">
                    <div class="d-flex justify-content-center">
                        <img src="{{asset('image/guest.png')}}"  style="width: 50%;" class="mt-3" alt="">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 ">
                    <h1 class="text-white mb-2" >Mallnage</h1>
                    <p class="athiti-font text-white-custom description1" >
                        เช่าระบบจัดการร้านค้า ( Mallnage )
                        <ul>
                            <li class="athiti-font f-18px text-white-custom">การขายสินค้า</li>
                            <li class="athiti-font f-18px text-white-custom">แจ้งเตือนต่างๆ ผ่าน Line Notification</li>
                            <li class="athiti-font f-18px text-white-custom">จัดการสต๊อก</li>
                            <li class="athiti-font f-18px text-white-custom">จัดการสินค้า</li>
                            <li class="athiti-font f-18px text-white-custom">จัดการสินค้า</li>
                            <li class="athiti-font f-18px text-white-custom">เบิกสินค้า</li>
                            <li class="athiti-font f-18px text-white-custom">สรุปผลร้านค้า</li>
                        </ul>
                    </p>
                    <p class="athiti-font text-white-custom description2">
                        เริ่มต้นเพียงแค่ <b class="athiti-font text-white-custom">10 บาท</b>/วัน
                    </p>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <a class="btn-register athiti-font" href="{{route('signup')}}">ลงทะเบียน</a>
                        </div>
                        <div class="col-lg-6 col-md-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section> <!-- PRODUCTS -->
        <div class="container mb-5" data-aos="zoom-in" data-aos-delay="200">
            <h1 style="text-align: center;" class="my-5">Products</h1>
            
            <div class="row columns-2 justify-content-center" >
                <div class="col-xl-4 col-lg-4 col-md-4 p-2">
                    <div class="product-card d-flex justify-content-center" style="flex-direction: column;">
                        <i class="fa-solid fa-box-open fa-3x" style="color: #964afa;"></i>
                        <h2 class="my-3 text-center">BASIC</h2>
                        <p class="text-muted text-center my-6">เช่าบริการระดับปกติ</p>
                        <div class="w-50 mb-3" style="margin: 0 auto;">
                            <a href="{{route('signup')}}" class="btn-register">เริ่มต้นใช้งาน</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 p-2">
                    <div class="product-card d-flex justify-content-center" style="flex-direction: column;">
                        <i class="fa-solid fa-box-open fa-3x" style="color: #964afa;"></i>
                        <h2 class="my-3 text-center">PRO</h2>
                        <p class="text-muted text-center my-6">ทำบันทึกประจำวันโดยอัตโนมัติ</p>
                        <div class="w-50 mb-3" style="margin: 0 auto;">
                            <a href="{{route('signup')}}" class="btn-register">เริ่มต้นใช้งาน</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="bg-p"> <!-- STATISTICS -->
        <div class="container py-5" data-aos="zoom-in" >
            <h1 style="text-align: center;" class="my-5 text-white">Statistics</h1>
        
            <div class="row columns-2 justify-content-center">
                <div class="col-xl-3 p-3">
                    <div class="product-card-p d-flex justify-content-center" style="flex-direction: column;">
                        <i class="fa-solid fa-user fa-3x" style="color: white;"></i>
                        <h2 class="my-3 text-center">@formatNumber($users_basic)</h2>
                        <p class="text-muted text-center my-6 text-white-custom">ผู้ใช้ระดับ BASIC</p>
                    </div>
                </div>
                <div class="col-xl-3 p-3">
                    <div class="product-card-p d-flex justify-content-center" style="flex-direction: column;">
                        <i class="fa-solid fa-user-plus fa-3x" style="color: white;"></i>
                        <h2 class="my-3 text-center">@formatNumber($users_pro)</h2>
                        <p class="text-muted text-center my-6 text-white-custom">ผู้ใช้ระดับ PRO</p>
                    </div>
                </div>
                <div class="col-xl-3 p-3">
                    <div class="product-card-p d-flex justify-content-center" style="flex-direction: column;">
                        <i class="fa-solid fa-users fa-3x" style="color: white;"></i>
                        <h2 class="my-3 text-center">@formatNumber($users)</h2>
                        <p class="text-muted text-center my-6 text-white-custom">ผู้ใช้ทั้งหมด</p>
                    </div>
                </div>
                <div class="col-xl-3 p-3">
                    <div class="product-card-p d-flex justify-content-center" style="flex-direction: column;">
                        <i class="fa-brands fa-product-hunt fa-3x" style="color: white;"></i>
                        <h2 class="my-3 text-center">@formatNumber($products)</h2>
                        <p class="text-muted text-center my-6 text-white-custom">สินค้าทั้งหมด</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/fontawesome.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}" ></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <script>
        AOS.init();
      </script>
    
</body>

</html>