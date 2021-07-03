$(document).ready(function(){
    $("#characters").on("change", ".rate", function(e, data){
        characterRate(data.to, $(this).attr('alt'));
    });
    $("#portal").on("change", ".rate", function(e, data){
        characterRate(data.to, $(this).attr('alt'));
    });
    function characterRate(rate, character_id){
        $.ajax({
			url: "components/ajax/rate_character.php",
			method: "post",
			data: {
                rate : rate,
                character_id : character_id
			},
			dataType: "json",
			success: function(res){
                console.log(res);
			}
        })
    }
    $("#search-form").submit(function(){
        $("#search-form").css("margin-top", "0");
        $.ajax({
			url: "components/ajax/search_characters.php",
            method: "post",
			data: {
				content : $("#searchInput").val(),
				status : $("#searchSelectStatus").val(),
				gender : $("#searchSelectGender").val()
			},
            dataType: "json",
			success: function(res){
                console.log(res);
                var counter = 0;
                var characters = ""
				$.each( res, function( key, value ){
                    var character_div = "";
                    if (counter % 4 == 0) {character_div += "<div class='row'>";}
                    character_div += "<div class='col'>";
                    character_div += "<div class='card mb-3 character rounded-0' style=''>";
                    character_div += "<img src='" + res[key]['image'] + "' class='card-img-top rounded-0'></img>";
                    character_div += "<div class='card-body'>";
                    character_div += "<h5 class='card-title mb-0 mt-2 osr'>Nome: " + res[key]['name'] + "</h5>";
                    character_div += "<h5 class='card-title mb-0 mt-2 osr'>Status: " + res[key]['status'] + "</h5>";
                    character_div += "<h5 class='card-title mb-0 mt-2 osr'>Species: " + res[key]['species'] + "</h5>";
                    character_div += "<h5 class='card-title mb-0 mt-2 osr'>Type: " + res[key]['type'] + "</h5>";
                    character_div += "<h5 class='card-title mb-0 mt-2 osr'>Gender: " + res[key]['gender'] + "</h5>";
                    character_div += "<div class='rate my-0 py-0' data-rate-value="+res[key]['rate']+" alt='"+res[key]['id']+"'></div>";
                    character_div += "</div></div></div>";
                    if (counter % 4 == 3) {character_div += "</div>";}
                    characters += character_div;
                    counter += 1;
                });
                $("#characters").html(characters);
                var options = {
                    max_value: 5,
                    step_size: 1,
                }
                $(".rate").rate(options);
			}
        })
        return false;
    });
    $("#searchLucky").click(function(){
        $.ajax({
			url: "components/ajax/search_characters.php",
			method: "post",
			data: {
				content : $("#searchInput").val(),
				status : $("#searchSelectStatus").val(),
				gender : $("#searchSelectGender").val()
			},
			dataType: "json",
			success: function(res) {
                $("#portal").show();
                $("#portal img").animate({
                    padding: '0'
                }, "slow");
                var character = res[Math.floor(Math.random() * res.length)];
                $("#portal .portal-body div").html("<img src='"+character['image']+"' class='rounded-circle'></img><div class='name mt-3'>" + character['name'] + "</div><div class='rate' data-rate-value="+character['rate']+" alt='"+character['id']+"'></div><div class='btn btn-danger btn-sm'>Close</div>");
                $("#portal .portal-body div img").animate({
                    width: '300px',
                    height: '300px',
                    margin: '0 0 0 0'
                }, "slow");
                setTimeout(function(){
                    $("#portal .portal-body div div").show();
                    var options = {
                        max_value: 5,
                        step_size: 1,
                    }
                    $(".rate").rate(options);
                }, 600);
			}
        })
    });
    $("#portal").on("click", ".btn", function(){
        $("#portal").hide();
        $("#portal img").css("padding", "100%");
    });
    $("#logoutButton").click(function(){
        Cookies.remove('user');
        location.reload();
    });
    $("#login-form").submit(function(){
        $.ajax({
			url: "components/ajax/login.php",
			method: "post",
			data: {
				email : $("#loginEmail").val(),
				password : $("#loginPassword").val()
			},
			dataType: "json",
			success: function(res){
                if (res[0] > 0){
                    $("#login-form input").addClass("error");
                    alert(res[1]);
                }
                if (res[0] == 0){
                    location.reload();
                }
			}
        })
        return false;
    });
    $("#login-form input").click(function(){
        $(this).removeClass("error");
    });
    $("#register-form").submit(function(){
        $.ajax({
			url: "components/ajax/register.php",    //Plik zwracający dane z dialami w postaci JSON
			method: "post",
			data: {
				email : $("#registerEmail").val(),
				password : $("#registerPassword").val(),
				passwordrepeat : $("#registerRepeatPassword").val()
			},
			dataType: "json",
			success: function(res) {
                if (res[0] == 1) {
                    $("#register-form input").addClass("error");
                    alert(res[1]);
                }
                if (res[0] == 2) {
                    $("#registerRepeatPassword").addClass("error");
                    alert(res[1]);
                }
                if (res[0] == 0) {
                    location.reload();
                }
			}
        })
        return false;
    });
});