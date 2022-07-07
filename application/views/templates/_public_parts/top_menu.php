        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            </li>
            <?php if ($this->session->identity == null) : ?>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url('auth/') ?>register" class="nav-link">Register</a>
                </li> -->
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url('auth/') ?>login" class="btn btn-light nav-link text-bold">Login</a>
                </li>
            <?php else : ?>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url().$this->ion_auth->group( $this->ion_auth->user()->row()->group_id )->row()->name ?>" class="btn btn-default nav-link">Dashboard</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>