<div class="comments">

</div>

@push('scripts')
<script>
  $(document).ready(function() {
    $.get("{{route('user.productratings', $services->id)}}", function(data){
      console.log(data);
      for (var i = 0; i < data.length; i++) {
        $("#rateYo"+data[i].id).rateYo({
          rating: data[i].rating,
          readOnly: true,
          starWidth: "16px"
        });
      }

    });
  });
</script>
@endpush
