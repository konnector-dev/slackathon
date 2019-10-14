<nav class="navbar navbar-light navbar-expand-md navbar-dark">
    <div class="container-fluid">
        <div>
            <a class="navbar-brand" href="#"><?php echo $org_first; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="navcol-2">
            <ul class="nav navbar-nav ml-auto" id="desktop-toolbar">
                <li class="nav-item" role="presentation"><a class="nav-link" href="#"><i class="fa fa-search"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                        <img class="rounded-circle"
                            src="<?php echo @$user['avatar_url'] ?>"
                            width="25px" height="25px"> <?php echo @$user['login'] ?> <i
                            class="fa fa-chevron-down fa-fw"></i></a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" role="presentation" href="#">
                            <i class="fa fa-user fa-fw"></i> Profile</a>
                        <a class="dropdown-item" role="presentation" href="#">
                            <i class="fa fa-power-off fa-fw"></i>Logout </a></div>
                </li>
            </ul>
        </div>
    </div>
</nav>