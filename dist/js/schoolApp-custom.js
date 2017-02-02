// include element
jQuery(function () {
    $('#header-include').load("header.html");
});
jQuery(document).ready(function(){
    var headerH =  $("#header-include").height(),
    winH = $(window).height();
    $(".content-wrapper .content").css({"height": (winH - headerH) - 70});

	 $('#logout').click(function () {
		console.log("logout");
        window.location.href = 'logout.html';
    });
});



var childId = '';
$(function () {
//                $.mobile.loading( 'show', {
//                        text: 'Loading...',
//                        textVisible: true,
//                        theme: 'b',
//                        html: ""
//                });
var secret = localStorage.getItem("secret");
console.log(secret);
if (secret == null)
{
  window.location.href = 'index.html';
}

$('#children').change(function () {
  childId = $('#children').val();
  if (childId != '') {
      localStorage.setItem("childId", childId);
      window.location.href = 'student_dashboard.html';
  }
});

	console.log(apiUrl);
  $.ajax({
      type: "POST",
      //                url: "http://thethirdthought.in/schoolapp/index.php/user/dashboardetails",
      url: apiUrl + "user/dashboardetails",
      data: {'secret': secret},
      datatype: "json",
      success: function (result) {
        var obj = $.parseJSON(result);
        if (obj.success){
          var nav_html = '';
          $.each(obj.navigation.parent, function (i, obj_navigation) {
//                                console.log(obj_navigation);
              if (obj_navigation.child) {
                  nav_html += '<li class=" treeview"><a href="' + obj_navigation.url + '"><img src="dist/images/icons/'+ obj_navigation.title +'.png" class="aside-icons" /><span>' + obj_navigation.title + '</span> <i class="fa fa-angle-left pull-right"></i></a><ul class="treeview-menu">';
              } else {
                  nav_html += '<li ><a href="' + obj_navigation.url + '"> <i class="fa fa-lock"></i><span>' + obj_navigation.title + '</span></a>';
              }
              if (obj_navigation.child) {
                  $.each(obj_navigation.child, function (i, obj_subnav) {
                      nav_html += '<li><a href="' + obj_subnav.url + '">' + obj_subnav.title + '</a></li>';
                  });
              }
              nav_html += '</ul></li>';

              if (!obj.profile_detail.image)
              {
                  obj.profile_detail.image = "dist/images/no-image.png";
              }
              if (!obj.profile_detail.avtar)
              {
                  obj.profile_detail.avtar = "no-image.png";
              }
              $(".sidebar-menu").html(nav_html);
              localStorage.setItem("nav_html", nav_html);
          });
        }
      }
    });
});
