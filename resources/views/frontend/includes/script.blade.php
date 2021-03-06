
<script src="{{asset('public/frontpanel/js/jquery.js')}}"></script>
<script src="{{asset('public/frontpanel/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/frontpanel/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/frontpanel/js/price-range.js')}}"></script>
<script src="{{asset('public/frontpanel/js/jquery.prettyPhoto.js')}}"></script>

<script>
    $(document).ready(function () {
        $("#selSize").change(function () {
            var idSize = $(this).val();
            if(idSize == ""){
                return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'get-product-price',
                data:{idSize:idSize},
                    success:function(resp) {
                    var arr = resp.split('#');
                    $("#getPrice").html("Rs. "+ arr[0]);
                    $("#price").val(arr[0]);

                    if(arr[1] == 0){
                        $("#cartButton").hide();
                        $("#availability").text("Out of Stock").css('color', 'red');
                    } else {
                        $("#cartButton").show();
                        $("#availability").text(" In Stock").css('color', 'green');
                    }
                },error:function (resp) {
                    alert("Error");
                }
            });
        });
    });
</script>
@yield('script')