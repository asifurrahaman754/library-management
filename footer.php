</main>

<script src="<?php echo base_url()?>asset/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>asset/js/fontawesome.min.js"></script>
<script src="<?php echo base_url()?>asset/js/script.js"></script>
<script src="<?php echo base_url()?>asset/js/datatables-demo.js"></script>
<script src="<?php echo base_url()?>asset/js/datatables@latest.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv1.min.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script>
// slider options
const swiper = new Swiper('.swiper', {
    autoplay: {
        delay: 1500,
    },
    speed: 800,
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 2,
            spaceBetween: 20
        },
        // when window width is >= 480px
        480: {
            slidesPerView: 3,
            spaceBetween: 30
        },
        // when window width is >= 780
        780: {
            slidesPerView: 4,
            spaceBetween: 30
        },
        // when window width is >= 1000
        1000: {
            slidesPerView: 6,
            spaceBetween: 30
        }
    }
});

//tooltip init
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
</body>

</html>