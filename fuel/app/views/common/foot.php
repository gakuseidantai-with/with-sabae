<!-- jQuery -->
<script src="/js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="/js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="/js/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="/js/jquery.waypoints.min.js"></script>
<!-- Owl Carousel -->
<script src="/js/owl.carousel.min.js"></script>
<!-- Flexslider -->
<script src="/js/jquery.flexslider-min.js"></script>
<script src="/js/jquery.MyThumbnail.js"></script>
<!-- MAIN JS -->
<script src="/js/main.js?<?php echo date('Ymd-His') ?>"></script>
<script type="text/javascript">
	var size = 200;
	    $(document).ready(function() {
	        $("img.image").MyThumbnail({
	            thumbWidth: size,
	            thumbHeight: size,
	            class: "image"
	        });
	    });
</script>