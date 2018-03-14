//SweetAlerts - Change User Password
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
    swal("Your Password is unchanged.");
  }
});
});



//SweetAlerts - Change User Email
$(document).on('click', '[id^=changeEmailButton]', function (e) {
  e.preventDefault();
  var data = $(this).serialize();
swal({
  title: "Are you sure?",
  text: "Do you want to change Email?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      swal("Poof! Your Email has been changed!", {
      //icon: "success",
    });
      $('#changeEmail').submit();
      
  
  } else {
    swal("Your Email is unchanged.");
  }
});
});
