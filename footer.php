<footer class="bg-dark text-light text-center py-5">
    <div class="container">
        <!-- Logo -->
        <div class="mb-4">
            <img src="assets/img/icon/logo.png" alt="Skill Connect Logo" height="60">
        </div>

        <div class="row justify-content-between">
            <!-- About Us -->
            <div class="col-md-3 mb-4">
                <h5 class="text-primary mb-3">About Us</h5>
                <p class="text-light">We connect job seekers with employers across Bangladesh. Hope that you find the
                    right connection and a very good job with good co-workers and upper management.</p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 mb-4">
                <h5 class="text-primary mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="about.php" class="text-decoration-none text-light footer-link">About Us</a></li>
                    <li><a href="job_listing.php" class="text-decoration-none text-light footer-link">Job Listings</a>
                    </li>
                    <li><a href="contact.php" class="text-decoration-none text-light footer-link">Contact</a></li>
                    <br>
                    <li><a href="terms-of-service.php" class="text-decoration-none text-light footer-link">Our Terms of
                            Services</a></li>
                    <li><a href="privacy-policy.php" class="text-decoration-none text-light footer-link">Our Privacy
                            Policy</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div class="col-md-3 mb-4">
                <h5 class="text-primary mb-3">Contact Us</h5>
                <p class="text-light">Email: <a href="mailto:skilluconnectus@gmail.com" class="text-light footer-link"
                        style="text-decoration: none;">skilluconnectus@gmail.com</a></p>

                <a href="tel:+8801990769940" class="text-light" style="text-decoration: none;">Phone: +880
                    1990769940</a>


                <!-- Social Media Icons -->
                <div class="social-icons2 mt-3">
                    <!-- Using CSS sprite -->
                    <!-- <a target="_blank" href="https://www.facebook.com" class="social-icon facebook"
                        title="Facebook"></a>
                    <a target="_blank" href="https://www.x.com" class="social-icon twitter" title="X"></a>
                    <a target="_blank" href="https://www.linkedin.com" class="social-icon linkedin"
                        title="LinkedIn"></a>
                    <a target="_blank" href="https://www.instagram.com" class="social-icon instagram"
                        title="Instagram"></a> -->


                </div>
            </div>

            <div class="social-icons2 mt-3">
                <!-- Using CSS sprite -->
                <a target="_blank" href="https://www.facebook.com" class="social-icon2 facebook" title="Facebook"></a>
                <a target="_blank" href="https://www.x.com" class="social-icon2 twitter" title="X"></a>
                <a target="_blank" href="https://www.linkedin.com" class="social-icon2 linkedin" title="LinkedIn"></a>
                <a target="_blank" href="https://www.instagram.com" class="social-icon2 instagram"
                    title="Instagram"></a>
                <a target="_blank" href="https://www.github.com" class="social-icon2 github" title="Github"></a>
                <a target="_blank" href="https://www.youtube.com/watch?v=zVjbVPFeo2o&ab_channel=VocalNationalAnthems"
                    class="social-icon2 bd_flag" title="Bangladesh Flag"></a>


            </div>


        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Copyright -->
        <div class="mt-5">
            <p class="text-primary mb-0">&copy; <?php echo date("Y"); ?> Skill Connect. All rights reserved.</p>
        </div>
    </div>
</footer>
<style>
    /* Hover effect */
    .social-icon2:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rebeccapurple;
    }

    /* Hover colors */
    .social-icon2.facebook:hover {
        background-color: rgba(193, 53, 132, 0.3);
    }

    .social-icon2.twitter:hover {
        background-color: rgb(75, 228, 62, 0.3);
    }

    .social-icon2.linkedin:hover {
        background-color: rgba(10, 102, 194, 0.3);
    }

    .social-icon2.instagram:hover {
        background-color: rgba(193, 53, 132, 0.3);
    }

    .social-icon2.github:hover {
        background-color: rgb(75, 228, 62, 0.3);
    }

    .social-icon2.bd_flag:hover {
        background-color: rgba(10, 102, 194, 0.3);
    }


    .social-icon2 {
        display: inline-block;
        width: 44px;
        height: 70px;
        background-image: url('assets/img/icon/test.png');
        background-size: 200px 190px;
        background-repeat: no-repeat;
        margin: 0 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Individual icon positions */
    .social-icon2.facebook {
        background-position: -37px -8px;
    }

    .social-icon2.twitter {
        background-position: -125px -8px;
    }

    .social-icon2.linkedin {
        background-position: -39px -62px;
    }

    .social-icon2.instagram {
        background-position: -123px -62px;
    }

    .social-icon2.github {
        background-position: -39px -118px;
    }

    .social-icon2.bd_flag {
        background-position: -123px -118px;
    }
</style>