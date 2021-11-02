@php($vendor = ['vendor' => (int) config('cashier.vendor_id')])

<script src="https://cdn.paddle.com/paddle/paddle.js"></script>
<script type="text/javascript">
    const vendor = @json($vendor);
    const redirectTo = "{{ route('payment.success') }}";
    Paddle.Setup({...vendor, eventCallback: function(data) {
            console.log(data, ">>>>>>>>>>>>>>>>>>>>>>>>>>")
            if (data.event === "Checkout.Complete") {
                window.location.href = redirectTo;
            }
            //window.location.reload();
        }});
</script>
