//script for hide & show button edit profile
$("#btneditName").hide();
$("#btneditCredential").hide();
$("#btneditDesc").hide();

$("#name").mouseenter(function(){
    $("#btneditName").show();
});
$("#name").mouseleave(function(){
    $("#btneditName").hide();
});
$("#credential").mouseenter(function(){
    $("#btneditCredential").show();
});
$("#credential").mouseleave(function(){
    $("#btneditCredential").hide();
});
$("#desc").mouseenter(function(){
    $("#btneditDesc").show();
});
$("#desc").mouseleave(function(){
    $("#btneditDesc").hide();
});

//script for currently checkbox
if($("#currently").prop("checked") == true){
    $("#endyear").hide();
}
if($("#currently2").prop("checked") == true){
    $("#endyear2").hide();
}
$("#currently").on('click',function(){
if($(this).prop("checked") == true){
    $("#endyear").hide();
}else if($(this).prop("checked") == false){
    $("#endyear").show();
}
});
$("#currently2").on('click',function(){
if($(this).prop("checked") == true){
    $("#endyear2").hide();
}else if($(this).prop("checked") == false){
    $("#endyear2").show();
}
});

//script for show years in dropdown
let startyearDropdown = document.getElementById('startyear-dropdown');
let endyearDropdown = document.getElementById('endyear-dropdown');
let startyearDropdown2 = document.getElementById('startyear-dropdown2');
let endyearDropdown2 = document.getElementById('endyear-dropdown2');
let gradyearDropdown = document.getElementById('gradyear-dropdown');

yeardropdown(startyearDropdown);
yeardropdown(endyearDropdown);
yeardropdown(startyearDropdown2);
yeardropdown(endyearDropdown2);
yeardropdown(gradyearDropdown);

function yeardropdown(dropdown){
    let currentYear = new Date().getFullYear();    
    let earliestYear = 2000;     
    while (currentYear >= earliestYear) {      
        let dateOption = document.createElement('option');          
        dateOption.text = currentYear;      
        dateOption.value = currentYear;        
        dropdown.add(dateOption);      
        currentYear -= 1;    
    }
}

//profile show
$('.ajax-loading-2').hide();
$('#noData').hide();

$(document).on('click','#showTopics',function(e){
    $('#noData').hide();
    $("#showQuestionsHtml").hide();
    $("#showAnswersHtml").hide();
    $("#showTopicsHtml").show();
    e.preventDefault();
    let site_url = $(this).attr('data-href');
    let html = "";
    $.ajax({
        url: site_url,
        type: 'get',
        dataType: 'json',
        beforeSend: function(){
            $('.ajax-loading-2').show();
        }
    })
    .done(function(data){
        $('.ajax-loading-2').hide();
        $.each(data, function(index,value){
            if(value.length === 0){
                $('#noData').show();
            }else{
                for (let i=0; i< value.length; i++) {
                    html += '<div class="col-12">' + '<b>' + '<a href="#" class="text-dark">' + value[i].name + '</a>' + '</b>' + '<span class="float-right">' + '(' + value[i].qty +  ' Followers)' + '</span>' + '<hr>' + '</div>'
                }
                $("#showTopicsHtml").html(html); 
            }
            
        });
        
    })
})

$(document).on('click','#showQuestions',function(e){
    $('#noData').hide();
    $("#showAnswersHtml").hide();
    $("#showTopicsHtml").hide();
    $("#showQuestionsHtml").show();
    e.preventDefault();
    let site_url = $(this).attr('data-href');
    let html2 = "";
    $.ajax({
        url: site_url,
        type: 'get',
        dataType: 'json',
        beforeSend: function(){
            $('.ajax-loading-2').show();
        }
    })
    .done(function(data){
        $('.ajax-loading-2').hide();
        $.each(data, function(index,value){
            if(value.length === 0){
                $('#noData').show();
            }else{
                for (let i=0; i< value.length; i++) {
                    let title_slug = value[i].title_slug;
                    html2 += '<div class="col-12">' + '<b>' + '<a href="/' + title_slug + '" class="text-dark">' + value[i].title + '</a>' + '</b>' + '<hr>' + '</div>'
                }
                $("#showQuestionsHtml").html(html2); 
            }
            
        });
        
    })
})


$(document).on('click','#showAnswers',function(e){
    $('#noData').hide();
    $("#showQuestionsHtml").hide();
    $("#showTopicsHtml").hide();
    $("#showAnswersHtml").show();
    e.preventDefault();
    let site_url = $(this).attr('data-href');
    let html3 = "";
    $.ajax({
        url: site_url,
        type: 'get',
        dataType: 'json',
        beforeSend: function(){
            $('.ajax-loading-2').show();
        }
    })
    .done(function(data){
        let name_slug = $('#name').attr('data-attr');
        $('.ajax-loading-2').hide();
        $.each(data, function(index,value){
            if(value.length === 0){
                $('#noData').show();
            }else{
                for (let i=0; i< value.length; i++) {
                    let title_slug = value[i].question.title_slug;
                    let title = value[i].question.title;
     
                    html3 += '<div class="col-12">' + '<b>' + '<a href="/' + title_slug + '#'+ name_slug +'" class="text-dark">' + title + '</a>' + '</b>' + '<br>' + value[i].text + '<hr>' + '</div>';
                }
                $("#showAnswersHtml").html(html3); 
            }
            
        });
        
    })
})