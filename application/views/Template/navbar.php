<nav class="navbar navbar-default top-navbar" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="#"><strong> SIMA</strong></a>

        <div id="sideNav" href="#">
            <i class="fa fa-bars icon"></i>
        </div>
        <!-- Menampilkan Waktu -->
        <div class="navbar-time">
            <span style="color:black" id="dates"><span id="the-day"></span><span id="the-time"></span> </span>
        </div>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <!-- <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <li>
                    <a href="#">
                        <div>
                            <strong>John Doe</strong>
                            <span class="pull-right text-muted">
                                <em>Today</em>
                            </span>
                        </div>
                        <div>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                <em>Yesterday</em>
                            </span>
                        </div>
                        <div>Lorem Ipsum has been the industry's standard dummy text ever since an kwilnw...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <strong>John Smith</strong>
                            <span class="pull-right text-muted">
                                <em>Yesterday</em>
                            </span>
                        </div>
                        <div>Lorem Ipsum has been the industry's standard dummy text ever since the...</div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>Read All Messages</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </li> -->
        <!-- /.dropdown-messages -->
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <?php
                $role = $this->session->userdata('role');
                if ($role == 1) { ?>
                    <li>
                        <a href="<?= base_url('Aset/log') ?>"><i class="fa fa-binoculars fa-fw"></i> Log</a>
                    </li>
                <?php } else {
                    echo "";
                } ?>
                <li>
                    <?php
                    $role = $this->session->userdata('role');
                    if ($role == 1) { ?>
                        <a href="<?= base_url('Aset/setting') ?>"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    <?php } elseif ($role == 2) { ?>
                        <a href="<?= base_url('Wakasek/setting') ?>"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    <?php } elseif ($role == 3) { ?>
                        <a href="<?= base_url('Kepsek/setting') ?>"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    <?php } else { ?>
                        <a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    <?php }
                    ?>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?= base_url('Login/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
</nav>