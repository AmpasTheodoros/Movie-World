$(document).ready(function(){

    // if the user clicks on the like button ...
    $('.like-btn').on('click', function(){
      var post_id = $(this).data('id');
      $clicked_btn = $(this);
      if ($clicked_btn.hasClass('far fa-thumbs-up')) {
          action = 'like';
      } else if($clicked_btn.hasClass('fas fa-thumbs-up')){
          action = 'unlike';
      }
      $.ajax({
          url: 'index.php',
          type: 'post',
          data: {
              'action': action,
              'post_id': post_id
          },
          success: function(data){
              res = JSON.parse(data);
              if (action == "like") {
                  $clicked_btn.removeClass('far fa-thumbs-up');
                  $clicked_btn.addClass('fas fa-thumbs-up');
              } else if(action == "unlike") {
                  $clicked_btn.removeClass('fas fa-thumbs-up');
                  $clicked_btn.addClass('far fa-thumbs-up');
              }
              // display the number of likes and dislikes
              $clicked_btn.siblings('span.likes').text(res.likes);
              $clicked_btn.siblings('span.dislikes').text(res.dislikes);
    
              // change button styling of the other button if user is reacting the second time to post
              $clicked_btn.siblings('i.fas fa-thumbs-down').removeClass('fas fa-thumbs-down').addClass('far fa-thumbs-down');
          }
      });		
    
    });
    
    // if the user clicks on the dislike button ...
    $('.dislike-btn').on('click', function(){
      var post_id = $(this).data('id');
      $clicked_btn = $(this);
      if ($clicked_btn.hasClass('far fa-thumbs-down')) {
          action = 'dislike';
      } else if($clicked_btn.hasClass('fas fa-thumbs-down')){
          action = 'undislike';
      }
      $.ajax({
          url: 'index.php',
          type: 'post',
          data: {
              'action': action,
              'post_id': post_id
          },
          success: function(data){
              res = JSON.parse(data);
              if (action == "dislike") {
                  $clicked_btn.removeClass('far fa-thumbs-down');
                  $clicked_btn.addClass('fas fa-thumbs-down');
              } else if(action == "undislike") {
                  $clicked_btn.removeClass('fas fa-thumbs-down');
                  $clicked_btn.addClass('far fa-thumbs-down');
              }
              // display the number of likes and dislikes
              $clicked_btn.siblings('span.likes').text(res.likes);
              $clicked_btn.siblings('span.dislikes').text(res.dislikes);
              
              // change button styling of the other button if user is reacting the second time to post
              $clicked_btn.siblings('i.fas fa-thumbs-up').removeClass('fas fa-thumbs-up').addClass('far fa-thumbs-up');
          }
      });	
    
    });
    
});