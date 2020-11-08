// A $( document ).ready() block.
$(document).ready(function () {
    
    var elementHeight = 0;
    var dataAnswer =[];

    function showSubmitButtonQuiz(dataAnswer) {
        if (dataAnswer.length == 7) {
            $("#buttonQuiz").removeAttr('disabled');
        }
    }

    function scrollDownBelow(elementHeight)
    {
        var scrollBottom = $(window).scrollTop() ;
        $(window).scrollTop(scrollBottom + elementHeight);
    }

    $("#sizelist").on("click", "li", function (e) {
        e.preventDefault();
        var $this = $(this);
        var elementHeight = $('#seccond-quiz').height();
        scrollDownBelow(elementHeight);
        $this.addClass("select-data-quiz").siblings().removeClass("select-data-quiz");
        dataAnswer.push($this.data("value"));
        $("#sizevalue_1").val($this.data("value"));
        showSubmitButtonQuiz(dataAnswer);
    })

    $("#sizelist_2").on("click", "li", function (e) {
        e.preventDefault();
        var $this = $(this);
        var elementHeight = $('#third-quiz').height();
        scrollDownBelow(elementHeight);
        $this.addClass("select-data-quiz_2").siblings().removeClass("select-data-quiz_2");
        dataAnswer.push($this.data("value"));
        $("#sizevalue_2").val($this.data("value"));
        showSubmitButtonQuiz(dataAnswer);
    })

    $("#sizelist_3").on("click", "li", function (e) {
        e.preventDefault();
        var $this = $(this);
        var elementHeight = $('#fourth-quiz').height() + 100;
        scrollDownBelow(elementHeight);
        $this.addClass("select-data-quiz_3").siblings().removeClass("select-data-quiz_3");
        dataAnswer.push($this.data("value"));
        $("#sizevalue_3").val($this.data("value"));
        showSubmitButtonQuiz(dataAnswer);
    })

    $("#sizelist_4").on("click", "li", function (e) {
        e.preventDefault();
        var $this = $(this);
        var elementHeight = $('#fifth-quiz').height() + 100;
        scrollDownBelow(elementHeight);
        $this.addClass("select-data-quiz_4").siblings().removeClass("select-data-quiz_4");
        dataAnswer.push($this.data("value"));
        $("#sizevalue_4").val($this.data("value"));
    })

    $("#sizelist_5").on("click", "li", function (e) {
        e.preventDefault();
        var $this = $(this);
        var elementHeight = $('#sixth-quiz').height() + 100;
        scrollDownBelow(elementHeight);
        $this.addClass("select-data-quiz_5").siblings().removeClass("select-data-quiz_5");
        dataAnswer.push($this.data("value"));
        $("#sizevalue_5").val($this.data("value"));
        showSubmitButtonQuiz(dataAnswer);
    })

    $("#sizelist_6").on("click", "li", function (e) {
        e.preventDefault();
        var $this = $(this);
        var elementHeight = $('#seventh-quiz').height() + 100;
        scrollDownBelow(elementHeight);
        $this.addClass("select-data-quiz_6").siblings().removeClass("select-data-quiz_6");
        dataAnswer.push($this.data("value"));
        $("#sizevalue_6").val($this.data("value"));
        showSubmitButtonQuiz(dataAnswer);
    })

    $("#sizelist_7").on("click", "li", function (e) {
        e.preventDefault();
        var $this = $(this);
        var elementHeight = $('#submitContainer').height() + 300;
        scrollDownBelow(elementHeight);
        $this.addClass("select-data-quiz_7").siblings().removeClass("select-data-quiz_7");
        dataAnswer.push($this.data("value"));
        $("#sizevalue_7").val($this.data("value"));
        showSubmitButtonQuiz(dataAnswer);
    })

    // Function on landing page quizs
    $("#emailForm").hide();
    $("#cashtagTrigger").hide();
    $("#emailFormButton").click(function(e){
        e.preventDefault();
        $("#cashTagForm").hide();
        $(".form-separator").hide();
        $("#emailForm").show();
        $("#cashtagTrigger").show();
    });

    

    $('#emailFormButtonCashtag').click(function(e){
        e.preventDefault();
        $("#cashTagForm").show();
        $(".form-separator").hide();
        $("#emailForm").hide();
        $("#emailTrigger").show();
    })
    

    $("#cashtagField").keydown(function (e) {
        var oldvalue = $(this).val();
        var field = this;
        setTimeout(function () {
            if (field.value.indexOf('$') !== 0) {
                $(field).val(oldvalue);
            }
        }, 1);
    });
});