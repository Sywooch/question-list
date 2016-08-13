$(function($){
  var answerVariantsBlock = document.getElementById('answer-variants-block');
  var container = document.querySelectorAll('.dynamicform_wrapper')[0];

  function titleCounter(e, item) {

    var heads = container.querySelectorAll('.panel-title');
    for(var i=0;i<heads.length;i++){
      heads[i].innerHTML = heads[i].innerHTML.replace(/[0-9]/g,'') + ' ' + (i+1);
    }
  }

  function changeAction(event){
    var answerVariantsBlock = document.getElementById('answer-variants-block');
    var checkboxScoreBlock = document.getElementById('checkbox-scores-block');
    switch(this.value) {
      case 'checkbox' :
        checkboxScoreBlock.hidden = false;
        answerVariantsBlock.hidden = true;
        break;
      case 'select_one' :
      case 'select_multiple' :
      case 'radio' :
        answerVariantsBlock.hidden = false;
        checkboxScoreBlock.hidden = true;
        break;
      default :
        answerVariantsBlock.hidden = true;
        checkboxScoreBlock.hidden = true;
    }
  }

  $(".dynamicform_wrapper").on("afterInsert", titleCounter);
  $(".dynamicform_wrapper").on("afterDelete", titleCounter);

  var MyForm = document.getElementById('dynamic-form');
  changeAction.call(MyForm.elements['Question[type]']);
  MyForm.elements['Question[type]'].onchange = changeAction;

  /*MyForm.addEventListener('submit',function(event){
    var answerVariantsBlock = $('#answer-variants-block');

    var checkboxScoreBlock = $('#checkbox-scores-block');
    switch(this.elements['Question[type]'].value)
    {
      case 'select_one' :
      case 'select_multiple' :
      case 'radio' :
        checkboxScoreBlock.remove();
        break;
      case 'checkbox' :
        answerVariantsBlock.remove();
        break;
      default :
        answerVariantsBlock.remove();
        checkboxScoreBlock.remove();
    }

  });*/

});