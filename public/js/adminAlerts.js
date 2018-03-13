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

//SweetAlerts - Ban User
$("#banUserButton").click( function (e) {
  e.preventDefault();
  var data = $(this).serialize();
  var link= $(this).closest("a").attr("href");
swal({
  title: "Are you sure?",
  text: "Do you want to Ban User?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
}) 
.then((willDelete) => {
    if (willDelete) {
      swal("Poof! User has been Banned!", {
      //icon: "success",
    });
      $.ajax({
            url: link,
            type: "get",
            success: function(result){window.location.reload()}
         });
      
  
  } else {
    swal("User is not Banned.");
  }
});
});


//SweetAlerts - Unban User
$("#unbanUserButton").click( function (e) {
  e.preventDefault();
  var data = $(this).serialize();
  var link= $(this).closest("a").attr("href");
swal({
  title: "Are you sure?",
  text: "Do you want to Unban User?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
}) 
.then((willDelete) => {
    if (willDelete) {
      swal("Poof! User has been Unbanned!", {
      //icon: "success",
    });
      $.ajax({
            url: link,
            type: "get",
            success: function(result){window.location.reload()}
         });
      
  
  } else {
    swal("User is still Banned.");
  }
});
});

