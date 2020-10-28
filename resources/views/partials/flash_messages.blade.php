@if($message = session()->has('success'))
  <script type="text/javascript">
     swal({
         title:'Success!',
         text:"{{ session()->get('success') }}",
         type:'success',
         timer:5000
     }).then((value) => {
       //location.reload();
     }).catch(swal.noop);
 </script>
 @endif

@if($message = session()->has('error'))
 <script type="text/javascript">
    swal({
        title:'Oops!',
        text:"{{ session()->get('error') }}",
        type:'error',
        timer:5000
    }).then((value) => {
      //location.reload();
    }).catch(swal.noop);
</script>
@endif

@if ($errors->any())
@endif