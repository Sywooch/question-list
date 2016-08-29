$(function($){

  function showHideQuestion(element) {
    element = $(element);
    var questionId = element.attr('data-question-id');
    var value = element.prop('type')=='checkbox' ? element.prop('checked') : element.val();
    if(!questionId) return;

    var linkedElement = $('.one-question-block[data-visible-condition-linked-question-id='+questionId+']');
    if(!linkedElement) return;

    var linkedElementValue = linkedElement.attr('data-visible-condition-linked-question-value');
    if(linkedElementValue == value) {
      linkedElement.removeClass('hidden-question').slideDown();
    } else {
      linkedElement.addClass('hidden-question').slideUp();
      linkedElement.find('.question-field').find('select, input').val('');
      linkedElement.find('.question-field').find('textarea').text('');
      linkedElement.find('.question-comment').hide().find('textarea').text('');
    }
  }

  function renumberQuestions(){
    var num = 1;
    // Перенумеруем вопросы, все кроме скрытых
    $('h4 span.label-info').each(function(k, el){
      if(!$(el).parents('.one-question-block').hasClass('hidden-question')) {
        $(el).text('Вопрос №'+num);
        num++;
      }
    });
  }

  document.getElementsByClassName('container-questions')[0].addEventListener('change',function(event){
    showHideQuestion(event.target);
    renumberQuestions();
  });

  $('.question-field').find('input[type!=hidden],select, textarea').each(function(k, el){
    showHideQuestion(el);
    renumberQuestions();
  });

});