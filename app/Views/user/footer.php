      <!-- footer -->
        <footer>
            <div class="main_footer bg_dark_blue mt-5 ">
                <div class="container ">
                    <div>
                        <div class="row padd-y-80 bottom_border border_gray justify-content-between ">
                            <div class="col-12 col-md-12 col-xl-3 pb-3 pb-lg-3 newsletter-form ">
                                <h4 class="txt_white ">Enter your email address to get $20 off your first order</h4>
                                <div class="pay_form">
                                    <form action="# " class="my-4 py-2 col-xxl-12 col-lg-7 col-md-7">
                                        <div class="d-flex align-items-center position-relative ">
                                            <input type="email " placeholder="Email Address ">
                                            <button class="sumbit position-absolute " type="submit ">Subscribe</button>
                                        </div>
                                    </form>
                                    <div class="col-xxl-12 col-lg-3 col-md-4">
                                        <img src="<?php echo base_url(); ?>/assets/user/Images/payment-method.png" class="img-fuild " alt="payment-method ">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-xl-2 justify-content-md-center d-flex pb-lg-0 pb-3 ">
                                <div class="footer_text ">
                                    <h4 class="fw_600 txt_white mb-4 ">Information</h4>
                                    <ul class="list-group ">
                                        <li><a href="<?php echo base_url(); ?>"class="fw_400 h6 txt_footer txt_hover ">Home</a></li>
                                        <li><a href="<?php echo base_url(); ?>About"class="fw_400 h6 txt_footer txt_hover ">About us</a></li>
                                        <li><a href="<?php echo base_url(); ?>contact" class="fw_400 h6 txt_footer txt_hover ">Contact us</a></li>
                                        <li><a href="<?php echo base_url(); ?>Privacypolicy" class="fw_400 h6 txt_footer txt_hover ">Privacy Policy</a></li>
                                        <li><a href="<?php echo base_url(); ?>TermCondition" class="fw_400 h6 txt_footer txt_hover ">Terms & Condition</a></li>
                                        <li><a href="<?php echo base_url(); ?>Faq" class="fw_400 h6 txt_footer ">Faq</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-xl-2 justify-content-md-center d-flex pb-lg-0 pb-3 ">
                                <div class="footer_text ">
                                    <h4 class="fw_600 txt_white mb-4 ">Categories</h4>
                                    <ul class="list-group ">
                                        <?php foreach($category_data as $catd){ ?>
                                        <li><a href="<?= base_url(); ?>/Shop/<?= $catd->cat_id; ?>" class="fw_400 h6 txt_footer txt_hover "><?=$catd->cat_name; ?></a></li>
                                        <?php } ?>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-xl-2 justify-content-md-center d-flex pb-lg-0 pb-3 ">
                                <div class="footer_text ">
                                    <h4 class="fw_600 txt_white mb-4 ">Brands</h4>
                                    <ul class="list-group ">
                                        <?php foreach($brand_data as $brand){ ?>
                                        <li><a href="javascript:void(0); " class="fw_400 h6 txt_footer txt_hover "><?=$brand->brands_name; ?></a></li>
                                       <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-xl-3 d-flex flex-column align-items-center pt-md-4 pb-lg-0 pb-4 ">
                                <div class="address_footer_text pb-3 ">
                                    <div class="d-flex align-items-start ">
                                        <svg xmlns="http://www.w3.org/2000/svg " width="24 " height="24 " viewBox="0 0 24 24 " fill="none " color="#ffc000 " stroke="currentColor " stroke-width="2 " stroke-linecap="round " stroke-linejoin="round
                            " class=" feather feather-phone "><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16
                            16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z "></path></svg>
                                        <div class="footer_txt ">
                                            <span class="h7 txt_white text-uppercase d-block ">Hotline Free :</span>
                                            <a href="tel:(+965)7492-4277 ">
                                                <h5 class="fw_700 txt_yellow ">(+965) 7492-4277 </h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="d-flex align-items-start txt_footer lh-base mb-3 ">
                                    <b>Address:</b> Acme Widgets 123 Widget Street Acmeville, AC<br> 12345 United States of America
                                </h6>
                                <h6 class="d-flex align-items-start txt_footer m-0 "><b>Email:</b> <a class="txt_white txt_hover " href="mailto:name@company.com ">name@company.com</a></h6>
                                <ul class="footer_social text-center ">
                                    <li>
                                        <a href="# ">
                                            <svg xmlns="http://www.w3.org/2000/svg " xmlns:xlink="http://www.w3.org/1999/xlink " version="1.1 " id="Capa_1 " x="0px " y="0px " viewBox="0 0 24 24 " style="enable-background:new 0 0 24 24; " xml:space="preserve
                            " width="512 " height="512 ">
                                                <g>
                                                    <path d="M24,12.073c0,5.989-4.394,10.954-10.13,11.855v-8.363h2.789l0.531-3.46H13.87V9.86c0-0.947,0.464-1.869,1.95-1.869h1.509 V5.045c0,0-1.37-0.234-2.679-0.234c-2.734,0-4.52,1.657-4.52,4.656v2.637H7.091v3.46h3.039v8.363C4.395,23.025,0,18.061,0,12.073
                            c0-6.627,5.373-12,12-12S24,5.445,24,12.073z "/>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=" ">
                                            <svg xmlns="http://www.w3.org/2000/svg " xmlns:xlink="http://www.w3.org/1999/xlink " version="1.1 " id="Capa_2 " x="0px " y="0px " viewBox="0 0 24 24 " style="enable-background:new 0 0 24 24; " xml:space="preserve
                            " width="512 " height="512 ">
                                                <g>
                                                    <path d="M12,2.162c3.204,0,3.584,0.012,4.849,0.07c1.308,0.06,2.655,0.358,3.608,1.311c0.962,0.962,1.251,2.296,1.311,3.608 c0.058,1.265,0.07,1.645,0.07,4.849c0,3.204-0.012,3.584-0.07,4.849c-0.059,1.301-0.364,2.661-1.311,3.608
                            c-0.962,0.962-2.295,1.251-3.608,1.311c-1.265,0.058-1.645,0.07-4.849,0.07s-3.584-0.012-4.849-0.07 c-1.291-0.059-2.669-0.371-3.608-1.311c-0.957-0.957-1.251-2.304-1.311-3.608c-0.058-1.265-0.07-1.645-0.07-4.849 c0-3.204,0.012-3.584,0.07-4.849c0.059-1.296,0.367-2.664,1.311-3.608c0.96-0.96,2.299-1.251,3.608-1.311
                            C8.416,2.174,8.796,2.162,12,2.162 M12,0C8.741,0,8.332,0.014,7.052,0.072C5.197,0.157,3.355,0.673,2.014,2.014 C0.668,3.36,0.157,5.198,0.072,7.052C0.014,8.332,0,8.741,0,12c0,3.259,0.014,3.668,0.072,4.948c0.085,1.853,0.603,3.7,1.942,5.038
                            c1.345,1.345,3.186,1.857,5.038,1.942C8.332,23.986,8.741,24,12,24c3.259,0,3.668-0.014,4.948-0.072 c1.854-0.085,3.698-0.602,5.038-1.942c1.347-1.347,1.857-3.184,1.942-5.038C23.986,15.668,24,15.259,24,12 c0-3.259-0.014-3.668-0.072-4.948c-0.085-1.855-0.602-3.698-1.942-5.038c-1.343-1.343-3.189-1.858-5.038-1.942
                            C15.668,0.014,15.259,0,12,0z "/>
                                                    <path d="M12,5.838c-3.403,0-6.162,2.759-6.162,6.162c0,3.403,2.759,6.162,6.162,6.162s6.162-2.759,6.162-6.162 C18.162,8.597,15.403,5.838,12,5.838z M12,16c-2.209,0-4-1.791-4-4s1.791-4,4-4s4,1.791,4,4S14.209,16,12,16z "/>
                                                    <circle cx="18.406 " cy="5.594 " r="1.44 "/>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=" ">
                                            <svg xmlns="http://www.w3.org/2000/svg " xmlns:xlink="http://www.w3.org/1999/xlink " version="1.1 " id="Capa_3 " x="0px " y="0px " viewBox="0 0 24 24 " style="enable-background:new 0 0 24 24; " xml:space="preserve
                            " width="512 " height="512 ">
                                                <g>
                                                    <path d="M12.01,0C5.388,0,0.02,5.368,0.02,11.99c0,5.082,3.158,9.424,7.618,11.171c-0.109-0.947-0.197-2.408,0.039-3.444 c0.217-0.938,1.401-5.961,1.401-5.961s-0.355-0.72-0.355-1.776c0-1.668,0.967-2.911,2.171-2.911c1.026,0,1.52,0.77,1.52,1.688
                            c0,1.026-0.651,2.566-0.997,3.997c-0.286,1.194,0.602,2.171,1.776,2.171c2.132,0,3.77-2.25,3.77-5.487 c0-2.872-2.062-4.875-5.013-4.875c-3.414,0-5.418,2.556-5.418,5.201c0,1.026,0.395,2.132,0.888,2.734 C7.52,14.615,7.53,14.724,7.5,14.842c-0.089,0.375-0.296,1.194-0.336,1.362c-0.049,0.217-0.178,0.266-0.405,0.158
                            c-1.5-0.701-2.438-2.882-2.438-4.648c0-3.78,2.743-7.253,7.924-7.253c4.155,0,7.391,2.961,7.391,6.928 c0,4.135-2.605,7.461-6.217,7.461c-1.214,0-2.359-0.632-2.743-1.382c0,0-0.602,2.289-0.75,2.852 c-0.266,1.046-0.997,2.349-1.49,3.148C9.562,23.812,10.747,24,11.99,24c6.622,0,11.99-5.368,11.99-11.99C24,5.368,18.632,0,12.01,0
                            z "/>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=" ">
                                            <svg xmlns="http://www.w3.org/2000/svg " xmlns:xlink="http://www.w3.org/1999/xlink " version="1.1 " id="Capa_4 " x="0px " y="0px " viewBox="0 0 24 24 " style="enable-background:new 0 0 24 24; " xml:space="preserve
                            " width="512 " height="512 ">
                                                <g id="XMLID_184_ ">
                                                    <path d="M23.498,6.186c-0.276-1.039-1.089-1.858-2.122-2.136C19.505,3.546,12,3.546,12,3.546s-7.505,0-9.377,0.504 C1.591,4.328,0.778,5.146,0.502,6.186C0,8.07,0,12,0,12s0,3.93,0.502,5.814c0.276,1.039,1.089,1.858,2.122,2.136
                            C4.495,20.454,12,20.454,12,20.454s7.505,0,9.377-0.504c1.032-0.278,1.845-1.096,2.122-2.136C24,15.93,24,12,24,12 S24,8.07,23.498,6.186z M9.546,15.569V8.431L15.818,12L9.546,15.569z "/>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href=" ">
                                            <svg xmlns="http://www.w3.org/2000/svg " xmlns:xlink="http://www.w3.org/1999/xlink " version="1.1 " id="Capa_5 " x="0px " y="0px " viewBox="0 0 24 24 " style="enable-background:new 0 0 24 24; " xml:space="preserve
                            " width="512 " height="512 ">
                                                <g>
                                                    <path id="Path_2520 " d="M17.291,19.073h-3.007v-4.709c0-1.123-0.02-2.568-1.564-2.568c-1.566,0-1.806,1.223-1.806,2.487v4.79H7.908 V9.389h2.887v1.323h0.04c0.589-1.006,1.683-1.607,2.848-1.564c3.048,0,3.609,2.005,3.609,4.612L17.291,19.073z
                            M4.515,8.065 c-0.964,0-1.745-0.781-1.745-1.745c0-0.964,0.781-1.745,1.745-1.745c0.964,0,1.745,0.781,1.745,1.745 C6.26,7.284,5.479,8.065,4.515,8.065L4.515,8.065 M6.018,19.073h-3.01V9.389h3.01V19.073z M18.79,1.783H1.497 C0.68,1.774,0.01,2.429,0,3.246V20.61c0.01,0.818,0.68,1.473,1.497,1.464H18.79c0.819,0.01,1.492-0.645,1.503-1.464V3.245
                            c-0.012-0.819-0.685-1.474-1.503-1.463 "/>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-footer top_padding bottom_padding ">
                        <div class="container ">
                            <div class="align-items-center ">
                                <div class="text-center ">
                                    <ul class="mb-3 ">
                                        <li><a class="fw_400 h6 txt_footer mb-0 txt_hover " href="terms-and-conditions.html">Privacy Policy</a></li>
                                        <li><a class="fw_400 h6 txt_footer mb-0 txt_hover " href="terms-and-conditions.html">California Notice at Collection</a></li>
                                        <li><a class="fw_400 h6 txt_footer mb-0 txt_hover " href="terms-and-conditions.html">Terms of Use</a></li>
                                        <li><a class="fw_400 h6 txt_footer mb-0 txt_hover " href="terms-and-conditions.html">Accessibility</a></li>
                                        <li><a class="fw_400 h6 txt_footer mb-0 txt_hover " href="terms-and-conditions.html">Supply Chain Transparency</a></li>
                                    </ul>
                                    <p class="h6 txt_footer m-0 ">COPYRIGHT 2023 © Magic_mart. ALL RIGHTS RESERVED.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>







        <!-- End footer -->
        <a href="# " class="back-to-top ">
            <svg xmlns="http://www.w3.org/2000/svg " height="48 " viewBox="0 96 960 960 " width="48 "><path d="M450 976V290L242 498l-42-42 280-280 280 280-42 42-208-208v686h-60Z "/></svg>
        </a>
        <!-- Jquery -->
        <script src="<?php echo base_url(); ?>/assets/user/JS/jquery.min.js"></script>
        <!-- bootstrap -->
        <script src="<?php echo base_url(); ?>/assets/user/JS/bootstrap.bundle.min.js"></script>
        <!--fontawesome js-->
        <!--fontawesome js-->
        <script src="https://kit.fontawesome.com/4fa83dc4e0.js " crossorigin="anonymous "></script>
        <!-- slick -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js "></script>
        <script src="<?php echo base_url(); ?>/assets/user/JS/custom.js"></script>
        <script>
            // loader js
            jQuery(window).on('load', function() {
                jQuery(".alloader ").fadeOut(600);
                jQuery(".alloader .rotating ").addClass("theme-open ");
            });
            // Count timer js
            function pad(n) {
                return (n < 10 ? '0' : '') + n;
            }

            (function() {
                const second = 1000,
                    minute = second * 60,
                    hour = minute * 60,
                    day = hour * 24;

                //I'm adding this section so I don't have to keep updating this pen every year :-)
                //remove this if you don't need it
                let today = new Date(),
                    dd = String(today.getDate()).padStart(2, "0 "),
                    mm = String(today.getMonth() + 1).padStart(2, "0 "),
                    yyyy = today.getFullYear(),
                    nextYear = yyyy + 1,
                    dayMonth = "08/01/ ",
                    birthday = dayMonth + yyyy;

                today = mm + "/ " + dd + "/ " + yyyy;
                if (today > birthday) {
                    birthday = dayMonth + nextYear;
                }
                //end

                const countDown = new Date(birthday).getTime(),
                    x = setInterval(function() {

                        const now = new Date().getTime(),
                            distance = countDown - now;

                        document.getElementById("days ").innerText = pad(parseInt(distance / (day))),
                            document.getElementById("hours ").innerText = pad(parseInt((distance % (day)) / (hour))),
                            document.getElementById("minutes ").innerText = pad(parseInt((distance % (hour)) / (minute))),
                            document.getElementById("seconds ").innerText = pad(parseInt((distance % (minute)) / (second)));

                        if (distance < 0) {
                            document.getElementById("countdown ").style.display = "none ";
                            $(".product-countdown ").addClass('product-count-hide');
                            clearInterval(x);
                        } else {
                            $(".product-countdown ").removeClass('product-count-hide');
                        }

                    }, 0)

            }());
        </script>
</body>


<!-- Mirrored from aerolexlabs.com/template_theme/aero002_bigtech/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Dec 2023 14:49:52 GMT -->
</html>