/**
 * Created by Jose Arias on 28/05/2017.
 */
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btn-addArea").on('click',function(){
        var mstr_nombreArea = $('#tex_nombre').val();
        var mstr_interface = $('#text_interface').val();
        var mstr_ctr = $('#text_CTR').val();
        $.ajax({
            type: "POST",
            url: '/pagPuntosAccesos/CrearArea',
            data: {nombre: mstr_nombreArea, interface: mstr_interface, ctr: mstr_ctr},
            dataType: 'json',
            error: function (data, status) {
                alert('Error');
            },
            success: function (data) {
                console.log('data', data);
                location.reload();
            }
        });
    });

    $('.btn-CrearArea').on('click',function(){
        $('#mdlCrearAreas').modal('show');
    });

    $("#btn-addSubArea").on('click',function(){
        var mint_AreaId = $('#mdlCrearSubArea').data('id');
        var mstr_nombreArea = $('#tex_nombreSubArea').val();
        var mstr_ctr = $('#text_CTRSubArea').val();
        $.ajax({
            type: "POST",
            url: '/pagPuntosAccesos/CrearArea',
            data: {nombre: mstr_nombreArea, AreaId: mint_AreaId, ctr: mstr_ctr},
            dataType: 'json',
            error: function (data, status) {
                alert('Error');
            },
            success: function (data) {
                console.log('data', data);
                location.reload();
            }
        });
    });

    $('.btn-ModalSubArea').on('click',function(){
        var mobj_modal = $('#mdlCrearSubArea');
        var mint_AreaId = $(this).parent().parent().data('id');
        mobj_modal.data('id',mint_AreaId)
        mobj_modal.modal('show');
    });


    $(".md-done-all").on('click',function(){
        $.bootstrapGrowl("Exito al validar Contrato", {
            type: 'success',
            align: 'botton',
        });
    });

    $('.btn-colapcin').on('click',function(){
        var mele_btn = $(this).find('.ico-colapcin');
        var mele_Card = $(this).parents('.card-header').siblings('div .colapcin');
        var mstr_Card = 'card';
        if(!mele_Card.hasClass('colapcin')){
            //mele_Card = $(this).parent().siblings('.colapcin');
            mint_posion = $(this).parent().index();
            mele_Card = $(this).parent().parent().children('tr').eq(mint_posion+1);
            mstr_Card = 'table';
        }

        if(mele_btn.hasClass('md-keyboard-arrow-up')){
            mele_Card.removeClass(mstr_Card+'-colapcin');
            mele_Card.addClass(mstr_Card+'-colapcin-off');
            mele_btn.removeClass('md-keyboard-arrow-up');
            mele_btn.addClass('md-keyboard-arrow-down');
        }else{
            mele_Card.addClass(mstr_Card+'-colapcin');
            mele_Card.removeClass(mstr_Card+'-colapcin-off');
            mele_btn.addClass('md-keyboard-arrow-up');
            mele_btn.removeClass('md-keyboard-arrow-down');
        }

    });

    $('.btn-validar').on('click',function(){
        var mint_ContratoId = $(this).parent().data('id');
        var mlst_lstConsumo = new Array();
        var mobj_card = $(this).parents('.card-jse');
        mobj_card.find('input[type="number"]').each(function(){
            var mint_AreaId = $(this).parents('tr').data('id');
            var mflo_Porc_Comsumo =$(this).val();
            var mflo_Cant_Comsumo = $(this).parents('tr').find('.cant_mbts').html();
            var mflo_SubTotal_Comsumo = $(this).parents('tr').find('.subtotal').html();
            var mint_CodPadre = $(this).parents('tr').parents('tr').data('codpadre');
            var mobj_Consumo = new Object();
            obj_Consumo =
            {
             "idArea": mint_AreaId,
             "Mbps_Asignado": mflo_Cant_Comsumo,
             "Porc_Mbps": mflo_Porc_Comsumo,
             "SubTotal": mflo_SubTotal_Comsumo,
            }
            mlst_lstConsumo.push(obj_Consumo);
        });



        //console.log(JSON.stringify(mlst_lstConsumo));
        $.ajax({
            type: "POST",
            url: '/pagPuntosAccesos/CrearConsumo',
            //url: "{{url('/pagPuntosAccesos/CrearConsumo')}}",
            data: {lstConsumo: mlst_lstConsumo},
            dataType: 'json',
            error: function (data, status) {
                alert('Error');
            },
            success: function (data) {
                console.log('data', data);
                location.reload();
            }
        });


    });

    $('#lst_Contratos').on('click','input[type="number"]',function(){
        listar(this);
    });

    $('#lst_Contratos').on('keyup','input[type="number"]',function(){
        listar(this);
    });


    function listar(m_conten){
      $(m_conten).parents('.card-contrato').find('table').each(function(){
          var mint_globalNivel = $(this).data('nivel');
          var mint_globalImporte = $(this).data('importe');
          var mint_globalCantMbts = $(this).data('mbts');

          var totalporc_Mbts = 0;
          var totalcant_Mbts = 0;
          var totalimporte_Mbts = 0;


          $(this).find('tr[data-nivel="'+mint_globalNivel+'"]').each(function(){

              var mint_AreaId = $(this).data('id');
              var mstr_porcMbts = $(this).children('.porc_mbts').find('input').eq(0).val();
              if(mstr_porcMbts == ""){
                  mstr_porcMbts = 0;
              }

              var mint_cantMbts = parseFloat(mint_globalCantMbts *  mstr_porcMbts/100).toFixed(2);
              var mint_importeMbts = parseFloat(mstr_porcMbts/100 * mint_globalImporte).toFixed(3);

              $(this).children('.cant_mbts').text(mint_cantMbts);
              $(this).children('.subtotal').text(mint_importeMbts);

              var mobj_tablaHija = $(this).siblings('tr[data-codpadre="'+mint_AreaId+'"]').find('table[data-nivel="' + parseInt(mint_globalNivel + 1) + '"]')
              mobj_tablaHija.data('importe',mint_importeMbts);
              mobj_tablaHija.data('mbts',mint_cantMbts);


              totalporc_Mbts += parseFloat(mstr_porcMbts);
              totalcant_Mbts += parseFloat($(this).children('.cant_mbts').text());
              totalimporte_Mbts += parseFloat($(this).children('.subtotal').text());

          });

          totalporc_Mbts =roundtwo(totalporc_Mbts);
          totalcant_Mbts = roundtwo(totalcant_Mbts);
          totalimporte_Mbts = roundtwo(totalimporte_Mbts);

          //$(this).children('tfoot').remove();

          $(this).children('tfoot').find('.totalPorc_Mbts').text(totalporc_Mbts);
          $(this).children('tfoot').find('.totalCant_Mbts').text(totalcant_Mbts);
          $(this).children('tfoot').find('.totalimporte_Mbts').text(totalimporte_Mbts);



          if(totalporc_Mbts>100){
              $(m_conten).val(0);
              listar(m_conten);
          }


      });

    }


    function roundtwo(num){
        return +(Math.round(num +"e+2") +"e-2");
    }

});