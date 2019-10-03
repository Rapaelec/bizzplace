<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Facture de la commande</title>
        <!-- bootstrap -->
        <link rel="stylesheet" href="{{asset('assets/user/css/bootstrap.min.css')}}">           
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
        <style>
            /* Echaffaudage #2 */
            /* [class*="col-"] {
                border: 1px dotted rgb(0, 0, 0);
                border-radius: 1px;
            } */
        </style>
    </head>
    <body cz-shortcut-listen="true">
        <div id="editor" class="edit-mode-wrap" style="margin-top: 20px">
            <style type="text/css">
                * {
                    margin: 0;
                    padding: 0;
                }
                body {
                    background: #fff;
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 12px;
                    line-height: 20px;
                }
                .invoice-wrap {
                    width: 800px;
                    margin: 0 auto;
                    background: #FFF;
                    color: #000
                }
                .invoice-inner {
                    margin: 0 15px;
                    padding: 20px 0
                }
                #info_gene {
                    border-radius: 20px;
                    width: 400px;
                    height: 175px;
                    border: solid 2px #000;
                    padding: 15px;
                    margin-bottom: 20pt;
                }
                #info_gene p {
                    font-size: 15pt;
                }
                #content_2 p {
                    font-size: 13pt;
                }
                #content_3 label {
                    font-size: 11pt;
                }
                th {
                    font-size: 11pt;
                }
                h3 {
                    text-align: center
                }
                .signature {
                    font-size: 13pt;
                    font-weight: bold;
                    font-style: italic;
                    text-decoration: underline;
                    text-align: center;
                }
                #nb p {
                    font-style: italic;
                    font-weight: bold;
                }
                #header p {
                    text-align: center;
                }
            </style>
            <div class="invoice-wrap">
                <div class="invoice-inner">
                    <div class="row" id="content_1">
                            <div class="col-sm-12" style="text-align:center;">
                                <h4 style="text-decoration:underline;font-weight:bold">
                                     FACTURE
                                </h4>
                            </div>
                    </div>
                    <div class="row" id="header">
                        <div class="col-md-6  ml-5 col-sm-5" style="height:100px;margin-top:2%">
                            <!-- <img class="editable-area" id="logo" src="../img/logo.png"> -->
                            <div class="row">
                                <div class="col-sm-12" style="text-align:left">
                                    <img class="editable-area" id="logo" src="{{asset('assets/user/img/shop-logo/'.$vendors->first()->logo) }}" height="100" width="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="font-size:9pt">
                                    <p style="text-align:left">
                                       Nom ou raison social: <strong>{{ $vendors->first()->shop_name }}</strong><br> 
                                       Adresse: <strong>{{ $vendors->first()->address }}</strong><br> 
                                       Téléphone: <strong>{{ $vendors->first()->phone }}</strong><br> 
                                       Email: <strong>{{ $vendors->first()->email }}</strong><br> 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5" style="margin-top:5%">
                            <div class="row" id="content_1">
                                <strong>INFORMATION COMMANDE :</strong><br>
                                <div class="col-md-12" style="border:3px solid black;border-radius:8px;font-size:9pt">
                                    N° Commande : {{$order->unique_id}}<br>
                                    Date Commande : {{date('j  F, Y', strtotime($order->created_at))}}<br>
                                    Destination: 
                                    @if ($order->shipping_method == 'around')
                                    Autour de la ville<br>
                                    @elseif ($order->shipping_method == 'world')
                                    Partout dans le monde<br>
                                    @elseif ($order->shipping_method == 'in')
                                    Dans la ville<br>
                                    @endif
                                    Méthode de paiement: 
                                    @if ($order->payment_method == 1)
                                    Cash à la livraison<br>
                                    @elseif ($order->payment_method == 2)
                                    Avance payée via <strong>Carte Bancaire</strong><br>
                                    @endif
                                    Status de la livraison:<strong>Livrée</strong><br>
                                    Status commande: <strong>Acceptée</strong><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="font-size:11pt;margin-top:20%">
                     @if (!empty($order->user->billing_last_name))
                         <div class="col-md-6 col-sm-6">
                           <strong>Facturé à:</strong><br>
                           <div class="row">
                               <div class="col-md-12 ml-3" style="border:3px solid black;border-radius:8px">
                               Nom ou raison social: <strong>{{ $vendors->first()->shop_name }}</strong><br> 
                               Adresse: <strong>{{ $vendors->first()->address }}</strong><br> 
                               Téléphone: <strong>{{ $vendors->first()->phone }}</strong><br> 
                               Email: <strong>{{ $vendors->first()->email }}</strong><br> 
                               </div>
                           </div>
                         </div>
                    @else
                    <div class="col-md-6 col-sm-6">
                            <strong>Facturé à:</strong><br>
                            <div class="row">
                                <div class="col-md-12 ml-3" style="border:3px solid black;border-radius:8px">
                                Nom ou raison social: <strong>{{ $vendors->first()->shop_name }}</strong><br> 
                                Adresse: <strong>{{ $vendors->first()->address }}</strong><br> 
                                Téléphone: <strong>{{ $vendors->first()->phone }}</strong><br> 
                                Email: <strong>{{ $vendors->first()->email }}</strong><br> 
                                </div>
                            </div>
                          </div>
                    @endif
                    @if(!empty($InforLivraisons))
                         <div class="col-md-5 ml-5">
                           <strong>Envoyé à:</strong><br/>
                           <div class="row">
                            <div class="col-md-12 " style="border:3px solid black;border-radius:8px">
                                Nom : {{$InforLivraisons->shipping_first_name}}  <br>
                                Prenom : {{$InforLivraisons->shipping_last_name}}   <br>
                                Email:{{$InforLivraisons->shipping_email}}<br>
                                Telephone:{{$InforLivraisons->shipping_phone}}<br>
                                Adresse: {{$InforLivraisons->address}}<br>
                            </div>
                        </div>
                        </div>
                    @endif
                    </div>
                    <div id="content_2" style="margin-top:5%">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table id="labour_table" class="table table-bordered table-hover">
                                        <thead style="background-color:dimgray">
                                            <tr>
                                                <th style="text-align:center">CODE</th>
                                                <th style="text-align:center">DESIGNATION</th>
                                                <th style="text-align:center">QUANTITE</th>
                                                <th style="text-align:center">PRIX UNIT. HT</th>
                                                <th style="text-align:center">MONTANT HT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vendors as $orderedproduct)
                                                <tr>
                                                    <td>{{$orderedproduct->product_code}}</td>
                                                    <td>{{strlen($orderedproduct->title) > 25 ? substr($orderedproduct->title, 0, 25) . '...' : $orderedproduct->title}}</td>
                                                    <td>{{$orderedproduct->quantity}}</td>
                                                    <td>{{round($orderedproduct->product_price, 2)}} &euro;</td>
                                                    <td>{{round($orderedproduct->product_price, 2)*$orderedproduct->quantity}} &euro;</td>
                                                </tr>
                                            @endforeach
                                                <tr>
                                                    <td colspan="4" style="text-align:right;border:none"><strong>Total HT</strong></td>
                                                    <td>{{$total}} &euro;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align:right;;border:none"><strong>Coupon</strong></td>
                                                    @if ($ccharge > 0)
                                                    <td>{{round($ccharge, 0)}} &euro;</td>
                                                    @else
                                                    <td>0.00 &euro;</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align:right;border:none"><strong>Total</strong></td>
                                                    <td>{{$total + $ccharge}} &euro;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align:right;border:none"><strong>Taxe</strong></td>
                                                    <td>{{ $total + $ccharge *($gs->tax/100)}} &euro;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align:right;border:none"><strong>Frais de livraison</strong></td>
                                                    <td>{{ $order->shipping_charge}} &euro;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align:right;border:none"><strong>Total TTC</strong></td>
                                                    <td>{{ $total + $ccharge *($gs->tax/100) + $order->shipping_charge }} &euro;</td>
                                                </tr>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            body {
                background: #EBEBEB;
            }
            .invoice-wrap {
                box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }
            #mobile-preview-close_2 a {
                position: fixed;
                /* left: 20px; */
                bottom: 30px;
                right: 0px;
                background-color: #f5f5f5;
                font-weight: 600;
                outline: 0 !important;
                line-height: 1.5;
                border-radius: 3px;
                font-size: 14px;
                padding: 7px 10px;
                margin: 7px 10px;
                border: 1px solid #000;
                color: #000;
                text-decoration: none;
            }
            #mobile-preview-close a {
                position: fixed;
                left: 20px;
                bottom: 30px;
                background-color: #f5f5f5;
                font-weight: 600;
                outline: 0 !important;
                line-height: 1.5;
                border-radius: 3px;
                font-size: 14px;
                padding: 7px 10px;
                border: 1px solid #000;
                color: #000;
                text-decoration: none;
            }
            #mobile-preview-close img,
            #mobile-preview-close_2 img {
                width: 20px;
                height: auto;
            }
            #mobile-preview-close a:nth-child(2),
            #mobile-preview-close_2 a:nth-child(2) {
                background: #f5f5f5;
                margin-bottom: 50px;
            }
            #mobile-preview-close a:nth-child(2) img,
            #mobile-preview-close_2 a:nth-child(2) img {
                height: auto;
                position: relative;
                top: 2px;
            }
            .invoice-wrap {
                padding: 20px;
            }
            @media screen and projection {
                a {
                    display: inline;
                }
            }
            @media print {
                a {
                    display: none;
                }
            }
            @page {
                margin: 0 -6cm
            }
            /* html {
            @media print {
                #mobile-preview-close a,
                #mobile-preview-close_2 a {
                    display: none
                }
                .invoice-wrap {
                    0
                }
                body {
                    background: none;
                }
                .invoice-wrap {
                    box-shadow: none;
                    margin-bottom: 0px;
                }
            }
        </style>
        <div id="mobile-preview-close">
            <a style="" href="javascript:window.print();"><img src="" style="float:left; margin:0 10px 0 0;">Imprimer</a>
        </div>
        <div id="mobile-preview-close_2">
            <a style="" href=""></a>
        </div>
    </body>
</html>