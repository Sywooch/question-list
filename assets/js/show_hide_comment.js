$(function($){
  document.addEventListener('change',function(event){
    showOrHideComment(event.target);
  });

  function showOrHideComment(element){
    var showComment = false;
    var commentBlock = $(element).parents('.one-question-group').eq(0).children('.question-comment');
    switch(element.tagName) {
      case 'SELECT':
        var selectedOption = $(element).find('option:selected');
        if(!selectedOption || !selectedOption.attr('data-showcomment')){
          // Показываем или скрываем комментарий
          commentBlock.hide().find('textarea').first().text('').val('');
        } else {
          commentBlock.show();
        }
        break;
      case 'INPUT':
        if($(element).attr('type')!='radio' || !$(element).prop('checked')) break;
        // Показываем или скрываем комментарий
        if(element.getAttribute('data-showcomment')) {
          commentBlock.show();
        } else {
          commentBlock.hide().find('textarea').first().text('').val('');
        }
        break;
      default:
    }
  }

  $('.container-questions').find('select, input, textarea').each(function(){
    showOrHideComment(this);
  });

});