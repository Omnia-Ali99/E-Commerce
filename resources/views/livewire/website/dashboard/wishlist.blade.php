 <div>
        @if($screen == 'wishlist')
             <div class="tab-pane fade @if ($screen == 'wishlist') active show @endif">
             @livewire('website.wishlist.wishlist-table')
         </div>
        @endif
 </div>