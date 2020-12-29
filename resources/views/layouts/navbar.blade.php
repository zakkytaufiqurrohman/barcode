<ul class="sidebar-menu" data-widget="tree">
        <li class="header">Admin</li>
        <li>
          <a href="{{route('user')}}">
            <i class="fa fa-user-plus"></i> <span>User</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('password_berkas')}}">
            <i class="fa fa-key"></i> <span>Password Berkas</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <!--  -->
        <li class="header">Berkas</li>
        <li>
          <a href="{{route('waarmeking')}}">
            <i class="fa fa-calendar"></i> <span>WAARMEKING</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('covernot')}}">
            <i class="fa fa-calendar"></i> <span>COVERNOT</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('legalisasi')}}">
            <i class="fa fa-calendar"></i> <span>LEGALISASI</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('akta-ppat')}}">
            <i class="fa fa-calendar"></i> <span>AKTA PPAT</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('akta-notaris')}}">
            <i class="fa fa-calendar"></i> <span>AKTA NOTARIS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('akta-jaminan-fidusia')}}">
            <i class="fa fa-calendar"></i> <span>AKTA JAMINAN FIDUSIA</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('tanda-terima')}}">
            <i class="fa fa-calendar"></i> <span>TANDA TERIMA</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li class="header">Lainnya</li>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-gears"></i> <span>Pengaturan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('user.profile')}}"><i class="fa fa-circle-o"></i> Edit Profile</a></li>
            <li><a href="{{route('user.password')}}"><i class="fa fa-circle-o"></i> Edit Password</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
      </ul>