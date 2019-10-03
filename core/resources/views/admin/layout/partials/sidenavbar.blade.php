<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">

  <ul class="app-menu">
    <li><a class="app-menu__item @if(request()->path() == 'admin/dashboard') active @endif" href="{{route('admin.dashboard')}}"><i class="app-menu__icon fas fa-tachometer-alt"></i><span class="app-menu__label">Tableau de bord</span></a></li>

   <li class="treeview
    @if(request()->path() == 'admin/generalSetting')
      is-expanded
    @elseif (request()->path() == 'admin/EmailSetting')
      is-expanded
    @elseif (request()->path() == 'admin/SmsSetting')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-globe"></i><span class="app-menu__label">Config Générale</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/generalSetting') active @endif" href="{{route('admin.GenSetting')}}"><i class="icon far fa-circle"></i> Paramètres</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/EmailSetting') active @endif" href="{{route('admin.EmailSetting')}}" rel="noopener"><i class="icon far fa-circle"></i>Gestion Email </a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/SmsSetting') active @endif" href="{{route('admin.SmsSetting')}}"><i class="icon far fa-circle"></i> Gestion SMS </a></li>
      </ul>
    </li>

    <li><a class="app-menu__item @if(request()->path() == 'admin/charge/index') active @endif" href="{{route('admin.charge.index')}}"><i class="app-menu__icon fas fa-money-bill-alt"></i><span class="app-menu__label">Paramètres de charge</span></a></li>

    <li><a class="app-menu__item @if(request()->path() == 'admin/coupon/index') active @endif" href="{{route('admin.coupon.index')}}"><i class="app-menu__icon fas fa-dollar-sign"></i><span class="app-menu__label">Paramètres du coupon</span></a></li>

    <li><a class="app-menu__item @if(request()->path() == 'admin/category/index' || request()->is('admin/subcategory/*')) active @endif" href="{{route('admin.category.index')}}"><i class="app-menu__icon fab fa-buromobelexperte"></i><span class="app-menu__label">Gestion catégories</span></a></li>

    <li><a class="app-menu__item
    @if(request()->path() == 'admin/productattr/index') active
    @elseif (request()->is('admin/options/*/index')) active
    @endif" href="{{route('admin.productattr.index')}}"><i class="app-menu__icon fab fa-product-hunt"></i><span class="app-menu__label">Attributs Produits</span></a></li>
    {{-- <li><a class="app-menu__item {{ route::is('admin.centralachat.index') ? 'active' : ''}}" href="{{ route('admin.centralachat.index') }}"><i class="app-menu__icon fab fa-product-hunt"></i><span class="app-menu__label">Centre d'Achat</span></a></li> --}}

    <li><a class="app-menu__item @if(request()->path() == 'admin/packages') active @endif" href="{{route('admin.package')}}"><i class="app-menu__icon fa fa-gift"></i><span class="app-menu__label">Packages</span></a></li>
    <li><a class="app-menu__item @if(request()->path() == 'admin/packgift') active @endif" href="{{route('admin.packgift')}}"><i class="app-menu__icon fa fa-gift"></i><span class="app-menu__label">Packs Cadeaux</span></a></li>


      <li class="treeview
      @if(request()->path() == 'admin/vendors/all')
        is-expanded
      @elseif(request()->path() == 'admin/vendors/pending')
          is-expanded
      @elseif(request()->path() == 'admin/vendors/accepted')
          is-expanded
      @elseif(request()->path() == 'admin/vendors/rejected')
          is-expanded
      @endif">
        <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-industry"></i><span class="app-menu__label">Gestion des comptes annonceurs</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li><a class="treeview-item @if(request()->path() == 'admin/vendors/all') active @endif" href="{{route('admin.vendors.all')}}"><i class="icon far fa-circle"></i> Listes</a></li>
          <li><a class="treeview-item @if(request()->path() == 'admin/vendors/pending') active @endif" href="{{route('admin.vendors.pending')}}"><i class="icon far fa-circle"></i> En Instance</a></li>
          <li><a class="treeview-item @if(request()->path() == 'admin/vendors/accepted') active @endif" href="{{route('admin.vendors.accepted')}}"><i class="icon far fa-circle"></i> Confirmés</a></li>
          <li><a class="treeview-item @if(request()->path() == 'admin/vendors/rejected') active @endif" href="{{route('admin.vendors.rejected')}}"><i class="icon far fa-circle"></i> Rejetés</a></li>
        </ul>
      </li>

      <li class="treeview
      @if(request()->path() == 'admin/flashsale/times')
        is-expanded
      @elseif(request()->path() == 'admin/flashsale/all')
          is-expanded
      @elseif(request()->path() == 'admin/flashsale/pending')
          is-expanded
      @elseif(request()->path() == 'admin/flashsale/accepted')
          is-expanded
      @elseif(request()->path() == 'admin/flashsale/rejected')
          is-expanded
      @endif">
        <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-hand-holding-usd"></i><span class="app-menu__label">Vente Flash</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li><a class="treeview-item @if(request()->path() == 'admin/flashsale/times') active @endif" href="{{route('admin.flashsale.times')}}"><i class="icon far fa-circle"></i> Réglage d'heure</a></li>
          <li><a class="treeview-item @if(request()->path() == 'admin/flashsale/all') active @endif" href="{{route('admin.flashsale.all')}}"><i class="icon far fa-circle"></i> Toutes les ventes Flash</a></li>
          <li><a class="treeview-item @if(request()->path() == 'admin/flashsale/pending') active @endif" href="{{route('admin.flashsale.pending')}}"><i class="icon far fa-circle"></i> Ventes  Flash en attente</a></li>
          <li><a class="treeview-item @if(request()->path() == 'admin/flashsale/accepted') active @endif" href="{{route('admin.flashsale.accepted')}}"><i class="icon far fa-circle"></i> Ventes  Flash Acceptéss</a></li>
          <li><a class="treeview-item @if(request()->path() == 'admin/flashsale/rejected') active @endif" href="{{route('admin.flashsale.rejected')}}"><i class="icon far fa-circle"></i> Ventes  Flash rejectées</a></li>
        </ul>
      </li>



    <li class="treeview
    @if(request()->path() == 'admin/orders/all')
      is-expanded
    @elseif(request()->path() == 'admin/orders/confirmation/pending')
        is-expanded
    @elseif(request()->path() == 'admin/orders/confirmation/accepted')
        is-expanded
    @elseif(request()->path() == 'admin/orders/confirmation/rejected')
        is-expanded
    @elseif(request()->path() == 'admin/orders/delivery/pending')
        is-expanded
    @elseif(request()->path() == 'admin/orders/delivery/inprocess')
        is-expanded
    @elseif(request()->path() == 'admin/orders/delivered')
        is-expanded
    @elseif(request()->path() == 'admin/orders/cashondelivery')
        is-expanded
    @elseif(request()->path() == 'admin/orders/advance')
        is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Commandes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/all') active @endif" href="{{route('admin.orders.all')}}"><i class="icon far fa-circle"></i> Listes</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/confirmation/pending') active @endif" href="{{route('admin.orders.cPendingOrders')}}"><i class="icon far fa-circle"></i> En cours </a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/confirmation/accepted') active @endif" href="{{route('admin.orders.cAcceptedOrders')}}"><i class="icon far fa-circle"></i> Acceptées</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/confirmation/rejected') active @endif" href="{{route('admin.orders.cRejectedOrders')}}"><i class="icon far fa-circle"></i> Rejetées</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/delivery/pending') active @endif" href="{{route('admin.orders.pendingDelivery')}}"><i class="icon far fa-circle"></i> En attente de livraison</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/delivery/inprocess') active @endif" href="{{route('admin.orders.pendingInprocess')}}"><i class="icon far fa-circle"></i>En cours de livraison</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/delivered') active @endif" href="{{route('admin.orders.delivered')}}"><i class="icon far fa-circle"></i> Livrées</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/cashondelivery') active @endif" href="{{route('admin.orders.cashOnDelivery')}}"><i class="icon far fa-circle"></i> Paiement à la livraison</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/orders/advance') active @endif" href="{{route('admin.orders.advance')}}"><i class="icon far fa-circle"></i> Avance payée</a></li>
      </ul>
    </li>


    <li class="treeview
    @if(request()->path() == 'admin/comments')
      is-expanded
    @elseif(request()->path() == 'admin/complains')
      is-expanded
    @elseif(request()->path() == 'admin/suggestions')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-comments"></i><span class="app-menu__label">commentaires</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/comments') active @endif" href="{{route('admin.comments.all')}}"><i class="icon far fa-circle"></i> Tous</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/complains') active @endif" href="{{route('admin.complains')}}"><i class="icon far fa-circle"></i> Plaintes</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/suggestions') active @endif" href="{{route('admin.suggestions')}}"><i class="icon far fa-circle"></i> Suggestions</a></li>
      </ul>
    </li>


    <li class="treeview
    @if(request()->path() == 'admin/refunds/all')
      is-expanded
    @elseif(request()->path() == 'admin/refunds/pending')
        is-expanded
    @elseif(request()->path() == 'admin/refunds/rejected')
        is-expanded
    @elseif(request()->path() == 'admin/refunds/accepted')
        is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-undo"></i><span class="app-menu__label">Demande de remboursement</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/refunds/all') active @endif" href="{{route('admin.refunds.all')}}"><i class="icon far fa-circle"></i> Tous</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/refunds/pending') active @endif" href="{{route('admin.refunds.pending')}}"><i class="icon far fa-circle"></i> en instance</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/refunds/accepted') active @endif" href="{{route('admin.refunds.accepted')}}"><i class="icon far fa-circle"></i> Acceptés</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/refunds/rejected') active @endif" href="{{route('admin.refunds.rejected')}}"><i class="icon far fa-circle"></i> Rejectés</a></li>
      </ul>
    </li>


    <li class="treeview
    @if (request()->path() == 'admin/userManagement/allUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/bannedUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/verifiedUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/mobileUnverifiedUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/emailUnverifiedUsers')
      is-expanded
    @elseif (request()->is('admin/userManagement/userDetails/*'))
      is-expanded
    @elseif (request()->is('admin/userManagement/emailToUser/*'))
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/allUsersSearchResult')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/bannedUsersSearchResult')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/verUsersSearchResult')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/mobileUnverifiedUsersSearchResult')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/emailUnverifiedUsersSearchResult')
      is-expanded
    @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Gestion des utilisateurs</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/userManagement/allUsers' || request()->path() == 'admin/userManagement/allUsersSearchResult') active @endif" href="{{route('admin.allUsers')}}"><i class="icon far fa-circle"></i> Liste</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/userManagement/bannedUsers' || request()->path() == 'admin/userManagement/bannedUsersSearchResult') active @endif" href="{{route('admin.bannedUsers')}}"><i class="icon far fa-circle"></i> Utilisateurs bannis</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/userManagement/verifiedUsers' || request()->path() == 'admin/userManagement/verUsersSearchResult') active @endif" href="{{route('admin.verifiedUsers')}}"><i class="icon far fa-circle"></i> Utilisateurs vérifiés</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/userManagement/mobileUnverifiedUsers' || request()->path() == 'admin/userManagement/mobileUnverifiedUsersSearchResult') active @endif" href="{{route('admin.mobileUnverifiedUsers')}}"><i class="icon far fa-circle"></i>  Mobiles des Utilisateurs  non vérifiés</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/userManagement/emailUnverifiedUsers' || request()->path() == 'admin/userManagement/emailUnverifiedUsersSearchResult') active @endif" href="{{route('admin.emailUnverifiedUsers')}}"><i class="icon far fa-circle"></i> Email des utilisateurs non vérifiés</a></li>
      </ul>
    </li>


    <li class="treeview
    @if (request()->path() == 'admin/vendorManagement/allVendors')
      is-expanded
    @elseif (request()->path() == 'admin/vendorManagement/bannedVendors')
      is-expanded
    @elseif (request()->is('admin/vendorManagement/emailToVendor/*'))
      is-expanded
    @elseif (request()->is('admin/vendorManagement/addSubtractBalance/*'))
      is-expanded
    @elseif (request()->path() == 'admin/vendorManagement/allVendorsSearchResult')
      is-expanded
    @elseif (request()->path() == 'admin/vendorManagement/bannedVendorsSearchResult')
      is-expanded
    @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Gestion des vendeurs</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/vendorManagement/allVendors' || request()->path() == 'admin/vendorManagement/allVendorsSearchResult') active @endif" href="{{route('admin.allVendors')}}"><i class="icon far fa-circle"></i> Liste</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/vendorManagement/bannedVendors' || request()->path() == 'admin/vendorManagement/bannedVendorsSearchResult') active @endif" href="{{route('admin.bannedVendors')}}"><i class="icon far fa-circle"></i> Vendeurs bannis</a></li>
      </ul>
    </li>

    <li><a class="app-menu__item @if(request()->path() == 'admin/subscribers') active @endif" href="{{route('admin.subscribers')}}"><i class="app-menu__icon fas fa-newspaper"></i><span class="app-menu__label">Les abonnés</span></a></li>

    <li><a class="app-menu__item @if(request()->path() == 'admin/gateways') active @endif" href="{{route('admin.gateways')}}"><i class="app-menu__icon fab fa-cc-mastercard"></i><span class="app-menu__label">Passerelles</span></a></li>


    <li class="treeview
    @if(request()->path() == 'admin/deposit/pending')
      is-expanded
    @elseif (request()->path() == 'admin/deposit/acceptedRequests')
      is-expanded
    @elseif (request()->path() == 'admin/deposit/rejectedRequests')
      is-expanded
    @elseif (request()->path() == 'admin/deposit/depositLog')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-download"></i><span class="app-menu__label">Dépôt</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/deposit/pending') active @endif" href="{{route('admin.deposit.pending')}}"><i class="icon far fa-circle"></i> Demande en attente</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/deposit/acceptedRequests') active @endif" href="{{route('admin.deposit.acceptedRequests')}}" rel="noopener"><i class="icon far fa-circle"></i> Demande acceptée</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/deposit/rejectedRequests') active @endif" href="{{route('admin.deposit.rejectedRequests')}}"><i class="icon far fa-circle"></i> Demande rejetée</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/deposit/depositLog') active @endif" href="{{route('admin.deposit.depositLog')}}"><i class="icon far fa-circle"></i> Historique des depôts</a></li>
      </ul>
    </li>


    <li class="treeview
    @if(request()->path() == 'admin/withdrawLog')
      is-expanded
    @elseif (request()->path() == 'admin/withdrawMethod')
      is-expanded
    @elseif (request()->path() == 'admin/successLog')
      is-expanded
    @elseif (request()->path() == 'admin/refundedLog')
      is-expanded
    @elseif (request()->path() == 'admin/pendingLog')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label">Retraît</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/withdrawMethod') active @endif" href="{{route('admin.withdrawMethod')}}"><i class="icon far fa-circle"></i> Méthode de retrait</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/withdrawLog') active @endif" href="{{route('admin.withdrawLog')}}" rel="noopener"><i class="icon far fa-circle"></i> Historique des retraits</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/pendingLog') active @endif" href="{{route('admin.withdrawMoney.pendingLog')}}"><i class="icon far fa-circle"></i> Historique des demandes en attentes</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/successLog') active @endif" href="{{route('admin.withdrawMoney.successLog')}}"><i class="icon far fa-circle"></i> Historique opération succès</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/refundedLog') active @endif" href="{{route('admin.withdrawMoney.refundedLog')}}"><i class="icon far fa-circle"></i> Historique opération remboursée</a></li>
      </ul>
    </li>

    <li><a class="app-menu__item @if(request()->path() == 'admin/trxlog') active @endif" href="{{route('admin.trxLog')}}"><i class="app-menu__icon fas fa-exchange-alt"></i><span class="app-menu__label">Histrorique des Transactions</span></a></li>


    <li class="treeview
    @if (request()->path() == 'admin/interfaceControl/logoIcon/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/partner/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/slider/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/contact/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/support/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/social/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/footer/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/logintext/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/registertext/index')
      is-expanded
    @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-desktop"></i><span class="app-menu__label">Gestion Frontend</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/logoIcon/index') active @endif" href="{{route('admin.logoIcon.index')}}"><i class="icon far fa-circle"></i>Config Logo+Icon </a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/support/index') active @endif" href="{{route('admin.support.index')}}"><i class="icon far fa-circle"></i> Informations d'assitance</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/partner/index') active @endif" href="{{route('admin.partner.index')}}"><i class="icon far fa-circle"></i> Partenaires</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/slider/index') active @endif" href="{{route('admin.slider.index')}}"><i class="icon far fa-circle"></i> Config Slides</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/contact/index') active @endif" href="{{route('admin.contact.index')}}"><i class="icon far fa-circle"></i> Informations de Contact </a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/social/index') active @endif" href="{{route('admin.social.index')}}"><i class="icon far fa-circle"></i> Config reseaux sociaux </a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/logintext/index') active @endif" href="{{route('admin.logintext.index')}}"><i class="icon far fa-circle"></i> Texte Connexion </a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/registertext/index') active @endif" href="{{route('admin.registertext.index')}}"><i class="icon far fa-circle"></i>Texte Inscription </a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/interfaceControl/footer/index') active @endif" href="{{route('admin.footer.index')}}"><i class="icon far fa-circle"></i> Texte Pied de page </a></li>
      </ul>
    </li>


    <li class="treeview
    @if(request()->path() == 'admin/policy/refund/index')
      is-expanded
    @elseif(request()->path() == 'admin/tos/index')
      is-expanded
    @elseif(request()->path() == 'admin/policy/replacement/index')
      is-expanded
    @elseif(request()->path() == 'admin/privacy/index')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-clipboard-list"></i><span class="app-menu__label">Politique</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item @if(request()->path() == 'admin/policy/refund/index') active @endif" href="{{route('admin.refund.index')}}"><i class="icon far fa-circle"></i> Politique de remboursement</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/policy/replacement/index') active @endif" href="{{route('admin.replacement.index')}}"><i class="icon far fa-circle"></i> Politique de remplacement</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/tos/index') active @endif" href="{{route('admin.tos.index')}}"><i class="icon far fa-circle"></i> Terms & Conditions</a></li>
        <li><a class="treeview-item @if(request()->path() == 'admin/privacy/index') active @endif" href="{{route('admin.privacy.index')}}"><i class="icon far fa-circle"></i> Politique de confidentialité</a></li>
      </ul>
    </li>


    <li><a class="app-menu__item @if(request()->path() == 'admin/menuManager/index') active @endif" href="{{route('admin.menuManager.index')}}"><i class="app-menu__icon fa fa-bars"></i><span class="app-menu__label">Gestion du menu</span></a></li>


    <li><a class="app-menu__item
      @if(request()->path() == 'admin/Ad/index')
        active
      @elseif(request()->path() == 'admin/Ad/create')
        active
      @endif" href="{{route('admin.ad.index')}}"><i class="app-menu__icon fab fa-buysellads"></i> <span class="app-menu__label"> Publicité</span></a></li>

  </ul>
</aside>
