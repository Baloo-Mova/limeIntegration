<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
<script src="https://unpkg.com/bootstrap-switch"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript" src="{{asset('js/jquery.tinymce.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tinymce.min.js')}}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
