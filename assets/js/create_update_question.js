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

  function writeQuestionVariants(question) {
    var types = {
      'text' : 'Поле для ответа',
      'select_one':'Выбор одного из списка',
      'select_multiple':'Множественный выбор',
      'radio':'Радио-кнопки',
      'checkbox':'Чек-бокс'
    };
    var questionBlock = $('#condition-value-block');
    var VariantValue = $('#question-visible_condition_value');
    var blockContent = $("<div>");
    var selectList;
    blockContent.append($("<p>").text('Вопрос типа "'+types[question.type]+'"'));
    switch(question.type){
      case 'select_multiple':
        blockContent.append($("<p>").text('Выберите значение при котором появится поле'));
        selectList = $("<select>").attr("multiple",1).addClass('form-control');
        var selectValues = VariantValue.val().split(',');
        question.answerVariants.forEach(function(el){
          var opt = $("<option>").val(el.id).text(el.answer);
          //if(selectValues.indexOf(VariantValue.val())!=-1) opt.attr('selected',true);
          selectList.append(opt);
        });
        selectList.val(selectValues);
        selectList.change(function(){
          VariantValue.val($(this).val().join());
        });
        blockContent.append(selectList);
        break;
      case 'select_one':
      case 'radio':
        blockContent.append($("<p>").text('Выберите значения при котором появится поле'));
        selectList = $("<select>").addClass('form-control');
        question.answerVariants.forEach(function(el){
          var opt = $("<option>").val(el.id).text(el.answer);
          if(VariantValue.val() == el.id) opt.attr('selected',true);
          selectList.append(opt);
        });
        selectList.change(function(){
          VariantValue.val(this.value);
        });
        blockContent.append(selectList);
        VariantValue.val(selectList.find('option:selected').val());
        break;
      case 'checkbox':
        blockContent.append($("<p>").text('Выберите значение при котором появится поле'));
        selectList = $("<select>").addClass('form-control');
        ['Не установлен','Установлен'].forEach(function(answ,k){
          var opt = $("<option>").val(k).text(answ);
          if(VariantValue.val() == k) opt.attr('selected',true);
          selectList.append(opt);
        });
        selectList.change(function(){
          VariantValue.val(this.value);
        });
        blockContent.append(selectList);
        VariantValue.val(selectList.find('option:selected').val());
        break;
      case 'text':
        blockContent.append($('<p>').text('Условия не предусмотрены системой'));
        VariantValue.val('');
      default:
    }

    questionBlock.html(blockContent);
  }

  function visibleAction(){
    var value = $('#question-visible_condition').val();
    if(!value) return;
    var question = {};
    $.get('get-question-data',{question_id : value},function(data){
      question = data.question;
      question.answerVariants = data.answerVariants;
      writeQuestionVariants(question);
    });
  }

  $(".dynamicform_wrapper").on("afterInsert", titleCounter).on("afterDelete", titleCounter);

  var MyForm = document.getElementById('dynamic-form');
  changeAction.call(MyForm.elements['Question[type]']);
  MyForm.elements['Question[type]'].onchange = changeAction;

  visibleAction();

  $('#question-visible_condition').change(function(){
    $('#question-visible_condition_value').val('');
    $('#condition-value-block').html('');
    visibleAction();
  });

});