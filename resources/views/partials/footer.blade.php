   <script>
       // Empêche le scroll chaining sur le sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.pcoded-navbar');
            
            if (sidebar) {
                sidebar.addEventListener('wheel', function(e) {
                    // Empêche le scroll de passer au parent
                    const isAtTop = this.scrollTop === 0;
                    const isAtBottom = this.scrollHeight - this.scrollTop === this.clientHeight;
                    
                    if ((isAtTop && e.deltaY < 0) || (isAtBottom && e.deltaY > 0)) {
                        e.preventDefault();
                    }
                }, { passive: false });
            }
        });
    </script>
   <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- waves js -->
    <script src="{{ asset('assets/pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- slimscroll js -->
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>

    <!-- menu js -->
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/vertical/vertical-layout.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>