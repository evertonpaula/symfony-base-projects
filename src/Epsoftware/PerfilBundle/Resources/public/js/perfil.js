$(function(){
    //Skin switcher
    var current_skin = "skin-blue";
    $('#layout-skins-list [data-skin]').click(function(e) {
      e.preventDefault();
      var skinName = $(this).data('skin');
      $('body').removeClass(current_skin);
      $('body').addClass(skinName);
      current_skin = skinName;
    });
});
