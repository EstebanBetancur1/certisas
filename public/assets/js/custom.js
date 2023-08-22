$('#registrarme').on("click", function(){
  $('#c1').addClass('move');
  $("#c2").removeClass("move2");
  });
  
  $("#iniciar").on("click", function () {
    $("#c1").removeClass("move");
    $("#c2").addClass("move2");
  });
  
  
  $('.menu-btn').on('click', function(){
    $(this).toggleClass('close-btn')
    $('aside').toggleClass('show-aside')
  })
  
  $('.open-filter').on('click', function(){
    $(this).addClass('active-btn')
    $('.filter-container').toggleClass('show-filter-container')
  })
  
  $("body").on("click", function () {
    $('.filter-container').removeClass("show-filter-container");
    $('.open-filter').removeClass('active-btn');
    $('.menu').removeClass('show-menu');
    $('aside').removeClass('show-aside');
    $('.menu-btn').removeClass('close-btn');
  });
  
  
  $('.filter-container , .open-filter , .profile-option , .menu , aside , .menu-btn').on("click", function (e) {
    e.stopPropagation();
  });
  
  $('#all-rows input').on('click', function(){
    if($(this).prop("checked") == true){
      $('table input[type="checkbox"]').prop("checked", true);
      $('.table-action').removeClass('d-none')
    }
    else if($(this).prop("checked") == false){
      $('table input[type="checkbox"]').prop("checked", false);
      $('.table-action').addClass('d-none')
    }
  })
  
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    $("[rel='tooltip']").tooltip();
  })

  // var tooltip = $("[rel='tooltip']");

  // $('[data-toggle="modal"]').on('click', function(){
  //   tooltip.toggle()
  // })
  
  $('.upload input').on('change', function(e) {
    var filename = e.target.files[0].name;
    $(this).parent().find('label').html(filename);
    $(this).parent().toggleClass('checked');
  });
  
  $('.profile-option').on('click', function(){
    $('.menu').toggleClass('show-menu')
  })
  
  $('.table-checkbox-row').on('change', function(){
    $(this).parent().parent().parent().toggleClass('row-selected')
  })
  
  // modal function
  
  $('.modal-btn').on("click", function(){
    var modal = $(this).attr('data-buttonmodal');
    $('[data-modal="'+ modal + '"]').addClass('show-modal')
  });
  $('.modal-shade').on("click", function(){
    $(this).parent().removeClass('show-modal')
  });
  
  $('.close-modal').on('click', function(){
    $(this).parent().parent().parent().parent().removeClass('show-modal')
  })
  