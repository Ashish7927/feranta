<?php 
 $this->session = session();
$this->db = db_connect();

 foreach( $cms_data as $cms) { }
 foreach( $contactus_data as $contact) {}
  foreach( $setting as $settingdata) { }
 
 ?>

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from aerolexlabs.com/template_theme/aero002_bigtech/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Dec 2023 14:49:30 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <title><?=$cms->page_title; ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>/assets/user/Images/favicon.png">
    <!--google font-->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <!--boostrap-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/user/css/bootstrap.min.css">
    <!-- slick -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!--css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/user/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/user/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/user/css/materialdesignicons.min.css">
    
    <!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.19.1/dist/css/uikit.min.css" />

<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.19.1/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.19.1/dist/js/uikit-icons.min.js"></script>
<style>
	a{ text-decoration:none !important;}
	h6, h2, h3, h4, h5, h6, h1{ padding:0 !important; margin:0!important;}
	
</style>

</head>

<body>
    <!-- Theme loader -->
    <!--<div class="alloader">-->
    <!--    <span class="loader"><span class="rotating"></span></span>-->
    <!--</div>-->
    <!-- End Theme loader -->
    <!-- ====== Header ====== -->
    <header class="header_section bg_dark_blue">
        <!-- Currency-language -->
        
        <!-- End Currency-language -->
        <!-- Logo-Search-header-icons -->
        <div class="border_blue_bottom second_header_outer">
            <div class="container second_header">
                <div class="magic_mart">
                    <div class="row py-md-3 align-items-center py-2">
                        <div class="col-5 order-1 order-lg-1 order-md-1 col-lg-2 col-xl-2 col-xxl-2 col-md-3">
                            <a href="<?php echo base_url(); ?>" class="magic_mart_logo">
                                <img src="<?php echo base_url(); ?>/uploads/<?=$settingdata->logo; ?>" alt="logo" class="img-fluid">
                            </a>
                        </div>
                        <div class="col-12 order-3 order-lg-2 order-md-2 col-lg-6 col-xl-5 col-xxl-4 mt-lg-0 col-md-6 d-none d-lg-block">
                            <div>
                                <form class="search_for_item_outer d-flex position-relative ms-2">
                                    <input class="shadow-none form-control border_radius bg_light_blue" type="search" placeholder="Search for items" aria-label="Search">
                                    <button class="btn search_for_item_btn position-absolute" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="txt_black feather feather-search">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-7 order-2 order-lg-3 order-md-3 col-lg-4 col-xl-5 col-xxl-6 col-md-9 d-flex align-items-center justify-content-end">
                            <div class="mm_profile_icon d-flex align-items-center">
                                <a href="tel:+96574924277" class="d-none d-xl-block contact d-xl-flex align-items-center border_blue_right">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px">
                                        <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M26.61,20.949 L26.61,24.572 C26.63,24.908 25.994,25.241 25.859,25.549 C25.724,25.857 25.527,26.134 25.279,26.361 C25.31,26.588 24.739,26.762 24.420,26.869 C24.101,26.977 23.764,27.17 23.429,26.987 C19.713,26.583 16.144,25.313 13.8,23.280 C10.91,21.426 7.617,18.952 5.763,16.34 C3.723,12.885 2.453,9.298 2.56,5.566 C2.26,5.232 2.66,4.895 2.173,4.578 C2.280,4.260 2.452,3.968 2.678,3.720 C2.904,3.473 3.179,3.275 3.486,3.139 C3.792,3.3 4.124,2.934 4.459,2.933 L8.82,2.933 C8.668,2.927 9.236,3.135 9.680,3.517 C10.124,3.900 10.415,4.430 10.497,5.10 C10.650,6.170 10.933,7.308 11.342,8.403 C11.504,8.836 11.540,9.306 11.443,9.757 C11.347,10.208 11.123,10.623 10.798,10.951 L9.265,12.485 C10.984,15.507 13.487,18.11 16.510,19.730 L18.44,18.196 C18.372,17.872 18.786,17.647 19.238,17.552 C19.689,17.455 20.159,17.490 20.591,17.652 C21.687,18.62 22.825,18.345 23.984,18.498 C24.571,18.581 25.107,18.876 25.490,19.328 C25.873,19.780 26.76,20.357 26.61,20.949 Z"></path>
                                    </svg>
                                    <div class="need-help ms-2 px-1 me-4">
                                        <span class="h7 fw_400 text-uppercase txt_yellow mb-0">Need help?</span>
                                        <h6 class="fw_500 mb-0 txt_hover txt_white uk-margin-remove"><?=$contact->phone?></h6>
                                    </div>
                                </a>
                                 <?php if ($this->session->get('cust_id') == "") { ?>
                                <a href="<?php echo base_url(); ?>/Register" class="profile d-flex align-items-center ms-2 ms-xl-4 ps-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28px" height="28px">
                                    <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M25.854,29.199 L25.854,26.179 C25.854,24.576 25.226,23.40 24.108,21.907 C22.990,20.774 21.474,20.137 19.893,20.137 L7.972,20.137 C6.391,20.137 4.875,20.774 3.757,21.907 C2.640,23.40 2.12,24.576 2.12,26.179 L2.12,29.199 "></path>
                                    <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M19.893,8.54 C19.893,11.391 17.224,14.96 13.933,14.96 C10.641,14.96 7.972,11.391 7.972,8.54 C7.972,4.718 10.641,2.13 13.933,2.13 C17.224,2.13 19.893,4.718 19.893,8.54 Z"></path>
                                        </svg>

                                    <div class="ms-2 ps-1 txt_white d-none d-xl-block">
                                        <span class="h7 fw_400 text-uppercase txt_yellow mb-0">Account</span>
                                        <h6 class="fw_500 mb-0 txt_hover uk-light uk-margin-remove">Login/Sign up</h6>
                                    </div>
                                </a>
                                 <?php } else { ?>
                                 <a href="<?php echo base_url(); ?>/Profile" class="profile d-flex align-items-center ms-2 ms-xl-4 ps-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28px" height="28px">
                                    <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M25.854,29.199 L25.854,26.179 C25.854,24.576 25.226,23.40 24.108,21.907 C22.990,20.774 21.474,20.137 19.893,20.137 L7.972,20.137 C6.391,20.137 4.875,20.774 3.757,21.907 C2.640,23.40 2.12,24.576 2.12,26.179 L2.12,29.199 "></path>
                                    <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M19.893,8.54 C19.893,11.391 17.224,14.96 13.933,14.96 C10.641,14.96 7.972,11.391 7.972,8.54 C7.972,4.718 10.641,2.13 13.933,2.13 C17.224,2.13 19.893,4.718 19.893,8.54 Z"></path>
                                        </svg>

                                    <div class="ms-2 ps-1 txt_white d-none d-xl-block">
                                        <span class="h7 fw_400 text-uppercase txt_yellow mb-0">Account</span>
                                        <h6 class="fw_500 mb-0 txt_hover uk-light uk-margin-remove"><?php echo $this->session->get('fullname') ?></h6>
                                    </div>
                                </a>
                                  <?php } ?>
                                
                                
                                
                                <a href="javascript:void(0);" class="js-menu__open cart position-relative d-flex align-items-center ms-2 ms-xl-4 ps-1" data-menu="#main-nav">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px">
                                   <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M12.462,26.955 C12.462,27.621 11.922,28.160 11.256,28.160 C10.590,28.160 10.50,27.621 10.50,26.955 C10.50,26.288 10.590,25.749 11.256,25.749 C11.922,25.749 12.462,26.288 12.462,26.955 Z"></path>
                                   <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M25.727,26.955 C25.727,27.621 25.187,28.160 24.521,28.160 C23.855,28.160 23.315,27.621 23.315,26.955 C23.315,26.288 23.855,25.749 24.521,25.749 C25.187,25.749 25.727,26.288 25.727,26.955 Z"></path>
                                   <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="2px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M1.609,2.837 L6.433,2.837 L9.664,18.984 C9.775,19.539 10.77,20.38 10.518,20.393 C10.958,20.748 11.510,20.936 12.76,20.925 L23.798,20.925 C24.363,20.936 24.915,20.748 25.356,20.393 C25.797,20.38 26.99,19.539 26.209,18.984 L28.139,8.866 L7.638,8.866 "></path>
                                    </svg>
                                    <span class="cart_count position-absolute bg_yellow txt_bl">2</span>
                                    <div class="ms-2 ps-1 txt_white d-none d-md-block">
                                        <span class="h7 fw_400 text-uppercase txt_yellow mb-0">Cart</span>
                                        <h6 class="fw_500 mb-0 uk-margin-remove uk-light">$199.98</h6>
                                    </div>
                                </a>
                                <div class="js-menu__context">
                                    <div id="main-nav" class="js-menu-cart js-menu--right">
                                        <div class="p-3 mb-3 cart__inner-head d-flex align-items-center justify-content-between bottom_border">
                                            <h5 class="cart__inner-title fw_700 txt_blue m-0">This is your bag</h5>
                                            <span class="js-menu__close">✕</span>
                                        </div>
                                        <div class="pt-2 cart-inner-form">
                                            <div class="cart-dropdown px-3">
                                                <ul class="list-unstyled pt-0">
                                                    <li class="bottom_border pb-3 mb-3">
                                                        <div class="">
                                                            <ul class="list-unstyled row mx-n2">
                                                                <li class="col-auto w-25">
                                                                    <img src="<?php echo base_url(); ?>/assets/user/Images/Product/06.jpg" alt="product-image" class="border_solid border_radius img-fluid">
                                                                </li>
                                                                <li class="col">
                                                                    <a href="single-product.html">
                                                                        <h6 class="fw_500 txt_blue lh-base">Defunc True Basic TWS Earbuds</h6>
                                                                    </a>
                                                                    <span class="fw_700 txt_blue mb-0 h6">1 × $99.99.00</span>
                                                                </li>
                                                                <li class="col-auto">
                                                                    <a href="#" class="text-gray-90"><i class="mdi mdi-close txt_black"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="bottom_border pb-3 mb-3">
                                                        <div class="">
                                                            <ul class="list-unstyled row mx-n2">
                                                                <li class="col-auto w-25">
                                                                    <img src="<?php echo base_url(); ?>/assets/user/Images/Product/07.jpg" alt="product-image" class="border_solid border_radius img-fluid">
                                                                </li>
                                                                <li class="col">
                                                                    <a href="single-product.html">
                                                                        <h6 class="fw_500 txt_blue lh-base">Headphones Bluetooth Style 3 Stone</h6>
                                                                    </a>
                                                                    <span class="fw_700 txt_blue mb-0 h6">1 × $99.99.00</span>
                                                                </li>
                                                                <li class="col-auto">
                                                                    <a href="#" class="text-gray-90"><i class="mdi mdi-close txt_black"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="cart__inner-foot flex-center-between bg_light_blue">
                                                <h3 class="d-flex align-items-center justify-content-between mb-4">
                                                    <span>Subtotal</span>
                                                    <span>$199.98</span>
                                                </h3>
                                                <a href="checkout.html" class="bg_dark_blue txt_white border_radius w-100 text-center p-3 ctm-btn">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Logo-Search-header-icons -->
        <!-- Bottom Header Bar -->
        <div class="bottom_border third_header_outer d-lg-block">
            <div class="container third_header my-lg-1">
                <div class="row align-items-center justify-content-xl-start justify-content-between justify-content-md-between">
                    <div class="col-2 col-lg-2 col-xl-3 col-xxl-2 col-sm-3 mt-0 mt-lg-0 mt-sm-0">
                        <div class="shop_cat_btn txt_white dropdown position-relative">
                            <a class="shop_cat_toggle btn ps-0 p-3 align-items-center justify-content-between border_radius dropdown-toggle" role="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <h6 class="txt_white fw_500 mb-0 d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#ffffff" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu me-0 me-md-3">
                                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <line x1="3" y1="18" x2="21" y2="18"></line>
                                            </svg><span class="d-md-block d-none">Shop By Categories</span>
                                </h6>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-none d-lg-block position-absolute feather txt_white feather-chevrons-down">
                                            <polyline points="7 13 12 18 17 13"></polyline>
                                            <polyline points="7 6 12 11 17 6"></polyline>
                                        </svg>
                            </a>
                            <ul class="p-0 dropdown-menu navbar__menu border-0 box-shadow" aria-labelledby="dropdownMenuClickableInside">
    <?php foreach($category_data as $cat): 
        $subcat = $this->db->query("SELECT * FROM category  where parent_id='$cat->cat_id' AND status='1'")->getResult();
    ?>
    <li class="has-mega-menu">
        <a class="dropdown-item txt_blue d-flex align-items-center justify-content-between" href="<?= base_url(); ?>/Shop/<?= $cat->cat_id; ?>">
            <?= $cat->cat_name ?>
            <?php if(!empty($subcat)): ?>
                <i class="mdi mdi-arrow-right txt_blue"></i>
            <?php endif; ?>
        </a>
        <?php if(!empty($subcat)): ?>
        <div class="mega-menu-inner ctm-width box-shadow border_radius">
            <div class="menu-menu-bgimage d-none d-lg-block">
                <img class="img-fluid" src="<?= base_url(); ?>/uploads/<?= $cat->cat_img ?>" width="200" alt="Image Description">
            </div>
            <div class="row row-cols-2 header__mega-menu-wrapper p-3 p-lg-5">
                <?php foreach($subcat as $subctt): 
                    $subcatm = $this->db->query("SELECT * FROM category  where parent_id='$subctt->cat_id' AND status='1'")->getResult();
                ?>
                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                    <h6 class="txt_blue fw_600 header__sub-menu-title mb-3">
                        <a href="<?= base_url(); ?>/Shop/<?= $subctt->cat_id; ?>"><?= $subctt->cat_name ?></a>
                    </h6>
                    <ul class="u-header__sub-menu-nav-group">
                        <?php foreach($subcatm as $subcatr): ?>
                            <li>
                                <a class="p-0 mb-2 txt_blue fw_400 h6 u-header__sub-menu-nav-link" href="<?= base_url(); ?>/Shop/<?= $subcatr->cat_id; ?>">
                                    <?= $subcatr->cat_name ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
</ul>

                        </div>
                    </div>
                    <div class="col-10 col-md-9  col-xl-5 col-xxl-4 mt-lg-0 col-lg-6 order-3 order-lg-2 order-md-2 d-lg-none">
                        <div>
                            <form class="search_for_item_outer d-flex position-relative ms-2">
                                <input class="shadow-none form-control border_radius bg_light_blue" type="search" placeholder="Search for items" aria-label="Search">
                                <button class="btn search_for_item_btn position-absolute" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="txt_black feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-10 col-4 col-sm-2 col-lg-3 d-none d-lg-block dropdown position-relative">
                        <nav class="p-0 navbar navbar-expand-lg txt_white">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="menu-navigation navbar-nav me-auto mb-2 mb-lg-0 dropdown-menu border-0 box-shadow">
                                    <li class="nav-item"><a class="nav-link text-white text-md-dark fw_500 txt_hover dropdown-item ps-2" aria-current="page" href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="nav-item"><a class="nav-link text-white text-md-dark fw_500 txt_hover dropdown-item ps-2" href="<?php echo base_url(); ?>/Shop/0">Shop</a></li>
                                    <li class="nav-item"><a class="nav-link text-white text-md-dark fw_500 txt_hover dropdown-item ps-2" href="<?php echo base_url(); ?>/contact">Contact</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bottom Header Bar -->
    </header>