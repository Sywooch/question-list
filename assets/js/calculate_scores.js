$(function($){
  var SummScores = calculateScores();

  document.addEventListener('change',function(event){
    showOrHideComment(event.target);
    SummScores = calculateScores();
  });

  function showOrHideComment(element){
    var showComment = false;
    var commentBlock = $(element).parents('.one-question-group').eq(0).children('.question-comment');
    switch(element.tagName) {
      case 'SELECT':
        showComment = element.selectedOptions[0].getAttribute('data-showcomment');
        // Показываем или скрываем комментарий
        if(showComment) commentBlock.show();
        else {
          commentBlock.hide().find('textarea').first().text('').val('');
        }
        break;
      case 'INPUT':
        if(element.getAttribute('type')!='radio') break;
        showComment = element.getAttribute('data-showcomment');
        // Показываем или скрываем комментарий
        if(showComment) commentBlock.show();
        else {
          commentBlock.hide().find('textarea').first().text('').val('');
        }
        break;
      default:
    }
  }

  function calculateScores(){
    var SummScores = 0;
    $('input[type=checkbox],input[type=radio], select').each(function(){
      var scores = 0;
      switch(this.tagName){
        case 'SELECT':
          scores  = +$(this).find('option:selected').attr('scores');
          scores = scores ? scores : 0;
          break;
        default:
          if($(this).prop('checked') && $(this).attr('scores')) {
            scores = +$(this).attr('scores');
          }
          break;
      }
      SummScores += scores;
    });

    return SummScores;
  }

  $('.container-questions').find('select, input, textarea').each(function(){
    showOrHideComment(this);
  });

});