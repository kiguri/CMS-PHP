$(document).ready(function(){
    //CK EDITOR
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch( error => {
            console.error( error );
        });
    //SELECT ALL CHECKBOX
    $('#selectAllBoxes').click(function(){
        if(this.checked) {
            $('.checkBoxes').each(function(){
                this.checked = true;
            })
        } else {
            $('.checkBoxes').each(function(){
                this.checked = false;
            })
        }
     })
});

function loadUsersOnline() {
    $.get("functions.php?onlineusers=result", function(data){
        $(".useronline").text(data);
    });
}

setInterval(function(){
    loadUsersOnline();
}, 500);

    