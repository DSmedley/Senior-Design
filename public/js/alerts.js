
$(document).on('click', '[id^=changePasswordButton]', function (e) {
  e.preventDefault();
  var data = $(this).serialize();
swal({
  title: "Are you sure?",
  text: "Do you want to change Password?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      swal("Poof! Your Password has been changed!", {
      //icon: "success",
    });
      $('#changePassword').submit();
      
  
  } else {
    swal("Wour Password is unchanged.");
  }
});
});