 <!-- jquery
		============================================ -->
    <script src="{{ asset('admin/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <!-- wow JS
		============================================ -->
    <script src="{{ asset('admin/js/wow.min.js') }}"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="{{ asset('admin/js/jquery-price-slider.js') }}"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="{{ asset('admin/js/jquery.meanmenu.js') }}"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="{{ asset('admin/js/owl.carousel.min.js') }}"></script>
    <!-- sticky JS
		============================================ -->
    <script src="{{ asset('admin/js/jquery.sticky.js') }}"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="{{ asset('admin/js/jquery.scrollUp.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- counterup JS
		============================================ -->
    <script src="{{ asset('admin/js/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('admin/js/counterup/waypoints.min.js') }}"></script>
    <script src="{{ asset('admin/js/counterup/counterup-active.js') }}"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="{{ asset('admin/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('admin/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="{{ asset('admin/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/js/metisMenu/metisMenu-active.js') }}"></script>
    <!-- morrisjs JS
		============================================ -->
    <script src="{{ asset('admin/js/morrisjs/raphael-min.js') }}"></script>
    <script src="{{ asset('admin/js/morrisjs/morris.js') }}"></script>
    <script src="{{ asset('admin/js/morrisjs/home3-active.js') }}"></script>
    <!-- morrisjs JS
		============================================ -->
    <script src="{{ asset('admin/js/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/js/sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ asset('admin/js/sparkline/sparkline-active.js') }}"></script>
    <!-- calendar JS
		============================================ -->
    <script src="{{ asset('admin/js/calendar/moment.min.js') }}"></script>
    <script src="{{ asset('admin/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('admin/js/calendar/fullcalendar-active.js') }}"></script>
    <!-- plugins JS
		============================================ -->
    <script src="{{ asset('admin/js/plugins.js') }}"></script>
    <!-- main JS
		============================================ -->
    <script src="{{ asset('admin/js/main.js') }}"></script>
    <!-- tawk chat JS


		============================================ -->
    {{-- <script src="{{ asset('admin/js/tawk-chat.js') }}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
  <!-- Loader JS -->
  <script>
    (function($){
      // Track whether navigation was initiated by a user action we handled
      var userInitiatedNav = false;

      $(function(){
        // Hide loader on initial DOM ready
        $('.page-loader').fadeOut(500);

        // Show loader and mark as user-initiated when user clicks a link we want to handle
        $(document).on('click', 'a:not([href^="#"]):not([target="_blank"]):not(.no-loader)', function(){
          userInitiatedNav = true;
          $('.page-loader').fadeIn(200);
        });

        // Show loader and mark as user-initiated when submitting forms
        $(document).on('submit', 'form:not(.no-loader)', function(){
          userInitiatedNav = true;
          $('.page-loader').fadeIn(200);
        });
      });

      // Only show loader on beforeunload if the navigation was initiated via our handlers
      window.addEventListener('beforeunload', function(e){
        if (userInitiatedNav) {
          // show immediately (no animation) to cover the unload gap
          $('.page-loader').show();
        }
      });

      // pageshow fires when the page is shown; event.persisted === true means it was restored from bfcache
      window.addEventListener('pageshow', function(event){
        if (event.persisted) {
          // restored from bfcache (back/forward) - ensure loader is hidden
          $('.page-loader').hide();
          userInitiatedNav = false;
        } else {
          // normal navigation - make sure loader is hidden once page is ready
          $('.page-loader').fadeOut(200);
        }
      });

      // popstate (history navigation) - treat as non-user-initiated for our loader
      window.addEventListener('popstate', function(){
        $('.page-loader').hide();
        userInitiatedNav = false;
      });
    })(jQuery);
  </script>