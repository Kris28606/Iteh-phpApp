$('#dodajForm').submit(function(){
    //1h trecih vezbi-objasnjenje
    //zaustavi refresh stranice
    event.preventDefault();
    console.log("Dodavanje");
    //this se odnosi na ovu formu
    const $form =$(this);
    //svi nasi inputi koje treba da pokupi
    const $input = $form.find('input, select, button, textarea');
    //da serijalizujemo podatke iz forme i posaljemo ih postu
    const serijalizacija = $form.serialize();
    console.log(serijalizacija);
    //na sve inpute, ne dozvoljavamo dalji unos
    $input.prop('disabled', true);
  
    
    //krece ajax
    //neki request
    //prihvata JSON kao obj, koji je niz, prvo imamo url, 
    //kada se pokrene ajax zahtev nad dodajForm formom ja hocu da se taj zahtev obradjuje u okviru add.php-a
    //tip je post, jer je forma post, data je serijalizacija
    req = $.ajax({
        url: 'handler/add.php',
        type:'post',
        data: serijalizacija
    });
    //kada zavrsim sa time, kreira se funkcija, koja ima odgovor, status i neki jq
    req.done(function(res, textStatus, jqXHR){
        //ovo je odg iz statusa, onaj echo iz add.php, odg nazad se salje kroz echo
        if(res=="Success"){
            Swal.fire( {

                title: 'Dodata!',
                text: 'Ocena je uspešno dodata.',
                confirmButtonColor: 'rgb(255, 142, 37)',
                icon: 'success',
              }).then((result) => {
                if (result.isConfirmed) {
                    location.reload(true);
                }
                }
            )
            // 
        }else 
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ocena nije dodata.',
              })
        }
        
    });

    req.fail(function(jqXHR, textStatus, errorThrown){
        console.error('Sledeca greska se desila: '+textStatus, errorThrown)
    });
});




$('#btn-pretraga').click(function () {

    var para = document.querySelector('#myInput');
    console.log(para);
    var style = window.getComputedStyle(para);
    console.log(style);
    if (!(style.display === 'inline-block') || ($('#myInput').css("visibility") ==  "hidden")) {
        console.log('block');
        $('#myInput').show();
        document.querySelector("#myInput").style.visibility = "";
    } else {
       document.querySelector("#myInput").style.visibility = "hidden";
    }
});

