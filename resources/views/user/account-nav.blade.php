<ul class="account-nav">
    <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Dashboard</a></li>
    <li><a href="{{ route('order.history')}}" class="menu-link menu-link_us-s">Order History</a></li>
    <li><a href="account-address.html" class="menu-link menu-link_us-s">Addresses</a></li>
    <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
    <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
  
    <li>
      <form method= 'POST' action="{{ route('logout') }}" id="logout-form">
        @csrf
      <a href="{{ route('logout') }}" class="menu-link menu-link_us-s"
      onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    </form>
    </li>
  </ul>