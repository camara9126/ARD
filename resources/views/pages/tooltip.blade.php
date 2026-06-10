    @include('partials.header')

                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Animated Tooltip</h5>
                                            <p class="m-b-0">Lorem Ipsum is simply dummy text of the printing</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Basic Components</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Animated Tooltip</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- Tooltip on button card start -->
                                                <div class="card button-page o-visible">
                                                    <div class="card-header">
                                                        <h5>Tooltip</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <ul>
                                                            <li>
                                                                <button type="button" class="btn btn-default waves-effect" data-toggle="tooltip" data-placement="top" title="tooltip on top">Top
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="tooltip" data-placement="left" title="tooltip on left">Left
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="right" title="tooltip on right">right
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="btn btn-warning waves-effect waves-light" data-toggle="tooltip" data-placement="bottom" title="tooltip on bottom">bottom
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="tooltip" data-html="true" title="<em>Tooltip</em> <u>with</u> <b>HTML</b>">Html Tooltip
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- Tooltip on button card end -->
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- Tooltip on popover card start -->
                                                <div class="card o-visible">
                                                    <div class="card-header">
                                                        <h5>Popover</h5>
                                                    </div>
                                                    <div class="card-block tooltip-pop button-list">
                                                        <button type="button" class="btn btn-default waves-effect" data-toggle="popover" data-placement="top" title="" data-content="top by popover" data-original-title="tooltip on top">Top
                                                        </button>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="popover" data-placement="left" title="tooltip on left" data-content="left by popover">Left
                                                        </button>
                                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="popover" data-placement="right" title="tooltip on right" data-content="right by popover">right
                                                        </button>
                                                        <button type="button" class="btn btn-warning waves-effect waves-light" data-toggle="popover" data-placement="bottom" title="tooltip on bottom" data-content="bottom by popover">bottom
                                                        </button>
                                                        <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="popover" data-html="true" data-placement="top" title="<em>Tooltip</em> <u>with</u> <b>HTML</b>"
                                                            data-content="tooltip by HTML">Html Tooltip
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Tooltip on popover card end -->
                                            </div>
                                            <div class="col-sm-12">
                                                <!-- Tooltips on textbox card start -->
                                                <div class="card o-visible">
                                                    <div class="card-header">
                                                        <h5>Tooltips On Textbox</h5>
                                                    </div>
                                                    <div class="card-block tooltip-icon button-list">
                                                        <div class="input-group">
                                                            <span class="input-group-prepend" id="name"><label class="input-group-text"><i class="icofont icofont-user-alt-3"></i></label></span>
                                                            <input type="text" class="form-control" placeholder="Enter your name" title="Enter your name" data-toggle="tooltip">
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend" id="name"><label class="input-group-text"><i class="icofont icofont-ui-email"></i></label></span>
                                                            <input type="text" class="form-control" placeholder="Enter email" title="Enter email" data-toggle="tooltip">
                                                        </div>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light m-r-20" data-toggle="tooltip" data-placement="right" title="submit">Submit
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Tooltips on textbox card end -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Main-body end -->
                    <div id="styleSelector">

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="assets/js/jquery/jquery.min.js "></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/vertical/vertical-layout.min.js"></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function() {
                    return $('#primary-popover-content').html();
                }
            });
        });
    </script>
    <!-- Custom js -->
    <script type="text/javascript" src="assets/js/script.js"></script>

</body>

</html>
