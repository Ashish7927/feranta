<?php include("header.php"); ?>
<div class="breadcumb-wrapper" data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg" data-overlay="title"
        data-opacity="4">
        <div class="container z-index-common">
            <h1 class="breadcumb-title">Contact Style 1</h1>
            <ul class="breadcumb-menu">
                <li><a href="index.html">Home</a></li>
                <li>Contact Style 1</li>
            </ul>
        </div>
    </div>
    <section class="space" id="contact-sec">
        <div class="container">
            <div class="nav tab-menu3" id="tab-menu3" role="tablist"><button class="th-btn active" id="nav-one-tab"
                    data-bs-toggle="tab" data-bs-target="#nav-one" type="button" role="tab" aria-controls="nav-one"
                    aria-selected="true">Sidney Branch</button> </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab">
                    <div class="row gy-30 justify-content-center">
                        <div class="col-md-6 col-lg-4">
                            <div class="contact-box">
                              
                                <div class="contact-box_content">
                                    <div class="contact-box_icon"><i class="fal fa-headset"></i></div>
                                    <div class="contact-box_info">
                                        <p class="contact-box_text">Call Us 24/7</p>
                                        <h5 class="contact-box_link"><a href="tel:+5842521453">+584 (25) 21453</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="contact-box">
                              
                                <div class="contact-box_content">
                                    <div class="contact-box_icon"><i class="fal fa-envelope-open-text"></i></div>
                                    <div class="contact-box_info">
                                        <p class="contact-box_text">MAke A Quote</p>
                                        <h5 class="contact-box_link"><a
                                                href="mailto:info@taxseco.com">info@taxseco.com</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="contact-box">
                                
                                <div class="contact-box_content">
                                    <div class="contact-box_icon"><i class="fal fa-map-location-dot"></i></div>
                                    <div class="contact-box_info">
                                        <p class="contact-box_text">Service Station</p>
                                        <h5 class="contact-box_link">25 Hilton Street, Aus.</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="space bg-smoke position-relative">
        <div class="container">
            <div class="title-area text-center"><span class="sub-title">OUR CONTACT FORM<span
                        class="double-line"></span></span>
                <h2 class="sec-title">You can connect with uS</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="https://html.themeholy.com/taxiar/demo/mail.php" method="POST"
                        class="contact-form ajax-contact">
                        <div class="row">
                            <div class="form-group col-md-6"><input type="text" class="form-control" name="name"
                                    id="name" placeholder="Enter Your Name"> <i class="fal fa-user"></i></div>
                            <div class="form-group col-md-6"><input type="email" class="form-control" name="email"
                                    id="email" placeholder="Email Address"> <i class="fal fa-envelope"></i></div>
                            <div class="form-group col-12"><select name="subject" id="subject" class="form-select">
                                    <option value="" disabled="disabled" selected="selected" hidden>Select Subject
                                    </option>
                                    <option value="Electrical System">Electrical System</option>
                                    <option value="Auto Car Repair">Auto Car Repair</option>
                                    <option value="Engine Diagnostics">Engine Diagnostics</option>
                                    <option value="Car & Engine Clean">Car & Engine Clean</option>
                                </select> <i class="fal fa-chevron-down"></i></div>
                            <div class="form-group col-12"><textarea name="message" id="message" cols="30" rows="3"
                                    class="form-control" placeholder="Message"></textarea> <i
                                    class="fal fa-comment"></i></div>
                            <div class="form-btn col-12 mt-10 text-center"><button class="th-btn">Send Message
                                    Now</button></div>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="map-sec"><iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.7310056272386!2d89.2286059153658!3d24.00527418490799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fe9b97badc6151%3A0x30b048c9fb2129bc!2sTaxiar!5e0!3m2!1sen!2sbd!4v1651028958211!5m2!1sen!2sbd"
            allowfullscreen="" loading="lazy"></iframe></div>
            <?php include("footer.php"); ?>