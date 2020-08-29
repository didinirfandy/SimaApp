        <!-- JS Scripts-->
        <!-- jQuery Js -->
        <script src="<?= base_url(); ?>assets_app/js/jquery-1.10.2.js"></script>
        <!-- Bootstrap Js -->
        <script src="<?= base_url(); ?>assets_app/js/bootstrap.min.js"></script>

        <!-- Metis Menu Js -->
        <script src="<?= base_url(); ?>assets_app/js/jquery.metisMenu.js"></script>

        <!-- Morris Chart Js -->
        <script src="<?= base_url(); ?>assets_app/js/morris/raphael-2.1.0.min.js"></script>
        <script src="<?= base_url(); ?>assets_app/js/morris/morris.js"></script>

        <script src="<?= base_url(); ?>assets_app/js/easypiechart.js"></script>
        <script src="<?= base_url(); ?>assets_app/js/easypiechart-data.js"></script>

        <!-- Lightweight Chart -->
        <script src="<?= base_url(); ?>assets_app/js/Lightweight-Chart/jquery.chart.js"></script>
        <script src="<?= base_url(); ?>assets_app/js/canvasjs.min.js"></script>

        <!-- DATA TABLE SCRIPTS -->
        <script src="<?= base_url(); ?>assets_app/js/dataTables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets_app/js/dataTables/dataTables.bootstrap.js"></script>

        <script src="<?= base_url(); ?>assets_app/js/popper.min.js"></script>
        <script src="<?= base_url(); ?>assets_app/js/main.js"></script>

        <!-- Select 2 Js -->
        <script src="<?= base_url(); ?>assets_app/js/select2.full.min.js"></script>

        <!-- SweetAlert Js -->
        <script type="text/javascript" src="<?= base_url(); ?>assets_app/plugins/bootstrap-notify.min.js"></script>
        <script type="text/javascript" src="<?= base_url(); ?>assets_app/plugins/sweetalert.min.js"></script>

        <script type="text/javascript" src="<?= base_url(); ?>assets_app/js/time.js"></script>

        <script type="text/javascript">
                $(document).ready(function() {
                        $(".selectbox").select2();
                        $('#brg_tbl').dataTable();

                        $('#main-menu').metisMenu();

                        $(window).bind("load resize", function() {
                                if ($(this).width() < 768) {
                                        $('div.sidebar-collapse').addClass('collapse')
                                } else {
                                        $('div.sidebar-collapse').removeClass('collapse')
                                }
                        });

                        $("#sideNav").click(function() {
                                if ($(this).hasClass('closed')) {
                                        $('.navbar-side').animate({
                                                left: '0px'
                                        });
                                        $(this).removeClass('closed');
                                        $('#page-wrapper').animate({
                                                'margin-left': '250px'
                                        });

                                } else {
                                        $(this).addClass('closed');
                                        $('.navbar-side').animate({
                                                left: '-250px'
                                        });
                                        $('#page-wrapper').animate({
                                                'margin-left': '0px'
                                        });
                                }
                        });
                });
        </script>