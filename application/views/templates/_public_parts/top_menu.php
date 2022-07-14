        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            </li>
            <?php if ($this->session->identity == null) : ?>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url() ?>" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url() ?>" class="nav-link">Tentang</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url('auth/') ?>login" class="nav-link">Login</a>
                </li>
            <?php else : ?>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url('/').$this->ion_auth->group( $this->ion_auth->user()->row()->group_id )->row()->name ?>" class="btn btn-default nav-link">Dashboard</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>