window.onload = function(){

    var errorAddress = function(data){
        console.warn('ERRO FATAL: ',data);
    };

    var setOptionsAddress = function(data, select){
        $(select).html(data).fadeIn();
    };

    var getFormEditAddress = function(data){
        if(data.warning || data.error){
            callMesageAddress(data);
        }else{
            var $modal = $("#modal_address_edit").find('.modal-content');
            var $html = $(data);
            $($modal).html($html).fadeIn();
        }
    };

    var getListAddress = function(url, method, data, setOptions, select){
        Pace.track(function(){
            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(data){setOptions(data,select);},
                error: errorAddress
            });
        });
    };
    
    var callMesageAddress = function(data){
        if(data.success){
            success(data);
        }else if(data.warning){
            warning(data);
        }else if(data.info){
            info(data);
        }else if(data.error){
            var message = JSON.parse(data.message);
                for(var i = 0; i < message.length; i++){
                error(message[i]);
            }
        }       
    };
    
    var addNewAddressToList = function(parameters){
        if(parameters.callback){
            var $data = $(parameters.view);
            $("#listAddress").append($data).fadeIn();
        }
        callback(parameters);
    };
   
    var addEditAddressToList = function(parameters){
        if(parameters.callback){
            var $data = $(parameters.view),
                $new = $($data.find('.info-box')),
                $address = $new.data('address');
            var $local = $('[data-address~="'+$address+'"]');
                $local.replaceWith($new);
        }
        callback(parameters);
    };
    
    var changeCidades = function ($form, $this){
        var $select = $form.find('select.address_form_cidade');
        $($select).html('<option value selected="selected">Carregando...</option>');
        getListAddress($this.data('url'), $this.data('method'), $this.serialize(), setOptionsAddress, $select);
    };
    
    var changeEstados = function($form, $this){
        var $select = $form.find('select.address_form_estado');
        $($select).html('<option value selected="selected">Carregando...</option>');
        getListAddress($this.data('url'), $this.data('method'), $this.serialize(), setOptionsAddress, $select);
    };
    
    $(function(){
        $('.cep').inputmask({"mask": "99999-999"}); 
    });

    $(function(){
        $('body').on('submit', 'form.addressAdd', function(e){
            e.preventDefault();
            ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize(),addNewAddressToList);
            document.forms.address_form.reset();
        });
    });

    $(function(){
        $('body').on('submit','.addressEdit', function(e){
           e.preventDefault();
           ajax($(this).attr('action'),$(this).attr('method'),$(this).serialize(), addEditAddressToList);
        });
    });

    $(function(){
        $('body').on('change', '.address_form_estado' ,function(){
            var $form = $(this).closest('form');
            changeCidades($form, $(this));
        });
    });

    $(function(){
        $('body').on('change', '.address_form_pais', function(){
            var $form = $(this).closest('form');
            changeEstados($form, $(this));
        });
    });

    $(function(){
        $("body").on('click', '.listAddress', function(){
            loader($("#modal_address_edit").find('.modal-content'));
            $.post($(this).data('url'), null, getFormEditAddress);
        });
    });
    
    $(function(){
        $("body").on('click', '.deleteAddress', function(){
            var parameters = {url: $(this).data('url'), divToRemove :$(this).closest('div.col-sm-12')};
            var deleteAddress = function(parameters){
                ajax(parameters.url, "POST", null);
                $(parameters.divToRemove).remove();
            };
            confirm("Você realmente deseja excluir este endereço?", deleteAddress, parameters);
        });
    });
    
    $(function(){
       $('body').on('click', ".map", function(){
           loader($("#map"));
            var position = [
                {
                    latitude: 40.6386333,
                    longitude: -8.745,
                    categoria: "Residencial",
                    address:"Rua Diogo Cão, 125",
                    cep: "3830-772 Gafanha da Nazaré" // não colocar virgula no último item de cada marcador
                },
                {
                    latitude: 40.59955,
                    longitude: -8.7498167,
                    categoria: "Comercial",
                    address:"Quinta dos Patos, n.º 2",
                    cep: "3830-453 Gafanha da Encarnação" // não colocar virgula no último item de cada marcador
                },
                {
                    latitude: 40.6247167,
                    longitude: -8.7129167,
                    categoria: "Outros",
                    address: "Rua dos Balneários do Complexo Desportivo",
                    cep: "3830-225 Gafanha da Nazaré" // não colocar virgula no último item de cada marcador
                } // não colocar vírgula no último marcador
            ];
           window.map(position);
       });
    });
    
    $(function(){
        var geocoder = geocoder = new google.maps.Geocoder();
        $(".txtLogradouro").autocomplete({
            minLength: 4, 
            source: function(request, response){
                geocoder.geocode({ 'address': request.term + ', Brasil', 'region': 'BR' }, function (results, status){
                    response($.map(results, function (item){
                        var response = getAddressFromGoogle(item.address_components);
                        return {
                            label: item.formatted_address,
                            value: response.route,
                            bairro: (response.sublocality) ? response.sublocality :response.sublocality_level_1,
                            pais: response.country,
                            estado: response.administrative_area_level_1,
                            cidade: response.locality,
                            googleFormat: item.formatted_address,
                            latitude: item.geometry.location.lat(),
                            longitude: item.geometry.location.lng(),
                            cep: (response.postal_code)
                        };
                    }));
                });
            },
            select: function (event, ui){
                var $form = $(this).closest('form');
                $form.find(".latitude").val(ui.item.latitude);
                $form.find(".longitude").val(ui.item.longitude);
                $form.find(".googleFormat").val(ui.item.googleFormat);
                var cep = ui.item.cep;
                $form.find(".cep").val( (cep)   ? cep.replace("-", "") : '');
                $form.find(".bairro").val(ui.item.bairro);
                ui.item.pais;
                ui.item.estado;
                ui.item.cidade;
            }
        });
        
        var getAddressFromGoogle = function (item){
            
            var optionsType = ['street_number', 'route', 'locality', 'sublocality_level_1', 'sublocality', 'administrative_area_level_2', 'administrative_area_level_1', 'country', 'postal_code'];
            var arrayRet = [];
            
            for(var i = 0; i < optionsType.length; i++){
                for(var b = 0; b < item.length ; b++){
                    for(var c = 0 ; c < item[b].types.length; c++){
                        if(item[b].types[c] === optionsType[i]){
                            if(optionsType[i] === "administrative_area_level_1"){
                                arrayRet[optionsType[i]] = item[b].long_name;
                            }else{
                                arrayRet[optionsType[i]] = item[b].short_name;
                            }
                        }
                    }
                }
            }
            return arrayRet;
        };
    });
    
};

window.map = function(parameters){

    'use strict';
    
    var map;
    var directionsDisplay = new google.maps.DirectionsRenderer();// Instanciaremos ele mais tarde, que será o nosso google.maps.DirectionsRenderer
    var directionsService = new google.maps.DirectionsService();
    var infoWindow = new google.maps.InfoWindow();
    var myatlng;
    
    var myOptions = function(){
        return {
            zoom: 15,
            center: myatlng,
            mapTypeControl: true,
            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    };
    
    var mapcanvas = function(){
        var mapcanvas = document.createElement('div');
            mapcanvas.id = 'mapcanvas';
            mapcanvas.style.height = (window.innerHeight - 120 ) + "px";
            mapcanvas.style.width = '100%';
            window.addEventListener('resize', function(){
                mapcanvas.style.height = (window.innerHeight - 120 ) + "px";
            });
        return mapcanvas;
    };
    
    var panel = function(){
        var panel = document.createElement('div');
            panel.id = 'panel';
            panel.style.float = "left";
        return panel;
    };
    
    var addressAddDirection = function(origem, destiny){
        
        directionsDisplay.setMap(map);
        
        for(var i = 0; i < parameters.length ; i ++){
            var request = { // Novo objeto google.maps.DirectionsRequest, contendo:
                origin: origem, // origem
                destination: new google.maps.LatLng(destiny.latitude, destiny.longitude),
                travelMode: google.maps.TravelMode.DRIVING // meio de transporte, nesse caso, de carro
            };
            
            directionsService.route(request, function(result, status){
                if (status === google.maps.DirectionsStatus.OK) { // Se deu tudo certo
                   directionsDisplay.setDirections(result); // Renderizamos no mapa o resultado
                }
            });
        }
        directionsDisplay.setPanel(document.getElementById("panel"));
    };
    
    // Esta função vai percorrer a informação contida na variável markersData
    // e cria os marcadores através da função createMarker
    var displayMarkers = function(){

        // esta variável vai definir a área de mapa a abranger e o nível do zoom
        // de acordo com as posições dos marcadores
        var bounds = new google.maps.LatLngBounds();

        // Loop que vai percorrer a informação contida em markersData 
        // para que a função createMarker possa criar os marcadores 
        for (var i = 0; i < parameters.length; i++){

            var latlng = new google.maps.LatLng(parameters[i].latitude, parameters[i].longitude);
            var categoria = parameters[i].categoria;
            var address = parameters[i].address;
            var codPostal = parameters[i].cep;

            createMarker(latlng, categoria, address, codPostal, false);

            // Os valores de latitude e longitude do marcador são adicionados à
            // variável bounds
            bounds.extend(latlng); 
        }
        
        createMarker(myatlng, "Você esta aqui!!!", "", "", true);
        // Os valores de latitude e longitude do marcador são adicionados à
        // variável bounds
        
        bounds.extend(myatlng);
            
        // Depois de criados todos os marcadores,
        // a API, através da sua função fitBounds, vai redefinir o nível do zoom
        // e consequentemente a área do mapa abrangida de acordo com    
        // as posições dos marcadores
        map.fitBounds(bounds);
    };
    
    // Função que cria os marcadores e define o conteúdo de cada Info Window.
    var createMarker = function(latlng, categoria, address, codPostal, myaddress){
        
        if(!myaddress){
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                title: categoria,
                icon: $("#marker-success").val()
            });

           // Evento que dá instrução à API para estar alerta ao click no marcador.
            // Define o conteúdo e abre a Info Window.
            google.maps.event.addListener(marker, 'click', function() {

                // Variável que define a estrutura do HTML a inserir na Info Window.
                var iwContent = '<div id="iw_container">'+
                                    '<div class="iw_title">' + categoria + '</div>'+
                                    '<div class="iw_content">' + address + '<br />' + codPostal + '</div>'+
                                    '<hr>'+
                                '</div>';

                // O conteúdo da variável iwContent é inserido na Info Window.
                infoWindow.setContent(iwContent);

                // A Info Window é aberta com um click no marcador.
                infoWindow.open(map, marker);
            });
        }else{
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                title: categoria,
                icon: $("#marker-info").val()
            });
        }
    };
    
    var success = function (position) {
        
        myatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        
        $('#map').html(mapcanvas).fadeIn();
        $('#text-map').html(panel).fadeIn();
        
        map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
        
        // Evento que fecha a infoWindow com click no mapa.
        google.maps.event.addListener(map, 'click', function() {
           infoWindow.close();
        });
        
        displayMarkers();
    };

    var error = function () {
        var position = {
            //Bragança Paulista
            coords: {
                latitude: -22.9527754,
                longitude: -46.5410751
            }
        };
        success(position);
    };

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, error);
    } else {
        error("Seu navegador não suporta localização geográfica.");
    }
          
};
