    </main>

    <footer class="site-footer" style="background-color: #060a10; border-top: 1px solid rgba(255,255,255,0.05); padding: 40px 0 20px; margin-top: 60px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mb-4 mb-lg-0">
                    <a class="custom-navbar-brand d-flex align-items-center mb-3" href="<?= base_url('home') ?>" style="text-decoration: none;">
                        <!-- <img src="<?= base_url('assets/img/logo_dru.png') ?>" alt="Logo" style="height: 32px; margin-right: 10px;"> -->
                        <span style="font-weight: 800; font-size: 1.2rem; color: #E0A96D;">Dheemobilindo <small style="color: rgba(255,255,255,0.5); font-weight: 600; font-size: 0.85rem;">Premium Fleet</small></span>
                    </a>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.95rem; max-width: 400px; line-height: 1.6;">Redefining group transportation through technological innovation and world-class service standards.</p>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <h5 style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 20px;">Working Hours</h5>
                    <p style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 8px; margin-bottom: 12px; color: rgba(255,255,255,0.7); font-size: 0.9rem;">
                        <span style="font-weight: 600;">Mon-Fri</span>
                        <span>8:00 AM - 6:00 PM</span>
                    </p>
                    <p style="display: flex; justify-content: space-between; color: rgba(255,255,255,0.7); font-size: 0.9rem;">
                        <span style="font-weight: 600;">Sat-Sun</span>
                        <span>8:30 AM - 4:30 PM</span>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 col-12 text-lg-end">
                    <h5 style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 20px;">Connect With Us</h5>
                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <a href="https://www.instagram.com/dheemobilindorajautama/" target="_blank" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.05); color: #E0A96D; border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='rgba(224,169,109,0.15)'; this.style.borderColor='rgba(224,169,109,0.4)';" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)';"><i class="bi bi-instagram"></i></a>
                        <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.05); color: #E0A96D; border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='rgba(224,169,109,0.15)'; this.style.borderColor='rgba(224,169,109,0.4)';" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)';"><i class="bi bi-twitter"></i></a>
                        <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.05); color: #E0A96D; border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='rgba(224,169,109,0.15)'; this.style.borderColor='rgba(224,169,109,0.4)';" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)';"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.05);">
                <div class="col-12 text-center">
                    <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem; margin: 0;">Copyright &copy; <?= date('Y') ?> Dheemobilindo. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT FILES -->
    <script src="<?= base_url('assets/tiya/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/tiya/') ?>js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom logic for alerts auto-hide and scroll spy -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-landing').fadeOut('slow');
            }, 5000); // 5 seconds

            // Smooth scrolling for anchor links
            $('a[href^="<?= base_url('home#') ?>"], a[href^="#"]').on('click', function(e) {
                var target = this.hash;
                if (target) {
                    var $target = $(target);
                    if ($target.length) {
                        e.preventDefault();
                        $('html, body').stop().animate({
                            'scrollTop': $target.offset().top - 80 // offset for fixed navbar
                        }, 500, 'swing', function () {
                            window.location.hash = target;
                        });
                    }
                }
            });

            // Scrollspy for active class
            $(window).scroll(function() {
                var scrollDistance = $(window).scrollTop() + 100;

                $('section[id]').each(function(i) {
                    if ($(this).position().top <= scrollDistance) {
                        var id = $(this).attr('id');
                        $('#navbarLinks a').removeClass('active');
                        $('#navbarLinks a[href*="#' + id + '"]').addClass('active');
                        
                        // If we are at the top, make Beranda active
                        if (scrollDistance < 300) {
                            $('#navbarLinks a').removeClass('active');
                            $('#navbarLinks a[href="<?= base_url('home') ?>"]').addClass('active');
                        }
                    }
                });
            }).scroll();
        });
    </script>
</body>
</html>
